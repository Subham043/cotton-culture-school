<?php

namespace App\Http\Controllers\Admin\Academic;

use App\Http\Controllers\Controller;
use App\Models\School;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\SchoolExport;
use App\Services\FileService;

class SchoolController extends Controller
{
    protected function query(){
        return School::latest();
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
        return view('admin.school.paginate')->with('data', $data);
    }

    public function create() {

        return view('admin.school.create');
    }

    public function store(SchoolCreateRequest $req) {

        $school = School::create($req->except('logo'));

        if($req->hasFile('logo')){
            $path = str_replace("storage/","",$school->logo);
            (new FileService)->delete_file($path);
            $logo_image = (new FileService)->save_file('logo', (new School)->image_path);
            $school->update([
                'logo' => $logo_image,
            ]);
        }

        return redirect()->back()->with('success_status', 'Data Stored successfully.');
    }

    public function edit($id) {
        $data = $this->query()->findOrFail($id);
        return view('admin.school.update')->with('data',$data);
    }

    public function update(SchoolUpdateRequest $req, $id) {
        $school = School::findOrFail($id);

        $school->update($req->except('logo'));

        if($req->hasFile('logo')){
            $path = str_replace("storage/","",$school->logo);
            (new FileService)->delete_file($path);
            $logo_image = (new FileService)->save_file('logo', (new School)->image_path);
            $school->update([
                'logo' => $logo_image,
            ]);
        }

        return redirect()->back()->with('success_status', 'Data Updated successfully.');

    }

    public function delete($id){
        $school = $this->query()->findOrFail($id);
        $path = str_replace("storage/","",$school->logo);
        (new FileService)->delete_file($path);
        $school->forceDelete();
        return redirect()->back()->with('success_status', 'Data Deleted successfully.');
    }

    public function excel(){
        return Excel::download(new SchoolExport, 'schools.xlsx');
    }

}


class SchoolCreateRequest extends FormRequest
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
            'submission_duration' => ['required', 'numeric'],
            'logo' => 'required|image|max:500',
        ];
    }

}

class SchoolUpdateRequest extends SchoolCreateRequest
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
            'submission_duration' => ['required', 'numeric'],
            'logo' => 'nullable|image|max:500',
        ];
    }

}
