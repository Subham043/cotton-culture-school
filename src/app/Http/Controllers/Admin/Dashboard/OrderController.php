<?php

namespace App\Http\Controllers\Admin\Dashboard;

use App\Enums\PaymentMode;
use App\Enums\PaymentStatus;
use App\Http\Controllers\Controller;
use App\Models\Order;

class OrderController extends Controller
{

    public function index(){
        $data = Order::with([
            'address',
            'user',
            'orderItems' => function($query) {
                $query->with([
                    'product',
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

        $data = $data->paginate(10);
        return view('admin.order.paginate')->with([
            'data'=> $data,
        ]);
    }

    public function detail($id) {
        $data = Order::with([
            'address',
            'user',
            'orderItems' => function($query) {
                $query->with([
                    'product',
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

}
