<?php

namespace App\Http\Controllers;

use App\Models\Program;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Validator;

class ProgramController extends Controller
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
        $title = 'All Programmes';
        $course_open = 'open';
        $course = 'active';
        $all_course = 'active';
        $programmes = Program::withTrashed()->get();
        return view('Admin.Course.allprogram', compact('title', 'course_open', 'course', 'all_course', 'programmes'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $title = 'Create Program';
        $course_open = 'open';
        $course = 'active';
        $create_course = 'active';
        return view('Admin.Course.createprogram', compact('title', 'course_open', 'course', 'create_course'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        if ($request->outline) {
            $outline = time().'.'.$request->outline->getClientOriginalName();
            $request->outline->move('allUploadedFiles', $outline);
        }

        $program = new Program();
        $program->user_id = $request->input('user_id');
        $program->program_type = $request->input('program_type');
        $program->title = $request->input('title');
        $program->course_code = $request->input('course_code');
        $program->diploma_code = $request->input('diploma_code');
        $program->certification_code = $request->input('certification_code');
        $program->fee = $request->input('fee');
        $program->duration = $request->input('duration');
        $program->discount_limit = $request->input('discount_limit');
        $program->status = "On Going";
        if ($request->outline) {
            $program->outline = $outline;
        }
        $program->prerequisite = $request->input('prerequisite');
        $program->remarks = $request->input('remarks');
        $program->save();
        return redirect('ongoing-program')->with([
            'message' => 'Program Added Successfully!'
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
        $title = 'Edit Program';
        $course_open = 'open';
        $course = 'active';
        $program = Program::find($id);

        return view('Admin.Course.editprogram', compact('title', 'course_open', 'course', 'program'));
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
        if ($request->outline) {
            $outline = time().'.'.$request->outline->getClientOriginalName();
            $request->outline->move('allUploadedFiles', $outline);
        }

        $program = Program::find($id);
        $program->program_type = $request->input('program_type');
        $program->title = $request->input('title');
        $program->course_code = $request->input('course_code');
        $program->diploma_code = $request->input('diploma_code');
        $program->certification_code = $request->input('certification_code');
        $program->fee = $request->input('fee');
        $program->duration = $request->input('duration');
        $program->discount_limit = $request->input('discount_limit');
        if ($request->outline) {
            $program->outline = $outline;
        }
        $program->prerequisite = $request->input('prerequisite');
        $program->remarks = $request->input('remarks');
        $program->save();
        return redirect('ongoing-program')->with([
            'message' => 'Program Updated Successfully!'
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
        $program = Program::find($id);
        if (!is_null($program)) {
            $program->status = "Suspended";
            $program->save();
            return redirect()->route('program.index')->with([
                'message' => 'Program Suspended Successfully!'
            ]);
        }else{
            return redirect()->route('program.index');
        }
    }
}
