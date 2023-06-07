<?php

namespace Webkul\Quote\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Event;
use Illuminate\Support\Facades\File;
use Webkul\Quote\Repositories\QuoteRepository as Quote;
// use Webkul\Quote\Models\Quote;
use DB;


class QuoteController extends Controller
{

    protected $_config;

    protected $quote;

    public function __construct(Quote $quote)
    {
        $this->quote             = $quote;
        $this->_config              = request('_config');
    }


    public function show()
    {
        return view($this->_config['view']);
    }


    public function index()
    {

        $data = request()->all();
        //  print_r($data);

        $quote       = $this->quote->all();
        return view($this->_config['view'], compact('quote'));
    }


    public function view($id)
    {
        $quote = $this->quote->findOrFail($id);

        return view($this->_config['view'], compact('quote'));
    }


    public function quotestatus($id)
    {
           $quote  = $this->quote->findOrFail($id);
        return view($this->_config['view'], compact('quote'));
    }


    public function updatestatus(Request $request)
    {
        // $quote       = $this->quote->findOrFail($id);
        // $quote = $request()->all();
        // $quotestatus          =$quote->quotestatus;
        
        $id=$request->ID;
        $quote=$request->quotestatus;  
 
         DB::table('quote')
            ->where('id', $id )
            ->update(['quotestatus' =>$quote]);

            return redirect()->route($this->_config['redirect']);

         
    }

    public function destroy($id=null)
    {
        
        $quote = $this->quote->findorFail($id);

        try {
            $this->quote->delete($id);

            session()->flash('success', trans('quote_lang::app.response.delete-success', ['name' => 'Message']));

        } catch(\Exception $e) {
            session()->flash('error', trans('quote_lang::app.response.delete-failed', ['name' => 'Message']));
        }


        return response()->json(['message' => false], 400);
    
    }
// 


// 


    // Shop Section
    public function sendMessage()
    {
        $this->validate(request(), [
            'name'              => 'required',
            'email'             => 'required',
        ]);

        $data = request()->all();
        //  print_r($data);
        

        try {
    
                $name          =$data['name'];
                $email         = $data['email'];
                $phone         = $data['phone'];
                $quantity         =$data['quantity'];
                $country        = $data['country'];
                $pincode         =$data['pincode'];
                $locationtype         = $data['locationtype'];
                $date         = $data['date'];
                $company_name         = $data['company_name'];
                $currency         = $data['pcurrency'];
                $message_body  = $data['message_body'];
                $pid=$data['pid'];
                
                $data=array("name"=>$name ,"email"=>$email,"phone"=>$phone,"quantity"=>$quantity,"country"=> $country,"pincode"=> $pincode,"locationtype"=> $locationtype,"date"=> $date,"company_name"=>$company_name,
                "pcurrency"=> $currency,
                "message_body"=>$message_body,'pid'=>$pid);

            $q= DB::table('quote')->insert($data);

            // print_r($q);

            if ($q) {
                session()->flash('success', trans('quote_lang::app.response.message-send-success'));
                return redirect()->route($this->_config['redirect']);
            }
        }catch (\Exception $e) {

        }

            
    }

    


}
