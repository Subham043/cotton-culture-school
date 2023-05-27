<?php

namespace App\Http\Controllers\Main\Dashboard;

use App\Http\Controllers\Controller;
use App\Models\Client;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\ClientExport;

class ClientController extends Controller
{
    protected function query(){
        return Client::latest();
    }

    public function index(Request $request){
        $data = $this->query();

        if ($request->has('search')) {
            $search = $request->input('search');
            $data->where(function ($query) use ($search) {
                $query->where('name', 'like', '%' . $search . '%')
                      ->orWhere('email', 'like', '%' . $search . '%')
                      ->orWhere('phone', 'like', '%' . $search . '%');
            });
        }

        $data = $data->paginate(10);
        return view('admin.pages.client.paginate')->with('data', $data);
    }

    public function create() {

        return view('admin.pages.client.create');
    }

    public function store(ClientCreateRequest $req) {

        Client::create([
            ...$req->validated()
        ]);

        return redirect()->back()->with('success_status', 'Data Stored successfully.');
    }

    public function edit($id) {
        $data = $this->query()->findOrFail($id);
        return view('admin.pages.client.update')->with('data',$data);
    }

    public function update(ClientUpdateRequest $req, $id) {
        $data = Client::findOrFail($id);

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
        return Excel::download(new ClientExport, 'clients.xlsx');
    }

}


class ClientCreateRequest extends FormRequest
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
            'name' => ['required','regex:/^[a-zA-Z0-9\s]*$/'],
            'email' => ['required','email','unique:clients'],
            'phone' => ['required','regex:/^[0-9]*$/','unique:clients'],
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
            'name.regex' => 'Please enter the valid name !',
            'email.required' => 'Please enter the email !',
            'email.email' => 'Please enter the valid email !',
            'phone.required' => 'Please enter the phone !',
            'phone.regex' => 'Please enter the valid phone !',
        ];
    }

}

class ClientUpdateRequest extends ClientCreateRequest
{

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'name' => ['required','regex:/^[a-zA-Z0-9\s]*$/'],
            'email' => ['required','email','unique:clients,email,'.$this->route('id')],
            'phone' => ['required','regex:/^[0-9]*$/','unique:clients,phone,'.$this->route('id')],
        ];
    }
}
