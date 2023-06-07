<?php

namespace Webkul\API\Http\Controllers\Shop;

use Exception;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Event;
use Illuminate\Support\Facades\DB;
use Webkul\Product\Repositories\ProductRepository;
use Webkul\API\Http\Resources\Catalog\Search as ProductResource;
use Webkul\API\Http\Resources\Catalog\ProductSearch as ProductResources;
use Webkul\Category\Repositories\CategoryRepository;
use Webkul\API\Http\Resources\Catalog\Category as CategoryResource;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Collection;

class SearchController extends Controller
{

    public function __construct(ProductRepository $productRepository,CategoryRepository $categoryRepository)
    {
        $this->productRepository = $productRepository;
        $this->categoryRepository = $categoryRepository;
    }

//     public function searches(Request $request)
// {
//     $datas = $request->validate([
//         'text' => 'string',
//     ]);

//     // $text = $datas['text'];
//     $text = strtoupper($datas['text']);

//     $products = DB::table('product_flat')
//         ->select('product_id')
//         ->where('name', 'like', '%' . $text . '%')
//         ->distinct()
//         ->limit(10) // Limit the number of records to 10
//         ->get();

//     $product_ids = $products->pluck('product_id');

//     if ($product_ids->isEmpty()) {
//         // Execute another query since $product_ids is empty
//         $categories = DB::table('category_translations')
//             ->select('category_id')
//             ->where('name', 'like', '%' . $text . '%')
//             ->distinct()
//             // ->limit(10) // Limit the number of records to 10
//             ->get();

//         $category_ids = $categories->pluck('category_id');


//         $parent_category = DB::table('categories')
//             ->select('parent_id')
//             ->whereIn('id', $category_ids)
//             ->get();

//             $p_ids = $parent_category->pluck('parent_id');

//         $child= [];
//         foreach($category_ids as $re)
//         {
//             $child[] = new CategoryResource(
//                 $this->categoryRepository->findOrFail($re));
//         }

//         return $child;
//     }

//     $child = [];
//     foreach ($product_ids as $re) {
//         $child[] = new ProductResources($this->productRepository->findOrFail($re));
//     }

//     return $child;
// }

 
    public function searches(Request $request)
    {
    $datas = $request->validate([
        'text' => 'string',
    ]);

    $text = strtoupper($datas['text']);

    // Search in categories
    $categories = DB::table('category_translations')
        ->select('category_id')
        ->where('name', 'like', '%' . $text . '%')
        ->distinct()
        // ->limit(10) // Limit the number of records to 10
        ->get();

    $category_ids = $categories->pluck('category_id');

    $parent_category = DB::table('categories')
        ->select('parent_id')
        ->whereIn('id', $category_ids)
        ->get();

    $p_ids = $parent_category->pluck('parent_id');

    $categoryResults = [];
    foreach ($category_ids as $re) {
        $categoryResults[] = new CategoryResource(
            $this->categoryRepository->findOrFail($re)
        );
    }

    // Search in products
    $products = DB::table('product_flat')
        ->select('product_id')
        ->where('name', 'like', '%' . $text . '%')
        ->distinct()
        ->limit(10) // Limit the number of records to 10
        ->get();

    $product_ids = $products->pluck('product_id');

    $productResults = [];
    foreach ($product_ids as $re) {
        $productResults[] = new ProductResources(
            $this->productRepository->findOrFail($re)
        );
    }

    // Combine the category and product results
    $results = array_merge($categoryResults, $productResults);

    return $results;
    }

    public function all_search(Request $request)
    {
        $datas = $request->validate([
            'text' => 'string',
        ]);
    
        $text = strtoupper($datas['text']);
        $perPage = 9; // Number of records per page
    
        $products = DB::table('product_flat')
            ->select('product_id')
            ->where('name', 'like', '%' . $text . '%')
            ->distinct()
            ->orderBy('product_id')
            ->get();
    
        $product_ids = $products->pluck('product_id');
    
        $child = [];
        foreach ($product_ids as $re) {
            $child[] = new ProductResource($this->productRepository->findOrFail($re));
        }
    
        // Create a collection from the child array
        $collection = new Collection($child);
    
        // Create the paginator instance
        $paginator = new LengthAwarePaginator(
            $collection->forPage($request->input('page', 1), $perPage),
            $collection->count(),
            $perPage,
            $request->input('page', 1),
            ['path' => $request->url()]
        );
    
        // Transform the paginated results
        $paginatedResults = $paginator->appends($request->except('page'))->toArray();

        $paginatedResults['data'] = array_values($paginatedResults['data']);

    
        return $paginatedResults;
    }

   
}