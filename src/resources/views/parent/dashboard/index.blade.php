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

                    @if($data->total() > 0)
                    <div class="row">
                        <div class="col-xl-3 col-lg-4">
                            <div class="card">
                                <div class="card-header">
                                    <div class="d-flex align-items-center">
                                        <div class="flex-grow-1">
                                            <h5 class="fs-16 m-0">Filters</h5>
                                        </div>
                                        <div class="flex-shrink-0">
                                            <a href="#" class="btn btn-primary" id="clearall">Apply</a>
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
                                                        <input class="form-check-input" type="checkbox" value="{{$v[0]->id}}" id="productBrandRadio5">
                                                        <label class="form-check-label" for="productBrandRadio5">{{$v[0]->name}}</label>
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
                                        <div id="flush-collapseDiscount" class="accordion-collapse collapse" aria-labelledby="flush-headingDiscount" style="">
                                            <div class="accordion-body text-body pt-1">
                                                <div class="d-flex flex-column gap-2 filter-check">
                                                    @foreach($category as $v)
                                                    <div class="form-check">
                                                        <input class="form-check-input" type="checkbox" value="50% or more" id="productdiscountRadio6">
                                                        <label class="form-check-label" for="productdiscountRadio6">{{$v[0]->name}}</label>
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
@stop
