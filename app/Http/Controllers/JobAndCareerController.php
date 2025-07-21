<?php

namespace App\Http\Controllers;

use App\Models\JobAndCareer;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Session;
use Illuminate\Http\Request;

class JobAndCareerController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $title = "see Jobs";
        $jobplacement = "active";
        $jobplace = JobAndCareer::all();
        return view('WebsiteAdmin.Job_Placement.pending_job', compact('title', 'jobplacement', 'jobplace'));
    }

    public function approve($id)
    {
        $jobplacement = JobAndCareer::findOrFail($id);
        $jobplacement->status = 'approved';
        $jobplacement->save();

        return redirect()->back()->with('message', 'Job Approved successfully!');
    }
    public function decline($id)
    {
        $jobplacement = JobAndCareer::findOrFail($id);  
        $jobplacement->status = 'rejected';
        $jobplacement->save();

        return redirect()->back()->with('message', 'Job Rejected successfully!');
    }
    public function approved()
    {
         $title = "see Jobs";
        $jobplacement = "active";
        $jobplace = JobAndCareer::all();
        return view('WebsiteAdmin.Job_Placement.approved_job', compact('title', 'jobplacement', 'jobplace'));
    }
    public function rejected()
    {
         $title = "see Jobs";
        $jobplacement = "active";
        $jobplace = JobAndCareer::all();
        return view('WebsiteAdmin.Job_Placement.rejected_job', compact('title', 'jobplacement', 'jobplace'));
    }
    public function expired()
    {
         $title = "see Jobs";
        $jobplacement = "active";
        $jobplace = JobAndCareer::all();
        return view('WebsiteAdmin.Job_Placement.expired_job', compact('title', 'jobplacement', 'jobplace'));
    }
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validate = Validator::make($request->all(), [
            'title' => 'required|string|max:255',
            'company' => 'required|string|max:255',
            'workplace' => 'required|string',
            'location' => 'required|string|max:255',
            'job_type' => 'required|string',
            'experience' => 'required|string|max:255',
            'education' => 'required|string',
            'deadline' => 'required|date',
            'description' => 'required|string',
            'duties' => 'required|string',
            'requirements' => 'required|string',
            'status' => 'required|string',
        ]);
        // dd($request);
        if ($validate->fails()) {
            return redirect()->back()->withErrors($validate)->withInput();
        }

        // Create a new PostJob record
        JobAndCareer::create($request->all());

        return redirect()->route('jobPlacement')->with(['message' => 'Job posted successfully!']);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\JobAndCareer  $jobAndCareer
     * @return \Illuminate\Http\Response
     */
    public function show(JobAndCareer $jobAndCareer)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\JobAndCareer  $jobAndCareer
     * @return \Illuminate\Http\Response
     */
    public function edit(JobAndCareer $jobAndCareer)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\JobAndCareer  $jobAndCareer
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, JobAndCareer $jobAndCareer)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\JobAndCareer  $jobAndCareer
     * @return \Illuminate\Http\Response
     */
    public function destroy(JobAndCareer $jobAndCareer)
    {
        //
    }
}
