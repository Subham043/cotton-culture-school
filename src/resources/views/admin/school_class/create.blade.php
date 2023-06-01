@extends('layouts.dashboard')


@section('content')

<div class="page-content">
    <div class="container-fluid">

        <!-- start page title -->
        @include('includes.breadcrumb', ['page'=>'Class & Section', 'page_link'=>route('school_class.paginate.get', $school_id), 'list'=>['Create']])
        <!-- end page title -->

        <div class="row">
            @include('includes.back_button', ['link'=>route('school_class.paginate.get', $school_id)])
            <div class="col-lg-12">
                <form id="countryForm" method="post" action="{{route('school_class.create.post', $school_id)}}" enctype="multipart/form-data">
                @csrf
                    <div class="card">
                        <div class="card-header align-items-center d-flex">
                            <h4 class="card-title mb-0 flex-grow-1">Class & Section Detail</h4>
                        </div><!-- end card header -->
                        <div class="card-body">
                            <div class="live-preview">
                                <div class="row gy-4">
                                    <div class="col-xxl-6 col-md-6">
                                        @include('includes.select', ['key'=>'class_id', 'label'=>'Class'])
                                    </div>
                                    <div class="col-xxl-6 col-md-6">
                                        @include('includes.select_multiple', ['key'=>'section', 'label'=>'Sections'])
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
  .addField('#class_id', [
    {
      rule: 'required',
      errorMessage: 'Class is required',
    },
  ])
  .addField('#section', [
    {
      rule: 'required',
      errorMessage: 'Section is required',
    },
  ])
  .onSuccess(async (event) => {
    event.target.submit();
  });
  const classChoice = new Choices('#class_id', {
        choices: [
            {
                value: '',
                label: 'Select a class',
                selected: {{empty(old('class_id')) ? 'true' : 'false'}},
                disabled: true,
            },
            @foreach($classes as $val)
                {
                    value: '{{$val->id}}',
                    label: '{{$val->name}}',
                    selected: {{(old('type')==$val->id) ? 'true' : 'false'}},
                },
            @endforeach
        ],
        placeholderValue: 'Select a class',
        ...CHOICE_CONFIG
    });

    const sectionChoice = new Choices('#section', {
        choices: [
            @foreach($sections as $section)
                {
                    value: '{{$section->id}}',
                    label: '{{$section->name}}',
                },
            @endforeach
        ],
        placeholderValue: 'Select sections',
        ...CHOICE_CONFIG,
        shouldSort: false,
        shouldSortItems: false,
    });
</script>

@stop
