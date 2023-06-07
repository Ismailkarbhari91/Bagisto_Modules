<?php

namespace Webkul\API\Http\Controllers\Shop;

use Cart;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Event;
use Illuminate\Support\Facades\DB;
use Webkul\Product\Repositories\ProductRepository;
use Webkul\API\Http\Resources\Catalog\Product as ProductResource;
use Webkul\Product\Facades\ProductImage;
use Webkul\Category\Repositories\CategoryRepository;


class FrechProductsController extends Controller
{
    public function __construct(ProductRepository $productRepository,
    protected CategoryRepository $categoryRepository
    )
    {
        $this->productRepository = $productRepository;
    }

    public function productfrech(Request $request)
    {

        $id = 'fr';
        // print_r($id);
        $product_id =  DB::table('product_flat')
        ->select('product_id')
        ->where('locale',$id)
        // ->where('Latest_Products',1)
        ->get();

        $related = json_decode($product_id,true);
        // print_r($p_id);
        $child = [];
        foreach($related as $re)
        {
            $child[] = new ProductResource($this->productRepository->findOrFail($re['product_id']));
            
        }

        return $child;
    }


    // public function latest_productfrech(Request $request)
    // {

    //     $id = 'fr';
    //     // print_r($id);
    //     $product_id =  DB::table('product_flat')
    //     ->select('product_id')
    //     ->where('locale',$id)
    //     ->where('Latest_Products',1)
    //     ->get();

    //     $related = json_decode($product_id,true);
    //     // print_r($p_id);
    //     $child = [];
    //     foreach($related as $re)
    //     {
    //         $child[] = new ProductResource($this->productRepository->findOrFail($re['product_id']));
            
    //     }

    //     return $child;
    // }


    public function latest_productfrech(Request $request)
{
    $latestProducts = [];

    // Get all unique locales in the product_flat table
    $locales = DB::table('product_flat')->distinct()->pluck('locale');

    foreach ($locales as $locale) {
        // Get the latest product for the current locale
        $latestProduct = DB::table('product_flat')
            ->where('locale', $locale)
            ->where('Latest_Products', 1)
            ->orderBy('created_at', 'desc')
            ->first();

        // Add the latest product to the array
        if ($latestProduct) {
            $latestProducts[] = $latestProduct;
        }
    }

    $products = [];

    // Retrieve the products for each locale
    foreach ($latestProducts as $latestProduct) {
        $product = $this->productRepository->findOrFail($latestProduct->product_id);
        $products[] = new ProductResource($product);
    }

    return $products;
}


    public function categoryfrench($slug)
    {

        $categoryDetails = $this->categoryRepository->findByPath($slug);

        if ($categoryDetails ) {
            $response = [
                'status'          => true,
                'categoryDetails' => $this->getCategoryFilteredData($categoryDetails),
            ];
        }

        return $response ?? [
            'status' => false,
        ];
    }
    

    // private function getCategoryFilteredData($category)
    // {
    //     $formattedChildCategory = [];

    //     foreach ($category->children as $child) {
    //         $formattedChildCategory[] = $this->getCategoryFilteredData($child);
    //     }

    //     return [
    //         'id'                => $category->id,
    //         'slug'              => $category->slug,
    //         'name'              => $category->name,
    //         'children'          => $formattedChildCategory,
    //         'category_icon_url' => $category->category_icon_url,
    //         'image_url'         => $category->image_url,
    //     ];
    // }


    // public function fetchCategories()
    // {
    //     $formattedCategories = [];

    //     $categories = $this->categoryRepository->getVisibleCategoryTree(core()->getCurrentChannel()->root_category_id);

    //     foreach ($categories as $category) {
    //         $formattedCategories[] = $this->getCategoryFilteredData($category);
    //     }

    //     return [
    //         'categories' => $formattedCategories,
    //     ];
    // }

    public function cslug(Request $request)
{

    
    $id = 'fr';
        $product_id =  DB::table('categories')
            ->select('id')
            ->where('parent_id', 70)
            ->get()
            ->pluck('id');

    $cnames = DB::table('category_translations')
        ->join('categories','category_translations.category_id','=','categories.id')
        ->where('locale', $id)
        ->whereIn('category_id', $product_id)
        ->select('category_translations.*', 'categories.status as status', DB::raw("CONCAT('http://151.80.237.29/public//storage/','', categories.image) as image_url"),'categories.display_mode as display_mode','categories.created_at as created_at','categories.updated_at as updated_at')
        ->get();

    $categories = [];
    foreach ($cnames as $cname) {
        $categories[] = [
            'id'                 => $cname->id,
            'code'               => null,
            'name'               => $cname->name,
            'slug'               => $cname->slug,
            'display_mode'       => $cname->display_mode,
            'description'        => $cname->description,
            'meta_title'         => $cname->meta_title,
            'meta_description'   => $cname->meta_description,
            'meta_keywords'      => $cname->meta_keywords,
            'status'             => $cname->status,
            'image_url'          => $cname->image_url,
            'category_icon_path' => null,
            'additional'         => null,
            'created_at'         => $cname->created_at,
            'updated_at'         => $cname->updated_at,
        ];
    }

    return $categories;
}

public function productbycategory(Request $request)
{

    // $datas = $request->validate([
    //     'id' =>'string',
    // ]);

    // $id = $datas['id'];
    // $locale = 'fr';

    // $product_id =  DB::table('product_categories')
    //     ->select('product_id')
    //     ->where('category_id',$id)
    //     ->get()
    //     ->pluck('product_id');

    $product_id =  DB::table('categories')
        ->select('id')
        ->where('parent_id', 70)
        ->get();

        $abut = json_decode($product_id,true);
        $a=[];
        foreach($abut as $ab)
        {
            $a[] = $ab['id'];
        }
        return $a;

        $product_details = DB::table('product_flat')
        ->select('product_id','name')
        ->where('locale','fr')
        ->whereIn('product_id',$product_id)
        ->get();

        // return $product_details;
        $related = json_decode($product_details,true);
        $child = [];
        foreach($related as $re)
        {
            $child[] = new ProductResource($this->productRepository->findOrFail($re['product_id']));
            
        }

        // return $child;
}

}