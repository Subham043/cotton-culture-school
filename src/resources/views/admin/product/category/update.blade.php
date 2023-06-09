@extends('layouts.dashboard')


@section('content')

<div class="page-content">
    <div class="container-fluid">

        <!-- start page title -->
        @include('includes.breadcrumb', ['page'=>'Category', 'page_link'=>route('category.paginate.get'), 'list'=>['Create']])
        <!-- end page title -->

        <div class="row">
            @include('includes.back_button', ['link'=>route('category.paginate.get')])
            <div class="col-lg-12">
                <form id="countryForm" method="post" action="{{route('category.update.post', $data->id)}}" enctype="multipart/form-data">
                @csrf
                    <div class="card">
                        <div class="card-header align-items-center d-flex">
                            <h4 class="card-title mb-0 flex-grow-1">Category Detail</h4>
                        </div><!-- end card header -->
                        <div class="card-body">
                            <div class="live-preview">
                                <div class="row gy-4">
                                    <div class="col-xxl-6 col-md-6">
                                        @include('includes.input', ['key'=>'name', 'label'=>'Name', 'value'=>$data->name])
                                    </div>
                                    <div class="col-xxl-6 col-md-6">
                                        @include('includes.select', ['key'=>'gender', 'label'=>'Gender'])
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
<script src="{{ asset('admin/js/pages/choices.min.js') }}"></script>

<script type="text/javascript">

// initialize the validation library
const validation = new JustValidate('#countryForm', {
      errorFieldCssClass: 'is-invalid',
});
// apply rules to form fields
validation
.addField('#name', [
    {
      rule: 'required',
      errorMessage: 'Name is required',
    },
  ])
  .addField('#gender', [
    {
      rule: 'required',
      errorMessage: 'Gender is required',
    },
  ])
  .onSuccess(async (event) => {
    event.target.submit();
  });


  const genderChoice = new Choices('#gender', {
        choices: [
            @foreach($genders as $val)
                {
                    value: '{{$val}}',
                    label: '{{$val}}',
                    selected: {{($data->gender->value==$val) ? 'true' : 'false'}},
                },
            @endforeach
        ],
        placeholderValue: 'Select a gender',
        ...CHOICE_CONFIG
    });
</script>

@stop