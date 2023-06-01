<?php

namespace App\Http\Controllers\Admin\Academic;

use App\Http\Controllers\Controller;
use App\Models\Classes;
use App\Models\SchoolClass;
use App\Models\School;
use App\Models\Section;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class SchoolClassController extends Controller
{
    protected function query($school_id){
        return SchoolClass::with(['class', 'school', 'section'])->where('school_id', $school_id)->latest();
    }

    public function index(Request $request, $school_id){
        School::findOrFail($school_id);
        $data = $this->query($school_id);

        if ($request->has('search')) {
            $search = $request->input('search');
            $data->where(function ($query) use ($search) {
                $query->whereHas('class', function($q) use($search){
                    $q->where('name', 'like', '%' . $search . '%');
                });
            });
        }

        $data = $data->paginate(10);
        return view('admin.school_class.paginate', compact(['school_id', 'data']));
    }

    public function create($school_id) {
        School::findOrFail($school_id);
        return view('admin.school_class.create', compact('school_id'))->with([
            'classes' => Classes::all(),
            'sections' => Section::all(),
        ]);
    }

    public function store(SchoolClassRequest $req, $school_id) {
        School::findOrFail($school_id);

        $school_class = SchoolClass::create([
            ...$req->except('section'),
            'school_id' => $school_id
        ]);

        $school_class->section()->sync($req->section);

        return redirect()->back()->with('success_status', 'Data Stored successfully.');
    }

    public function edit($school_id, $id) {
        School::findOrFail($school_id);

        $data = $this->query($school_id)->findOrFail($id);
        return view('admin.school_class.update', compact(['school_id', 'data']))->with([
            'classes' => Classes::all(),
            'sections' => Section::all(),
            'section_data' => $data->section->pluck('id')->toArray(),
        ]);
    }

    public function update(SchoolClassRequest $req, $school_id, $id) {
        School::findOrFail($school_id);

        $data = $this->query($school_id)->findOrFail($id);

        $data->update([
            ...$req->except('section'),
        ]);

        $data->section()->sync($req->section);

        return redirect()->back()->with('success_status', 'Data Updated successfully.');

    }

    public function delete($school_id, $id){
        School::findOrFail($school_id);
        $data = $this->query($school_id)->findOrFail($id);
        $data->forceDelete();
        return redirect()->back()->with('success_status', 'Data Deleted successfully.');
    }

}


class SchoolClassRequest extends FormRequest
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
            'class_id' => 'required|numeric|exists:classes,id',
            'section' => 'required|array|min:1',
            'section.*' => 'required|numeric|exists:sections,id',
        ];
    }

}
