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
use Google\Cloud\Translate\V2\TranslateClient;

class AboutUsController extends Controller
{

    public function about_us(Request $request)
    {

        $img =  DB::table('aboutimage')
        ->select(DB::raw("CONCAT('http://151.80.237.29/public/storage/public/images/','', images) as image_url"))
        ->get();


        $about_us =  DB::table('aboutus')
        ->where('locale','en')
        ->get();


        return response([
            // 'Banner_Image'    =>$img,
            'About_Us_Data'    =>$about_us,
        ]);
    

        
}


    public function about_us_french(Request $request)
    {

        $img =  DB::table('aboutimage')
        ->select(DB::raw("CONCAT('http://151.80.237.29/public/storage/public/images/','', images) as image_url"))
        ->get();


        $about_us =  DB::table('aboutus')
        ->where('locale','fr')
        ->get();


        return response([
            // 'Banner_Image'    =>$img,
            'About_Us_Data'    =>$about_us,
        ]);
    
    }
}