@extends('layouts.parent_dashboard')


@section('content')

<div class="page-content">
    <div class="container-fluid">

        @include('includes.breadcrumb', ['page'=>'Order Item', 'page_link'=>route('parent_dashboard'), 'list'=>['Edit']])

        <div class="row project-wrapper">
            <div class="col-xxl-12">

                <div class="row">
                    <div class="col-xl-12">
                        <div class="card mb-4">
                            <div class="card-body">
                                <h4 class="card-title mb-0 flex-grow-1 mb-4 text-center">Time pending before you won't be allowed to update the size for the following item!</h4>
                                <hr>
                                <div id="countdown" class="text-center">
                                    <h3>
                                        <code>
                                            {{$order_detail->order->created_at->addDays($order_detail->product->schoolAndclass->school->submission_duration)->format('M d, Y')}}
                                        </code>
                                    </h3>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-xl-8">
                        <div class="card">
                            <div class="card-body checkout-tab">

                                <form action="#">

                                    <div class="tab-content">

                                        <div class="tab-pane fade active show" id="pills-bill-address" role="tabpanel" aria-labelledby="pills-bill-address-tab">
                                            <div class="row">
                                                <div class="col-xl-12">
                                                    <div class="mt-xl-0 mt-5">
                                                        <div class="d-flex">
                                                            <div class="flex-grow-1">
                                                                <h4>{{$order_detail->product->name}}</h4>
                                                                <div class="hstack gap-3 flex-wrap">
                                                                    <div class="text-muted">Category : <span class="text-body fw-medium">{{$order_detail->product->category->name}}</span>
                                                                    </div>
                                                                    <div class="vr"></div>
                                                                    <div class="text-muted">Gender : <span class="text-body fw-medium">{{$order_detail->product->gender}}</span>
                                                                    </div>
                                                                    <div class="vr"></div>
                                                                    <div class="text-muted">Published : <span class="text-body fw-medium">{{$order_detail->product->created_at->diffForHumans()}}</span>
                                                                    </div>
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
                                                                            <h5 class="mb-0">&#8377; {{$order_detail->product->price}}</h5>
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
                                                                            <h5 class="mb-0">{{$order_detail->product->schoolAndclass->school->name}}</h5>
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
                                                                            <h5 class="mb-0">{{$order_detail->product->schoolAndclass->class->name}}</h5>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <!-- end col -->
                                                        </div>

                                                        <div class="mt-4 text-muted">
                                                            <h5 class="fs-15">Description :</h5>
                                                            <p>{{$order_detail->product->brief_description}}</p>
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
                                                                                @foreach($order_detail->product->specification as $v)
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
                                                                        {!!$order_detail->product->detailed_description!!}
                                                                    </div>
                                                                </div>
                                                                <div class="tab-pane fade" id="nav-refer" role="tabpanel" aria-labelledby="nav-refer-tab">
                                                                    <div>
                                                                        <iframe loading="lazy" src="https://www.youtube.com/embed/{{$order_detail->product->youtube_video_id}}" title="YouTube video player" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" allowFullScreen="" style="width: 100%; height: 450px;" frameBorder="0"></iframe>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <!-- product-content -->

                                                        <!-- end card body -->
                                                    </div>
                                                </div>
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
                                        <h5 class="card-title mb-0">Order Item ({{$order_detail->product->name}}) Detail</h5>
                                    </div>
                                </div>
                            </div>
                            <div class="card-body">
                                <form action="javascript:void(0);" id="cartForm">
                                    <div class="row g-3">
                                        <div class="col-12">
                                            <div class="row align-items-end justify-content-between">
                                                <div class="col-lg-12 md-12">
                                                    <div>
                                                        <label for="kid" class="form-label">Kid</label>
                                                        <input type="text" class="form-control" id="kid" readonly disabled placeholder="Enter Kid" value="{{$order_detail->kid->name}}">
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-xxl-12">
                                            <div>
                                                <label for="quantity" class="form-label">Quantity</label>
                                                <input type="text" class="form-control" readonly disabled id="quantity" placeholder="Enter Quantity" value="{{$order_detail->quantity}}">
                                            </div>
                                        </div>
                                        @foreach($order_detail->product->units as $k=>$v)
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
                                                <button type="submit" class="btn btn-primary" id="submitBtn">Update Order Item</button>
                                            </div>
                                        </div>
                                        <!--end col-->
                                    </div>
                                    <!--end row-->
                                </form>
                            </div>
                            <!-- end card body -->
                        </div>
                        <!-- end card -->
                    </div>
                    <!-- end col -->
                </div>

            </div>
        </div>
    </div>
    <!-- container-fluid -->
</div><!-- End Page-content -->

@stop

@section('javascript')

<script src="{{ asset('admin/js/pages/choices.min.js') }}"></script>
<script src="{{ asset('admin/js/pages/axios.min.js') }}"></script>

<script type="text/javascript">

const cart_field = @json(json_decode($order_detail->units));
const cart_field_data = JSON.parse(cart_field)
for (const key in cart_field_data) {
    document.getElementById(key).value = cart_field_data[key];
}

// initialize the validation library
const validation = new JustValidate('#cartForm', {
      errorFieldCssClass: 'is-invalid',
});
// apply rules to form fields
validation
  @foreach($order_detail->product->units as $k=>$v)
  .addField('#{{str()->snake($v->unit_title)}}_{{$v->id}}', [
    {
      rule: 'required',
      errorMessage: '{{$v->unit_title}} is required',
    },
  ])
  @endforeach
  .onSuccess(async (event) => {
    var submitBtn = document.getElementById('submitBtn')
    submitBtn.innerHTML = "Updating Order Item ..."
    submitBtn.disabled = true;
    try {
        var formData = new FormData();
        let obj = {};
        @foreach($order_detail->product->units as $k=>$v)
            obj['{{str()->snake($v->unit_title)}}_{{$v->id}}'] = document.getElementById('{{str()->snake($v->unit_title)}}_{{$v->id}}').value;
        @endforeach
        formData.append('units',JSON.stringify(obj))

        const response = await axios.post('{{route('parent_update_order', $order_detail->id)}}', formData)
        successToast(response.data.message)
        setInterval(location.reload(), 1500);
    }catch (error){
        if(error?.response?.data?.errors?.units){
            errorToast(error?.response?.data?.errors?.units[0])
        }
        if(error?.response?.data?.message){
            errorToast(error?.response?.data?.message)
        }
    }finally{
        submitBtn.innerHTML =  `
            Update Order Item
            `
        submitBtn.disabled = false;
    }
  });

</script>

@stop

