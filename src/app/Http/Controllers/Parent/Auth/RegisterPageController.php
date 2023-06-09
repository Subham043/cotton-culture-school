<?php

namespace App\Http\Controllers\Parent\Auth;

use App\Enums\Role;
use App\Http\Controllers\Controller;
use App\Models\User;
use App\Services\RateLimitService;
use Stevebauman\Purify\Facades\Purify;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rules\Password as PasswordValidation;
use Illuminate\Auth\Events\Registered;

class RegisterPageController extends Controller
{
    public function index(){
        return view('parent.auth.register');
    }

    public function post(Request $request){

        (new RateLimitService($request))->ensureIsNotRateLimited(3);

        $request->validate([
            'name' => ['required','string'],
            'phone' => ['required','numeric', 'digits:10','unique:users'],
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
            'confirm_password' => ['required_with:password', 'same:password'],
        ],
        [
            'email.required' => 'Please enter the email !',
            'email.email' => 'Please enter the valid email !',
            'password.required' => 'Please enter the password !',
            'password.regex' => 'Please enter the valid password !',
        ]);

        $user = User::create(Purify::clean(
            [
                ...$request->all(),
                'role' => Role::PARENT->value
            ]
        ));
        event(new Registered($user));

        Auth::login($user);

        return redirect()->intended(route('parent_dashboard'))->with('success_status', 'Logged in successfully.');
    }
}
