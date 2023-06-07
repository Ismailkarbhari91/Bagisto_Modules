# Go to vendor/bagisto/legacy-api/src/Http/routes.php


# Add below routes code
~~~
 Route::get('related-products', [RelatedProductsController::class, 'related']);
 ~~~

 # Add Controller in routes.php file to top of the file
 ~~~
 use Webkul\API\Http\Controllers\Shop\RelatedProductsController;
~~~


# Now Craete a controller file name RelatedProductsController in vendor/bagisto/legacy-api/src/Http/Controllers/Shop

# Add below code in that RelatedProductsController file
 ~~~
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
        $product_id =  DB::table('product_flat')
        ->select('product_id')
        ->where('url_key',$id)
        ->get();
        

        $p_id = json_decode($product_id,true);
      

        $id = $p_id[0];
       

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
    
}
~~~

# Now hit below routes for related products
your-domain-name/api/related-products