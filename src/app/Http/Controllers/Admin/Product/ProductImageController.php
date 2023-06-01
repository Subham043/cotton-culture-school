<?php

namespace App\Http\Controllers\Admin\Product;

use App\Http\Controllers\Controller;
use App\Models\ProductImage;
use App\Models\Product;
use App\Services\FileService;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ProductImageController extends Controller
{
    protected function query($product_id){
        return ProductImage::with(['product'])->where('product_id', $product_id)->latest();
    }

    public function index(Request $request, $product_id){
        Product::findOrFail($product_id);
        $data = $this->query($product_id);

        $data = $data->paginate(10);
        return view('admin.product.image.paginate', compact(['product_id', 'data']));
    }

    public function store(ProductImageRequest $req, $product_id) {
        Product::findOrFail($product_id);

        $product_image = ProductImage::create([
            ...$req->except('image'),
            'product_id' => $product_id
        ]);

        if($req->hasFile('image')){
            $path = str_replace("storage/","",$product_image->image);
            (new FileService)->delete_file($path);
            $image = (new FileService)->save_file('image', (new ProductImage)->image_path);
            $product_image->update([
                'image' => $image,
            ]);
        }

        return redirect()->back()->with('success_status', 'Data Stored successfully.');
    }

    public function delete($product_id, $id){
        Product::findOrFail($product_id);
        $data = $this->query($product_id)->findOrFail($id);
        $data->forceDelete();
        return redirect()->back()->with('success_status', 'Data Deleted successfully.');
    }

}


class ProductImageRequest extends FormRequest
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
            'image' => 'required|image|max:500',
        ];
    }

}
