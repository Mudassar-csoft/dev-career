<?php

namespace App\Http\Controllers\WebsiteAdmin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Session;
use App\Models\WebsiteAdmin\StudyAbroad;
use Illuminate\Support\Facades\Validator;



class StudyAbroadController extends Controller
{
    public function store(Request $request)
    {
        $validate = Validator::make($request->all(), [
            'name'=>'required',
            'study'=>'required',
            'number'=>'required|numeric',
            'eamil'=>'required|email',
            'city'=>'required',
            'degree'=>'required',
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
        }else{
            StudyAbroad::create($request->except('_token'));
            return redirect()->back()->with([
                'message'=>'Submitted successfully!'
            ]);
        }
    }

    public function index()
    {
        $title = "Study Abroad";
        $studyabroad = 'active';
        $studyabr = StudyAbroad::all();
        return view('WebsiteAdmin.Study_Abroad.index',compact('studyabroad','title','studyabr'));
    }
}
