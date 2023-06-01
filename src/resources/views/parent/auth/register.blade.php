@extends('admin.layouts.auth')



@section('content')

<div class="row justify-content-center">
    <div class="col-md-8 col-lg-6 col-xl-5">
        <div class="card mt-4">

            <div class="card-body p-4">
                <div class="text-center mt-2">
                    <h5 class="text-primary">New User ?</h5>
                    <p class="text-muted">Register with COTTON CULTURE.</p>
                </div>
                <div class="p-2 mt-4">
                    <form id="loginForm" method="post" action="{{route('signup_store')}}">
                    @csrf
                        <div class="mb-3">
                            @include('admin.includes.input', ['key'=>'name', 'label'=>'Name', 'value'=>old('name')])
                        </div>

                        <div class="mb-3">
                            @include('admin.includes.input', ['key'=>'email', 'label'=>'Email', 'value'=>old('email')])
                        </div>

                        <div class="mb-3">
                            @include('admin.includes.password_input', ['key'=>'password', 'label'=>'Password', 'value'=>''])
                        </div>

                        <div class="mb-3">
                            @include('admin.includes.password_input', ['key'=>'cpassword', 'label'=>'Confirm Password', 'value'=>''])
                        </div>

                        <div class="mt-4">
                            <button class="btn btn-success w-100" type="submit">Sign Up</button>
                            <p class="mt-3">Already have an account? <a href="{{route('signin')}}" class="text-muted">Sign In</a></p>
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
.addField('#name', [
    {
      rule: 'required',
      errorMessage: 'Name is required',
    },
  ])
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
    },
    {
      rule: 'strongPassword',
    },
  ])
  .addField('#cpassword', [
    {
      rule: 'required',
      errorMessage: 'Confirm Password is required',
    },
    {
        validator: (value, fields) => {
        if (fields['#password'] && fields['#password'].elem) {
            const repeatPasswordValue = fields['#password'].elem.value;

            return value === repeatPasswordValue;
        }

        return true;
        },
        errorMessage: 'Password and Confirm Password must be same',
    },
  ])
  .onSuccess((event) => {
    event.target.submit();
  });
</script>

@stop
