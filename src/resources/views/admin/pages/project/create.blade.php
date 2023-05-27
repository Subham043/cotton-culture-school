@extends('admin.layouts.dashboard')


@section('content')

<div class="page-content">
    <div class="container-fluid">

        <!-- start page title -->
        @include('admin.includes.breadcrumb', ['page'=>'Projects', 'page_link'=>route('project.paginate.get'), 'list'=>['Create']])
        <!-- end page title -->

        <div class="row">
            @include('admin.includes.back_button', ['link'=>route('project.paginate.get')])
            <div class="col-lg-12">
                <form id="countryForm" method="post" action="{{route('project.create.post')}}" enctype="multipart/form-data">
                @csrf
                    <div class="card">
                        <div class="card-header align-items-center d-flex">
                            <h4 class="card-title mb-0 flex-grow-1">Projects Detail</h4>
                        </div><!-- end card header -->
                        <div class="card-body">
                            <div class="live-preview">
                                <div class="row gy-4">
                                    <div class="col-xxl-3 col-md-3">
                                        @include('admin.includes.input', ['key'=>'name', 'label'=>'Project Name', 'value'=>old('name')])
                                    </div>
                                    <div class="col-xxl-3 col-md-3">
                                        @include('admin.includes.input', ['key'=>'number', 'label'=>'Project Number', 'value'=>old('number')])
                                    </div>
                                    <div class="col-xxl-3 col-md-3">
                                        @include('admin.includes.input', ['key'=>'facing', 'label'=>'Project Facing', 'value'=>old('facing')])
                                    </div>
                                    <div class="col-xxl-3 col-md-3">
                                        @include('admin.includes.input', ['key'=>'site_measurement', 'label'=>'Project Site Measurement', 'value'=>old('site_measurement')])
                                    </div>
                                    <div class="col-xxl-4 col-md-4">
                                        @include('admin.includes.select', ['key'=>'project_type', 'label'=>'Project Type'])
                                    </div>
                                    <div class="col-xxl-4 col-md-4">
                                        @include('admin.includes.select', ['key'=>'type', 'label'=>'Project Room Type'])
                                    </div>
                                    <div class="col-xxl-4 col-md-4">
                                        @include('admin.includes.select', ['key'=>'availibility', 'label'=>'Project Availibility'])
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
  .addField('#number', [
    {
      rule: 'required',
      errorMessage: 'Project Number is required',
    },
  ])
  .addField('#facing', [
    {
      rule: 'required',
      errorMessage: 'Project Facing is required',
    },
  ])
  .addField('#type', [
    {
      rule: 'required',
      errorMessage: 'Project Room Type is required',
    },
  ])
  .addField('#project_type', [
    {
      rule: 'required',
      errorMessage: 'Project Type is required',
    },
  ])
  .addField('#site_measurement', [
    {
      rule: 'required',
      errorMessage: 'Project Site Measurement is required',
    },
  ])
  .addField('#availibility', [
    {
      rule: 'required',
      errorMessage: 'Project Availibility is required',
    },
  ])
  .onSuccess(async (event) => {
    event.target.submit();
  });

  const projectTypeChoice = new Choices('#project_type', {
        choices: [
            {
                value: '',
                label: 'Select a type',
                selected: {{empty(old('project_type')) ? 'true' : 'false'}},
                disabled: true,
            },
            @foreach($project_types as $val)
                {
                    value: '{{$val}}',
                    label: '{{$val}}',
                    selected: {{(old('project_type')==$val) ? 'true' : 'false'}},
                },
            @endforeach
        ],
        placeholderValue: 'Select a type',
        ...CHOICE_CONFIG
    });
  const projectRoomTypeChoice = new Choices('#type', {
        choices: [
            {
                value: '',
                label: 'Select a type',
                selected: {{empty(old('type')) ? 'true' : 'false'}},
                disabled: true,
            },
            @foreach($room_types as $val)
                {
                    value: '{{$val}}',
                    label: '{{$val}}',
                    selected: {{(old('type')==$val) ? 'true' : 'false'}},
                },
            @endforeach
        ],
        placeholderValue: 'Select a type',
        ...CHOICE_CONFIG
    });
  const availibilityTypeChoice = new Choices('#availibility', {
        choices: [
            {
                value: '',
                label: 'Select availibility',
                selected: {{empty(old('availibility')) ? 'true' : 'false'}},
                disabled: true,
            },
            @foreach($availibility_types as $val)
                {
                    value: '{{$val}}',
                    label: '{{$val}}',
                    selected: {{(old('availibility')==$val) ? 'true' : 'false'}},
                },
            @endforeach
        ],
        placeholderValue: 'Select availibility',
        ...CHOICE_CONFIG
    });
</script>

@stop
