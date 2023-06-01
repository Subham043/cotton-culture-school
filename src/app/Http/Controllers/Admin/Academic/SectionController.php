<?php

namespace App\Http\Controllers\Admin\Academic;

use App\Http\Controllers\Controller;
use App\Models\Section;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\SectionExport;

class SectionController extends Controller
{
    protected function query(){
        return Section::latest();
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
        return view('admin.section.paginate')->with('data', $data);
    }

    public function create() {

        return view('admin.section.create');
    }

    public function store(SectionRequest $req) {

        Section::create([
            ...$req->validated()
        ]);

        return redirect()->back()->with('success_status', 'Data Stored successfully.');
    }

    public function edit($id) {
        $data = $this->query()->findOrFail($id);
        return view('admin.section.update')->with('data',$data);
    }

    public function update(SectionRequest $req, $id) {
        $data = Section::findOrFail($id);

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
        return Excel::download(new SectionExport, 'sections.xlsx');
    }

}


class SectionRequest extends FormRequest
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
        ];
    }

    /**
     * Get the error messages for the defined validation rules.
     *
     * @return array<string, string>
     */
    public function messages(): array
    {
        return [
            'name.required' => 'Please enter the name !',
        ];
    }

}
