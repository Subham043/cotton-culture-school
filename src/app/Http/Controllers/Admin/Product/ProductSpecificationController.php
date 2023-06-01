<?php

namespace App\Http\Controllers\Admin\Product;

use App\Http\Controllers\Controller;
use App\Models\ProductSpecification;
use App\Models\Product;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ProductSpecificationController extends Controller
{
    protected function query($product_id){
        return ProductSpecification::with(['product'])->where('product_id', $product_id)->latest();
    }

    public function index(Request $request, $product_id){
        Product::findOrFail($product_id);
        $data = $this->query($product_id);
        if ($request->has('search')) {
            $search = $request->input('search');
            $data->where(function ($query) use ($search) {
                $query->where('title', 'like', '%' . $search . '%')
                ->orWhere('description', 'like', '%' . $search . '%');
            });
        }
        $data = $data->paginate(10);
        return view('admin.product.specification.paginate', compact(['product_id', 'data']));
    }

    public function create($product_id) {
        Product::findOrFail($product_id);
        return view('admin.product.specification.create', compact('product_id'));
    }

    public function store(ProductSpecificationRequest $req, $product_id) {
        Product::findOrFail($product_id);

        ProductSpecification::create([
            ...$req->validated(),
            'product_id' => $product_id
        ]);

        return redirect()->back()->with('success_status', 'Data Stored successfully.');
    }

    public function edit($product_id, $id) {
        Product::findOrFail($product_id);

        $data = $this->query($product_id)->findOrFail($id);
        return view('admin.product.specification.update', compact(['product_id', 'data']));
    }

    public function update(ProductSpecificationRequest $req, $product_id, $id) {
        Product::findOrFail($product_id);

        $data = $this->query($product_id)->findOrFail($id);

        $data->update([
            ...$req->validated(),
        ]);

        return redirect()->back()->with('success_status', 'Data Updated successfully.');

    }

    public function delete($product_id, $id){
        Product::findOrFail($product_id);
        $data = $this->query($product_id)->findOrFail($id);
        $data->forceDelete();
        return redirect()->back()->with('success_status', 'Data Deleted successfully.');
    }

}


class ProductSpecificationRequest extends FormRequest
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
            'title' => ['required'],
            'description' => ['required'],
        ];
    }

}
