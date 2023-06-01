<?php

namespace App\Http\Controllers\Admin\Product;

use App\Enums\Gender;
use App\Http\Controllers\Controller;
use App\Models\Category;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\CategoryExport;
use Illuminate\Validation\Rules\Enum;
use Illuminate\Support\Arr;

class CategoryController extends Controller
{
    protected function query(){
        return Category::latest();
    }

    public function index(Request $request){
        $data = $this->query();

        if ($request->has('search')) {
            $search = $request->input('search');
            $data->where(function ($query) use ($search) {
                $query->where('name', 'like', '%' . $search . '%')
                ->orWhere('gender', 'like', '%' . $search . '%');
            });
        }

        $data = $data->paginate(10);
        return view('admin.product.category.paginate')->with('data', $data);
    }

    public function create() {

        return view('admin.product.category.create')->with([
            'genders' => Arr::map(Gender::cases(), fn($enum) => $enum->value),
        ]);
    }

    public function store(CategoryRequest $req) {

        Category::create([
            ...$req->validated()
        ]);

        return redirect()->back()->with('success_status', 'Data Stored successfully.');
    }

    public function edit($id) {
        $data = $this->query()->findOrFail($id);
        return view('admin.product.category.update')->with('data',$data)->with([
            'genders' => Arr::map(Gender::cases(), fn($enum) => $enum->value),
        ]);
    }

    public function update(CategoryRequest $req, $id) {
        $data = Category::findOrFail($id);

        $data->update([
            ...$req->validated()
        ]);

        return redirect()->back()->with('success_status', 'Data Updated successfully.');

    }

    public function delete($id){
        $data = $this->query()->findOrFail($id);
        $data->forceDelete();
        return redirect()->back()->with('success_status', 'Data Deleted successfully.');
    }

    public function excel(){
        return Excel::download(new CategoryExport, 'categories.xlsx');
    }

}


class CategoryRequest extends FormRequest
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
            'gender' => ['required', new Enum(Gender::class)],
        ];
    }

}
