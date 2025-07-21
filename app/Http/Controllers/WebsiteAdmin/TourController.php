<?php

namespace App\Http\Controllers\WebsiteAdmin;

use Illuminate\Http\Request;
use App\Models\WebsiteAdmin\Tour;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;

class TourController extends Controller
{
    public function index()
    {
        $title = "Book A Tour";
        $tour = "active";
        $booktour = Tour::all();
        return view('WebsiteAdmin.Tour.index', compact('title','tour','booktour'));
    }
    public function store(Request $requst)
    {
        $validate = Validator::make($requst->all(), [

            'name' =>'required',
            'email'=>'required|email',
            'service'=>'required',
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
            return redirect()->back()->withInput($requst->input())->with([
                'error'=>'Something went wrong!!',
            ]);
        }else{
            Tour::create($requst->except('_token'));
            return redirect()->back()->with([
                'message' => 'Submitted successfully!'
            ]);
        }
    }
}
