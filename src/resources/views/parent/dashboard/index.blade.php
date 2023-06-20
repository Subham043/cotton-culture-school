@extends('layouts.parent_dashboard')


@section('content')

<div class="page-content">
    <div class="container-fluid">

        @include('includes.breadcrumb', ['page'=>'Dashboard', 'page_link'=>route('parent_dashboard'), 'list'=>['COTTON CULTURE']])

        <div class="row project-wrapper">
            <div class="col-xxl-12">
                    <div class="row">

                        <div class="col-xl-12 col-lg-12">
                            <div class="card">
                                <div class="card-body">
                                    <!-- Swiper -->
                                    <div id="carouselExampleSlidesOnly" class="carousel slide" data-bs-ride="carousel">
                                        <div class="carousel-indicators">
                                            <button type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide-to="0" class="active" aria-current="true" aria-label="Slide 1"></button>
                                            <button type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide-to="1" aria-label="Slide 2"></button>
                                            <button type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide-to="2" aria-label="Slide 3"></button>
                                        </div>
                                        <div class="carousel-inner">
                                        <div class="carousel-item active">
                                            <img src="https://placehold.co/600x200" class="d-block w-100" alt="...">
                                        </div>
                                        <div class="carousel-item">
                                            <img src="https://placehold.co/600x200" class="d-block w-100" alt="...">
                                        </div>
                                        <div class="carousel-item">
                                            <img src="https://placehold.co/600x200" class="d-block w-100" alt="...">
                                        </div>
                                        </div>
                                    </div>
                                </div><!-- end card-body -->
                            </div><!-- end card -->
                        </div>


                    </div>
                    @if(count($kids)>0)
                        <div class="row">
                            <div class="col-xl-3 col-lg-4">
                                <div class="card">
                                    <div class="card-header">
                                        <div class="d-flex align-items-center">
                                            <div class="flex-grow-1">
                                                <h5 class="fs-16 m-0">Filters</h5>
                                            </div>
                                            <div class="flex-shrink-0">
                                                <button type="button" class="btn btn-primary" id="filterBtn">Apply</button>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="accordion accordion-flush filter-accordion">

                                        <div class="accordion-item">
                                            <h2 class="accordion-header" id="flush-headingBrands">
                                                <button class="accordion-button bg-transparent shadow-none" type="button" data-bs-toggle="collapse" data-bs-target="#flush-collapseBrands" aria-expanded="true" aria-controls="flush-collapseBrands">
                                                    <span class="text-muted text-uppercase fs-13 fw-medium">School</span> <span class="badge bg-success rounded-pill align-middle ms-1 filter-badge">{{count($school)}}</span>
                                                </button>
                                            </h2>

                                            <div id="flush-collapseBrands" class="accordion-collapse collapse show" aria-labelledby="flush-headingBrands">
                                                <div class="accordion-body text-body pt-0">
                                                    <div class="d-flex flex-column gap-2 mt-3 filter-check">
                                                        @foreach($school as $v)
                                                        <div class="form-check">
                                                            <input class="form-check-input" type="checkbox" value="{{$v[0]->id}}" id="school{{$v[0]->id}}" name="school" value="{{$v[0]->id}}" @if(app('request')->has('school') && in_array($v[0]->id, explode('_', app('request')->input('school')))) checked @endif>
                                                            <label class="form-check-label" for="school"{{$v[0]->id}}>{{$v[0]->name}}</label>
                                                        </div>
                                                        @endforeach
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <!-- end accordion-item -->

                                        <div class="accordion-item">
                                            <h2 class="accordion-header" id="flush-headingDiscount">
                                                <button class="accordion-button bg-transparent shadow-none collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#flush-collapseDiscount" aria-expanded="false" aria-controls="flush-collapseDiscount">
                                                    <span class="text-muted text-uppercase fs-13 fw-medium">Category</span> <span class="badge bg-success rounded-pill align-middle ms-1 filter-badge" style="display: none;">0</span>
                                                </button>
                                            </h2>
                                            <div id="flush-collapseDiscount" class="accordion-collapse collapse @if(app('request')->has('category')) show @endif" aria-labelledby="flush-headingDiscount" style="">
                                                <div class="accordion-body text-body pt-1">
                                                    <div class="d-flex flex-column gap-2 filter-check">
                                                        @foreach($category as $v)
                                                        <div class="form-check">
                                                            <input class="form-check-input" type="checkbox" value="{{$v[0]->id}}" name="category" id="category{{$v[0]->id}}" @if(app('request')->has('category') && in_array($v[0]->id, explode('_', app('request')->input('category')))) checked @endif>
                                                            <label class="form-check-label" for="category{{$v[0]->id}}">{{$v[0]->name}}</label>
                                                        </div>
                                                        @endforeach
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <!-- end accordion-item -->

                                        <div class="accordion-item">
                                            <h2 class="accordion-header" id="flush-headingDiscount2">
                                                <button class="accordion-button bg-transparent shadow-none collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#flush-collapseDiscount2" aria-expanded="false" aria-controls="flush-collapseDiscount2">
                                                    <span class="text-muted text-uppercase fs-13 fw-medium">Gender</span> <span class="badge bg-success rounded-pill align-middle ms-1 filter-badge" style="display: none;">0</span>
                                                </button>
                                            </h2>
                                            <div id="flush-collapseDiscount2" class="accordion-collapse collapse @if(app('request')->has('gender')) show @endif" aria-labelledby="flush-headingDiscount2" style="">
                                                <div class="accordion-body text-body pt-1">
                                                    <div class="d-flex flex-column gap-2 filter-check">
                                                        @foreach($gender as $v)
                                                        <div class="form-check">
                                                            <input class="form-check-input" type="checkbox" value="{{$v->gender}}" name="gender" id="gender{{$v->gender}}" @if(app('request')->has('gender') && in_array($v->gender->value, explode('_', app('request')->input('gender')))) checked @endif>
                                                            <label class="form-check-label" for="gender{{$v->gender->value}}">{{$v->gender}}</label>
                                                        </div>
                                                        @endforeach
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <!-- end accordion-item -->

                                    </div>
                                </div>
                                <!-- end card -->
                            </div>

                            <div class="col-xl-9 col-lg-8 col-md-12 mb-3">
                                @if($data->total() > 0)
                                    <div class="row">
                                        @foreach ($data->items() as $item)
                                        <!-- end col -->
                                        <div class="col-xl-4 col-md-6">
                                            <div class="card card-height-100">
                                                <div class="card-body">
                                                    <div class="w-100 mb-2">
                                                        <div class="w-100 p-1 bg-soft-danger rounded">
                                                            <img src="{{$item->featured_image_link}}" alt="" class="w-100" style="height: 250px; object-fit:cover;">
                                                        </div>
                                                    </div>
                                                    <div class="d-flex align-items-center mb-3">
                                                        <div class="flex-grow-1">
                                                            <h5 class="fs-15 mb-0 text-uppercase">{{$item->name}}</h5>
                                                            <p class="badge text-info fs-12 m-0 p-0">{{$item->category->name}}</p>
                                                        </div>
                                                    </div>
                                                    <p class="text-muted pb-1">{{$item->brief_description}}</p>

                                                    <!-- end row -->

                                                    <div class="d-flex mb-4 align-items-center">
                                                        <div class="flex-grow-1">
                                                            <h5 class="text-primary fs-18 mb-0"><span>&#8377; {{$item->price}}</span></h5>
                                                        </div>
                                                    </div>

                                                    <a href="{{route('parent_product_detail', $item->id)}}" class="btn btn-soft-danger d-block">Buy Now</a>

                                                </div>
                                            </div>
                                        </div>
                                        @endforeach
                                    </div>
                                    {{$data->onEachSide(5)->links('includes.pagination')}}
                                @else
                                <div class="noresult text-center">
                                    <lord-icon
                                        src="https://cdn.lordicon.com/msoeawqm.json"
                                        trigger="loop"
                                        colors="primary:#121331,secondary:#08a88a"
                                        style="width:150px;height:150px">
                                    </lord-icon>
                                    <div class="text-center">
                                        <h5 class="mt-2">Sorry! No Result Found</h5>
                                    </div>
                                </div>
                                @endif
                            </div>

                        </div>
                    @else
                        <div class="modal-body text-center p-5">
                            <lord-icon src="https://cdn.lordicon.com/imamsnbq.json" trigger="loop" colors="primary:#121331,secondary:#08a88a" style="width:120px;height:120px">
                            </lord-icon>
                            <div class="mt-4">
                                <h4 class="mb-3">Oops, No kid found for your account!</h4>
                                <p class="text-muted mb-4"> Please add kid in order to see products from their respective school.</p>
                                <div class="hstack gap-2 justify-content-center">
                                    <a href="{{route('kid.paginate.get')}}" class="btn btn-danger">Add Kid</a>
                                </div>
                            </div>
                        </div>
                    @endif

            </div>
        </div>
    </div>
    <!-- container-fluid -->
</div><!-- End Page-content -->

@stop

@section('javascript')

<script>
    document.getElementById('filterBtn').addEventListener('click', function(event) {
        event.preventDefault();
        var str= "";
        var arr = [];

        var schoolElems = document.getElementsByName("school");
        var schoolArr = [];
        for (var i=0; i<schoolElems.length; i++) {
            if (schoolElems[i].type === "checkbox" && schoolElems[i].checked === true){
                schoolArr.push(schoolElems[i].value);
            }
        }
        if(schoolArr.length > 0){
            schoolStr = schoolArr.join('_');
            arr.push("school="+schoolStr)
        }

        var categoryElems = document.getElementsByName("category");
        var categoryArr = [];
        for (var i=0; i<categoryElems.length; i++) {
            if (categoryElems[i].type === "checkbox" && categoryElems[i].checked === true){
                categoryArr.push(categoryElems[i].value);
            }
        }
        if(categoryArr.length > 0){
            categoryStr = categoryArr.join('_');
            arr.push("category="+categoryStr)
        }

        var genderElems = document.getElementsByName("gender");
        var genderArr = [];
        for (var i=0; i<genderElems.length; i++) {
            if (genderElems[i].type === "checkbox" && genderElems[i].checked === true){
                genderArr.push(genderElems[i].value);
            }
        }
        if(genderArr.length > 0){
            genderStr = genderArr.join('_');
            arr.push("gender="+genderStr)
        }

        str = arr.join('&');
        window.location.replace('{{route('parent_dashboard')}}?'+str)
    })
</script>
@stop
