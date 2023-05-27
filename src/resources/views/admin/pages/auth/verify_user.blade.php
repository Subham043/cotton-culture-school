@extends('admin.layouts.auth')



@section('content')

<div class="row justify-content-center">
    <div class="col-md-8 col-lg-6 col-xl-5">
        <div class="card mt-4">

            <div class="card-body p-4">
                <div class="text-center mt-2">
                    <h5 class="text-primary">Verify Email.</h5>
                    <p class="text-muted">{{ __('Thanks for signing up! Before getting started, could you verify your email address by clicking on the link we just emailed to you? If you didn\'t receive the email, we will gladly send you another.') }}</p>
                </div>
                <div class="p-2 mt-4">
                    <form action="{{route('verification.send')}}" method="post" id="loginForm">
                        @csrf
                        </div>

                        <div class="form-button d-flex gap-2">
                            <button type="submit" class="btn btn-success w-100">Resend Verification Email</button>
                            <a type="button" href="{{route('signout')}}" class="btn btn-success w-100">
                                {{ __('Log Out') }}
                            </a>
                        </div>
                    </form>
                </div>
            </div>
            <!-- end card body -->
        </div>
        <!-- end card -->

    </div>
</div>

@stop
