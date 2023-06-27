@extends('layouts.dashboard')

@section('content')

<div class="page-content">
    <div class="container-fluid">

        <!-- start page title -->
        @include('includes.breadcrumb', ['page'=>'Parent', 'page_link'=>route('user.parent.paginate.get'), 'list'=>['Create']])
        <!-- end page title -->

        <div class="row" id="image-container">
            @include('includes.back_button', ['link'=>route('user.parent.paginate.get')])
            <div class="col-lg-12">
                <form id="countryForm" method="post" action="{{route('user.parent.update.post', $data->id)}}" enctype="multipart/form-data">
                @csrf
                    <div class="card">
                        <div class="card-header align-items-center d-flex">
                            <h4 class="card-title mb-0 flex-grow-1">Parent Detail</h4>
                        </div><!-- end card header -->
                        <div class="card-body">
                            <div class="live-preview">
                                <div class="row gy-4">
                                    <div class="col-xxl-4 col-md-4">
                                        @include('includes.input', ['key'=>'name', 'label'=>'Name', 'value'=>$data->name])
                                    </div>
                                    <div class="col-xxl-4 col-md-4">
                                        @include('includes.input', ['key'=>'email', 'label'=>'Email', 'value'=>$data->email])
                                    </div>
                                    <div class="col-xxl-4 col-md-4">
                                        @include('includes.input', ['key'=>'phone', 'label'=>'Phone', 'value'=>$data->phone])
                                    </div>

                                    <div class="col-xxl-12 col-md-12">
                                        <button type="submit" class="btn btn-primary waves-effect waves-light" id="submitBtn">Update</button>
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
