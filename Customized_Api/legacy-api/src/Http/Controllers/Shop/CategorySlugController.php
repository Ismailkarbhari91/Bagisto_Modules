<?php

namespace Webkul\API\Http\Controllers\Shop;

// use Cart;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Event;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use Webkul\Product\Repositories\ProductRepository;
use Webkul\API\Http\Resources\Catalog\Product as ProductResource;

class CategorySlugController extends Controller
{
    public function __construct(ProductRepository $productRepository)
    {
        $this->productRepository = $productRepository;
    }

    public function csvslug()
    {
       
    }

    public function productcategoryslug( Request $request )
    {

        $datas = $request->validate([
            'slug' =>'string',
        ]);

        $slug = $datas['slug'];

        $category_id =  DB::table('category_translations')
        ->select('category_id')
        ->where('slug',$slug)
        ->where('locale','en')
        ->get();

        $p_id = json_decode($category_id,true);
        // print_r($p_id);

        $id = $p_id[0];
        // foreach($p_id  as $id)
        // {
       
        // }
        // print_r($id);
        $product_id = DB::table('product_categories')
        ->select('product_id')
        ->where('category_id',$id)
        ->get();

        // print_r($product_id);

        $p_ids = json_decode($product_id,true);
        $child = [];
        foreach( $p_ids as $pida)
        {
            // print_r($pida);
            $child[] = new ProductResource($this->productRepository->findOrFail($pida['product_id']));
        }
        
        return $child;
        
    }
}