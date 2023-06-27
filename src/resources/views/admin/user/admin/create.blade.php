@extends('layouts.dashboard')

@section('content')

<div class="page-content">
    <div class="container-fluid">

        <!-- start page title -->
        @include('includes.breadcrumb', ['page'=>'Admin', 'page_link'=>route('user.admin.paginate.get'), 'list'=>['Create']])
        <!-- end page title -->

        <div class="row">
            @include('includes.back_button', ['link'=>route('user.admin.paginate.get')])
            <div class="col-lg-12">
                <form id="countryForm" method="post" action="{{route('user.admin.create.post')}}" enctype="multipart/form-data">
                @csrf
                    <div class="card">
                        <div class="card-header align-items-center d-flex">
                            <h4 class="card-title mb-0 flex-grow-1">Admin Detail</h4>
                        </div><!-- end card header -->
                        <div class="card-body">
                            <div class="live-preview">
                                <div class="row gy-4">
                                    <div class="col-xxl-4 col-md-4">
                                        @include('includes.input', ['key'=>'name', 'label'=>'Name', 'value'=>old('name')])
                                    </div>
                                    <div class="col-xxl-4 col-md-4">
                                        @include('includes.input', ['key'=>'email', 'label'=>'Email', 'value'=>old('email')])
                                    </div>
                                    <div class="col-xxl-4 col-md-4">
                                        @include('includes.input', ['key'=>'phone', 'label'=>'Phone', 'value'=>old('phone')])
                                    </div>
                                    <div class="col-xxl-6 col-md-6">
                                        @include('includes.password_input', ['key'=>'password', 'label'=>'Password', 'value'=>''])
                                    </div>
                                    <div class="col-xxl-6 col-md-6">
                                        @include('includes.password_input', ['key'=>'confirm_password', 'label'=>'Confirm Password', 'value'=>''])
                                    </div>

                                    <div class="col-xxl-12 col-md-12">
                                        <button type="submit" class="btn btn-primary waves-effect waves-light" id="submitBtn">Create</button>
                                    </div>

                                </div>
                                <!--end row-->
                            </div>

                        </div>
                    </div>
                </form>
            </div>
            <!--end col-->
        </div>
        <!--end row-->



    </div> <!-- container-fluid -->
</div><!-- End Page-content -->



@stop


@section('javascript')

<script type="text/javascript">

// initialize the validation library
const validation = new JustValidate('#countryForm', {
      errorFieldCssClass: 'is-invalid',
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
  .onSuccess(async (event) => {
    event.target.submit();
  });

</script>

@stop
