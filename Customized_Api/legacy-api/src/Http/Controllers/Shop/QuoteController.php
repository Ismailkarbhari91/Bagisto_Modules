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
use Illuminate\Support\Carbon;

class QuoteController extends Controller
{
    // public function quote(Request $request)
    // {

    //     //
        
    
        
    //     // 
    //     $datas = $request->validate([
    //         'name' => 'string|max:255',
    //         'email' => 'string|email|max:255|unique:users',
    //         'phone' => 'string',
    //         'address' => 'string',
    //         'subject' => 'string',
    //         'message_body' =>'string',
    //         'quantity' => 'string',
    //         'pid' =>'string',
    //     ]);
        
    //     $id_list = $datas['pid'];
    //     $qty_list = $datas['quantity'];
    //     $id_array = explode(",", $id_list);
    //     $qty_array =  explode(",", $qty_list);
        
    //     $data = [];
        
    //     for ($i = 0; $i < count($id_array); $i++) {
    //         $data[] = [
    //             "name" => $datas['name'],
    //             "email" => $datas['email'],
    //             "phone" => $datas['phone'],
    //             "message_body" => $datas['message_body'],
    //             "address" => $datas['address'],
    //             "subject" => $datas['subject'],
    //             "quantity" => $qty_array[$i],
    //             "pid" => $id_array[$i]
    //         ];
    //     }
        
    //     $user = DB::table('quote')->insert($data);

    //     $quote = DB::table('quote')->orderBy('id', 'desc')->first();
    
    
    //     $admin_email = 'ismailkarbhari91@gmail.com';
    //     Mail::send('emails.api_data', ['quote' => $quote], function ($message) use ($admin_email) {
    //         $message->to($admin_email);
    //         $message->subject('API Data');
    //     });


    //     $customer_email = $datas['email'];
    //     Mail::send('emails.customer_data', $datas, function ($message) use ($customer_email) {
    //         $message->to($customer_email);
    //         $message->subject('API Data');
    //     });
        
    //     return response()->json([
    //         'message' => 'Quotation Created Successfully',
    //         'data' => $user,
    //     ], 201);

    // }


public function quote(Request $request)
{
    $datas = $request->validate([
        'name' => 'string|max:255',
        'email' => 'string|email|max:255|unique:users',
        'phone' => 'string',
        'address' => 'string',
        'subject' => 'string',
        'message_body' =>'string',
        'quantity' => 'string',
        'pid' =>'string',
    ]);
    
    $id_list = $datas['pid'];
    $qty_list = $datas['quantity'];
    $id_array = explode(",", $id_list);
    $qty_array =  explode(",", $qty_list);
    $date = Carbon::now();
    
    $data = [];
    
    for ($i = 0; $i < count($id_array); $i++) {
        $data[] = [
            "name" => $datas['name'],
            "email" => $datas['email'],
            "phone" => $datas['phone'],
            "message_body" => $datas['message_body'],
            "address" => $datas['address'],
            "subject" => $datas['subject'],
            "quantity" => $qty_array[$i],
            "pid" => $id_array[$i],
            "created_at" => $date
        ];
    }
    
    $user = DB::table('quote')->insert($data);


    $quote = DB::table('quote')->whereIn('pid', $id_array)->get();



    $pflat = DB::table('product_flat')
    ->select('name')
    ->whereIn('id', $id_array)
    ->get();

    
    $admin_email = 'ismailkarbhari91@gmail.com';
    Mail::send('emails.api_data', ['quotes' => $datas,'flat'=> $pflat], function ($message) use ($admin_email) {
        $message->to($admin_email);
        $message->subject('Quotation Request');
    });

    $customer_email = $datas['email'];
    Mail::send('emails.customer_data', $datas, function ($message) use ($customer_email) {
        $message->to($customer_email);
        $message->subject('Quotation Request');
    });
    
    return response()->json([
        'message' => 'Quotation Created Successfully',
        'data' => $user,
    ], 201);
}



}