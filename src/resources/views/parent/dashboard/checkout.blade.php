@extends('layouts.parent_dashboard')


@section('content')

<div class="page-content">
    <div class="container-fluid">

        @include('includes.breadcrumb', ['page'=>'Checkout', 'page_link'=>route('parent_dashboard'), 'list'=>['Checkout']])

        <div class="row project-wrapper">
            <div class="col-xxl-12">

                @if(count($cart)>0)
                <div class="row">
                    <div class="col-xl-8">
                        <div class="card">
                            <div class="card-body checkout-tab">

                                <form action="#" id="checkoutForm" onsubmit="return placeOrderHandler(event)">

                                    <div class="tab-content">

                                        <div class="tab-pane fade active show" id="pills-bill-address" role="tabpanel" aria-labelledby="pills-bill-address-tab">
                                            <div>
                                                <h5 class="mb-1">Shipping Information</h5>
                                                <p class="text-muted mb-4">Please select an address</p>
                                            </div>

                                            <div class="mt-4">
                                                <div class="d-flex align-items-center mb-2">
                                                    <div class="flex-grow-1">
                                                        <h5 class="fs-15 mb-0">Saved Address</h5>
                                                    </div>
                                                    <div class="flex-shrink-0">
                                                        <!-- Button trigger modal -->
                                                        <a href="{{route('address.create.get')}}" class="btn btn-sm btn-success mb-3">
                                                            Add Address
                                                        </a>
                                                    </div>
                                                </div>
                                                <div class="row gy-3">
                                                    @foreach($address as $k => $v)
                                                    <div class="col-lg-4 col-sm-6">
                                                        <div class="form-check card-radio">
                                                            <input id="shippingAddress{{$k+1}}" name="address_id" type="radio" value="{{$v->id}}" class="form-check-input" {{$k==0 ? 'checked' : ''}}>
                                                            <label class="form-check-label" for="shippingAddress{{$k+1}}">
                                                                <span class="mb-4 fw-semibold d-block text-muted text-uppercase">{{$v->label}}</span>

                                                                <span class="text-muted fw-normal text-wrap mb-1 d-block">
                                                                    {{$v->address}}, {{$v->city}}, {{$v->state}}, {{$v->pin}}
                                                                </span>
                                                            </label>
                                                        </div>
                                                        <div class="d-flex flex-wrap p-2 py-1 bg-light rounded-bottom border mt-n1">
                                                            <div>
                                                                <a href="{{route('address.update.get', $v->id)}}" class="d-block text-body p-1 px-2"><i class="ri-pencil-fill text-muted align-bottom me-1"></i>
                                                                    Edit</a>
                                                            </div>
                                                            <div>
                                                                <button type="button" data-link="{{route('address.delete.get', $v->id)}}" class="d-block btn text-body p-1 px-2 remove-item-btn"><i class="ri-delete-bin-fill text-muted align-bottom me-1"></i>
                                                                    Remove</button>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    @endforeach

                                                </div>

                                            </div>

                                            <div class="mt-4">
                                                <h5 class="mb-1">Payment Selection</h5>
                                                <p class="text-muted mb-4">Please select the mode of payment</p>
                                            </div>

                                            <div class="row g-4">
                                                <div class="col-lg-4 col-sm-6">
                                                    <div data-bs-toggle="collapse" data-bs-target="#paymentmethodCollapse.show" aria-expanded="true" aria-controls="paymentmethodCollapse">
                                                        <div class="form-check card-radio">
                                                            <input id="paymentMethod01" name="mode_of_payment" type="radio" value="Online" class="form-check-input">
                                                            <label class="form-check-label" for="paymentMethod01">
                                                                <span class="fs-16 text-muted me-2"><i class="ri-paypal-fill align-bottom"></i></span>
                                                                <span class="fs-15 text-wrap">Online</span>
                                                            </label>
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="col-lg-4 col-sm-6">
                                                    <div data-bs-toggle="collapse" data-bs-target="#paymentmethodCollapse.show" aria-expanded="true" aria-controls="paymentmethodCollapse">
                                                        <div class="form-check card-radio">
                                                            <input id="paymentMethod02" name="mode_of_payment" type="radio" value="Cash On Delivery" class="form-check-input">
                                                            <label class="form-check-label" for="paymentMethod02">
                                                                <span class="fs-16 text-muted me-2"><i class="ri-money-dollar-box-fill align-bottom"></i></span>
                                                                <span class="fs-15 text-wrap">Cash on
                                                                    Delivery</span>
                                                            </label>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="d-flex align-items-start gap-3 mt-4">
                                                <button type="submit" id="submitBtn" class="btn btn-primary btn-label right ms-auto nexttab"><i class="ri-bank-card-line label-icon align-middle fs-16 ms-2"></i>Place Order</button>
                                            </div>
                                        </div>
                                        <!-- end tab pane -->

                                    </div>
                                    <!-- end tab content -->
                                </form>
                            </div>
                            <!-- end card body -->
                        </div>
                        <!-- end card -->
                    </div>
                    <!-- end col -->

                    <div class="col-xl-4">
                        <div class="card">
                            <div class="card-header">
                                <div class="d-flex">
                                    <div class="flex-grow-1">
                                        <h5 class="card-title mb-0">Order Summary</h5>
                                    </div>
                                </div>
                            </div>
                            <div class="card-body">
                                <div class="table-responsive table-card">
                                    <table class="table table-borderless align-middle mb-0">
                                        <thead class="table-light text-muted">
                                            <tr>
                                                <th style="width: 90px;" scope="col">Product</th>
                                                <th scope="col">Product Info</th>
                                                <th scope="col" class="text-end">Price</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach($cart as $k=>$v)
                                            <tr>
                                                <td>
                                                    <div class="bg-light rounded p-1">
                                                        <img src="{{$v->product->featured_image_link}}" alt="" class="img-fluid d-block">
                                                    </div>
                                                </td>
                                                <td>
                                                    <h5 class="fs-15"><a href="{{route('parent_product_detail', $v->product->id)}}" class="text-dark">{{$v->product->name}}</a>
                                                    </h5>
                                                    <p class="text-muted mb-0">&#8377; {{$v->product->price}} x {{$v->quantity}}</p>
                                                </td>
                                                <td class="text-end">&#8377; {{$v->cart_quantity_price}}</td>
                                            </tr>
                                            @endforeach
                                            <tr class="table-active">
                                                <th colspan="2">Total :</th>
                                                <td class="text-end">
                                                    <span class="fw-semibold">
                                                        &#8377; {{$cart_total}}
                                                    </span>
                                                </td>
                                            </tr>
                                        </tbody>
                                    </table>

                                </div>
                            </div>
                            <!-- end card body -->
                        </div>
                        <!-- end card -->
                    </div>
                    <!-- end col -->
                </div>
                @else
                <div class="row">
                    <div class="col-12">
                        <div class="text-center empty-cart" id="empty-cart">
                            <div class="avatar-md mx-auto my-3">
                                <div class="avatar-title bg-soft-info text-info fs-36 rounded-circle">
                                    <i class='bx bx-cart'></i>
                                </div>
                            </div>
                            <h5 class="mb-3">Your Cart is Empty!</h5>
                            <a href="{{route('parent_dashboard')}}" class="btn btn-success w-md mb-3">Shop Now</a>
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
<script src="https://checkout.razorpay.com/v1/checkout.js"></script>
<script src="{{ asset('admin/js/pages/axios.min.js') }}"></script>

<script type="text/javascript">

async function placeOrderHandler(event) {
    event.preventDefault()
    var submitBtn = document.getElementById('submitBtn')
    submitBtn.innerHTML = "Placing Order ..."
    submitBtn.disabled = true;
    try {
        var formData = new FormData();

        var mode_of_payment = document.getElementsByName('mode_of_payment');
        var mode_of_payment_value;
        for(var i = 0; i < mode_of_payment.length; i++){
            if(mode_of_payment[i].checked){
                mode_of_payment_value = mode_of_payment[i].value;
            }
        }
        formData.append('mode_of_payment',mode_of_payment_value)

        var address_id = document.getElementsByName('address_id');
        var address_id_value;
        for(var i = 0; i < address_id.length; i++){
            if(address_id[i].checked){
                address_id_value = address_id[i].value;
            }
        }
        formData.append('address_id',address_id_value)


        const response = await axios.post('{{route('parent_place_order')}}', formData)
        successToast(response.data.message)
        if(response.data?.link){
            setInterval(window.location.replace(response.data?.link), 1500);
        }
    }catch (error){
        console.log(error);
        if(error?.response?.data?.errors?.mode_of_payment){
            errorToast(error?.response?.data?.errors?.mode_of_payment[0])
        }
        if(error?.response?.data?.errors?.address_id){
            errorToast(error?.response?.data?.errors?.address_id[0])
        }
        if(error?.response?.data?.message){
            errorToast(error?.response?.data?.message)
        }
    }finally{
        submitBtn.innerHTML =  `
            Place Order
            `
        submitBtn.disabled = false;
        return false;
    }
}

</script>

@stop

