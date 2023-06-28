<?php

namespace App\Http\Controllers\School\Dashboard;

use App\Http\Controllers\Controller;
use App\Models\Address;
use App\Models\Cart;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AddressController extends Controller
{
    protected function query(){
        return Address::where('user_id', auth()->user()->id)->latest();
    }

    protected function cart(){
        return Cart::with(['product'])->where('user_id', auth()->user()->id)->latest()->get();
    }

    protected function cart_total(){
        return $this->cart()->reduce(function ($total, $item) {
            return $total + $item->cart_quantity_price;
        },0);
    }

    public function index(Request $request){
        $data = $this->query();

        if ($request->has('search')) {
            $search = $request->input('search');
            $data->where(function ($query) use ($search) {
                $query->where('label', 'like', '%' . $search . '%')
                ->orWhere('state', 'like', '%' . $search . '%')
                ->orWhere('pin', 'like', '%' . $search . '%')
                ->orWhere('address', 'like', '%' . $search . '%')
                ->orWhere('city', 'like', '%' . $search . '%');
            });
        }

        $data = $data->paginate(10);
        return view('school.address.paginate')->with([
            'data'=> $data,
            'cart'=> $this->cart(),
            'cart_total'=> $this->cart_total(),
        ]);
    }

    public function create() {

        return view('school.address.create')->with([
            'cart'=> $this->cart(),
            'cart_total'=> $this->cart_total(),
        ]);
    }

    public function store(AddressRequest $req) {

        Address::create([
            ...$req->validated(),
            'user_id' => auth()->id()
        ]);

        return redirect()->back()->with('success_status', 'Data Stored successfully.');
    }

    public function edit($id) {
        $data = $this->query()->findOrFail($id);
        return view('school.address.update')->with([
            'data'=> $data,
            'cart'=> $this->cart(),
            'cart_total'=> $this->cart_total(),
        ]);
    }

    public function update(AddressRequest $req, $id) {
        $product = $this->query()->findOrFail($id);

        $product->update($req->validated());

        return redirect()->back()->with('success_status', 'Data Updated successfully.');

    }

    public function delete($id){
        $product = $this->query()->findOrFail($id);
        $product->forceDelete();
        return redirect()->back()->with('success_status', 'Data Deleted successfully.');
    }

}


class AddressRequest extends FormRequest
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
            'label' => ['required', 'string'],
            'city' => ['required', 'string'],
            'state' => ['required', 'string'],
            'pin' => ['required', 'string'],
            'address' => ['required', 'string'],
        ];
    }

}
