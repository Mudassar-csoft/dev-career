<?php

namespace App\Http\Controllers\WebsiteAdmin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\WebsiteAdmin\Ambassador;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;
use App\Mail\AmbassadorFormMail;
use Illuminate\Support\Facades\Mail;

class AmbassadorController extends Controller
{
    public function store(Request $request)
    {
        // return $request;
        $validate = Validator::make($request->all(), [
            'name' => 'required',
            'contact' => 'required|numeric',
            'email' => 'required|email',
            'linkedin' => 'nullable|url',
            'education' => 'nullable',
            'organization' => 'nullable',
            'city' => 'required',
            'file' => 'required|file', 
        ]);
        // dd($request);
        // if ($validate->fails()) {
        //     return redirect()->back()->withInput($request->input())->with([
        //         'error' => 'Something went wrong!!',
        //         'error' => $validate->errors()->all(),
        //     ]);
        // } else {
            if ($request->hasFile('file')) {
                $filePath = $request->file('file')->storeAs('Web/job_Placement', $request->file('file')->getClientOriginalName(), 'public');

            }
            // $data = Ambassador::create($request->except('_token'));
            $data = new Ambassador();
            $data->name = $request->name;
            $data->contact = $request->contact;
            $data->email = $request->email;
            $data->organization = $request->organization;
            $data->linkedin = $request->linkedin;
            $data->city = $request->city;
            $data->education = $request->education;
            $data->file = $filePath;
            $data->save();

            $emailData = [
                'name' => $request->name,
                'contact' => $request->contact,
                'email' => $request->email,
                'linkedin' => $request->linkedin,
                'organization' => $request->organization,
                'city' => $request->city,
                'education' => $request->education
            ];

            Mail::mailer('account2')->to('ambassador@career.edu.pk')->send(new AmbassadorFormMail($emailData, $filePath));

            //Mail::to('ambassador@career.edu.pk')->send(new AmbassadorFormMail($emailData, $path));

            return redirect()->back()->with([
                'message' => 'Submitted successfully!'
            ]);
        // }
    }

    public function index(Request $request)
    {
        $title = "show-ammbassador";
        $ammbassador = "active";
        $ammbassadors = Ambassador::all();
        return view('WebsiteAdmin.Ambassador.index', compact('title', 'ammbassador', 'ammbassadors'));
    }
}
