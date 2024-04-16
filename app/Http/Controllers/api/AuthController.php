<?php

namespace App\Http\Controllers\api;

use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Mail;

class AuthController extends Controller
{
    public function user(Request $request){
        $user = $request->user();
//        $user = Auth::user();
        return response()->json([
            'user'=>$user,
        ],200);

    }


    public function register(Request $request)
    {


        $validator = Validator::make($request->all(), [
            'name'=>'required',
            'email' => 'required|max:100|email',
            'password' => 'required|max:255|min:8',
        ], [
            'email.required' => 'هذه الحقل مطلوب',
            'email.max' => 'لا يمكن تخطي اللحد الاقصي',
            'email.email'=>'يرجي كتاابه بريد صالح',
            'password.required' => 'هذه الحقل مطلوب',
            'password.max' => 'لا يمكن تخطي اللحد الاقصي',
        ]);

        if ($validator->fails()) {
            return response()->json(['error' => $validator->errors()]);
        };



        $users = User::create([
            'name'=>$request->name,
            'email'=>$request->email,
            'password'=>bcrypt($request->password),
        ]);



        $token = $users->createToken('auth_token')->plainTextToken;

        return response()->json([
            'status'=>200,
            'access_token'=>$token,
            'token_type'=>'Bearer',
        ]);


    }

    public function login(Request $request)
    {

        $validator = Validator::make($request->all(), [
            'email' => 'required|max:100|email',
            'password' => 'required|max:255',
        ], [
            'email.required' => 'هذه الحقل مطلوب',
            'email.max' => 'لا يمكن تخطي اللحد الاقصي',
            'email.email'=>'يرجي كتاابه بريد صالح',
            'password.required' => 'هذه الحقل مطلوب',
            'password.max' => 'لا يمكن تخطي اللحد الاقصي',
        ]);

        if ($validator->fails()) {
            return response()->json(['message' => $validator->errors()]);
        };


        $credentials = request(['email', 'password']);

        if (! $token = auth()->attempt($credentials)) {
            return response()->json(['message' => 'Unauthorized'], 401);
        }



        $user = auth()->user();

        $token = $user->createToken('auth_token')->plainTextToken;

        return response()->json([
           'status'=>200,
           'access_token'=>$token,
            'token_type'=>'Bearer'
        ]);
    }

    public function logout(Request $request)
    {
       Auth::user()->tokens()->delete();

//        auth()->user()->currentAccessToken->delete();

        return response()->json([
            'status' => 200,
            'message' => 'Logout Success',
        ]);
    }

    public function resetPassword(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required|max:100|email|exists:users,email',
        ], [
            'email.required' => 'هذه الحقل مطلوب',
            'email.exists' => 'هذه الايميل غير موجود',
            'email.max' => 'لا يمكن تخطي اللحد الاقصي',
            'email.email'=>'يرجي كتاابه بريد صالح',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'message' => $validator->errors(),
                'status'=>500
            ]);
        };

        $user = User::where('email',$request->email)->first();

        if(!$user){
            return response()->json(['status'=>500,'message'=>'this email not found']);
        }

        $token = $user->createToken('auth_token')->plainTextToken;

        $toEmail = $request->email;
        $subject = 'reset password notifcation';
        $fromEmail = 'app@gmail.com';
        $name = $user->name;

        $data = array('name'=>$name,'token' =>$token);

        Mail::send('emails.email',$data,function($message) use ($toEmail,$subject,$fromEmail){
            $message->to($toEmail)->subject($subject);
            $message->from($fromEmail);
        });

        return response()->json(['status'=>200,'message'=>'email sended']);

    }


    public function resetPass(Request $request)
    {

        $id = $request->user()->id;

        $user = User::find($id)->update([
            'password' => bcrypt($request->password)
        ]);
        return response()->json([
            'status' => 200,
            'message' => 'password change success'
        ]);
    }

}
