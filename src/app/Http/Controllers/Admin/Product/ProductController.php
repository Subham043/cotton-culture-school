<?php

namespace App\Http\Controllers\Admin\Product;

use App\Http\Controllers\Controller;
use App\Models\Product;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\ProductExport;
use App\Models\Category;
use App\Models\SchoolClass;
use App\Services\FileService;

class ProductController extends Controller
{
    protected function query(){
        return Product::with(['category', 'schoolAndclass'])->latest();
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
        return view('admin.product.item.paginate')->with('data', $data);
    }

    public function create() {

        return view('admin.product.item.create')->with([
            'categories' => Category::all(),
            'school_classes' => SchoolClass::with(['class', 'school'])->get(),
        ]);
    }

    public function store(ProductCreateRequest $req) {

        $product = Product::create($req->except('featured_image'));

        if($req->hasFile('featured_image')){
            $path = str_replace("storage/","",$product->featured_image);
            (new FileService)->delete_file($path);
            $featured_image = (new FileService)->save_file('featured_image', (new Product)->image_path);
            $product->update([
                'featured_image' => $featured_image,
            ]);
        }

        return redirect()->back()->with('success_status', 'Data Stored successfully.');
    }

    public function edit($id) {
        $data = $this->query()->findOrFail($id);
        return view('admin.product.item.update')->with('data',$data)->with([
            'categories' => Category::all(),
            'school_classes' => SchoolClass::with(['class', 'school'])->get(),
        ]);
    }

    public function update(ProductUpdateRequest $req, $id) {
        $product = $this->query()->findOrFail($id);

        $product->update($req->except('featured_image'));

        if($req->hasFile('featured_image')){
            $path = str_replace("storage/","",$product->featured_image);
            (new FileService)->delete_file($path);
            $featured_image = (new FileService)->save_file('featured_image', (new Product)->image_path);
            $product->update([
                'featured_image' => $featured_image,
            ]);
        }

        return redirect()->back()->with('success_status', 'Data Updated successfully.');

    }

    public function delete($id){
        $product = $this->query()->findOrFail($id);
        $path = str_replace("storage/","",$product->featured_image);
        (new FileService)->delete_file($path);
        $product->forceDelete();
        return redirect()->back()->with('success_status', 'Data Deleted successfully.');
    }

    public function excel(){
        return Excel::download(new ProductExport, 'products.xlsx');
    }

}


class ProductCreateRequest extends FormRequest
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
            'name' => ['required'],
            'price' => ['required', 'numeric'],
            'category_id' => 'required|numeric|exists:categories,id',
            'school_class_id' => 'required|numeric|exists:school_classes,id',
            'brief_description' => ['required'],
            'detailed_description' => ['required'],
            'detailed_description_unfiltered' => ['required'],
            'featured_image' => 'required|image|max:500',
        ];
    }

}

class ProductUpdateRequest extends ProductCreateRequest
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
            'name' => ['required'],
            'price' => ['required', 'numeric'],
            'category_id' => 'required|numeric|exists:categories,id',
            'school_class_id' => 'required|numeric|exists:school_classes,id',
            'brief_description' => ['required'],
            'detailed_description' => ['required'],
            'detailed_description_unfiltered' => ['required'],
            'featured_image' => 'nullable|image|max:500',
        ];
    }

}
