@extends('layouts.school_dashboard')

@section('content')

<div class="page-content">
    <div class="container-fluid">

        @include('includes.breadcrumb', ['page'=>'Order', 'page_link'=>route('school_dashboard'), 'list'=>['Detail']])

        <div class="row project-wrapper">
            <div class="col-xxl-12">

                @if(Session::has('order_placed'))
                <div class="card">
                    <div class="text-center py-5">

                        <div class="mb-4">
                            <lord-icon src="https://cdn.lordicon.com/lupuorrc.json" trigger="loop" colors="primary:#0ab39c,secondary:#405189" style="width:120px;height:120px"></lord-icon>
                        </div>
                        <h5>Thank you ! Your Order is Completed !</h5>
                        {{-- <p class="text-muted">You will receive an order confirmation email
                            with
                            details of your order.</p> --}}

                        <h3 class="fw-semibold">Order ID: <a href="{{route('school_order.detail.get', $data->id)}}" class="text-decoration-underline">{{$data->id}}</a></h3>
                    </div>
                </div>
                @endif

                <div class="row">
                    <div class="col-xl-9">
                        <div class="card">
                            <div class="card-header">
                                <div class="d-flex align-items-center">
                                    <h5 class="card-title flex-grow-1 mb-0">Order #{{$data->id}}</h5>
                                    {{-- <div class="flex-shrink-0">
                                        <a href="apps-invoices-details.html" class="btn btn-secondary btn-sm"><i class="ri-download-2-fill align-middle me-1"></i> Invoice</a>
                                    </div> --}}
                                </div>
                            </div>
                            <div class="card-body">
                                <div class="table-responsive table-card">
                                    <table class="table table-nowrap align-middle table-borderless mb-0">
                                        <thead class="table-light text-muted">
                                            <tr>
                                                <th scope="col">Product Details</th>
                                                <th scope="col">Item Price</th>
                                                <th scope="col">Quantity</th>
                                                <th scope="col" class="text-end">Total Amount</th>
                                                <th scope="col" class="text-end">Edit Sizes</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach($data->orderItems as $k => $v)
                                            <tr>
                                                <td>
                                                    <div class="d-flex flex-wrap">
                                                        <div class="flex-shrink-0 avatar-md bg-light rounded p-1">
                                                            <img src="{{$v->product->featured_image_link}}" alt="" class="img-fluid d-block">
                                                        </div>
                                                        <div class="flex-grow-1 ms-3">
                                                            <h5 class="fs-16"><a href="{{route('school_product_detail', $v->product->id)}}" class="link-primary">{{$v->product->name}}</a></h5>
                                                            <p class="text-muted mb-0">Gender: <span class="fw-medium">{{$v->product->gender}}</span></p>
                                                            <p class="text-muted mb-0">School: <span class="fw-medium">{{$v->product->schoolAndclass->school->name}}</span></p>
                                                            <p class="text-muted mb-0">Class: <span class="fw-medium">{{$v->product->schoolAndclass->class->name}}</span></p>
                                                        </div>
                                                        <div class="col-12 mt-2">
                                                            <p>
                                                                <code>
                                                                    Note :
                                                                </code>
                                                                Last date to update the size for the above item  -
                                                                <b>
                                                                    {{$data->created_at->addDays($v->product->schoolAndclass->school->submission_duration)->format('M d, Y')}}
                                                                </b>
                                                            </p>
                                                        </div>
                                                    </div>
                                                </td>
                                                <td>&#8377; {{$v->product->price}}</td>
                                                <td>{{$v->quantity}}</td>
                                                <td class="fw-medium text-end">
                                                    &#8377; {{$v->cart_quantity_price}}
                                                </td>
                                                <td class="text-end">
                                                    @if($data->order_status!=\App\Enums\OrderStatus::CANCELLED)
                                                        @if((time()-(60*60*24)) < strtotime($data->created_at->addDays($v->product->schoolAndclass->school->submission_duration)))
                                                            <a href="{{route('school_edit_order', $v->id)}}" class="btn btn-sm btn-warning edit-item-btn"><i class="ri-pencil-fill text-white align-bottom"></i></a>
                                                        @else
                                                            <div class="alert alert-danger p-1" role="alert">
                                                                <strong> Deadline Exceeded</strong>
                                                            </div>
                                                        @endif
                                                    @else
                                                        <div class="alert alert-danger p-1" role="alert">
                                                            <strong> Order Cancelled</strong>
                                                        </div>
                                                    @endif
                                                </td>
                                            </tr>
                                            @endforeach

                                            <tr class="border-top border-top-dashed">
                                                <th>
                                                    Total :
                                                </th>
                                                <td colspan="2"></td>
                                                <th class="text-end">&#8377; {{$data->total_amount}}</th>
                                                <td></td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                        <!--end card-->
                        <div class="card">
                            <div class="card-header">
                                <div class="d-sm-flex align-items-center">
                                    <h5 class="card-title flex-grow-1 mb-0">Order Status</h5>
                                    @if($data->order_status!=\App\Enums\OrderStatus::CANCELLED)
                                    <div class="flex-shrink-0 mt-2 mt-sm-0">
                                        <button data-link="{{route('school_order.cancel.get', $data->id)}}" class="btn btn-soft-danger btn-sm mt-2 mt-sm-0 remove-item-btn"><i class="mdi mdi-archive-remove-outline align-bottom me-1"></i> Cancel
                                            Order</button>
                                    </div>
                                    @endif
                                </div>
                            </div>
                            <div class="card-body">
                                <div class="profile-timeline">
                                    <div class="accordion accordion-flush" id="accordionFlushExample">
                                        <div class="accordion-item border-0">
                                            <div class="accordion-header" id="headingOne">
                                                <a class="accordion-button p-2 shadow-none" data-bs-toggle="collapse" href="#collapseOne" aria-expanded="true" aria-controls="collapseOne">
                                                    <div class="d-flex align-items-center">
                                                        <div class="flex-shrink-0 avatar-xs">
                                                            <div
                                                                @class([
                                                                    'avatar-title rounded-circle',
                                                                    'bg-success'=>!empty($data->placed_at),
                                                                    'bg-light text-success'=>empty($data->placed_at)
                                                                ])>
                                                                <i class="ri-shopping-bag-line"></i>
                                                            </div>
                                                        </div>
                                                        <div class="flex-grow-1 ms-3">
                                                            <h6 class="fs-15 mb-0 fw-semibold">Order Placed @if(!empty($data->placed_at))- <span class="fw-normal">{{$data->placed_at->diffForHumans()}}</span>@endif</h6>
                                                        </div>
                                                    </div>
                                                </a>
                                            </div>
                                        </div>
                                        @if($data->order_status!=\App\Enums\OrderStatus::CANCELLED)
                                        <div class="accordion-item border-0">
                                            <div class="accordion-header" id="headingTwo">
                                                <a class="accordion-button p-2 shadow-none" data-bs-toggle="collapse" href="#collapseTwo" aria-expanded="false" aria-controls="collapseTwo">
                                                    <div class="d-flex align-items-center">
                                                        <div class="flex-shrink-0 avatar-xs">
                                                            <div
                                                                @class([
                                                                    'avatar-title rounded-circle',
                                                                    'bg-success'=>!empty($data->packed_at),
                                                                    'bg-light text-success'=>empty($data->packed_at)
                                                                ])>
                                                                <i class="mdi mdi-gift-outline"></i>
                                                            </div>
                                                        </div>
                                                        <div class="flex-grow-1 ms-3">
                                                            <h6 class="fs-15 mb-1 fw-semibold">Packed @if(!empty($data->packed_at))- <span class="fw-normal">{{$data->packed_at->diffForHumans()}}</span>@endif</h6>
                                                        </div>
                                                    </div>
                                                </a>
                                            </div>
                                        </div>
                                        <div class="accordion-item border-0">
                                            <div class="accordion-header" id="headingThree">
                                                <a class="accordion-button p-2 shadow-none" data-bs-toggle="collapse" href="#collapseThree" aria-expanded="false" aria-controls="collapseThree">
                                                    <div class="d-flex align-items-center">
                                                        <div class="flex-shrink-0 avatar-xs">
                                                            <div @class([
                                                                'avatar-title rounded-circle',
                                                                'bg-success'=>!empty($data->shipped_at),
                                                                'bg-light text-success'=>empty($data->shipped_at)
                                                            ])>
                                                                <i class="ri-truck-line"></i>
                                                            </div>
                                                        </div>
                                                        <div class="flex-grow-1 ms-3">
                                                            <h6 class="fs-15 mb-1 fw-semibold">Shipped @if(!empty($data->shipped_at))- <span class="fw-normal">{{$data->shipped_at->diffForHumans()}}</span>@endif</h6>
                                                        </div>
                                                    </div>
                                                </a>
                                            </div>
                                        </div>
                                        <div class="accordion-item border-0">
                                            <div class="accordion-header" id="headingFour">
                                                <a class="accordion-button p-2 shadow-none" data-bs-toggle="collapse" href="#collapseFour" aria-expanded="false">
                                                    <div class="d-flex align-items-center">
                                                        <div class="flex-shrink-0 avatar-xs">
                                                            <div @class([
                                                                'avatar-title rounded-circle',
                                                                'bg-success'=>!empty($data->ofd_at),
                                                                'bg-light text-success'=>empty($data->ofd_at)
                                                            ])>
                                                                <i class="ri-takeaway-fill"></i>
                                                            </div>
                                                        </div>
                                                        <div class="flex-grow-1 ms-3">
                                                            <h6 class="fs-14 mb-0 fw-semibold">Out For Delivery</h6>
                                                        </div>
                                                    </div>
                                                </a>
                                            </div>
                                        </div>
                                        <div class="accordion-item border-0">
                                            <div class="accordion-header" id="headingFive">
                                                <a class="accordion-button p-2 shadow-none" data-bs-toggle="collapse" href="#collapseFile" aria-expanded="false">
                                                    <div class="d-flex align-items-center">
                                                        <div class="flex-shrink-0 avatar-xs">
                                                            <div @class([
                                                                'avatar-title rounded-circle',
                                                                'bg-success'=>!empty($data->delivered_at),
                                                                'bg-light text-success'=>empty($data->delivered_at)
                                                            ])>
                                                                <i class="mdi mdi-package-variant"></i>
                                                            </div>
                                                        </div>
                                                        <div class="flex-grow-1 ms-3">
                                                            <h6 class="fs-14 mb-0 fw-semibold">Delivered @if(!empty($data->delivered_at))- <span class="fw-normal">{{$data->delivered_at->diffForHumans()}}</span>@endif</h6>
                                                        </div>
                                                    </div>
                                                </a>
                                            </div>
                                        </div>
                                        @else
                                        <div class="accordion-item border-0">
                                            <div class="accordion-header" id="headingTwo">
                                                <a class="accordion-button p-2 shadow-none" data-bs-toggle="collapse" href="#collapseTwo" aria-expanded="false" aria-controls="collapseTwo">
                                                    <div class="d-flex align-items-center">
                                                        <div class="flex-shrink-0 avatar-xs">
                                                            <div
                                                                @class([
                                                                    'avatar-title rounded-circle',
                                                                    'bg-danger',
                                                                ])>
                                                                <i class="ri-close-line"></i>
                                                            </div>
                                                        </div>
                                                        <div class="flex-grow-1 ms-3">
                                                            <h6 class="fs-15 mb-1 fw-semibold">Cancelled @if(!empty($data->cancelled_at))- <span class="fw-normal">{{$data->cancelled_at->diffForHumans()}}</span>@endif</h6>
                                                        </div>
                                                    </div>
                                                </a>
                                            </div>
                                        </div>
                                        @endif
                                    </div>
                                    <!--end accordion-->
                                </div>
                            </div>
                        </div>
                        <!--end card-->
                    </div>
                    <!--end col-->
                    <div class="col-xl-3">

                        <div class="card">
                            <div class="card-header">
                                <div class="d-flex">
                                    <h5 class="card-title flex-grow-1 mb-0">Customer Details</h5>
                                </div>
                            </div>
                            <div class="card-body">
                                <ul class="list-unstyled mb-0 vstack gap-3">
                                    <li><i class="ri-user-2-line me-2 align-middle text-muted fs-16"></i>{{auth()->user()->name}}
                                    </li>
                                    <li><i class="ri-mail-line me-2 align-middle text-muted fs-16"></i>{{auth()->user()->email}}
                                    </li>
                                    <li><i class="ri-phone-line me-2 align-middle text-muted fs-16"></i>+91-{{auth()->user()->phone}}</li>
                                </ul>
                            </div>
                        </div>

                        <!--end card-->
                        <div class="card">
                            <div class="card-header">
                                <h5 class="card-title mb-0"><i class="ri-map-pin-line align-middle me-1 text-muted"></i> Shipping Address
                                </h5>
                            </div>
                            <div class="card-body">
                                <ul class="list-unstyled vstack gap-2 mb-0">
                                    <li class="fw-medium fs-15">{{auth()->user()->name}}</li>
                                    <li>+91-{{auth()->user()->phone}}</li>
                                    <li>{{$data->address->address}}</li>
                                    <li>{{$data->address->city}} - {{$data->address->pin}}</li>
                                    <li>{{$data->address->state}}s</li>
                                </ul>
                            </div>
                        </div>
                        <!--end card-->

                        <div class="card">
                            <div class="card-header">
                                <h5 class="card-title mb-0"><i class="ri-secure-payment-line align-bottom me-1 text-muted"></i> Payment
                                    Details</h5>
                            </div>
                            <div class="card-body">
                                <div class="d-flex align-items-center mb-2">
                                    <div class="flex-shrink-0">
                                        <p class="text-muted mb-0">Payment Method:</p>
                                    </div>
                                    <div class="flex-grow-1 ms-2">
                                        <h6 class="mb-0">{{$data->mode_of_payment}}</h6>
                                    </div>
                                </div>
                                <div class="d-flex align-items-center mb-2">
                                    <div class="flex-shrink-0">
                                        <p class="text-muted mb-0">Payment Status:</p>
                                    </div>
                                    <div class="flex-grow-1 ms-2">
                                        <h6 class="mb-0">{{$data->payment_status}}</h6>
                                    </div>
                                </div>
                                <div class="d-flex align-items-center">
                                    <div class="flex-shrink-0">
                                        <p class="text-muted mb-0">Total Amount:</p>
                                    </div>
                                    <div class="flex-grow-1 ms-2">
                                        <h6 class="mb-0">&#8377; {{$data->total_amount}}</h6>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!--end card-->
                    </div>
                    <!--end col-->
                </div>

            </div>
        </div>
    </div>
    <!-- container-fluid -->
</div><!-- End Page-content -->

@stop

@section('javascript')


@stop

