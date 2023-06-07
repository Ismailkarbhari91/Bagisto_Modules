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

class RelatedProductsController extends Controller
{
    public function __construct(ProductRepository $productRepository)
    {
        $this->productRepository = $productRepository;
    }

    public function related(Request $request)
    {
        $datas = $request->validate([
            'id' =>'string',
        ]);


       
        $id = $datas['id'];
        // print_r($id);
        $product_id =  DB::table('product_flat')
        ->select('product_id')
        ->where('url_key',$id)
        ->get();
        // print_r($product_id);

        $p_id = json_decode($product_id,true);
        // print_r($p_id);

        $id = $p_id[0];
        // print_r($id);

        $about_us =  DB::table('product_relations')
        ->select('child_id')
        ->where('parent_id',$id)
        ->get();

        $related = json_decode($about_us,true);

        $child = [];
        foreach($related as $re)
        {
            $child[] = new ProductResource($this->productRepository->findOrFail($re['child_id']));
            
        }

        return $child;

    
    }

    public function slugs($slug)
    {
    $product =  new ProductResource(
        $this->productRepository->findBySlug($slug)
    );

    return $product;
}
    
}