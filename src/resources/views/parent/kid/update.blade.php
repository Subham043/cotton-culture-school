@extends('layouts.parent_dashboard')

@section('content')

<div class="page-content">
    <div class="container-fluid">

        <!-- start page title -->
        @include('includes.breadcrumb', ['page'=>'Kid', 'page_link'=>route('kid.paginate.get'), 'list'=>['Create']])
        <!-- end page title -->

        <div class="row" id="image-container">
            @include('includes.back_button', ['link'=>route('kid.paginate.get')])
            <div class="col-lg-12">
                <form id="countryForm" method="post" action="{{route('kid.update.post', $data->id)}}" enctype="multipart/form-data">
                @csrf
                    <div class="card">
                        <div class="card-header align-items-center d-flex">
                            <h4 class="card-title mb-0 flex-grow-1">Kid Detail</h4>
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
                                    <div class="col-xxl-6 col-md-6">
                                        @include('includes.select', ['key'=>'school_class_id', 'label'=>'School/Class'])
                                    </div>
                                    <div class="col-xxl-6 col-md-6">
                                        @include('includes.select', ['key'=>'section', 'label'=>'Section'])
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
  .addField('#section', [
    {
      rule: 'required',
      errorMessage: 'Section is required',
    },
  ])
  .addField('#school_class_id', [
    {
      rule: 'required',
      errorMessage: 'School/Class is required',
    },
  ])
  .onSuccess(async (event) => {
    event.target.submit();
  });

    const schoolClassChoice = new Choices('#school_class_id', {
        choices: [
            {
                value: '',
                label: 'Select a school/class',
                disabled: true,
            },
            @foreach($school_classes as $val)
                {
                    value: '{{$val->id}}',
                    label: '{{$val->school->name." / ".$val->class->name}}',
                    selected: {{($data->school_class_id==$val->id) ? 'true' : 'false'}},
                },
            @endforeach
        ],
        placeholderValue: 'Select a school/class',
        ...CHOICE_CONFIG
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

    var school_data = @json($school_classes);

    const sectionChoice = new Choices('#section', {
        choices: [
            {
                value: '',
                label: 'Select a section',
                disabled: true,
            },
            @foreach($data->schoolAndClass->section as $val)
                {
                    value: '{{$val->name}}',
                    label: '{{$val->name}}',
                    selected: {{($data->section==$val->name) ? 'true' : 'false'}},
                },
            @endforeach
        ],
        placeholderValue: 'Select a section',
        ...CHOICE_CONFIG
    });

    document.getElementById('school_class_id').addEventListener(
    'change',
    function(event) {
      // do something creative here...
      sectionChoice.clearChoices();
      sectionChoice.clearInput();
      let data = [
        {value: '', label: 'Select a section', disabled: true, selected: true}
      ]
      schoolData = school_data.filter((item)=>item.id==document.getElementById('school_class_id').value)
      if(schoolData.length>0){
        schoolData[0].section.forEach((item)=>{
            data.push({value: item.name, label: item.name,})
        })
        sectionChoice.setChoices(data);
      }
    }
  );

</script>

@stop
