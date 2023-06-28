<?php

namespace App\Http\Controllers\School\Dashboard;

use App\Http\Controllers\Controller;
use App\Models\Cart;
use App\Models\Kid;
use App\Models\Product;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    protected function query(){
        $kids = Kid::with([
            'schoolAndClass' => function($query) {
                $query->with(['school', 'class']);
            }
        ])->where('user_id', auth()->user()->id)->get();

        return Product::select('*')->with([
            'category',
            'schoolAndclass' => function($query) {
                $query->with(['school', 'class']);
            }
        ])
        ->where(function($query) use($kids){
            foreach ($kids as $key => $value) {
                # code...
                if($key==0){
                    $query->where(function($q) use($value){
                        $q->where('gender', $value->gender)->where('school_class_id', $value->school_class_id);
                    });
                }else{
                    $query->orWhere(function($q) use($value){
                        $q->where('gender', $value->gender)->where('school_class_id', $value->school_class_id);
                    });
                }
            }
        })
        ->latest();
    }

    public function index(Request $request){
        $data = $this->query();

        if ($request->has('school')) {
            $arr = array_map('intval', explode('_', request()->input('school')));
            $data->where(function($query) use($arr){
                $query->whereHas('schoolAndClass', function($q) use($arr) {
                    $q->whereHas('school', function($q) use($arr) {
                        $q->whereIn('id', $arr);
                    });
                });
            });
        }

        if ($request->has('category')) {
            $arr = array_map('intval', explode('_', request()->input('category')));
            $data->where(function($query) use($arr){
                $query->whereHas('category', function($q) use($arr) {
                    $q->whereIn('id', $arr);
                });
            });
        }

        if ($request->has('gender')) {
            $arr = explode('_', request()->input('gender'));
            $data->whereIn('gender', $arr);
        }

        $kids = Kid::with([
            'schoolAndClass' => function($query) {
                $query->with(['school', 'class']);
            }
        ])->where('user_id', auth()->user()->id)->get();

        $school_category =  Product::with([
            'category',
            'schoolAndclass' => function($query) {
                $query->with(['school', 'class']);
            }
        ])
        ->where(function($query) use($kids){
            foreach ($kids as $key => $value) {
                # code...
                if($key==0){
                    $query->where(function($q) use($value){
                        $q->where('gender', $value->gender)->where('school_class_id', $value->school_class_id);
                    });
                }else{
                    $query->orWhere(function($q) use($value){
                        $q->where('gender', $value->gender)->where('school_class_id', $value->school_class_id);
                    });
                }
            }
        })
        ->latest()->get();

        $gender = Product::select('gender')
        ->where(function($query) use($kids){
            foreach ($kids as $key => $value) {
                # code...
                if($key==0){
                    $query->where(function($q) use($value){
                        $q->where('gender', $value->gender)->where('school_class_id', $value->school_class_id);
                    });
                }else{
                    $query->orWhere(function($q) use($value){
                        $q->where('gender', $value->gender)->where('school_class_id', $value->school_class_id);
                    });
                }
            }
        })->groupBy('gender')->get();

        $data = $data->paginate(10);

        $cart = Cart::with(['product'])->where('user_id', auth()->user()->id)->latest()->get();
        $cart_total = $cart->reduce(function ($total, $item) {
            return $total + $item->cart_quantity_price;
        },0);

        return view('school.dashboard.index')->with([
            'data' => $data,
            'cart' => $cart,
            'cart_total' => $cart_total,
            'kids' => $kids,
            'gender' => $gender,
            'school' => $school_category->pluck('schoolAndclass.school')->groupBy('id'),
            'category' => $school_category->pluck('category')->groupBy('id'),
        ]);
    }

}
