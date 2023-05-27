<?php

namespace App\Http\Controllers\Main\Dashboard;

use App\Enums\AvailibilityType;
use App\Enums\ProjectType;
use App\Enums\RoomType;
use App\Http\Controllers\Controller;
use App\Models\Project;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use Illuminate\Validation\Rules\Enum;
use Illuminate\Support\Facades\Auth;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\ProjectExport;

class ProjectController extends Controller
{
    protected function query(){
        return Project::latest();
    }

    public function index(Request $request){
        $data = $this->query();

        if ($request->has('search')) {
            $search = $request->input('search');
            $data->where(function ($query) use ($search) {
                $query->where('name', 'like', '%' . $search . '%')
                      ->orWhere('project_type', 'like', '%' . $search . '%')
                      ->orWhere('number', 'like', '%' . $search . '%')
                      ->orWhere('facing', 'like', '%' . $search . '%')
                      ->orWhere('availibility', 'like', '%' . $search . '%')
                      ->orWhere('site_measurement', 'like', '%' . $search . '%')
                      ->orWhere('type', 'like', '%' . $search . '%');
            });
        }

        $data = $data->paginate(10);
        return view('admin.pages.project.paginate')->with('data', $data);
    }

    public function create() {

        return view('admin.pages.project.create')->with([
            'project_types' => Arr::map(ProjectType::cases(), fn($enum) => $enum->value),
            'room_types' => Arr::map(RoomType::cases(), fn($enum) => $enum->value),
            'availibility_types' => Arr::map(AvailibilityType::cases(), fn($enum) => $enum->value),
        ]);
    }

    public function store(ProjectRequest $req) {

        Project::create($req->validated());

        return redirect()->back()->with('success_status', 'Data Stored successfully.');
    }

    public function edit($id) {
        $data = $this->query()->findOrFail($id);
        return view('admin.pages.project.update')->with('data',$data)->with([
            'project_types' => Arr::map(ProjectType::cases(), fn($enum) => $enum->value),
            'room_types' => Arr::map(RoomType::cases(), fn($enum) => $enum->value),
            'availibility_types' => Arr::map(AvailibilityType::cases(), fn($enum) => $enum->value),
        ]);
    }

    public function update(ProjectRequest $req, $id) {
        $data = Project::findOrFail($id);

        $data->update($req->validated());

        return redirect()->back()->with('success_status', 'Data Updated successfully.');

    }

    public function delete($id){
        $data = $this->query()->findOrFail($id);
        $data->forceDelete();
        return redirect()->back()->with('success_status', 'Data Deleted successfully.');
    }

    public function excel(){
        return Excel::download(new ProjectExport, 'projects.xlsx');
    }

}


class ProjectRequest extends FormRequest
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
            'project_type' => ['required', new Enum(ProjectType::class)],
            'number' => ['required'],
            'facing' => ['required'],
            'availibility' => ['required', new Enum(AvailibilityType::class)],
            'site_measurement' => ['required'],
            'type' => ['required', new Enum(RoomType::class)],
        ];
    }

    public function attributes(): array
    {
        return [
            'name' => 'Project Name',
            'type' => 'Project Room Type',
            'number' => 'Project Number',
            'facing' => 'Project Facing',
            'availibility' => 'Project Availibility',
            'site_measurement' => 'Project Site Measurement',
        ];
    }

}
