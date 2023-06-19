<?php

namespace App\Http\Controllers\Parent\Dashboard;

use App\Enums\OrderStatus;
use App\Enums\PaymentMode;
use App\Enums\PaymentStatus;
use App\Http\Controllers\Controller;
use App\Models\Cart;
use App\Models\Order;
use App\Models\OrderUnit;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Illuminate\Validation\Rules\Enum;
use Razorpay\Api\Api;
use Razorpay\Api\Errors\SignatureVerificationError;

class OrderController extends Controller
{
    protected function query(){
        return Order::with([
            'address',
            'user',
            'orderItems' => function($query) {
                $query->with([
                    'product',
                    'kid'
                ]);
            }
        ])
        ->where('user_id', auth()->user()->id)
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
    }

    protected function cart(){
        return Cart::with(['product'])->where('user_id', auth()->user()->id)->latest()->get();
    }

    protected function cart_total(){
        return $this->cart()->reduce(function ($total, $item) {
            return $total + $item->cart_quantity_price;
        },0);
    }

    protected function create_order_id(float $amount, string $receipt): string
    {

        $api = new Api(env('RAZORPAY_KEY'), env('RAZORPAY_SECRET'));
        $orderData = [
            'receipt'         => $receipt,
            'amount'          => $amount*100, // 39900 rupees in paise
            'currency'        => 'INR',
            'partial_payment' => false,
        ];

        $razorpayOrder = $api->order->create($orderData);
        return $razorpayOrder['id'];
    }

    protected function payment_verify(array $data): bool
    {

        $api = new Api(env('RAZORPAY_KEY'), env('RAZORPAY_SECRET'));
        try
        {
            $data['status'] = 1;

            $api->utility->verifyPaymentSignature($data);
            return true;
        }
        catch(SignatureVerificationError $e)
        {
            return false;
        }
    }

    protected function refund(float $amount, string $razorpay_payment_id): void
    {

        $api = new Api(env('RAZORPAY_KEY'), env('RAZORPAY_SECRET'));
        $refundData = [
            'amount'          => $amount*100, // 39900 rupees in paise
            'speed'        => 'normal',
        ];

        $razorpayOrder = $api->payment->fetch($razorpay_payment_id)->refund($refundData);
    }

    public function index(Request $request){
        $data = $this->query();

        $data = $data->paginate(10);
        return view('parent.order.paginate')->with([
            'data'=> $data,
            'cart'=> $this->cart(),
            'cart_total'=> $this->cart_total(),
        ]);
    }

    public function detail($id) {
        $data = $this->query()->findOrFail($id);
        return view('parent.order.detail')->with([
            'data'=> $data,
            'cart'=> $this->cart(),
            'cart_total'=> $this->cart_total(),
        ]);
    }

    public function place_order(OrderRequest $request)
    {
        $cart = Cart::with(['product'])->where('user_id', auth()->user()->id)->latest()->get();
        $cart_total = $cart->reduce(function ($total, $item) {
            return $total + $item->cart_quantity_price;
        },0);

        $order = Order::create([
            ...$request->validated(),
            'total_amount' => $cart_total,
            'receipt' => str()->uuid(),
            'user_id' => auth()->user()->id,
        ]);

        foreach ($cart as $key => $value) {
            # code...
            OrderUnit::create(
                array(
                    "units" => $value->units,
                    "quantity" => $value->quantity,
                    "product_id" => $value->product_id,
                    "kid_id" => $value->kid_id,
                    "order_id" => $order->id,
                )
            );
        }

        if($request->mode_of_payment==PaymentMode::COD->value){
            Cart::where('user_id', auth()->user()->id)->forceDelete();
            Session::flash('order_placed', 'Ordered successfully.');
            return response()->json([
                'message' => 'Order completed successfully.',
                'link' => route('order.detail.get', $order->id),
            ], 201);
        }

        $order_id = $this->create_order_id($cart_total, $order->receipt);
        $order->update([
            'razorpay_order_id' => $order_id
        ]);

        return response()->json([
            'message' => 'Please make the payment to complete the order.',
            'link' => route('order.make_payment.get', $order->id),
        ], 201);
    }

    public function make_payment($id) {
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
        ->where('user_id', auth()->user()->id)
        ->where(function($query){
            $query->where('mode_of_payment', PaymentMode::ONLINE)->where('payment_status', PaymentStatus::PENDING);
        })
        ->latest()->findOrFail($id);
        return view('parent.order.payment')->with([
            'data'=> $data,
            'cart'=> $this->cart(),
            'cart_total'=> $this->cart_total(),
        ]);
    }
    public function verify_payment(VerifyPaymentRequest $request, $id) {
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
        ->where('user_id', auth()->user()->id)
        ->where(function($query){
            $query->where('mode_of_payment', PaymentMode::ONLINE)->where('payment_status', PaymentStatus::PENDING);
        })
        ->latest()->findOrFail($id);

        $verify = $this->payment_verify($request->validated());

        if($verify){
            $data->update([
                'razorpay_payment_id' => $request->razorpay_payment_id,
                'razorpay_signature' => $request->razorpay_signature,
                'payment_status' => PaymentStatus::PAID,
            ]);
            Cart::where('user_id', auth()->user()->id)->forceDelete();
            Session::flash('order_placed', 'Ordered successfully.');
            return response()->json([
                'message' => 'Order completed successfully.',
                'link' => route('order.detail.get', $data->id),
            ], 201);
        }
        return response()->json([
            'message' => 'Payment verification failed!',
        ], 400);
    }

    public function cancel_order($id) {
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
        ->where('user_id', auth()->user()->id)
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
}

class OrderRequest extends FormRequest
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
            'mode_of_payment' => ['required', new Enum(PaymentMode::class)],
            'address_id' => 'required|numeric|exists:addresses,id',
        ];
    }

}

class VerifyPaymentRequest extends FormRequest
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
            'razorpay_order_id' => ['required', 'string', 'exists:orders,razorpay_order_id'],
            'razorpay_payment_id' => ['required', 'string'],
            'razorpay_signature' => ['required', 'string'],
        ];
    }

}
