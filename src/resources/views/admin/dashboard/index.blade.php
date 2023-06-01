@extends('layouts.dashboard')


@section('content')

<div class="page-content">
    <div class="container-fluid">

        @include('includes.breadcrumb', ['page'=>'Dashboard', 'page_link'=>route('dashboard'), 'list'=>['COTTON CULTURE']])

        <div class="row project-wrapper">
            <div class="col-xxl-12">

                    <div class="row">


                            <div class="col-xl-12">
                                <div>

                                    <div class="card-body p-0">
                                        <div class="p-3">
                                            <div class="row">

                                                <div class="col-xl-4">
                                                    <div class="card card-animate no-box-shadow">
                                                        <div class="card-body">
                                                            <div class="d-flex align-items-center">
                                                                <div class="avatar-sm flex-shrink-0">
                                                                    <span class="avatar-title bg-soft-success text-success rounded-2 fs-2">
                                                                        <i class="ri-check-double-line text-success"></i>
                                                                    </span>
                                                                </div>
                                                                <div class="flex-grow-1 ms-3">
                                                                    <div class="d-flex align-items-center">
                                                                        <h4 class="fs-4 flex-grow-1 mb-0"><span class="text-uppercase">hey</span></h4>
                                                                    </div>
                                                                    <p class="text-muted mb-0">
                                                                        Total Number Of Projects
                                                                    </p>
                                                                </div>
                                                            </div>
                                                        </div><!-- end card body -->
                                                    </div>
                                                </div><!-- end col -->

                                                <div class="col-xl-4">
                                                    <div class="card card-animate no-box-shadow">
                                                        <div class="card-body">
                                                            <div class="d-flex align-items-center">
                                                                <div class="avatar-sm flex-shrink-0">
                                                                    <span class="avatar-title bg-soft-success text-success rounded-2 fs-2">
                                                                        <i class="ri-check-double-line text-success"></i>
                                                                    </span>
                                                                </div>
                                                                <div class="flex-grow-1 ms-3">
                                                                    <div class="d-flex align-items-center">
                                                                        <h4 class="fs-4 flex-grow-1 mb-0"><span class="text-uppercase">hey</span></h4>
                                                                    </div>
                                                                    <p class="text-muted mb-0">
                                                                        Total Sales from inclusive of Projects
                                                                    </p>
                                                                </div>
                                                            </div>
                                                        </div><!-- end card body -->
                                                    </div>
                                                </div><!-- end col -->

                                                <div class="col-xl-4">
                                                    <div class="card card-animate no-box-shadow">
                                                        <div class="card-body">
                                                            <div class="d-flex align-items-center">
                                                                <div class="avatar-sm flex-shrink-0">
                                                                    <span class="avatar-title bg-soft-success text-success rounded-2 fs-2">
                                                                        <i class="ri-check-double-line text-success"></i>
                                                                    </span>
                                                                </div>
                                                                <div class="flex-grow-1 ms-3">
                                                                    <div class="d-flex align-items-center">
                                                                        <h4 class="fs-4 flex-grow-1 mb-0"><span class="text-uppercase">hey</span></h4>
                                                                    </div>
                                                                    <p class="text-muted mb-0">
                                                                        Total Sale Value
                                                                    </p>
                                                                </div>
                                                            </div>
                                                        </div><!-- end card body -->
                                                    </div>
                                                </div><!-- end col -->
                                            </div>
                                        </div>
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
