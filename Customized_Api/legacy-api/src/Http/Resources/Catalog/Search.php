<?php

namespace Webkul\API\Http\Resources\Catalog;

use Illuminate\Http\Resources\Json\JsonResource;
use Webkul\Product\Facades\ProductImage as ProductImageFacade;
use Illuminate\Support\Facades\DB;

class Search extends JsonResource
{
    /**
     * Create a new resource instance.
     *
     * @return void
     */
    public function __construct($resource)
    {
        $this->productReviewHelper = app('Webkul\Product\Helpers\Review');

        $this->wishlistHelper = app('Webkul\Customer\Helpers\Wishlist');

        parent::__construct($resource);
    }

    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request
     * @return array
     */
    public function toArray($request)
    {
        /* assign product */
        $product = $this->product ? $this->product : $this;

        /* get type instance */
        $productTypeInstance = $product->getTypeInstance();

        /* generating resource */

        $cname = DB::table('product_categories')
        ->join('category_translations','product_categories.category_id',  '=', 'category_translations.category_id')
        ->select('category_translations.name','category_translations.slug')
        ->where('product_categories.product_id', $product->id)
        ->where('category_translations.locale', '=', 'en')
        ->get();

      foreach($cname as $name)
      {

        return [
            /* product's information */
            'id'                     => $product->id,
            'sku'                    => $product->sku,
            'type'                   => $product->type,
            'name'                   => $product->name,
            'product'                =>'yes',
            'category_name'          =>$name->name,
            'category_slug'          =>$name->slug,
            'url_key'                => $product->url_key,
            'price'                  => $productTypeInstance->getMinimalPrice(),
            'images'                 => ProductImage::collection($product->images),
            'base_image'             => ProductImageFacade::getProductBaseImage($product),
            'created_at'             => $product->created_at,
            'updated_at'             => $product->updated_at,
        ];
    }
}
}
