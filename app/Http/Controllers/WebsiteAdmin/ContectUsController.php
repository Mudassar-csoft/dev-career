<?php

namespace App\Http\Controllers\WebsiteAdmin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\WebsiteAdmin\ContectUs;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;

class ContectUsController extends Controller
{
   
    public function contectindex()
    {
        $allcontectus = ContectUs::all();
        $title = "Contect-Us";
        $contectus = 'active';
        return view('WebsiteAdmin.Contect _Us.index',compact('contectus','title','allcontectus'));


    }
    public function contectStore(Request $request)
    {
        $validate = Validator::make($request->all(),[
            'name'=>'required|alpha',
            'email'=>'required|email',
            'subject'=>'required',
            'number'=>'required|numeric',
            'g-recaptcha-response'=> function ($attribute, $value, $fail) {

                $secretkey = '6LfbyWEiAAAAAGfB9gPGXJyhy2yv_RimJ12maubc';
                $response = $value;
                $userid = $_SERVER['REMOTE_ADDR'];
                $url = "https://www.google.com/recaptcha/api/siteverify?secret=$secretkey&response=$response&remoteip=$userid";
                $response = \file_get_contents($url);
                $response = json_decode($response);
                if(!$response->success){
                    Session::flash('error','Please Check reCaptcha');
                    // Session::flash('alert-class','alert-danger');
                    $fail($attribute.'google reCaptcha failed');

                }
            },

        ]);
        if ($validate->fails()) {
            return redirect()->back()->with([
                'message' => 'Something went wrong!!',
            ])->withErrors($validate);
        }else{
            ContectUs::create($request->except('_token'));
            return redirect()->back()->with([
                'message'=>'Submited Successfully',
            ]);
        }

    }
}
