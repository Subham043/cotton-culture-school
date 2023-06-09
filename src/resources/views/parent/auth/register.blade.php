@extends('layouts.parent_auth')



@section('content')

<div class="row justify-content-center">
    <div class="col-md-8 col-lg-6 col-xl-5">
        <div class="card mt-4">

            <div class="card-body p-4">
                <div class="text-center mt-2">
                    <h5 class="text-primary">Registration !</h5>
                    <p class="text-muted">Sign up to continue with COTTON CULTURE.</p>
                </div>
                <div class="p-2 mt-4">
                    <form id="loginForm" method="post" action="{{route('parent_register_post')}}">
                    @csrf
                        <div class="mb-3">
                            @include('includes.input', ['key'=>'name', 'label'=>'Name', 'value'=>old('name')])
                        </div>

                        <div class="mb-3">
                            @include('includes.input', ['key'=>'email', 'label'=>'Email', 'value'=>old('email')])
                        </div>

                        <div class="mb-3">
                            @include('includes.input', ['key'=>'phone', 'label'=>'Phone', 'value'=>old('phone')])
                        </div>

                        <div class="mb-3">
                            @include('includes.password_input', ['key'=>'password', 'label'=>'Password', 'value'=>''])
                        </div>

                        <div class="mb-3">
                            @include('includes.password_input', ['key'=>'confirm_password', 'label'=>'Password', 'value'=>''])
                        </div>

                        <div class="mt-4">
                            <button class="btn btn-success w-100" type="submit">Sign up</button>
                        </div>

                    </form>
                </div>
            </div>
            <!-- end card body -->
        </div>
        <!-- end card -->

        <div class="mt-4 text-center">
            <p class="mb-0">Wait, I already have an account... <a href="{{route('parent_signin')}}" class="fw-semibold text-primary text-decoration-underline"> Click here </a> </p>
        </div>

    </div>
</div>

@stop

@section('javascript')
<script type="text/javascript">

// initialize the validation library
const validation = new JustValidate('#loginForm', {
      errorFieldCssClass: 'is-invalid',
      focusInvalidField: true,
      lockForm: true,
});
// apply rules to form fields
validation
  .addField('#email', [
    {
      rule: 'required',
      errorMessage: 'Email is required',
    },
    {
      rule: 'email',
      errorMessage: 'Email is invalid!',
    },
  ])
  .addField('#password', [
    {
      rule: 'required',
      errorMessage: 'Password is required',
    }
  ])
  .addField('#confirm_password', [
    {
      rule: 'required',
      errorMessage: 'Confirm Password is required',
    }
  ])
  .addField('#name', [
    {
      rule: 'required',
      errorMessage: 'Name is required',
    }
  ])
  .addField('#phone', [
    {
      rule: 'required',
      errorMessage: 'Phone is required',
    }
  ])
  .onSuccess((event) => {
    event.target.submit();
  });
</script>

@stop
