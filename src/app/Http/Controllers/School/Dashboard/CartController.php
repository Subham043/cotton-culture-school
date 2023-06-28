<?php

namespace App\Http\Controllers\School\Dashboard;

use App\Http\Controllers\Controller;
use App\Models\Address;
use App\Models\Cart;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;

class CartController extends Controller
{
    public function save_cart(CartRequest $request)
    {
        Cart::create([
            ...$request->safe()->except('units'),
            'user_id' => auth()->user()->id,
            'units' => json_encode($request->units),
        ]);

        return response()->json([
            'message' => 'Added to cart successfully.'
        ], 201);
    }

    public function delete_cart($id)
    {
        $cart = Cart::where('user_id', auth()->user()->id)->findOrFail($id);
        $cart->forceDelete();
        return redirect()->back()->with('success_status', 'Cart Item Deleted successfully.');
    }

    public function checkout(){

        $cart = Cart::with(['product'])->where('user_id', auth()->user()->id)->latest()->get();
        $cart_total = $cart->reduce(function ($total, $item) {
            return $total + $item->cart_quantity_price;
        },0);

        $address = Address::where('user_id', auth()->user()->id)->get();

        return view('school.dashboard.checkout')->with([
            'address' => $address,
            'cart' => $cart,
            'cart_total' => $cart_total,
        ]);
    }

    public function edit_cart($id){

        $cart_detail = Cart::with(['product', 'kid'])->where('user_id', auth()->user()->id)->latest()->findOrFail($id);
        $cart = Cart::with(['product'])->where('user_id', auth()->user()->id)->latest()->get();
        $cart_total = $cart->reduce(function ($total, $item) {
            return $total + $item->cart_quantity_price;
        },0);

        return view('school.dashboard.cart_edit')->with([
            'cart_detail' => $cart_detail,
            'cart' => $cart,
            'cart_total' => $cart_total,
        ]);
    }

    public function update_cart(CartUpdateRequest $request, $id)
    {
        $cart_detail = Cart::with(['product', 'kid'])->where('user_id', auth()->user()->id)->latest()->findOrFail($id);
        $cart_detail->update([
            ...$request->safe()->except('units'),
            'units' => json_encode($request->units),
        ]);

        return response()->json([
            'message' => 'Cart Item updated successfully.'
        ], 200);
    }

}

class CartRequest extends FormRequest
{

    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return Auth::check();
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'product_id' => 'required|numeric|exists:products,id',
            'kid_id' => 'required|numeric|exists:kids,id',
            'units' => 'required',
            'quantity' => 'required|numeric',
        ];
    }

}

class CartUpdateRequest extends FormRequest
{

    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return Auth::check();
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'units' => 'required',
            'quantity' => 'required|numeric',
        ];
    }

}
