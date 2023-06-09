<?php

namespace App\Http\Controllers\School\Dashboard;

use App\Enums\Gender;
use App\Http\Controllers\Controller;
use App\Models\Cart;
use App\Models\Kid;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\SchoolClass;
use Illuminate\Validation\Rules\Enum;
use Illuminate\Support\Arr;

class KidController extends Controller
{
    protected function query(){
        return Kid::with(['schoolAndclass'])->where('user_id', auth()->user()->id)->latest();
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
                $query->where('name', 'like', '%' . $search . '%');
            });
        }

        $data = $data->paginate(10);
        return view('school.kid.paginate')->with([
            'data'=> $data,
            'cart'=> $this->cart(),
            'cart_total'=> $this->cart_total(),
        ]);
    }

    public function create() {
        $school_ids = Auth::user()->allocated_schools->pluck('id');
        return view('school.kid.create')->with([
            'school_classes' => SchoolClass::with(['class', 'school', 'section'])->whereHas('school', function($query) use($school_ids) {
                $query->whereIn('id', $school_ids);
            })->get(),
            'genders' => Arr::map(Gender::cases(), fn($enum) => $enum->value),
            'cart' => $this->cart(),
            'cart_total' => $this->cart_total(),
        ]);
    }

    public function store(KidRequest $req) {

        Kid::create([
            ...$req->validated(),
            'user_id' => auth()->id()
        ]);

        return redirect()->back()->with('success_status', 'Data Stored successfully.');
    }

    public function edit($id) {
        $data = $this->query()->findOrFail($id);
        $school_ids = Auth::user()->allocated_schools->pluck('id');
        return view('school.kid.update')->with('data',$data)->with([
            'school_classes' => SchoolClass::with(['class', 'school', 'section'])->whereHas('school', function($query) use($school_ids) {
                $query->whereIn('id', $school_ids);
            })->get(),
            'genders' => Arr::map(Gender::cases(), fn($enum) => $enum->value),
            'cart' => $this->cart(),
            'cart_total' => $this->cart_total(),
        ]);
    }

    public function update(KidRequest $req, $id) {
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


class KidRequest extends FormRequest
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
            'name' => ['required', 'string'],
            'section' => ['required', 'string'],
            'gender' => ['required', new Enum(Gender::class)],
            'school_class_id' => 'required|numeric|exists:school_classes,id',
        ];
    }

}
