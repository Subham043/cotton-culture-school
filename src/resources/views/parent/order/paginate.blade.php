@extends('layouts.parent_dashboard')



@section('content')

<div class="page-content">
    <div class="container-fluid">

        <!-- start page title -->
        @include('includes.breadcrumb', ['page'=>'Order', 'page_link'=>route('address.paginate.get'), 'list'=>['List']])
        <!-- end page title -->

        <div class="row">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-header">
                        <h4 class="card-title mb-0">Order</h4>
                    </div><!-- end card header -->

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
                                            <td class="date">{{$item->placed_at->diffForHumans()}}</td>
                                            <td>
                                                <div class="d-flex gap-2">
                                                    <div class="edit">
                                                        <a href="{{route('order.detail.get', $item->id)}}" class="btn btn-sm btn-primary edit-item-btn">View Detail</a>
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
                            {{$data->onEachSide(5)->links('includes.pagination')}}
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
