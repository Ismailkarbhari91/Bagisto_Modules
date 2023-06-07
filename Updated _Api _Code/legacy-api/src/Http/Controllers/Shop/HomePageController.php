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

class HomePageController extends Controller
{

    public function Homepagecontent(Request $request)
    {
     
        // slider
        $sliders = DB::table('velocity_meta_data')->select('slider')->get();

        $url = [];
        foreach($sliders as $slider)
        {

            $slider = $slider->slider;
            // print_r($slider);
            if($slider == 1)
            {

                $url['url'] = 'http://151.80.237.29/public/api/sliders';
                $url['key'] = "Cover";
            }
            else
            {
                $url['url'] = '';
            }
        }
        // end slider


        // About us section

        $about_us = DB::table('velocity_meta_data')->select('about_heading','about_sub_heading','about_para','about_images','button_text')->get();
        $abs = [];
       $abut = json_decode($about_us,true);
        foreach($abut[0] as $key => $ab)
        {
            $abs =$abut;
            $abut[0]['key'] = "About us";
        }
        // 

        // product 

    $pposition = [];
    $tag = DB::table('attributes')
    ->select('code')
    ->where('product_collection', 1)
    ->get();

    
    $add = [];
    $i=0;
    $t = json_decode($tag,true);
    foreach($t as $ta)
    {
        $pcposition = $ta['code'];
        $pposition = DB::table('velocity_meta_data')
        ->select($pcposition)
        ->get();
        
        $p = json_decode($pposition,true);
        // print_r($p);
        // foreach($p[0] as $key => $value)
        // {
        //     if($value == 1)
        //     {
        //     $p[0]['url'] = "http://151.80.237.29/public/api/products?Latest_Products=1&locale=fr&limit=10000";

        //     $p[0]['key']=$pcposition;
        //     $urls[$ta['code']] = $p;
            
        //     }
        //     else
        //     {
        //         $p[0]['url']='';
        //         $p[0]['key']=$pcposition;
        //     $urls[$ta['code']] = $p;
        //     // $urls=[;
        //     }
    // }
    }
    $urls['url']= "http://151.80.237.29/public/api/latest-product?latest_product=1&limit=10000";
    //
    
    // categories

    $category['url'] = "http://151.80.237.29/public/api/descendant-categories?parent_id=70"; 


    // 

    // all products

    $products['url'] = "http://151.80.237.29/public/api/products?limit=10000";

    // end all produts

    // Testimonial

    $testimonial= DB::table('testimonial')
            ->select('customer_name', 'description_arabic','description', DB::raw("CONCAT('http://151.80.237.29/public/storage/public/images/','', image_url) as image_url"))
            ->where('locale','en')
            ->get();


    // $test = json_decode($testimonial,true);
    // foreach($test as $key => $ab)
    //     {
    //     $testimonial =$test;
    //     $test[0]['key'] = "Testimonial";
    //     }
    // 
        

    // position
    // $spostion = DB::table('velocity_meta_data')->select('slider_position')->get();
    // $pa = json_decode($spostion,true);
    // foreach($pa[0] as $key => $ps)
    // {
    // $pa[0]['key'] = "Cover"; 
    // $s['Cover'] = $pa;
    // }

    // $apostion = DB::table('velocity_meta_data')->select('aboutus_position')->get();

    // $ap = json_decode($apostion,true);
    // foreach($ap[0] as $key => $value)
    // {
    //     $ap[0]['key'] = "About us"; 
    // $s['About Us'] = $ap;
    // }
    // $pposition = [];
    // $tag = DB::table('attributes')
    // ->select('code')
    // ->where('product_collection', 1)
    // ->get();

    

    // $t = json_decode($tag,true);
    // // print_r($t);
    // foreach($t as $ta)
    // {
    //     $pcposition = $ta['code'];
    //     $pposition = DB::table('velocity_meta_data')
    //     ->select($pcposition.'_position')
    //     ->get();

    //     $p = json_decode($pposition,true);

    //     foreach($p[0] as $key => $value)
    //     {
    
    //     $p[0]['key']=$pcposition;
    //     $s[$ta['code']] = $p;
    //     }
    // }

    // $tespostion = DB::table('velocity_meta_data')->select('testimonial_position')->get();
    // $ts = json_decode($tespostion,true);
    // foreach($ts[0] as $tsa)
    // {
    //     $ts[0]['key'] = "Testimonial"; 
    //     $s['Testimonial'] = $ts;
    // }


    // map

    $map =  DB::table('velocity_meta_data')
    ->select(DB::raw("CONCAT('http://151.80.237.29/public/storage/public/images/','', image_url) as image_url"))
        ->get();

    // end position
         return response([
            'Latest_Products' =>$urls,
            'Cover'           =>$url,
            'Category'        =>$category,
            'All_Products'    =>$products,
            'About_Us'      =>$abs,
            'testimonial'  =>$testimonial,
            'Map_img'     =>$map,
            // 'Position'    =>$s,
        ]);
    }


    // 

    public function Homefrechpagecontent(Request $request)
    {
      // slider
      $sliders = DB::table('velocity_meta_data')->select('slider')->get();

      $url = [];
      foreach($sliders as $slider)
      {

          $slider = $slider->slider;
          // print_r($slider);
          if($slider == 1)
          {

              $url['url'] = 'http://151.80.237.29/public/api/sliders';
              $url['key'] = "Cover";
          }
          else
          {
              $url['url'] = '';
          }
      }
      // end slider

      // product 

    $pposition = [];
    $tag = DB::table('attributes')
    ->select('code')
    ->where('product_collection', 1)
    ->get();

    
    $add = [];
    $i=0;
    $t = json_decode($tag,true);
    foreach($t as $ta)
    {
        $pcposition = $ta['code'];
        $pposition = DB::table('velocity_meta_data')
        ->select($pcposition)
        ->get();
        
        $p = json_decode($pposition,true);
        // print_r($p);
    //     foreach($p[0] as $key => $value)
    //     {
    //         if($value == 1)
    //         {
    //         $p[0]['url'] = "http://151.80.237.29/public/api/products?limit=10000&Latest_Products=1&locale=fr";

    //         $p[0]['key']=$pcposition;
    //         $urls[$ta['code']] = $p;
            
    //         }
    //         else
    //         {
    //             $p[0]['url']='';
    //             $p[0]['key']=$pcposition;
    //             $urls[$ta['code']] = $p;
    //         // $urls=[;
    //         }
    // }
    }

    $urls['url']= "http://151.80.237.29/public/api/latest-product?latest_product=1&limit=10000&locale=fr";
    //

     // all products

     $products['url'] = "http://151.80.237.29/public/api/products?locale=fr&limit=100";

     // end all produts

    //testimonial 
     $testimonial= DB::table('testimonial')
            ->select('customer_name', 'description_arabic','description', DB::raw("CONCAT('http://151.80.237.29/public/storage/public/images/','', image_url) as image_url"))
            ->where('locale','fr')
            ->get();

    // end testimonial

    // About us section

    $about_us = DB::table('velocity_meta_data')->select('about_heading_fr as about_heading','about_sub_heading_fr as about_sub_heading','about_para_fr as about_para','button_text_fr as button_text')->get();
    $abs = [];
   $abut = json_decode($about_us,true);
    foreach($abut[0] as $key => $ab)
    {
        $abs =$abut;
        $abut[0]['key'] = "About us";
    }
    
    // 

    // categories

    $category['url'] = "http://151.80.237.29/public/api/descendant-categories?parent_id=70&limit=1000&locale=fr"; 

    // 


    // map

    $map =  DB::table('velocity_meta_data')
    ->select(DB::raw("CONCAT('http://151.80.237.29/public/storage/public/images/','', image_url) as image_url"))
        ->get();
    // 

      return response([
        'Latest_Products' =>$urls,     
        'Cover'           =>$url,
        'Category'        =>$category,
        'All_Products'    =>$products,
        'About_Us'      =>$abs,
        'testimonial'  =>$testimonial,
        'Map_img'     =>$map,
        ]);

    }

    // 

}
