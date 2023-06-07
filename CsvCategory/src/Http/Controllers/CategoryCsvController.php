<?php

namespace Webkul\CsvCategory\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Event;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;
use Webkul\Category\Repositories\CategoryRepository;
use Webkul\Category\Models\Category;
use Webkul\Category\Models\CategoryTranslation;
use Illuminate\Http\UploadedFile;
use Intervention\Image\Facades\Image;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;

class CategoryCsvController extends Controller
{

    protected $_config;

    protected $quote;

    public function __construct()
    {
        // $this->quote             = $quote;
        $this->_config              = request('_config');
    }

    public function index()
    {
        return view($this->_config['view']);
    }

    public function upload(Request $request)
    {
        $file = $request->file('categories_file');
        $rows = array_map('str_getcsv', file($file));
        $header = array_shift($rows);
        $categories = [];
        $counter = 0;
        $existingSlugs = [];
        $importedRows = [];

        foreach ($rows as $row) {
            $category = array_combine($header, $row);
            $categories[] = $category;
        }

        foreach ($categories as $category) {
            $existingCategory = DB::table('category_translations')->where('slug', $category['slug'])->first();
    
            if ($existingCategory) {
                $existingSlugs[] = $category['slug'];
                continue;
            }
    
            if (strpos($category['slug'], '_') !== false) {
                session()->flash('error', 'The slug "' . $category['slug'] . '" contains an underscore. Please remove it.');
                continue;
            }
    

            $parentCategory = null;

            $tempImage = tempnam(sys_get_temp_dir(), 'category_');
            $imageContents = file_get_contents($category['image_url']);
            file_put_contents($tempImage, $imageContents);

            $extension = pathinfo($category['image_url'], PATHINFO_EXTENSION);
            $fileName = Str::random(32) . '.' . $extension;
            $categoryId = DB::table('categories')->max('id') + 1;
            $filePath = 'category/' . $categoryId . '/' . $fileName;

            $image = Image::make($tempImage);
            $imagePath = 'category/' . $categoryId . '/' . $fileName;
            Storage::disk('public')->put($filePath, $image->stream());

            // 

            // Get the last inserted position value and increment it by 1
            $lastPosition = DB::table('categories')->max('position');
            $position = $lastPosition + 1;

            $categoryId = DB::table('categories')->insertGetId([
                'parent_id' => $category['parent_id'],
                'status' => 1,
                'position' => $position, // Use the incremented position value
                'image' => $imagePath,
                'updated_at' => now(),
                'created_at' => now(),
            ]);

            DB::table('category_translations')->insert([
                'category_id' => $categoryId,
                'name' => $category['name'],
                'description' => $category['description'],
                'slug' => Str::slug($category['slug']),
                'locale' => 'en',
                'meta_title' => $category['meta_title'],
                'meta_description' => $category['meta_description'],
                'meta_keywords' => $category['meta_keywords'],
            ]);

            $counter++;
            $importedRows[] = $category['slug'];
        }

        if (!empty($importedRows)) {
            $counter = count($importedRows);
            $totalRows = count($categories);
            $successMessage = "Imported $counter categories out of $totalRows.";
        }

        if (!empty($existingSlugs)) {
            $errorMessage = 'The following slugs are already in use: ' . implode(', ', $existingSlugs) . '. Please add a unique slug in the CSV file.';
        }


        // display appropriate messages
        if (!empty($successMessage) && !empty($errorMessage)) {
        // display both messages
        session()->flash('success', $successMessage);
        session()->flash('error', $errorMessage);
        } elseif (!empty($successMessage)) {
        // display success message only
        session()->flash('success', $successMessage);
        } elseif (!empty($errorMessage)) {
        // display error message only
        session()->flash('error', $errorMessage);
        } else {
        // no rows imported and no slugs already existed
        session()->flash('error', 'No category were imported.');
        }
        return redirect()->route($this->_config['redirect']);
        }
    

}
