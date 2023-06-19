<?php

namespace App\Http\Controllers\Parent\Dashboard;

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

        if ($request->has('search')) {
            $search = $request->input('search');
            $data->where(function ($query) use ($search) {
                $query->where('name', 'like', '%' . $search . '%');
            });
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

        $data = $data->paginate(10);

        $cart = Cart::with(['product'])->where('user_id', auth()->user()->id)->latest()->get();
        $cart_total = $cart->reduce(function ($total, $item) {
            return $total + $item->cart_quantity_price;
        },0);

        return view('parent.dashboard.index')->with([
            'data' => $data,
            'cart' => $cart,
            'cart_total' => $cart_total,
            'school' => $school_category->pluck('schoolAndclass.school')->groupBy('id'),
            'category' => $school_category->pluck('category')->groupBy('id'),
        ]);
    }

}
