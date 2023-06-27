<?php

namespace App\Http\Controllers\Admin\User;

use App\Enums\Role;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;
use Stevebauman\Purify\Facades\Purify;
use Illuminate\Auth\Events\Registered;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules\Password as PasswordValidation;

class ParentUserController extends Controller
{

    protected function query(){
        return User::where('id', '!=' , Auth::user()->id)->where("role" , Role::PARENT->value)->orderBy('id', 'DESC');
    }

    public function create() {

        return view('admin.user.parent.create');
    }

    public function store(UserCreateRequest $req) {

        $result = User::create([
            ...$req->except('phone', 'password'),
            'role' => Role::PARENT->value,
            'password' => Hash::make($req->password),
            'phone' => !empty($req->phone) ? $req->phone : null
        ]);

        event(new Registered($result));

        if($result){
            return redirect()->back()->with('success_status', 'Data Stored successfully.');
        }else{
            return redirect()->back()->with('error_status', 'Something went wrong. Please try again');
        }
    }

    public function edit($id) {
        $data = $this->query()->findOrFail($id);
        return view('admin.user.parent.update')->with('data',$data);
    }

    public function update(UserUpdateRequest $req, $id) {
        $data = User::findOrFail($id);

        $result = $data->fill([
            ...$req->except(['password', 'phone']),
            'phone' => !empty($req->phone) ? $req->phone : null
        ]);

        if ($data->isDirty('email')) {
            $data->email_verified_at = null;
            $data->sendEmailVerificationNotification();
            $data->save();
        }

        if($result){
            return redirect()->back()->with('success_status', 'Data Updated successfully.');
        }else{
            return redirect()->back()->with('error_status', 'Something went wrong. Please try again');
        }
    }

    public function delete($id){
        $data = $this->query()->findOrFail($id);
        $data->forceDelete();
        return redirect()->back()->with('success_status', 'Data Deleted successfully.');
    }

    public function view(Request $request) {
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
        return view('admin.user.parent.paginate')->with('data', $data);
    }

}


class UserCreateRequest extends FormRequest
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
            'email' => ['required','email','unique:users'],
            'phone' => ['nullable','regex:/^[0-9]*$/','unique:users'],
            'password' => ['required',
                'string',
                PasswordValidation::min(8)
                        ->letters()
                        ->mixedCase()
                        ->numbers()
                        ->symbols()
                        ->uncompromised()
            ],
            'confirm_password' => ['required_with:password|same:password'],
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
            'userType.required' => 'Please enter the user type !',
            'userType.regex' => 'Please enter the valid user type !',
            'email.required' => 'Please enter the email !',
            'email.email' => 'Please enter the valid email !',
            'phone.required' => 'Please enter the phone !',
            'phone.regex' => 'Please enter the valid phone !',
            'password.required' => 'Please enter the password !',
            'password.regex' => 'Please enter the valid password !',
            'confirm_password.required' => 'Please enter your confirm password !',
            'confirm_password.same' => 'password & confirm password must be the same !',
        ];
    }

    /**
     * Handle a passed validation attempt.
     *
     * @return void
     */
    protected function passedValidation()
    {
        $this->replace(
            Purify::clean(
                $this->all()
            )
        );
    }

}

class UserUpdateRequest extends UserCreateRequest
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
            'email' => ['required','email','unique:users,email,'.$this->route('id')],
            'phone' => ['required','regex:/^[0-9]*$/','unique:users,phone,'.$this->route('id')],
        ];
    }
}
