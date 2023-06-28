@extends('layouts.school_dashboard')

@section('content')

<div class="page-content">
    <div class="container-fluid">

        <!-- start page title -->
        @include('includes.breadcrumb', ['page'=>'Address', 'page_link'=>route('school_address.paginate.get'), 'list'=>['Create']])
        <!-- end page title -->

        <div class="row">
            @include('includes.back_button', ['link'=>route('school_address.paginate.get')])
            <div class="col-lg-12">
                <form id="countryForm" method="post" action="{{route('school_address.create.post')}}" enctype="multipart/form-data">
                @csrf
                    <div class="card">
                        <div class="card-header align-items-center d-flex">
                            <h4 class="card-title mb-0 flex-grow-1">Address Detail</h4>
                        </div><!-- end card header -->
                        <div class="card-body">
                            <div class="live-preview">
                                <div class="row gy-4">
                                    <div class="col-xxl-3 col-md-3">
                                        @include('includes.input', ['key'=>'label', 'label'=>'Label', 'value'=>old('name')])
                                    </div>
                                    <div class="col-xxl-3 col-md-3">
                                        @include('includes.input', ['key'=>'city', 'label'=>'City', 'value'=>old('city')])
                                    </div>
                                    <div class="col-xxl-3 col-md-3">
                                        @include('includes.input', ['key'=>'state', 'label'=>'State', 'value'=>old('state')])
                                    </div>
                                    <div class="col-xxl-3 col-md-3">
                                        @include('includes.input', ['key'=>'pin', 'label'=>'Pin', 'value'=>old('pin')])
                                    </div>
                                    <div class="col-xxl-12 col-md-12">
                                        @include('includes.textarea', ['key'=>'address', 'label'=>'Address', 'value'=>old('address')])
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
  .addField('#label', [
    {
      rule: 'required',
      errorMessage: 'Label is required',
    },
  ])
  .addField('#city', [
    {
      rule: 'required',
      errorMessage: 'City is required',
    },
  ])
  .addField('#state', [
    {
      rule: 'required',
      errorMessage: 'State is required',
    },
  ])
  .addField('#pin', [
    {
      rule: 'required',
      errorMessage: 'Pin is required',
    },
  ])
  .addField('#address', [
    {
      rule: 'required',
      errorMessage: 'Address is required',
    },
  ])
  .onSuccess(async (event) => {
    event.target.submit();
  });
</script>

@stop
