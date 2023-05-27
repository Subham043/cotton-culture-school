<?php

namespace App\Http\Controllers\Main\Dashboard;

use App\Http\Controllers\Controller;

class DashboardController extends Controller
{

    public function index(){
        return view('admin.pages.dashboard.index');
    }

}
