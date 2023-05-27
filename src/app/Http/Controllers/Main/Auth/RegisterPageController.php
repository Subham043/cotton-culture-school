<?php

namespace App\Http\Controllers\Main\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Stevebauman\Purify\Facades\Purify;
use Illuminate\Validation\Rules\Password as PasswordValidation;
use Illuminate\Auth\Events\Registered;

class RegisterPageController extends Controller
{
    public function index(){
        return view('admin.pages.auth.register');
    }

    public function store(Request $req) {
        $req->validate([
            'name' => ['required','regex:/^[a-zA-Z0-9\s]*$/'],
            'email' => ['required','email','unique:users'],
            'password' => ['required',
                'string',
                PasswordValidation::min(8)
                        ->letters()
                        ->mixedCase()
                        ->numbers()
                        ->symbols()
                        ->uncompromised()
            ],
            'cpassword' => ['required_with:password|same:password'],
        ],
        [
            'name.required' => 'Please enter the name !',
            'name.regex' => 'Please enter the valid name !',
            'email.required' => 'Please enter the email !',
            'email.email' => 'Please enter the valid email !',
            'password.required' => 'Please enter the password !',
            'password.regex' => 'Please enter the valid password !',
            'cpassword.required' => 'Please enter your confirm password !',
            'cpassword.same' => 'password & confirm password must be the same !',
        ]);

        $user = User::create(Purify::clean([
            ...$req->except('password'),
            'password' => Hash::make($req->password)
        ]));

        event(new Registered($user));

        Auth::login($user);

        return redirect()->intended(route('dashboard'))->with('success_status', 'Logged in successfully.');

    }

}
