<?php

namespace App\Http\Controllers\Admin\Auth;

use App\Http\Controllers\Controller;
use App\Services\RateLimitService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Password;

class ForgotPasswordPageController extends Controller
{
    public function index(){
        return view('admin.auth.forgot_password');
    }

    public function requestForgotPassword(Request $request) {

        (new RateLimitService($request))->ensureIsNotRateLimited(3);

        $request->validate([
            'email' => ['required','string','email','max:255','exists:App\Models\User,email'],
        ]);

        $status = Password::sendResetLink(
            $request->only('email')
        );
        if($status === Password::RESET_LINK_SENT){
            (new RateLimitService($request))->clearRateLimit();
            return redirect(route('forgot_password'))->with(['success_status' => __($status)]);
        }
        return redirect(route('forgot_password'))->with(['error_status' => __($status)]);

    }
}
