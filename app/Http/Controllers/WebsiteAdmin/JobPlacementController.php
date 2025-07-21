<?php

namespace App\Http\Controllers\WebsiteAdmin;

use Illuminate\Http\Request;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Session;
use App\Models\WebsiteAdmin\JobPlacement;
use Illuminate\Support\Facades\Validator;

class JobPlacementController extends Controller
{
    public function store(Request $request)
    {
        // return $request;
        $validate = Validator::make($request->all(),[
            'name'=>'required',
            'number'=>'required|numeric',
            'email'=>'required|email',
            'city'=>'required',
            'education'=>'required',
            'file'=>'required',
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
        if ($validate->fails()) {
            return redirect()->back()->withErrors($validate)->withInput($request->input())->with([
                'error'=>'Something went wrong!!',
            ]);
        }else{
            if ($request->hasFile('file')) {
                $path = asset('storage/'.$request->file->store('Web/job_Placement'));

            }
            $jobplace =  new JobPlacement();
            $jobplace->name = $request->name;
            $jobplace->number = $request->number;
            $jobplace->email = $request->email;
            $jobplace->city = $request->city;
            $jobplace->education = $request->education;
            $jobplace->file =  $path;
            $jobplace->save();
            return redirect()->route('jobPlacement')->with([
                'message'=>'Submitted successfully!'
            ]);
        }

    }

    public function index()
    {
        $title = "Job Placement";
        $jobplacement = "active";
        $jobplace = JobPlacement::all();
        return view('WebsiteAdmin.Job_Placement.index',compact('title','jobplacement','jobplace'));

    }
}
