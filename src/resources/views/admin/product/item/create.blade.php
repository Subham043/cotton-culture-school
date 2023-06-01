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

        <div class="row">
            @include('includes.back_button', ['link'=>route('product.paginate.get')])
            <div class="col-lg-12">
                <form id="countryForm" method="post" action="{{route('product.create.post')}}" enctype="multipart/form-data">
                @csrf
                    <div class="card">
                        <div class="card-header align-items-center d-flex">
                            <h4 class="card-title mb-0 flex-grow-1">Product Detail</h4>
                        </div><!-- end card header -->
                        <div class="card-body">
                            <div class="live-preview">
                                <div class="row gy-4">
                                    <div class="col-xxl-4 col-md-4">
                                        @include('includes.input', ['key'=>'name', 'label'=>'Name', 'value'=>old('name')])
                                    </div>
                                    <div class="col-xxl-4 col-md-4">
                                        @include('includes.input', ['key'=>'price', 'label'=>'Price', 'value'=>old('price')])
                                    </div>
                                    <div class="col-xxl-4 col-md-4">
                                        @include('includes.file_input', ['key'=>'featured_image', 'label'=>'Featured Image'])
                                    </div>
                                    <div class="col-xxl-6 col-md-6">
                                        @include('includes.select', ['key'=>'category_id', 'label'=>'Category'])
                                    </div>
                                    <div class="col-xxl-6 col-md-6">
                                        @include('includes.select', ['key'=>'school_class_id', 'label'=>'School/Class'])
                                    </div>
                                    <div class="col-xxl-12 col-md-12">
                                        @include('includes.textarea', ['key'=>'brief_description', 'label'=>'Brief Description', 'value'=>old('brief_description')])
                                    </div>
                                    <div class="col-xxl-12 col-md-12">
                                        @include('includes.quill', ['key'=>'detailed_description', 'label'=>'Detailed Description', 'value'=>old('detailed_description'), 'value_unfiltered'=>old('detailed_description_unfiltered')])
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
<script src="{{ asset('admin/js/pages/plugins/quill.min.js' ) }}"></script>

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
  .addField('#featured_image', [
    {
        rule: 'minFilesCount',
        value: 1,
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
                selected: {{empty(old('category_id')) ? 'true' : 'false'}},
                disabled: true,
            },
            @foreach($categories as $val)
                {
                    value: '{{$val->id}}',
                    label: '{{$val->name}} - {{$val->gender}}',
                    selected: {{(old('category_id')==$val->id) ? 'true' : 'false'}},
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
                selected: {{empty(old('school_class_id')) ? 'true' : 'false'}},
                disabled: true,
            },
            @foreach($school_classes as $val)
                {
                    value: '{{$val->id}}',
                    label: '{{$val->school->name." / ".$val->class->name}}',
                    selected: {{(old('school_class_id')==$val->id) ? 'true' : 'false'}},
                },
            @endforeach
        ],
        placeholderValue: 'Select a school/class',
        ...CHOICE_CONFIG
    });

</script>

@stop
