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

                    <div class="row">
                        <div class="col-12">
                            <h5 class="text-decoration-underline mb-3 mt-2 pb-3">Ecommerce Widgets</h5>
                        </div>
                    </div>

                    <div class="row">

                        <!-- end col -->
                        <div class="col-xl-3 col-md-6">
                            <div class="card card-height-100">
                                <div class="card-body">
                                    <div class="d-flex align-items-center mb-3">
                                        <div class="avatar-sm me-3 flex-shrink-0">
                                            <div class="avatar-title bg-soft-danger rounded">
                                                <img src="https://placehold.co/600x600" alt="" class="avatar-xs">
                                            </div>
                                        </div>
                                        <div class="flex-grow-1">
                                            <p class="text-muted mb-2">Adidas</p>
                                            <h5 class="fs-15 mb-0">Half Sleeve T-Shirts (Pink)</h5>
                                        </div>
                                    </div>
                                    <p class="text-muted pb-1">If you couldn't relate to the information in the previous point, you might be looking for the singlet T-shirt, which is also known as the half T-shirt.</p>

                                    <!-- end row -->

                                    <div class="d-flex mb-4 align-items-center">
                                        <div class="flex-grow-1">
                                            <h5 class="text-primary fs-18 mb-0"><span>$48.20</span> <small class="text-decoration-line-through text-muted fs-13">$124.10</small></h5>
                                        </div>
                                    </div>

                                    <a href="#!" class="btn btn-soft-danger d-block">View Detail</a>

                                </div>
                            </div>
                        </div>
                        <div class="col-xl-3 col-md-6">
                            <div class="card card-height-100">
                                <div class="card-body">
                                    <div class="d-flex align-items-center mb-3">
                                        <div class="avatar-sm me-3 flex-shrink-0">
                                            <div class="avatar-title bg-soft-danger rounded">
                                                <img src="https://placehold.co/600x600" alt="" class="avatar-xs">
                                            </div>
                                        </div>
                                        <div class="flex-grow-1">
                                            <p class="text-muted mb-2">Adidas</p>
                                            <h5 class="fs-15 mb-0">Half Sleeve T-Shirts (Pink)</h5>
                                        </div>
                                    </div>
                                    <p class="text-muted pb-1">If you couldn't relate to the information in the previous point, you might be looking for the singlet T-shirt, which is also known as the half T-shirt.</p>

                                    <!-- end row -->

                                    <div class="d-flex mb-4 align-items-center">
                                        <div class="flex-grow-1">
                                            <h5 class="text-primary fs-18 mb-0"><span>$48.20</span> <small class="text-decoration-line-through text-muted fs-13">$124.10</small></h5>
                                        </div>
                                    </div>

                                    <a href="#!" class="btn btn-soft-danger d-block">View Detail</a>

                                </div>
                            </div>
                        </div>
                        <div class="col-xl-3 col-md-6">
                            <div class="card card-height-100">
                                <div class="card-body">
                                    <div class="d-flex align-items-center mb-3">
                                        <div class="avatar-sm me-3 flex-shrink-0">
                                            <div class="avatar-title bg-soft-danger rounded">
                                                <img src="https://placehold.co/600x600" alt="" class="avatar-xs">
                                            </div>
                                        </div>
                                        <div class="flex-grow-1">
                                            <p class="text-muted mb-2">Adidas</p>
                                            <h5 class="fs-15 mb-0">Half Sleeve T-Shirts (Pink)</h5>
                                        </div>
                                    </div>
                                    <p class="text-muted pb-1">If you couldn't relate to the information in the previous point, you might be looking for the singlet T-shirt, which is also known as the half T-shirt.</p>

                                    <!-- end row -->

                                    <div class="d-flex mb-4 align-items-center">
                                        <div class="flex-grow-1">
                                            <h5 class="text-primary fs-18 mb-0"><span>$48.20</span> <small class="text-decoration-line-through text-muted fs-13">$124.10</small></h5>
                                        </div>
                                    </div>

                                    <a href="#!" class="btn btn-soft-danger d-block">View Detail</a>

                                </div>
                            </div>
                        </div>
                        <div class="col-xl-3 col-md-6">
                            <div class="card card-height-100">
                                <div class="card-body">
                                    <div class="d-flex align-items-center mb-3">
                                        <div class="avatar-sm me-3 flex-shrink-0">
                                            <div class="avatar-title bg-soft-danger rounded">
                                                <img src="https://placehold.co/600x600" alt="" class="avatar-xs">
                                            </div>
                                        </div>
                                        <div class="flex-grow-1">
                                            <p class="text-muted mb-2">Adidas</p>
                                            <h5 class="fs-15 mb-0">Half Sleeve T-Shirts (Pink)</h5>
                                        </div>
                                    </div>
                                    <p class="text-muted pb-1">If you couldn't relate to the information in the previous point, you might be looking for the singlet T-shirt, which is also known as the half T-shirt.</p>

                                    <!-- end row -->

                                    <div class="d-flex mb-4 align-items-center">
                                        <div class="flex-grow-1">
                                            <h5 class="text-primary fs-18 mb-0"><span>$48.20</span> <small class="text-decoration-line-through text-muted fs-13">$124.10</small></h5>
                                        </div>
                                    </div>

                                    <a href="#!" class="btn btn-soft-danger d-block">View Detail</a>

                                </div>
                            </div>
                        </div>
                    </div>

            </div>
        </div>
    </div>
    <!-- container-fluid -->
</div><!-- End Page-content -->

@stop

@section('js')
<!--Swiper slider js-->
<script src="{{asset('admin/js/plugins/swiper-bundle.min.js')}}"></script>

<!-- swiper.init js -->
<script src="{{asset('admin/js/pages/swiper.init.js')}}"></script>
@stop
