<?php

namespace App\Http\Controllers\Admin\Product;

use App\Http\Controllers\Controller;
use App\Models\Unit;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UnitController extends Controller
{
    protected function query(){
        return Unit::latest();
    }

    public function index(Request $request){
        $data = $this->query();
        if ($request->has('search')) {
            $search = $request->input('search');
            $data->where(function ($query) use ($search) {
                $query->where('unit_title', 'like', '%' . $search . '%');
            });
        }
        $data = $data->paginate(10);
        return view('admin.product.unit.paginate', compact(['data']));
    }

    public function create() {
        return view('admin.product.unit.create');
    }

    public function store(UnitRequest $req) {
        Unit::create([
            ...$req->validated(),
        ]);

        return redirect()->back()->with('success_status', 'Data Stored successfully.');
    }

    public function edit($id) {

        $data = $this->query()->findOrFail($id);
        return view('admin.product.unit.update', compact(['data']));
    }

    public function update(UnitRequest $req, $id) {

        $data = $this->query()->findOrFail($id);

        $data->update([
            ...$req->validated(),
        ]);

        return redirect()->back()->with('success_status', 'Data Updated successfully.');

    }

    public function delete($id){
        $data = $this->query()->findOrFail($id);
        $data->forceDelete();
        return redirect()->back()->with('success_status', 'Data Deleted successfully.');
    }

}


class UnitRequest extends FormRequest
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
