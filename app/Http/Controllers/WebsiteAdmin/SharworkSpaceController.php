<?php

namespace App\Http\Controllers\WebsiteAdmin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;
use App\Models\WebsiteAdmin\SharworkSpace;

class SharworkSpaceController extends Controller
{
    public function store(Request $request)
    {
      dd("hello");
        // return $request;
        $validate = Validator::make($request->all(), [
            'name'=>'required|alpha',
            'number'=>'required',
            'email'=>'required|email',
            'location'=>'required',
            'type'=>'required',
            'dob'=>'required',
            'g-recaptcha-response'=> function ($attribute, $value, $fail) {
                $secretkey = '6LfbyWEiAAAAAGfB9gPGXJyhy2yv_RimJ12maubc';
                $response = $value;
                $userid = $_SERVER['REMOTE_ADDR'];
                $url = "https://www.google.com/recaptcha/api/siteverify?secret=$secretkey&response=$response&remoteip=$userid";
                $response = \file_get_contents($url);
                $response = json_decode($response);
                if(!$response->success){
                    Session::flash('g-recaptcha-response','Please Check reCaptcha');
                    Session::flash('alert-class','alert-danger');
                    $fail($attribute.'google reCaptcha failed');
                }

            },
        ]);
        if($validate->fails()) {
           return redirect()->back()->withInput($request->input())->with([
            'error'=>'Something went wrong!!',
           ]);
        }
        SharworkSpace::create($request->except('_token'));
        return redirect()->back()->with([
            'message' => 'Submitted successfully!'
        ]);
    }

    public function index()
    {   $title = "Sharwork Space";
        $wokspace = "active";
        $sharworkspaces = SharworkSpace::orderby('id','desc')->get();
        return view('WebsiteAdmin.Sharwork_Space.index',compact('sharworkspaces','title','wokspace'));
    }
}
