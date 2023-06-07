<?php

namespace Webkul\Blog\Http\Controllers;

use Webkul\Admin\DataGrids\CategoryDataGrid;
use Webkul\Admin\DataGrids\CategoryProductDataGrid;
use Webkul\Attribute\Repositories\AttributeRepository;
use Webkul\Category\Http\Requests\CategoryRequest;
use Webkul\Category\Repositories\CategoryRepository;
use Webkul\Core\Models\Channel;
use Illuminate\Http\Request;
use Webkul\Blog\Models\Blog_Post;
use Webkul\Blog\Models\Blog_Category;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Storage;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\DB;

class BlogPostController extends Controller
{
    /**
     * Contains route related configuration.
     *
     * @var array
     */
    protected $_config;

    /**
     * Create a new controller instance.
     *
     * @param  \Webkul\Category\Repositories\CategoryRepository  $categoryRepository
     * @param  \Webkul\Attribute\Repositories\AttributeRepository  $attributeRepository
     * @return void
     */
    public function __construct(
        protected CategoryRepository $categoryRepository,
        protected AttributeRepository $attributeRepository
    )
    {
        $this->_config = request('_config');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {
        if (request()->ajax()) {
            return app(CategoryDataGrid::class)->toJson();
        }

        return view($this->_config['view']);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\View\View
     */
    public function create()
    {
        // Get all the locales from the channel_locales table
        $locales = DB::table('channel_locales')->pluck('locale_id');
        $localeCodes = DB::table('locales')->whereIn('id', $locales)->pluck('code');


        $categories = Blog_Category::pluck('category_name', 'id'); // Retrieve category names and IDs from the category table
        return view($this->_config['view'], compact('categories','localeCodes'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Webkul\Category\Http\Requests\CategoryRequest  $categoryRequest
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
{
    // Validate the request data
    $validatedData = $request->validate([
        'title' => 'required|string',
        'post_category_name' => 'required',
        'post_slug' => 'required|string',
        'description' => 'required|string',
        'locale' => 'required|string',
        'status' => 'required|string',
        'image.*' => 'image|mimes:jpeg,png,jpg,gif|max:2048', // Add validation rules for each image
    ]);

    $slug = $validatedData['post_slug'];

    if (Blog_Post::where('post_slug', $slug)->exists()) {
        // Slug is not unique
        $errorMessage = 'The slug is already taken. Please choose a different slug.';
        return redirect()->route('blog.post.create')->with('error', $errorMessage)->withInput();
    }

    // Handle image upload
    $uploadedImages = [];
    if ($request->hasFile('image')) {
        foreach ($request->file('image') as $file) {
            if ($file instanceof UploadedFile) {
                $imagePath = $file->store('blog_images', 'public'); // Store the image file
                $uploadedImages[] = $imagePath; // Save the image paths in an array
            }
        }
    }

    $validatedData['image'] = implode(',', $uploadedImages); // Convert array of image paths to a string

    Blog_Post::create($validatedData);

    // Add any additional logic or redirects as needed

    session()->flash('success', trans('Blog Post Save Successfully..'));

    return redirect()->route($this->_config['redirect']);
}
    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\View\View
     */
    public function edit($id)
{
    $blogPost = Blog_Post::findOrFail($id);
    
    $categories = Blog_Category::pluck('category_name', 'id');
    
    // Concatenate the base URL with the image URL
    $baseURL = 'http://localhost/parind4/public/storage/';
    $imageURL = $baseURL . $blogPost->image;

    $descriptions = $blogPost->description; // Assign the description value to the $descriptions variable
    
    // Get all the locales from the channel_locales table
    $locales = DB::table('channel_locales')->pluck('locale_id');
    $localeCodes = DB::table('locales')->whereIn('id', $locales)->pluck('code');


    return view($this->_config['view'], compact('blogPost', 'categories', 'imageURL', 'descriptions','localeCodes'));
}

    

    /**
     * Show the products of specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\View\View
     */
    public function products($id)
    {
        if (request()->ajax()) {
            return app(CategoryProductDataGrid::class)->toJson();
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Webkul\Category\Http\Requests\CategoryRequest  $categoryRequest
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $validatedData = $request->validate([
            'title' => 'required',
            'post_category_name' => 'required',
            'post_slug' => 'required|unique:blog_post,post_slug,'.$id,
            'locale' => 'required',
            'status' => 'required',
            'description' => 'required',
            'image.*' => 'image|mimes:jpeg,png,jpg,gif|max:2048', // Adjust the validation rules for image upload as per your needs
        ]);
    
        $blogPost = Blog_Post::findOrFail($id);
        $blogPost->title = $validatedData['title'];
        $blogPost->post_category_name = $validatedData['post_category_name'];
        $blogPost->post_slug = $validatedData['post_slug'];
        $blogPost->locale = $validatedData['locale'];
        $blogPost->status = $validatedData['status'];
        $blogPost->description = $validatedData['description'];
    
        // Handle image upload
        if ($request->hasFile('image')) {
            $uploadedImages = [];
    
            foreach ($request->file('image') as $file) {
                if ($file instanceof UploadedFile) {
                    $imagePath = $file->store('blog_images', 'public'); // Adjust the storage path as per your needs
                    $uploadedImages[] = $imagePath;
                }
            }
    
            $blogPost->image = implode(',', $uploadedImages);
        }
    
        $blogPost->save();
    
        session()->flash('success', trans('Blog Post Updated Successfully.'));
    
        return redirect()->route($this->_config['redirect']);
    }
    

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $blogPost = Blog_Post::findOrFail($id);

    // Delete the associated image file
    if (!empty($blogPost->image)) {
        $imagePath = public_path($blogPost->image);
        if (file_exists($imagePath)) {
            unlink($imagePath);
        }
    }

    // Delete the resource from the database
    $blogPost->delete();

    // Add any additional logic or redirects as needed

    session()->flash('success', trans('Blog Category deleted successfully.'));

    return redirect()->route($this->_config['redirect']);
    }

    /**
     * Remove the specified resources from database.
     *
     * @return \Illuminate\Http\Response
     */
    public function massDestroy()
    {
        $suppressFlash = true;
        $categoryIds = explode(',', request()->input('indexes'));

        foreach ($categoryIds as $categoryId) {
            $category = $this->categoryRepository->find($categoryId);

            if (isset($category)) {
                if ($this->isCategoryDeletable($category)) {
                    $suppressFlash = false;

                    session()->flash('warning', trans('admin::app.response.delete-category-root', ['name' => 'Category']));
                } else {
                    try {
                        $suppressFlash = true;

                        $this->categoryRepository->delete($categoryId);
                    } catch (\Exception $e) {
                        session()->flash('error', trans('admin::app.response.delete-failed', ['name' => 'Category']));
                    }
                }
            }
        }

        if (count($categoryIds) != 1 || $suppressFlash == true) {
            session()->flash('success', trans('admin::app.datagrid.mass-ops.delete-success', ['resource' => 'Category']));
        }

        return redirect()->route($this->_config['redirect']);
    }

    /**
     * Get category product count.
     *
     * @return \Illuminate\Http\Response
     */
    public function categoryProductCount()
    {
        $product_count = 0;
        $indexes = explode(',', request()->input('indexes'));

        foreach ($indexes as $index) {
            $category = $this->categoryRepository->find($index);
            $product_count += $category->products->count();
        }

        return response()->json(['product_count' => $product_count]);
    }

    /**
     * Check whether the current category is deletable or not.
     *
     * This method will fetch all root category ids from the channel. If `id` is present,
     * then it is not deletable.
     *
     * @param  \Webkul\Category\Models\Category $category
     * @return bool
     */
    private function isCategoryDeletable($category)
    {
        static $rootIdInChannels;

        if (! $rootIdInChannels) {
            $rootIdInChannels = Channel::pluck('root_category_id');
        }

        return $category->id === 1 || $rootIdInChannels->contains($category->id);
    }
}
