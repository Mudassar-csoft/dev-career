<?php

namespace App\Http\Controllers;

use App\Models\Batch;
use App\Models\Campus;
use App\Models\Program;
use App\Models\Employee;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Validator;

class BatchController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $title = 'All Batches';
        $batch_open = 'open';
        $batch = 'active';
        $all_batch = 'active';
       if (Auth::user()->role == 'Super Admin' ||
                                    Auth::user()->role == 'Admin' ||
                                    Auth::user()->role == 'Telesales Representative' ||
                                    Auth::user()->role == 'Business Operations Manager' ||
                                    Auth::user()->role == 'Admin & Finance') {
            $batches = Batch::with('campus', 'program', 'employee')->orderBy('id', 'desc')->get();
        } else {
            $batches = Batch::where('campus_id', Auth::user()->campus_id)->with('campus', 'program', 'employee')->orderBy('id', 'desc')->get();
        }

        return view('Admin.Batch&Time.allbatch', compact('title', 'batch_open', 'batch', 'all_batch', 'batches'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $title = 'Create Batch';
        $batch_open = 'open';
        $batch = 'active';
        $create_batch = 'active';
        $campusess = Campus::all();

        $campuses = Campus::where('id', Auth::user()->campus_id)->get();

        $programmes = Program::where('status', 'on Going')->get();
       if (Auth::user()->role == 'Super Admin' ||
                                    Auth::user()->role == 'Admin' ||
                                    Auth::user()->role == 'Telesales Representative' ||
                                    Auth::user()->role == 'Business Operations Manager' ||
                                    Auth::user()->role == 'Admin & Finance'){
            $employees = Employee::where('status', 'Employee')->where('employee_type', 'Trainer')->get();
        } else {
            // $employees = Employee::where('campus_id', Auth::user()->campus_id)->where('status', 'Employee')->where('employee_type', 'Trainer')->get();
            $employees = Employee::where('status', 'Employee')->where('employee_type', 'Trainer')->get();
        }

        return view('Admin.Batch&Time.createbatch', compact('title', 'batch_open', 'batch', 'create_batch', 'campuses', 'programmes', 'employees', 'campusess'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'program_id' => 'required',
            'campus_id' => 'required',
            'employee_id' => 'required',
            'start_date' => 'required',
            'end_date' => 'required',
            'session' => 'required',
            'start_time' => 'required',
            'end_time' => 'required',
            'remarks' => 'required',
        ]);
        if ($validator->fails()) {
            return Redirect::back()->with([
                'message' => 'Something went wrong!'
            ])->withInput();
        } else {
            $batch = new Batch();
            $batch->user_id = $request->input('user_id');
            $batch->program_id = $request->input('program_id');
            $batch->campus_id = $request->input('campus_id');
            $batch->employee_id = $request->input('employee_id');
            $batch->batch_code = $request->input('batch_code');
            $batch->start_date = $request->input('start_date');
            $batch->end_date = $request->input('end_date');
            $batch->session = $request->input('session');
            $batch->start_time = $request->input('start_time');
            $batch->end_time = $request->input('end_time');
            $batch->lab = $request->input('lab');
            $batch->remarks = $request->input('remarks');
            $batch->status = $request->input('status');
            $batch->save();
        }
        return redirect('batch')->with([
            'message' => 'Batch added successfully!'
        ]);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $title = 'Edit Batch';
        $batch_open = 'open';
        $batch = 'active';

        $batch = Batch::with('program')->find($id);
        $campus_id=$batch->campus_id;
        if(Auth::user()->role == 'Super Admin' || Auth::user()->role == 'Business Operations Manager' || Auth::user()->role == 'Admin & Finance'){
            $campuses = Campus::where('id', $campus_id)->get();

        }else{

            $campuses = Campus::where('id', Auth::user()->campus_id)->get();
        }


        $programmes = Program::where('status', 'on Going')->get();
       if (Auth::user()->role == 'Super Admin' || Auth::user()->role == 'Business Operations Manager' || Auth::user()->role == 'Admin & Finance'){
            $employees = Employee::where('status', 'Employee')->where('employee_type', 'Trainer')->get();
        } else {
            $employees = Employee::where('campus_id', Auth::user()->campus_id)->where('status', 'Employee')->where('employee_type', 'Trainer')->get();
        }

        return view('Admin.Batch&Time.editbatch', compact('title', 'batch_open', 'batch', 'campuses', 'programmes', 'employees', 'batch'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $batch = Batch::find($id);
        $batch->employee_id = $request->input('employee_id');
        $batch->start_date = $request->input('start_date');
        $batch->end_date = $request->input('end_date');
        $batch->session = $request->input('session');
        $batch->start_time = $request->input('start_time');
        $batch->end_time = $request->input('end_time');
        $batch->lab = $request->input('lab');
        $batch->remarks = $request->input('remarks');
        $batch->status = $request->input('status');
        $batch->save();

        return redirect('batch')->with([
            'message' => 'Batch updated successfully!'
        ]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
