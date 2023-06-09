<?php

namespace App\Http\Controllers\Parent\Auth;

use App\Enums\Role;
use App\Http\Controllers\Controller;
use App\Services\RateLimitService;
use Stevebauman\Purify\Facades\Purify;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoginPageController extends Controller
{
    public function index(){
        return view('parent.auth.login');
    }

    public function authenticate(Request $request){

        (new RateLimitService($request))->ensureIsNotRateLimited(3);

        $request->validate([
            'email' => ['required','email'],
            'password' => ['required','regex:/^[a-z 0-9~%.:_\@\-\/\(\)\\\#\;\[\]\{\}\$\!\&\<\>\'\r\n+=,]+$/i'],
        ],
        [
            'email.required' => 'Please enter the email !',
            'email.email' => 'Please enter the valid email !',
            'password.required' => 'Please enter the password !',
            'password.regex' => 'Please enter the valid password !',
        ]);

        $credentials = Purify::clean($request->only('email', 'password', 'remember'));
        $credentials['role'] = Role::PARENT->value;

        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();
            (new RateLimitService($request))->clearRateLimit();
            return redirect()->intended(route('parent_dashboard'))->with('success_status', 'Logged in successfully.');
        }

        return redirect(route('parent_signin'))->with('error_status', 'Oops! You have entered invalid credentials');
    }
}
