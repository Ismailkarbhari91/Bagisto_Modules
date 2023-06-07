<?php

namespace Webkul\Blog\Http\Controllers;

use Webkul\Admin\DataGrids\CategoryDataGrid;
use Webkul\Admin\DataGrids\CategoryProductDataGrid;
use Webkul\Attribute\Repositories\AttributeRepository;
use Webkul\Category\Http\Requests\CategoryRequest;
use Webkul\Category\Repositories\CategoryRepository;
use Webkul\Core\Models\Channel;
use Illuminate\Http\Request;
use Webkul\Blog\Models\Blog_Category;
use Illuminate\Support\Facades\DB;

class BlogCategoryController extends Controller
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
        // $localeNames = DB::table('locales')->whereIn('id', $locales)->pluck('name');

        return view($this->_config['view'], compact('localeCodes'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Webkul\Category\Http\Requests\CategoryRequest  $categoryRequest
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'category_name' => 'required',
            'slug' => 'required',
            'locale' => 'required',
        ]);
    
        $slug = $validatedData['slug'];
    
        if (Blog_Category::where('slug', $slug)->exists()) {
            // Slug is not unique
            $errorMessage = 'The slug is already taken. Please choose a different slug.';
            return redirect()->route('blog.categories.create')->with('error', $errorMessage)->withInput();
        }
    
        Blog_Category::create($validatedData);
    
        // Add any additional logic or redirects as needed
    
        session()->flash('success', trans('Blog Category Save Successfully..'));
    
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
        $blogCategory = Blog_Category::findOrFail($id);
    
        // Get all the locales from the channel_locales table
        $locales = DB::table('channel_locales')->pluck('locale_id');
        $localeCodes = DB::table('locales')->whereIn('id', $locales)->pluck('code');
        
        return view($this->_config['view'], compact('blogCategory', 'localeCodes'));
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
        // $this->categoryRepository->update($categoryRequest->all(), $id);

        // session()->flash('success', trans('admin::app.response.update-success', ['name' => 'Category']));

        // return redirect()->route($this->_config['redirect']);

        $validatedData = $request->validate([
            'category_name' => 'required',
            'slug' => 'required|unique:blog_category,slug,'.$id,
            'locale' => 'required',
        ]);
    
        $blogCategory = Blog_Category::findOrFail($id);
        $blogCategory->update($validatedData);
    
        // Add any additional logic or redirects as needed

        session()->flash('success', trans('Blog Category Update Successfully..'));
    
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
       
    $blogCategory = Blog_Category::findOrFail($id);

    // Delete the resource
    $blogCategory->delete();

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
