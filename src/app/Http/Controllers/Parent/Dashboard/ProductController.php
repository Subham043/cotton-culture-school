<?php

namespace App\Http\Controllers\Parent\Dashboard;

use App\Http\Controllers\Controller;
use App\Models\Cart;
use App\Models\Kid;
use App\Models\Product;

class ProductController extends Controller
{
    public function index($id){
        $kids = Kid::with([
            'schoolAndClass' => function($query) {
                $query->with(['school', 'class']);
            }
        ])->where('user_id', auth()->user()->id)->get();

        $product = Product::with([
            'category',
            'schoolAndclass' => function($query) {
                $query->with(['school', 'class']);
            },
            'slider_image',
            'specification',
            'units',
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
        ->latest()->findOrFail($id);

        $kid = Kid::select('*')->with([
            'schoolAndClass' => function($query) {
                $query->with(['school', 'class']);
            }
        ])->where('user_id', auth()->user()->id)
        ->where(function($query) use($product){
            $query->where('gender', $product->gender)->where('school_class_id', $product->school_class_id);
        })->get();

        $cart = Cart::with(['product'])->where('user_id', auth()->user()->id)->latest()->get();
        $cart_total = $cart->reduce(function ($total, $item) {
            return $total + $item->cart_quantity_price;
        },0);

        return view('parent.dashboard.product')->with([
            'product' => $product,
            'kid' => $kid,
            'cart' => $cart,
            'cart_total' => $cart_total,
        ]);
    }

}
