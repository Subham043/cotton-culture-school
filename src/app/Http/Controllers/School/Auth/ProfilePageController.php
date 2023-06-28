<?php

namespace App\Http\Controllers\School\Auth;

use App\Http\Controllers\Controller;
use App\Models\Cart;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Stevebauman\Purify\Facades\Purify;
use Illuminate\Validation\Rules\Password as PasswordValidation;

class ProfilePageController extends Controller
{

    public function index(){
        $cart = Cart::with(['product'])->where('user_id', auth()->user()->id)->latest()->get();
        $cart_total = $cart->reduce(function ($total, $item) {
            return $total + $item->cart_quantity_price;
        },0);
        return view('school.profile.index', compact([
            'cart', 'cart_total'
        ]));
    }

    public function update(Request $req){
        $rules = array(
            'name' => ['required','regex:/^[a-zA-Z0-9\s]*$/'],
            'email' => ['required','email','unique:users,email,'.Auth::user()->id],
            'phone' => ['required','numeric','unique:users,phone,'.Auth::user()->id],
        );
        $messages = array(
            'name.required' => 'Please enter the name !',
            'name.regex' => 'Please enter the valid name !',
            'email.required' => 'Please enter the email !',
            'email.email' => 'Please enter the valid email !',
        );

        $validator = Validator::make($req->all(), $rules, $messages);
        if($validator->fails()){
            return response()->json(["errors"=>$validator->errors()], 400);
        }

        $req->user()->fill(Purify::clean($req->only(['email', 'phone', 'name'])));

        if ($req->user()->isDirty('email')) {
            $req->user()->email_verified_at = null;
            $req->user()->sendEmailVerificationNotification();
        }

        $result = $req->user()->save();

        if($result){
            return response()->json(["message" => "Profile Updated successfully."], 201);
        }else{
            return response()->json(["error"=>"something went wrong. Please try again"], 400);
        }
    }

    public function change_profile_password(Request $req){
        $rules = array(
            'opassword' => ['required','string', function ($attribute, $value, $fail) {
                if (!Hash::check($value, Auth::user()->password)) {
                    $fail('The Old Password entered is incorrect.');
                }
            }],
            'password' => ['required',
                'string',
                PasswordValidation::min(8)
                        ->letters()
                        ->mixedCase()
                        ->numbers()
                        ->symbols()
                        ->uncompromised()
            ],
            'cpassword' => 'required_with:password|same:password',
        );
        $messages = array(
            'opassword.required' => 'Please enter your old password !',
            'password.required' => 'Please enter your password !',
            'cpassword.required' => 'Please enter your confirm password !',
            'cpassword.same' => 'password & confirm password must be the same !',
        );

        $validator = Validator::make($req->all(), $rules, $messages);
        if($validator->fails()){
            return response()->json(["errors"=>$validator->errors()], 400);
        }

        $req->user()->fill($req->only([
            'password' => Hash::make(Purify::clean($req->password))
        ]));

        $result = $req->user()->save();

        if($result){
            return response()->json(["message" => "Password Updated successfully."], 201);
        }else{
            return response()->json(["error"=>"something went wrong. Please try again"], 400);
        }
    }

}
