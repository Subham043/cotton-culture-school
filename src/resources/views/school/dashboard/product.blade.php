@extends('layouts.school_dashboard')

@section('css')
<style>
    .carousel-indicators {
        position: absolute;
        right: 0;
        bottom: -85px;
        left: 0;
        z-index: 2;
        display: -webkit-box;
        display: -ms-flexbox;
        display: flex;
        -webkit-box-pack: center;
        -ms-flex-pack: center;
        justify-content: center;
        padding: 0;
        margin-right: 15%;
        margin-bottom: 1rem;
        align-items: center;
        margin-left: 15%;
        list-style: none;
    }
    .carousel-indicators .active {
        opacity: 1;
        border: 1px solid;
    }
    .carousel-indicators [data-bs-target] {
        -webkit-box-sizing: content-box;
        box-sizing: content-box;
        -webkit-box-flex: 0;
        -ms-flex: 0 1 auto;
        flex: 0 1 auto;
        width: 50px;
        height: 50px;
        padding: 0;
        margin-right: 3px;
        margin-left: 3px;
        /* text-indent: -999px; */
        cursor: pointer;
        background-color: #fff;
        background-clip: padding-box;
        border: 0;
        border-top: 10px solid transparent;
        border-bottom: 10px solid transparent;
        opacity: 1;
        -webkit-transition: opacity .6s ease;
        transition: opacity .6s ease;
    }
</style>
@stop

@section('content')

<div class="page-content">
    <div class="container-fluid">

        @include('includes.breadcrumb', ['page'=>'Product', 'page_link'=>route('school_dashboard'), 'list'=>[$product->name]])

        <div class="row project-wrapper">
            <div class="col-xxl-12">

                    <div class="row">

                        <div class="col-lg-12">
                            <div class="card">
                                <div class="card-body">
                                    <div class="row gx-lg-5">
                                        <div class="col-xl-4 col-md-8 mx-auto">
                                            <div class="product-img-slider sticky-side-div">
                                                <div id="carouselExampleSlidesOnly" class="carousel slide" data-bs-ride="carousel">
                                                    <div class="carousel-indicators">
                                                        <button type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide-to="0" class="active" aria-current="true" aria-label="Slide 1"><img src="{{$product->featured_image_link}}" class="d-block w-100" alt="..."></button>
                                                        @foreach($product->slider_image as $k=>$v)
                                                        <button type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide-to="{{$k+1}}" aria-label="Slide {{$k+1}}"><img src="{{$v->image_link}}" class="d-block w-100" alt="..."></button>
                                                        @endforeach
                                                    </div>
                                                    <div class="carousel-inner">
                                                      <div class="carousel-item active">
                                                        <img src="{{$product->featured_image_link}}" class="d-block w-100" alt="...">
                                                      </div>
                                                      @foreach($product->slider_image as $k=>$v)
                                                      <div class="carousel-item">
                                                        <img src="{{$v->image_link}}" class="d-block w-100" alt="...">
                                                      </div>
                                                      @endforeach
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <!-- end col -->

                                        <div class="col-xl-8">
                                            <div class="mt-xl-0 mt-5">
                                                <div class="d-flex">
                                                    <div class="flex-grow-1">
                                                        <h4>{{$product->name}}</h4>
                                                        <div class="hstack gap-3 flex-wrap">
                                                            <div class="text-muted">Category : <span class="text-body fw-medium">{{$product->category->name}}</span>
                                                            </div>
                                                            <div class="vr"></div>
                                                            <div class="text-muted">Gender : <span class="text-body fw-medium">{{$product->gender}}</span>
                                                            </div>
                                                            <div class="vr"></div>
                                                            <div class="text-muted">Published : <span class="text-body fw-medium">{{$product->created_at->diffForHumans()}}</span>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="flex-shrink-0">
                                                        <div>
                                                            <button data-bs-toggle="modal" data-bs-target="#exampleModal" class="btn rounded-pill btn-primary waves-effect waves-light" data-bs-toggle="tooltip" data-bs-placement="top" aria-label="Edit" data-bs-original-title="Edit"><i class="bx bx-shopping-bag align-center"></i> Add to Cart</button>
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="row mt-4">
                                                    <div class="col-lg-4 col-sm-12">
                                                        <div class="p-2 border border-dashed rounded">
                                                            <div class="d-flex align-items-center">
                                                                <div class="avatar-sm me-2">
                                                                    <div class="avatar-title rounded bg-transparent text-success fs-24">
                                                                        <i class="ri-money-dollar-circle-fill"></i>
                                                                    </div>
                                                                </div>
                                                                <div class="flex-grow-1">
                                                                    <p class="text-muted mb-1">Price :</p>
                                                                    <h5 class="mb-0">&#8377; {{$product->price}}</h5>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <!-- end col -->
                                                    <div class="col-lg-4 col-sm-12">
                                                        <div class="p-2 border border-dashed rounded">
                                                            <div class="d-flex align-items-center">
                                                                <div class="avatar-sm me-2">
                                                                    <div class="avatar-title rounded bg-transparent text-success fs-24">
                                                                        <i class="ri-community-line"></i>
                                                                    </div>
                                                                </div>
                                                                <div class="flex-grow-1">
                                                                    <p class="text-muted mb-1">School :</p>
                                                                    <h5 class="mb-0">{{$product->schoolAndclass->school->name}}</h5>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <!-- end col -->
                                                    <div class="col-lg-4 col-sm-12">
                                                        <div class="p-2 border border-dashed rounded">
                                                            <div class="d-flex align-items-center">
                                                                <div class="avatar-sm me-2">
                                                                    <div class="avatar-title rounded bg-transparent text-success fs-24">
                                                                        <i class="ri-file-copy-2-fill"></i>
                                                                    </div>
                                                                </div>
                                                                <div class="flex-grow-1">
                                                                    <p class="text-muted mb-1">Class :</p>
                                                                    <h5 class="mb-0">{{$product->schoolAndclass->class->name}}</h5>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <!-- end col -->
                                                </div>

                                                <div class="mt-4 text-muted">
                                                    <h5 class="fs-15">Description :</h5>
                                                    <p>{{$product->brief_description}}</p>
                                                </div>


                                                <div class="product-content mt-5">
                                                    <h5 class="fs-15 mb-3">Product Description :</h5>
                                                    <nav>
                                                        <ul class="nav nav-tabs nav-tabs-custom nav-success" id="nav-tab" role="tablist">
                                                            <li class="nav-item" role="presentation">
                                                                <a class="nav-link active" id="nav-speci-tab" data-bs-toggle="tab" href="#nav-speci" role="tab" aria-controls="nav-speci" aria-selected="true">Specification</a>
                                                            </li>
                                                            <li class="nav-item" role="presentation">
                                                                <a class="nav-link" id="nav-detail-tab" data-bs-toggle="tab" href="#nav-detail" role="tab" aria-controls="nav-detail" aria-selected="false" tabindex="-1">Details</a>
                                                            </li>
                                                            <li class="nav-item" role="presentation">
                                                                <a class="nav-link" id="nav-refer-tab" data-bs-toggle="tab" href="#nav-refer" role="tab" aria-controls="nav-refer" aria-selected="false" tabindex="-1">Size Reference</a>
                                                            </li>
                                                        </ul>
                                                    </nav>
                                                    <div class="tab-content border border-top-0 p-4" id="nav-tabContent">
                                                        <div class="tab-pane fade show active" id="nav-speci" role="tabpanel" aria-labelledby="nav-speci-tab">
                                                            <div class="table-responsive">
                                                                <table class="table mb-0">
                                                                    <tbody>
                                                                        @foreach($product->specification as $v)
                                                                        <tr>
                                                                            <th scope="row" style="width: 200px;">
                                                                                {{$v->title}}</th>
                                                                            <td>{{$v->description}}</td>
                                                                        </tr>
                                                                        @endforeach
                                                                    </tbody>
                                                                </table>
                                                            </div>
                                                        </div>
                                                        <div class="tab-pane fade" id="nav-detail" role="tabpanel" aria-labelledby="nav-detail-tab">
                                                            <div>
                                                                {!!$product->detailed_description!!}
                                                            </div>
                                                        </div>
                                                        <div class="tab-pane fade" id="nav-refer" role="tabpanel" aria-labelledby="nav-refer-tab">
                                                            <div>
                                                                <iframe loading="lazy" src="https://www.youtube.com/embed/{{$product->youtube_video_id}}" title="YouTube video player" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" allowFullScreen="" style="width: 100%; height: 450px;" frameBorder="0"></iframe>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <!-- product-content -->

                                                <!-- end card body -->
                                            </div>
                                        </div>
                                        <!-- end col -->
                                    </div>
                                    <!-- end row -->
                                </div>
                                <!-- end card body -->
                            </div>
                            <!-- end card -->
                        </div>


                    </div>

            </div>
        </div>
    </div>
    <!-- container-fluid -->
</div><!-- End Page-content -->

<!-- Modal -->
<div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalgridLabel">Fill in the required details to add the product to cart.</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form action="javascript:void(0);" id="cartForm">
                    <div class="row g-3">
                        <div class="col-12">
                            <div class="row align-items-end justify-content-between">
                                <div class="col-lg-9 md-9">
                                    @include('includes.select', ['key'=>'kid_id', 'label'=>'Kid'])
                                </div>
                                <div class="col-lg-3 md-3">
                                    <a href="{{route('school_kid.create.get')}}" class="btn btn-primary">Add Kid</a>
                                </div>
                            </div>
                        </div>
                        <div class="col-xxl-12">
                            <div>
                                <label for="quantity" class="form-label">Quantity</label>
                                <input type="text" class="form-control" id="quantity" placeholder="Enter Quantity">
                            </div>
                        </div>
                        @foreach($product->units as $k=>$v)
                        <div class="col-xxl-12">
                            <div>
                                <label for="{{str()->snake($v->unit_title)}}_{{$v->id}}" class="form-label">{{$v->unit_title}}</label>
                                <input type="text" class="form-control" id="{{str()->snake($v->unit_title)}}_{{$v->id}}" placeholder="Enter {{$v->unit_title}}">
                            </div>
                        </div>
                        @endforeach
                        <!--end col-->
                        <div class="col-lg-12">
                            <div class="hstack gap-2 justify-content-end">
                                <button type="submit" class="btn btn-primary" id="submitBtn">Add To Cart</button>
                            </div>
                        </div>
                        <!--end col-->
                    </div>
                    <!--end row-->
                </form>
            </div>
        </div>
    </div>
  </div>

@stop

@section('javascript')

<script src="{{ asset('admin/js/pages/choices.min.js') }}"></script>
<script src="{{ asset('admin/js/pages/axios.min.js') }}"></script>

<script type="text/javascript">

// initialize the validation library
const validation = new JustValidate('#cartForm', {
      errorFieldCssClass: 'is-invalid',
});
// apply rules to form fields
validation
  .addField('#kid_id', [
    {
      rule: 'required',
      errorMessage: 'Kid is required',
    },
  ])
  .addField('#quantity', [
    {
      rule: 'required',
      errorMessage: 'Quantity is required',
    },
  ])
  @foreach($product->units as $k=>$v)
  .addField('#{{str()->snake($v->unit_title)}}_{{$v->id}}', [
    {
      rule: 'required',
      errorMessage: '{{$v->unit_title}} is required',
    },
  ])
  @endforeach
  .onSuccess(async (event) => {
    var submitBtn = document.getElementById('submitBtn')
    submitBtn.innerHTML = "Adding To Cart ..."
    submitBtn.disabled = true;
    try {
        var formData = new FormData();
        formData.append('kid_id',document.getElementById('kid_id').value)
        formData.append('product_id','{{$product->id}}')
        formData.append('quantity',document.getElementById('quantity').value)
        let obj = {};
        @foreach($product->units as $k=>$v)
            obj['{{str()->snake($v->unit_title)}}_{{$v->id}}'] = document.getElementById('{{str()->snake($v->unit_title)}}_{{$v->id}}').value;
        @endforeach
        formData.append('units',JSON.stringify(obj))


        const response = await axios.post('{{route('school_save_cart')}}', formData)
        successToast(response.data.message)
        setInterval(location.reload(), 1500);
    }catch (error){
        if(error?.response?.data?.errors?.kid_id){
            errorToast(error?.response?.data?.errors?.kid_id[0])
        }
        if(error?.response?.data?.errors?.product_id){
            errorToast(error?.response?.data?.errors?.product_id[0])
        }
        if(error?.response?.data?.errors?.quantity){
            errorToast(error?.response?.data?.errors?.quantity[0])
        }
        if(error?.response?.data?.errors?.units){
            errorToast(error?.response?.data?.errors?.units[0])
        }
        if(error?.response?.data?.message){
            errorToast(error?.response?.data?.message)
        }
    }finally{
        submitBtn.innerHTML =  `
            Add To Cart
            `
        submitBtn.disabled = false;
    }
  });

  const kidChoice = new Choices('#kid_id', {
        choices: [
            {
                value: '',
                label: 'Select a kid',
                selected: {{empty(old('kid_id')) ? 'true' : 'false'}},
                disabled: true,
            },
            @foreach($kid as $val)
                {
                    value: '{{$val->id}}',
                    label: '{{$val->name}}',
                    selected: {{(old('kid_id')==$val->id) ? 'true' : 'false'}},
                },
            @endforeach
        ],
        placeholderValue: 'Select a kid',
        ...CHOICE_CONFIG
    });

</script>

@stop

