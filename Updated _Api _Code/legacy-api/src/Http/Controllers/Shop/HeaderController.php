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

class HeaderController extends Controller
{
    public function headers(Request $request)
    {

        // logo
        $logo = DB::table('channels')->select(DB::raw("CONCAT('http://151.80.237.29/public/storage/','', logo) as logo_url"),DB::raw("CONCAT('http://151.80.237.29/public/storage/','', favicon) as favicon_url"))->get();

        // end logo

        // menu
        $menu =  DB::table('velocity_contents_translations')
        ->join('velocity_contents', 'velocity_contents_translations.content_id', '=', 'velocity_contents.id')
        ->select('velocity_contents.id','velocity_contents_translations.title','velocity_contents_translations.page_link','velocity_contents.type')
        ->where('velocity_contents_translations.locale','en')
        ->where('velocity_contents.visible_in_footer',0)
        ->where('velocity_contents.status',1)
        ->get();
        // end menu
        
        return response([
            'Logo'           =>$logo,
            'Header_Menu'    =>$menu,
        ]);
        

    }


    public function headersfrench(Request $request)
    {

        // logo
        $logo = DB::table('channels')->select(DB::raw("CONCAT('http://151.80.237.29/public/storage/','', logo) as logo_url"),DB::raw("CONCAT('http://151.80.237.29/public/storage/','', favicon) as favicon_url"))->get();

        // end logo

        // menu
        $menu =  DB::table('velocity_contents_translations')
        ->join('velocity_contents', 'velocity_contents_translations.content_id', '=', 'velocity_contents.id')
        ->select('velocity_contents.id','velocity_contents_translations.title','velocity_contents_translations.page_link','velocity_contents.type')
        ->where('velocity_contents_translations.locale','fr')
        ->where('velocity_contents.visible_in_footer',0)
        ->where('velocity_contents.status',1)
        ->get();
        // end menu
        
        return response([
            'Logo'           =>$logo,
            'Header_Menu'    =>$menu,
        ]);
        

    }
}