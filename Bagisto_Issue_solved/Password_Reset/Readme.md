# Go to vendor/bagisto/legacy-api/src/Http/routes.php


# Add below routes code
~~~
 Route::post('passsword-reset', [ResetPaswordController::class, 'passwordreset']);
 ~~~

 # Add Controller in routes.php file to top of the file
 ~~~
 use Webkul\API\Http\Controllers\Shop\ResetPaswordController;
~~~


# Now Craete a controller file name ResetPaswordController in vendor/bagisto/legacy-api/src/Http/Controllers/Shop

# Add below code in that ResetPaswordController file
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
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Hash;
use Webkul\API\Http\Resources\Catalog\Product as ProductResource;

class ResetPaswordController extends Controller
{

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

~~~

# Create a resetpassword.blade.php in resources/views/emails

~~~

<!DOCTYPE html>
<html>
    <head>
        <title></title>
    </head>
    <body>
    <h3>Dear {{ !empty($fname) && !empty($lname) ? $fname . ' ' . $lname : 'User' }}</h3>
        <h4>You are receiving this email because we received a password reset request for your account.</h3>

        <p><a href="http://151.80.237.29:34055/reset-password"><button class="btn btn-primary">Reset Password</button></a></p>

        <h4>If you did not request a password reset, no further action is required.</h4>

        <h3>Thanks!</h3>
    </body>
</html>


~~~

# Replace href url with your url

# Now hit below routes for Rest Password
your-domain-name/api/passsword-reset