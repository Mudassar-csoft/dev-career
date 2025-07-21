<?php

namespace App\Http\Controllers\WebsiteAdmin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\WebsiteAdmin\NewsUpdate;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;

class NewsUpdateController extends Controller
{
    public function store(Request $request)
    {
        // return $request;
        $validate = Validator::make($request->all(), [
            'name'=>'required|alpha',
            'number' => 'required|unique:news_updates,number,null,null|numeric',
            'email' => 'required|unique:news_updates,email,null,null|email',
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
        if($validate->fails()){
            return redirect()->back()->with([
                'error' => 'Something went wrong!!'
                ])->withErrors($validate)->withInput();
            }
        $partner = new NewsUpdate;
        $partner->name = $request->name;
        $partner->number = $request->number;
        $partner->email = $request->email;
        $partner->save();
        return redirect('/')->with([
            'message' => 'Submitted successfully!'
        ]);





    }

    public function show()
    {
        $title = "Latest News";
        $update = "active";
        $allupdate = NewsUpdate::all();
        return view('WebsiteAdmin.NewsAndUpdate.index',compact('title','update','allupdate'));
    }
}
