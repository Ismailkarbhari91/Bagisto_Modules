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
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Hash;
use Webkul\API\Http\Resources\Catalog\Product as ProductResource;

class ResetPaswordController extends Controller
{


    public function resetpaswords(Request $request)
    {
        $datas = $request->validate([
            'email' =>'required|email',
            'password'      => 'confirmed|min:6',
        ]);

        $email = $datas['email'];
        $password = $datas['password'];

        $user = DB::table('customers')->where('email', $email)->first();
        
        if (!$user) {
            return response()->json(['message' => 'User not found'], 404);
        }
        
        DB::table('customers')->where('email', $email)->update(['password' => bcrypt($password)]);
        
        return response()->json(['message' => 'Password updated successfully']);
    }

    public function updatePassword(Request $request)
{
    $data = $request->validate([
        'customer_id' => 'required|string',
        'current_password' => 'required|string',
        'password' => 'required|string',
    ]);

    $customerId = $data['customer_id'];
    $newPassword = $data['password'];
    $currentPassword = $data['current_password'];

    try {
        $user = DB::table('customers')->where('id', $customerId)->first();
        if (!$user) {
            return response()->json(['message' => 'Customer not found'], 404);
        }

        if (!Hash::check($currentPassword, $user->password)) {
            return response()->json(['message' => 'Current password is incorrect'], 400);
        }

        DB::table('customers')->where('id', $customerId)->update(['password' => Hash::make($newPassword)]);
        
        return response()->json(['message' => 'Password updated successfully']);
    } catch (\Exception $e) {
        return response()->json(['message' => 'An error occurred while updating password'], 500);
    }
}

    public function passwordreset ( Request $request )
    {
        $datas = $request->validate([
            'email'      => 'required|email',
        ]);

        $email = $datas['email'];

        $username = explode('@', $email)[0];

        $user = DB::table('customers')->where('email', $email)->first();

        $fname = DB::table('customers')
        ->select('first_name')
        ->where('email', $email)
        ->value('first_name');

        $lname = DB::table('customers')
        ->select('last_name')
        ->where('email', $email)
        ->value('last_name');

        if (!$user) {
            return response()->json(['message' => 'email not found'], 404);
        }

        Mail::send('emails.resetpassword',['fname' => $fname,'lname'=>$lname], function ($message) use ($email) {
            $message->to($email);
            $message->subject('Customer Reset Password');
        });

        return response([
            'message' => 'We have e-mailed your password reset link!',
        ]);

    }

}