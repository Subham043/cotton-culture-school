@extends('layouts.dashboard')



@section('content')

<div class="page-content">
    <div class="container-fluid">

        <!-- start page title -->
        @include('includes.breadcrumb', ['page'=>'Order', 'page_link'=>route('admin_order.paginate.get'), 'list'=>['List']])
        <!-- end page title -->

        <div class="row">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-header">
                        <h4 class="card-title mb-0">Order</h4>
                    </div><!-- end card header -->

                    <div class="card-body border border-dashed border-end-0 border-start-0">
                        <form>
                            <div class="row g-1 align-items-end justify-content-start">
                                <div class="col-xxl-2 col-sm-12">
                                    <label class="form-label" for="">Search</label>
                                    <div class="search-box">
                                        <input type="text" class="form-control search" name="search" placeholder="Search for anything..." value="@if(request()->has('search')){{request()->input('search')}}@endif">
                                        <i class="ri-search-line search-icon"></i>
                                    </div>
                                </div>
                                <!--end col-->
                                <div class="col-xxl-2 col-sm-12">
                                    <label class="form-label" for="">Mode Of Payment</label>
                                    <div>
                                        <select class="form-control" name="mode_of_payment" id="mode_of_payment">
                                            <option value="all" @if(!request()->has('mode_of_payment') || (request()->has('mode_of_payment') && strpos('all',request()->input('mode_of_payment')) !== false )) selected @endif>all</option>
                                            @foreach($payment_modes as $v)
                                                <option value="{{$v}}" @if(request()->has('mode_of_payment') && strpos($v,request()->input('mode_of_payment')) !== false) selected @endif>{{$v}}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <!--end col-->
                                <div class="col-xxl-2 col-sm-12">
                                    <label class="form-label" for="">Payment Status</label>
                                    <div>
                                        <select class="form-control" name="payment_status" id="payment_status">
                                            <option value="all"  @if(!request()->has('payment_status') || (request()->has('payment_status') && strpos('all',request()->input('payment_status')) !== false )) selected @endif>all</option>
                                            @foreach($payment_statuses as $v)
                                                <option value="{{$v}}" @if(request()->has('payment_status') && strpos($v,request()->input('payment_status')) !== false) selected @endif>{{$v}}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <!--end col-->
                                <div class="col-xxl-2 col-sm-12">
                                    <label class="form-label" for="">Order Status</label>
                                    <div>
                                        <select class="form-control" name="order_status" id="order_status">
                                            <option value="all"  @if(!request()->has('order_status') || (request()->has('order_status') && strpos('all',request()->input('order_status')) !== false )) selected @endif>all</option>
                                            @foreach($order_statuses as $v)
                                                <option value="{{$v}}" @if(request()->has('order_status') && strpos($v,request()->input('order_status')) !== false) selected @endif>{{$v}}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="col-xxl-2 col-sm-12">
                                    <label class="form-label" for="">Product</label>
                                    <div>
                                        <select class="form-control" name="products" id="products">
                                            <option value="all"  @if(!request()->has('products') || (request()->has('products') && strpos('all',request()->input('products')) !== false )) selected @endif>all</option>
                                            @foreach($products as $v)
                                                <option value="{{$v->id}}"  @if(request()->has('products') && strpos($v->id,request()->input('products')) !== false) selected @endif>{{$v->name}}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="col-xxl-2 col-sm-12">
                                    <label class="form-label" for="">School</label>
                                    <div>
                                        <select class="form-control" name="schools" id="schools">
                                            <option value="all"  @if(!request()->has('schools') || (request()->has('schools') && strpos('all',request()->input('schools')) !== false )) selected @endif>all</option>
                                            @foreach($schools as $v)
                                                <option value="{{$v->id}}" @if(request()->has('schools') && strpos($v->id,request()->input('schools')) !== false) selected @endif>{{$v->name}}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <!--end col-->
                                <div class="col-xxl-1 col-sm-12 mt-3">
                                    <div>
                                        <button type="submit" class="btn btn-primary w-100">
                                            Filter
                                        </button>
                                    </div>
                                </div>
                                <!--end col-->
                            </div>
                            <!--end row-->
                        </form>
                    </div>

                    <div class="card-body">
                        <div id="customerList">
                            <div class="table-responsive table-card mt-3 mb-1">
                                @if($data->total() > 0)
                                <table class="table align-middle table-nowrap" id="customerTable">
                                    <thead class="table-light">
                                        <tr>
                                            <th class="sort" data-sort="customer_name">ID</th>
                                            <th class="sort" data-sort="customer_name">Receipt</th>
                                            <th class="sort" data-sort="customer_name">Mode Of Payment</th>
                                            <th class="sort" data-sort="customer_name">Payment Status</th>
                                            <th class="sort" data-sort="customer_name">Order Status</th>
                                            <th class="sort" data-sort="customer_name">Total Amount</th>
                                            <th class="sort" data-sort="customer_name">Products</th>
                                            <th class="sort" data-sort="customer_name">Schools / Classes</th>
                                            <th class="sort" data-sort="customer_name">Kids</th>
                                            <th class="sort" data-sort="customer_name">User</th>
                                            <th class="sort" data-sort="date">Placed On</th>
                                            <th class="sort" data-sort="action">Action</th>
                                            </tr>
                                    </thead>
                                    <tbody class="list form-check-all">
                                        @foreach ($data->items() as $item)
                                        <tr>
                                            <td class="customer_name">{{$item->id}}</td>
                                            <td class="customer_name">{{$item->receipt}}</td>
                                            <td class="customer_name">{{$item->mode_of_payment}}</td>
                                            <td class="customer_name">{{$item->payment_status}}</td>
                                            <td class="customer_name">{{$item->order_status}}</td>
                                            <td class="customer_name">{{$item->total_amount}}</td>
                                            <td class="customer_name">
                                                @foreach($item->orderItems as $k=>$v)
                                                <span class="badge bg-success">{{$v->product->name}}</span><br/>
                                                @endforeach
                                            </td>
                                            <td class="customer_name">
                                                @foreach($item->orderItems as $k=>$v)
                                                <span class="badge bg-primary">{{$v->product->schoolAndclass->school->name}} / {{$v->product->schoolAndclass->class->name}}</span><br/>
                                                @endforeach
                                            </td>
                                            <td class="customer_name">
                                                @foreach($item->orderItems as $k=>$v)
                                                <span class="badge bg-success">{{$v->kid->name}}</span><br/>
                                                @endforeach
                                            </td>
                                            <td class="customer_name">{{$item->user->name}}<br/>{{$item->user->email}}<br/>{{$item->user->phone}}</td>
                                            <td class="date">{{$item->placed_at->diffForHumans()}}</td>
                                            <td>
                                                <div class="d-flex gap-2">
                                                    <div class="edit">
                                                        <a href="{{route('admin_order.detail.get', $item->id)}}" class="btn btn-sm btn-primary edit-item-btn">View Detail</a>
                                                    </div>
                                                </div>
                                            </td>
                                        </tr>
                                        @endforeach

                                    </tbody>
                                </table>
                                @else
                                    @include('includes.no_result')
                                @endif
                            </div>
                            {{$data->withQueryString()->onEachSide(5)->links('includes.pagination')}}
                        </div>
                    </div><!-- end card -->
                </div>
                <!-- end col -->
            </div>
            <!-- end col -->
        </div>
        <!-- end row -->

    </div>
</div>

@stop
