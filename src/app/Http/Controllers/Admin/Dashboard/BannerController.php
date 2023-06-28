<?php

namespace App\Http\Controllers\Admin\Dashboard;

use App\Http\Controllers\Controller;
use App\Models\Banner;
use App\Services\FileService;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class BannerController extends Controller
{
    protected function query(){
        return Banner::latest();
    }

    public function index(Request $request){
        $data = $this->query();

        $data = $data->paginate(10);
        return view('admin.banner.paginate', compact(['data']));
    }

    public function store(BannerRequest $req) {

        $product_image = Banner::create([
            ...$req->except('image')
        ]);

        if($req->hasFile('image')){
            $path = str_replace("storage/","",$product_image->image);
            (new FileService)->delete_file($path);
            $image = (new FileService)->save_file('image', (new Banner)->image_path);
            $product_image->update([
                'image' => $image,
            ]);
        }

        return redirect()->back()->with('success_status', 'Data Stored successfully.');
    }

    public function delete($id){
        $data = $this->query()->findOrFail($id);
        $data->forceDelete();
        return redirect()->back()->with('success_status', 'Data Deleted successfully.');
    }

}


class BannerRequest extends FormRequest
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
            'image' => 'required|image|max:500',
        ];
    }

}
