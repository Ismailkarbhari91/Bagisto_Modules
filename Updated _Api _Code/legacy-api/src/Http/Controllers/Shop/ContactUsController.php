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
use Illuminate\Support\Carbon;

class ContactUsController extends Controller
{
    public function contactus(Request $request)
    {

        $data = $request->validate([
            'name' => 'string|max:255',
            'email' => 'string|email|max:255|unique:users',
            'message_title'=>'string',
            'message_body' => 'string',
            'phone' => 'string',

        ]);
    
        $date = Carbon::now();
        $data=array("name"=>$data['name'] ,"email"=>$data['email'],"message_title"=>$data['message_title'],"message_body"=>$data['message_body'],"phone"=>$data['phone'],"created_at"=>$date);


        $user= DB::table('contacts')->insert($data);

    
        return response()->json([
            'message' => 'Form Submitted Successfully',
            'data' => $user,
        ], 201);

    }

    public function contactusdata(Request $request)
    {

        $contact_us =  DB::table('contactusdata')
        ->select('contact_us_heading','company_name','address','mobile_number as fax_number','phone_number','email','whatsapp_number',DB::raw("CONCAT('http://151.80.237.29/public/storage/public/images/','', image_url) as image_url"),'map_visibility')
        ->get();

        $p =  DB::table('contactusdata')
        ->select('contact_us_data_position as position')
        ->get();

        $position['Conatct_Us_Data Position']=$p;

        $pe =  DB::table('contactusdata')
        ->select('contact_us_form_position as position')
        ->get();


        $position['Conatct_Us_Form_Position']=$pe;

        return response([
            'Contact_Us_Data'    =>$contact_us,
            'Position'    =>$position,
        ]);

    }


    // 

    public function contactusdatafr(Request $request)
    {

        $contact_us =  DB::table('contactusdatafrech')
        ->select('contact_us_heading_fr as contact_us_heading','company_name_fr as company_name','address_fr as address','mobile_number_fr as fax_number','phone_number_fr as phone_number','email_fr as email','whatsapp_number_fr as whatsapp_number','map_visibility_fr as map_visibility')
        ->get();

        // $p =  DB::table('contactusdata')
        // ->select('contact_us_data_position as position')
        // ->get();

        // $position['Conatct_Us_Data Position']=$p;

        // $pe =  DB::table('contactusdata')
        // ->select('contact_us_form_position as position')
        // ->get();


        // $position['Conatct_Us_Form_Position']=$pe;

        return response([
            'Contact_Us_Data'    =>$contact_us,
            // 'Position'    =>$position,
        ]);

    }

    // 
}