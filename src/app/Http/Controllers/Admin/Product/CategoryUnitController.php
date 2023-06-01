<?php

namespace App\Http\Controllers\Admin\Product;

use App\Http\Controllers\Controller;
use App\Models\CategoryUnit;
use App\Models\Category;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CategoryUnitController extends Controller
{
    protected function query($category_id){
        return CategoryUnit::with(['category'])->where('category_id', $category_id)->latest();
    }

    public function index(Request $request, $category_id){
        Category::findOrFail($category_id);
        $data = $this->query($category_id);
        if ($request->has('search')) {
            $search = $request->input('search');
            $data->where(function ($query) use ($search) {
                $query->where('unit_title', 'like', '%' . $search . '%');
            });
        }
        $data = $data->paginate(10);
        return view('admin.product.unit.paginate', compact(['category_id', 'data']));
    }

    public function create($category_id) {
        Category::findOrFail($category_id);
        return view('admin.product.unit.create', compact('category_id'));
    }

    public function store(CategoryUnitRequest $req, $category_id) {
        Category::findOrFail($category_id);

        CategoryUnit::create([
            ...$req->validated(),
            'category_id' => $category_id
        ]);

        return redirect()->back()->with('success_status', 'Data Stored successfully.');
    }

    public function edit($category_id, $id) {
        Category::findOrFail($category_id);

        $data = $this->query($category_id)->findOrFail($id);
        return view('admin.product.unit.update', compact(['category_id', 'data']));
    }

    public function update(CategoryUnitRequest $req, $category_id, $id) {
        Category::findOrFail($category_id);

        $data = $this->query($category_id)->findOrFail($id);

        $data->update([
            ...$req->validated(),
        ]);

        return redirect()->back()->with('success_status', 'Data Updated successfully.');

    }

    public function delete($category_id, $id){
        Category::findOrFail($category_id);
        $data = $this->query($category_id)->findOrFail($id);
        $data->forceDelete();
        return redirect()->back()->with('success_status', 'Data Deleted successfully.');
    }

}


class CategoryUnitRequest extends FormRequest
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
            'unit_title' => ['required'],
        ];
    }

}
