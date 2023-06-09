@extends('layouts.dashboard')


@section('content')

<div class="page-content">
    <div class="container-fluid">

        <!-- start page title -->
        @include('includes.breadcrumb', ['page'=>'School', 'page_link'=>route('school.paginate.get'), 'list'=>['Create']])
        <!-- end page title -->

        <div class="row">
            @include('includes.back_button', ['link'=>route('school.paginate.get')])
            <div class="col-lg-12">
                <form id="countryForm" method="post" action="{{route('school.create.post')}}" enctype="multipart/form-data">
                @csrf
                    <div class="card">
                        <div class="card-header align-items-center d-flex">
                            <h4 class="card-title mb-0 flex-grow-1">School Detail</h4>
                        </div><!-- end card header -->
                        <div class="card-body">
                            <div class="live-preview">
                                <div class="row gy-4">
                                    <div class="col-xxl-4 col-md-4">
                                        @include('includes.input', ['key'=>'name', 'label'=>'Name', 'value'=>old('name')])
                                    </div>
                                    <div class="col-xxl-4 col-md-4">
                                        @include('includes.select', ['key'=>'submission_duration', 'label'=>'Submission Duration'])
                                    </div>
                                    <div class="col-xxl-4 col-md-4">
                                        @include('includes.file_input', ['key'=>'logo', 'label'=>'Logo'])
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
  .addField('#submission_duration', [
    {
      rule: 'required',
      errorMessage: 'Submission End Date is required',
    },
  ])
  .addField('#logo', [
    {
        rule: 'minFilesCount',
        value: 1,
        errorMessage: 'Logo is required',
    },
    {
        rule: 'maxFilesCount',
        value: 1,
        errorMessage: 'Only One Logo is required',
    },
    {
        rule: 'files',
        value: {
        files: {
            extensions: ['jpeg', 'jpg', 'png', 'webp'],
            maxSize: 500000,
            types: ['image/jpeg', 'image/jpg', 'image/png', 'image/webp'],
        },
        },
        errorMessage: 'Logo with jpeg,jpg,png,webp extensions is allowed! Logo size should not exceed 500kb!',
    },
  ])
  .onSuccess(async (event) => {
    event.target.submit();
  });

  const submissionChoice = new Choices('#submission_duration', {
        choices: [
            {
                value: '',
                label: 'Select submission duration (in days)',
                selected: {{empty(old('submission_duration')) ? 'true' : 'false'}},
                disabled: true,
            },
            @for($i=1; $i<=60; $i++)
                {
                    value: '{{$i}}',
                    label: '{{$i}}',
                    selected: {{(old('submission_duration')==$i) ? 'true' : 'false'}},
                },
            @endfor
        ],
        placeholderValue: 'Select submission duration (in days)',
        ...CHOICE_CONFIG
    });

</script>

@stop
