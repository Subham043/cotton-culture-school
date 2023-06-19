@extends('layouts.dashboard')

@section('css')
<style>
    #detailed_description_quill{
        min-height: 200px;
    }
</style>
@stop

@section('content')

<div class="page-content">
    <div class="container-fluid">

        <!-- start page title -->
        @include('includes.breadcrumb', ['page'=>'Product', 'page_link'=>route('product.paginate.get'), 'list'=>['Create']])
        <!-- end page title -->

        <div class="row" id="image-container">
            @include('includes.back_button', ['link'=>route('product.paginate.get')])
            <div class="col-lg-12">
                <form id="countryForm" method="post" action="{{route('product.update.post', $data->id)}}" enctype="multipart/form-data">
                @csrf
                    <div class="card">
                        <div class="card-header align-items-center d-flex">
                            <h4 class="card-title mb-0 flex-grow-1">Product Detail</h4>
                        </div><!-- end card header -->
                        <div class="card-body">
                            <div class="live-preview">
                                <div class="row gy-4">
                                    <div class="col-xxl-3 col-md-3">
                                        @include('includes.input', ['key'=>'name', 'label'=>'Name', 'value'=>$data->name])
                                    </div>
                                    <div class="col-xxl-3 col-md-3">
                                        @include('includes.input', ['key'=>'price', 'label'=>'Price', 'value'=>$data->price])
                                    </div>
                                    <div class="col-xxl-3 col-md-3">
                                        @include('includes.file_input', ['key'=>'featured_image', 'label'=>'Featured Image'])
                                        @if(!empty($data->featured_image_link))
                                            <img src="{{$data->featured_image_link}}" alt="" class="img-preview">
                                        @endif
                                    </div>
                                    <div class="col-xxl-3 col-md-3">
                                        @include('includes.input', ['key'=>'youtube_video_id', 'label'=>'Youtube Video ID (Size Reference)', 'value'=>$data->youtube_video_id])
                                    </div>
                                    <div class="col-xxl-3 col-md-3">
                                        @include('includes.select', ['key'=>'gender', 'label'=>'Gender'])
                                    </div>
                                    <div class="col-xxl-3 col-md-3">
                                        @include('includes.select', ['key'=>'category_id', 'label'=>'Category'])
                                    </div>
                                    <div class="col-xxl-3 col-md-3">
                                        @include('includes.select', ['key'=>'school_class_id', 'label'=>'School/Class'])
                                    </div>
                                    <div class="col-xxl-3 col-md-3">
                                        @include('includes.select_multiple', ['key'=>'unit_field_id', 'label'=>'Units/Metrics'])
                                    </div>
                                    <div class="col-xxl-12 col-md-12">
                                        @include('includes.textarea', ['key'=>'brief_description', 'label'=>'Brief Description', 'value'=>$data->brief_description])
                                    </div>
                                    <div class="col-xxl-12 col-md-12">
                                        @include('includes.quill', ['key'=>'detailed_description', 'label'=>'Detailed Description', 'value'=>$data->detailed_description, 'value_unfiltered'=>$data->detailed_description_unfiltered])
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
<script src="{{ asset('admin/js/pages/plugins/quill.min.js' ) }}"></script>

<script type="text/javascript">
    const myViewer = new ImgPreviewer('#image-container',{
      // aspect ratio of image
        fillRatio: 0.9,
        // attribute that holds the image
        dataUrlKey: 'src',
        // additional styles
        style: {
            modalOpacity: 0.6,
            headerOpacity: 0,
            zIndex: 99
        },
        // zoom options
        imageZoom: {
            min: 0.1,
            max: 5,
            step: 0.1
        },
        // detect whether the parent element of the image is hidden by the css style
        bubblingLevel: 0,

    });
</script>

<script type="text/javascript">

var quillDescription = new Quill('#detailed_description_quill', {
    theme: 'snow',
    modules: {
        toolbar: QUILL_TOOLBAR_OPTIONS
    },
});

quillDescription.on('text-change', function(delta, oldDelta, source) {
  if (source == 'user') {
    document.getElementById('detailed_description').value = quillDescription.root.innerHTML
    document.getElementById('detailed_description_unfiltered').value = quillDescription.getText()
  }
});

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
  .addField('#price', [
    {
      rule: 'required',
      errorMessage: 'Price is required',
    },
  ])
  .addField('#brief_description', [
    {
      rule: 'required',
      errorMessage: 'Brief Description is required',
    },
  ])
  .addField('#detailed_description', [
    {
      rule: 'required',
      errorMessage: 'Detailed Description is required',
    },
  ])
  .addField('#category_id', [
    {
      rule: 'required',
      errorMessage: 'Category is required',
    },
  ])
  .addField('#school_class_id', [
    {
      rule: 'required',
      errorMessage: 'School/Class is required',
    },
  ])
  .addField('#unit_field_id', [
    {
      rule: 'required',
      errorMessage: 'Units/Metrics is required',
    },
  ])
  .addField('#youtube_video_id', [
    {
      rule: 'required',
      errorMessage: 'Youtube Video Id is required',
    },
  ])
  .addField('#gender', [
    {
      rule: 'required',
      errorMessage: 'Gender is required',
    },
  ])
  .addField('#featured_image', [
    {
        rule: 'minFilesCount',
        value: 0,
        errorMessage: 'Featured Image is required',
    },
    {
        rule: 'maxFilesCount',
        value: 1,
        errorMessage: 'Only One Featured Image is required',
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
        errorMessage: 'Featured Image with jpeg,jpg,png,webp extensions is allowed! Featured Image size should not exceed 500kb!',
    },
  ])
  .onSuccess(async (event) => {
    event.target.submit();
  });

  const categoryChoice = new Choices('#category_id', {
        choices: [
            {
                value: '',
                label: 'Select a category',
                disabled: true,
            },
            @foreach($categories as $val)
                {
                    value: '{{$val->id}}',
                    label: '{{$val->name}}',
                    selected: {{($data->category_id==$val->id) ? 'true' : 'false'}},
                },
            @endforeach
        ],
        placeholderValue: 'Select a category',
        ...CHOICE_CONFIG
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

    const unitChoice = new Choices('#unit_field_id', {
        choices: [
            @foreach($units as $unit)
                {
                    value: '{{$unit->id}}',
                    label: '{{$unit->unit_title}}',
                    selected: {{ (in_array($unit->id, $unit_data)) ? 'true' : 'false'}}
                },
            @endforeach
        ],
        placeholderValue: 'Select units/metrics',
        ...CHOICE_CONFIG,
        shouldSort: false,
        shouldSortItems: false,
    });

</script>

@stop
