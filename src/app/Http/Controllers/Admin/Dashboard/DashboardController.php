<?php

namespace App\Http\Controllers\Admin\Dashboard;

use App\Enums\Gender;
use App\Enums\OrderStatus;
use App\Http\Controllers\Controller;
use App\Models\Kid;
use App\Models\Order;

class DashboardController extends Controller
{

    public function index(){
        return view('admin.dashboard.index')->with([
            'male_students' => Kid::where('gender', Gender::MALE->value)->count(),
            'female_students' => Kid::where('gender', Gender::FEMALE->value)->count(),
            'orders' => Order::where('order_status', '!=', OrderStatus::CANCELLED->value)->count(),
            'amount' => Order::where('order_status', '!=', OrderStatus::CANCELLED->value)->sum('total_amount'),
        ]);
    }

}
