@extends('layouts.school_dashboard')


@section('content')

<div class="page-content">
    <div class="container-fluid">

        @include('includes.breadcrumb', ['page'=>'Order', 'page_link'=>route('school_dashboard'), 'list'=>['Payment']])

        <div class="row project-wrapper">
            <div class="col-xxl-12">

                <div class="text-center p-5" id="payment_failed" style="display: none;">
                    <lord-icon src="https://cdn.lordicon.com/hrqwmuhr.json" trigger="loop" colors="primary:#121331,secondary:#08a88a" style="width:120px;height:120px">
                    </lord-icon>
                    <div class="mt-4">
                        <h4 class="mb-3">Oops payment failed!</h4>
                        <p class="text-muted mb-4"> The transfer was not successfully received by us.</p>
                        <div class="hstack gap-2 justify-content-center">
                            <button type="button" class="btn btn-light">Cancel</button>
                            <button onclick="setPrice()" class="btn btn-success">Try Again</button>
                        </div>
                    </div>
                </div>

                <div class="text-center p-5" style="display: none;" id="payment_cancelled">
                    <lord-icon src="https://cdn.lordicon.com/tdrtiskw.json" trigger="loop" colors="primary:#f7b84b,secondary:#405189" style="width:130px;height:130px">
                    </lord-icon>
                    <div class="mt-4 pt-4">
                        <h4>Uh oh, You cancelled the payment!</h4>
                        <p class="text-muted"> The payment was not successfully received by us.</p>
                        <!-- Toogle to second dialog -->
                        <button onclick="setPrice()" class="btn btn-warning">Make Payment</button>
                    </div>
                </div>

                <div class="text-center p-5" style="display: none;" id="payment_success">
                    <lord-icon src="https://cdn.lordicon.com/lupuorrc.json" trigger="loop" colors="primary:#121331,secondary:#08a88a" style="width:120px;height:120px">
                    </lord-icon>

                    <div class="mt-4">
                        <h4 class="mb-3">Your Transaction was Successfull !</h4>
                        <p class="text-muted mb-4"> Please wait till we verify your payment. Do not refresh the browser unless we have completed the verification.</p>
                        <div class="hstack gap-2 justify-content-center">
                            <div class="spinner-border text-primary" role="status">
                                <span class="visually-hidden">Loading...</span>
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

@section('javascript')
<script src="https://checkout.razorpay.com/v1/checkout.js"></script>
<script src="{{ asset('admin/js/pages/axios.min.js') }}"></script>

<script>

var options;

function setPrice() {
    options = {
        "key": "{{env('RAZORPAY_KEY')}}", // Enter the Key ID generated from the Dashboard
        "amount": parseInt({{$data->total_amount}}) * 100, // Amount is in currency subunits. Default currency is INR. Hence, 50000 refers to 50000 paise
        "order_id": "{{$data->razorpay_order_id}}",
        "currency": "INR",
        "name": "Cotton Culture",
        "description": "Test Transaction",
        "image": "{{ asset('admin/images/logo.png') }}",
        //This is a sample Order ID. Pass the `id` obtained in the response of Step 1
        "handler": function(response) {
            document.getElementById('payment_success').style.display = 'block';
            document.getElementById('payment_cancelled').style.display = 'none';
            document.getElementById('payment_failed').style.display = 'none';
            verifyPayment(response);
        },

        "prefill": {
            "name": "{{auth()->user()->name}}",
            "email": "{{auth()->user()->email}}",
            "contact": "+91{{auth()->user()->phone}}"
        },
        "notes": {
            "address": "Razorpay Corporate Office"
        },
        "theme": {
            "color": "#ffaa49"
        },
        "modal": {
            "ondismiss": function() {
                document.getElementById('payment_cancelled').style.display = 'block';
                document.getElementById('payment_failed').style.display = 'none';
                document.getElementById('payment_success').style.display = 'none';
            }
        }
    };

    var rzp1 = new Razorpay(options);
    rzp1.on('payment.failed', function(response) {
        // console.log(response);
        document.getElementById('payment_failed').style.display = 'block';
        document.getElementById('payment_cancelled').style.display = 'none';
        document.getElementById('payment_success').style.display = 'none';
    });
    rzp1.open();

}

window.onload = setPrice;

const verifyPayment = async (data) => {
    try {
        const response = await axios.post('{{route('school_order.verify_payment.get', $data->id)}}', data)
        successToast(response.data.message)
        if(response.data?.link){
            setInterval(window.location.replace(response.data?.link), 1500);
        }
    }catch (error){
        console.log(error);
        if(error?.response?.data?.errors?.razorpay_order_id){
            errorToast(error?.response?.data?.errors?.razorpay_order_id[0])
        }
        if(error?.response?.data?.errors?.razorpay_payment_id){
            errorToast(error?.response?.data?.errors?.razorpay_payment_id[0])
        }
        if(error?.response?.data?.errors?.razorpay_signature){
            errorToast(error?.response?.data?.errors?.razorpay_signature[0])
        }
        if(error?.response?.data?.message){
            errorToast(error?.response?.data?.message)
        }
    }finally{
        return false;
    }
}

</script>

@stop

