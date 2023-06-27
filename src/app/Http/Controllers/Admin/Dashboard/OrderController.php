<?php

namespace App\Http\Controllers\Admin\Dashboard;

use App\Enums\OrderStatus;
use App\Enums\PaymentMode;
use App\Enums\PaymentStatus;
use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\Product;
use App\Models\School;
use Illuminate\Support\Arr;

class OrderController extends Controller
{

    public function index(){
        $data = Order::with([
            'address',
            'user',
            'orderItems' => function($query) {
                $query->with([
                    'product' => function($query) {
                        $query->with([
                            'schoolAndclass' => function($query) {
                                $query->with([
                                    'school',
                                    'class'
                                ]);

                            }
                        ]);
                    },
                    'kid'
                ]);
            }
        ])
        ->where(function($query){
            $query->where('mode_of_payment', PaymentMode::COD)
            ->orWhere(function($q){
                $q->where('mode_of_payment', PaymentMode::ONLINE)
                ->where(function($qr){
                    $qr->where('payment_status', PaymentStatus::PAID)->orWhere('payment_status', PaymentStatus::REFUND);
                });
            });
        })
        ->latest();

        if (request()->has('search')) {
            $search = request()->input('search');
            $data->where(function($query) use($search){
                $query->where('receipt', 'like', '%' . $search . '%')
                ->orWhere('id', 'like', '%' . $search . '%')
                ->orWhere('payment_status', 'like', '%' . $search . '%')
                ->orWhere('order_status', 'like', '%' . $search . '%')
                ->orWhere('mode_of_payment', 'like', '%' . $search . '%')
                ->orWhere('total_amount', 'like', '%' . $search . '%')
                ->orWhereHas('user', function($q) use($search) {
                    $q->where('name', 'like', '%' . $search . '%')
                    ->orWhere('email', 'like', '%' . $search . '%')
                    ->orWhere('phone', 'like', '%' . $search . '%');
                })
                ->orWhereHas('orderItems.kid', function($q) use($search) {
                    $q->where('name', 'like', '%' . $search . '%');
                })
                ->orWhereHas('orderItems.product', function($q) use($search) {
                    $q->where('name', 'like', '%' . $search . '%');
                })
                ->orWhereHas('orderItems.product.schoolAndclass.school', function($q) use($search) {
                    $q->where('name', 'like', '%' . $search . '%');
                })
                ->orWhereHas('orderItems.product.schoolAndclass.class', function($q) use($search) {
                    $q->where('name', 'like', '%' . $search . '%');
                });
            });
        }

        if (request()->has('payment_status') && request()->input('payment_status')!='all') {
            $payment_status = request()->input('payment_status');
            $data->where(function($query) use($payment_status){
                $query->where('payment_status', 'like', '%' . $payment_status . '%');
            });
        }

        if (request()->has('mode_of_payment') && request()->input('mode_of_payment')!='all') {
            $mode_of_payment = request()->input('mode_of_payment');
            $data->where(function($query) use($mode_of_payment){
                $query->where('mode_of_payment', 'like', '%' . $mode_of_payment . '%');
            });
        }

        if (request()->has('order_status') && request()->input('order_status')!='all') {
            $order_status = request()->input('order_status');
            $data->where(function($query) use($order_status){
                $query->where('order_status', 'like', '%' . $order_status . '%');
            });
        }

        if (request()->has('products') && request()->input('products')!='all') {
            $products = request()->input('products');
            $data->where(function($query) use($products){
                $query->whereHas('orderItems.product', function($q) use($products) {
                    $q->where('id', $products);
                });
            });
        }

        if (request()->has('schools') && request()->input('schools')!='all') {
            $schools = request()->input('schools');
            $data->where(function($query) use($schools){
                $query->whereHas('orderItems.product.schoolAndclass.school', function($q) use($schools) {
                    $q->where('id', $schools);
                });
            });
        }

        $data = $data->paginate(10);
        return view('admin.order.paginate')->with([
            'data'=> $data,
            'schools'=> School::all(),
            'products'=> Product::all(),
            'order_statuses' => Arr::map(OrderStatus::cases(), fn($enum) => $enum->value),
            'payment_statuses' => Arr::map(PaymentStatus::cases(), fn($enum) => $enum->value),
            'payment_modes' => Arr::map(PaymentMode::cases(), fn($enum) => $enum->value),
        ]);
    }

    public function detail($id) {
        $data = Order::with([
            'address',
            'user',
            'orderItems' => function($query) {
                $query->with([
                    'product' => function($query) {
                        $query->with([
                            'schoolAndclass' => function($query) {
                                $query->with([
                                    'school',
                                    'class'
                                ]);

                            }
                        ]);
                    },
                    'kid'
                ]);
            }
        ])
        ->where(function($query){
            $query->where('mode_of_payment', PaymentMode::COD)
            ->orWhere(function($q){
                $q->where('mode_of_payment', PaymentMode::ONLINE)
                ->where(function($qr){
                    $qr->where('payment_status', PaymentStatus::PAID)->orWhere('payment_status', PaymentStatus::REFUND);
                });
            });
        })->findOrFail($id);
        return view('admin.order.detail')->with([
            'data'=> $data,
        ]);
    }

    public function cancel_order($id) {
        $data = Order::with([
            'address',
            'user',
            'orderItems' => function($query) {
                $query->with([
                    'product' => function($query) {
                        $query->with([
                            'schoolAndclass' => function($query) {
                                $query->with([
                                    'school',
                                    'class'
                                ]);

                            }
                        ]);
                    },
                    'kid'
                ]);
            }
        ])
        ->where(function($query){
            $query->where('mode_of_payment', PaymentMode::COD)->where('order_status', '!=', OrderStatus::CANCELLED)
            ->orWhere(function($q){
                $q->where('mode_of_payment', PaymentMode::ONLINE)
                ->where('order_status', '!=', OrderStatus::CANCELLED)
                ->where(function($qr){
                    $qr->where('payment_status', PaymentStatus::PAID);
                });
            });
        })
        ->latest()->findOrFail($id);

        $data->update([
            'order_status' => OrderStatus::CANCELLED,
            'cancelled_at' => now(),
        ]);

        if($data->mode_of_payment==PaymentMode::ONLINE){
            $this->refund($data->total_amount, $data->razorpay_payment_id);
            $data->update([
                'payment_status' => PaymentStatus::REFUND,
            ]);
        }

        return redirect()->back()->with('success_status', 'Order cancelled successfully.');

    }

    public function update_order_status($id) {
        $data = Order::with([
            'address',
            'user',
            'orderItems' => function($query) {
                $query->with([
                    'product' => function($query) {
                        $query->with([
                            'schoolAndclass' => function($query) {
                                $query->with([
                                    'school',
                                    'class'
                                ]);

                            }
                        ]);
                    },
                    'kid'
                ]);
            }
        ])
        ->where(function($query){
            $query->where('mode_of_payment', PaymentMode::COD)->where('order_status', '!=', OrderStatus::CANCELLED)
            ->orWhere(function($q){
                $q->where('mode_of_payment', PaymentMode::ONLINE)
                ->where('order_status', '!=', OrderStatus::CANCELLED)
                ->where(function($qr){
                    $qr->where('payment_status', PaymentStatus::PAID);
                });
            });
        })
        ->latest()->findOrFail($id);
        if(empty($data->packed_at)){
            $data->update([
                'order_status' => OrderStatus::PACKED,
                'packed_at' => now(),
            ]);
        }elseif(empty($data->shipped_at)){
            $data->update([
                'order_status' => OrderStatus::SHIPPED,
                'shipped_at' => now(),
            ]);
        }elseif(empty($data->ofd_at)){
            $data->update([
                'order_status' => OrderStatus::OFD,
                'ofd_at' => now(),
            ]);
        }elseif(empty($data->delivered_at)){
            $data->update([
                'order_status' => OrderStatus::DELIVERED,
                'delivered_at' => now(),
            ]);
        }

        return redirect()->back()->with('success_status', 'Order cancelled successfully.');

    }

}
