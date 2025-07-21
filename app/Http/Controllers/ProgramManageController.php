<?php

namespace App\Http\Controllers;

use App\Models\Program;
use Illuminate\Http\Request;

class ProgramManageController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function ongoingProgram()
    {
        $title = 'On Going Programmes';
        $course_open = 'open';
        $course = 'active';
        $on_going = 'active';
        $programmes = Program::where("status", "On Going")->get();
        return view('Admin.Course.ongoingprograme', compact('title', 'course_open', 'course', 'on_going', 'programmes'));
    }

    public function suspendedProgram()
    {
        $title = 'Suspended Programmes';
        $course_open = 'open';
        $course = 'active';
        $suspend_program = 'active';
        $programmes = Program::where("status", "Suspended")->get();
        return view('Admin.Course.suspendedprogram', compact('title', 'course_open', 'course', 'suspend_program', 'programmes'));
    }

    public function restoreProgram($id)
    {
        $program = Program::withTrashed()->find($id);
        if (!is_null($program)) {
            $program->status = "On Going";
            $program->save();
            return redirect()->route('program.index')->with([
                'message' => 'Program Restored Successfully!'
            ]);
        }else{
            return redirect()->route('suspendedProgram');
        }
    }

    public function deleteProgram($id)
    {
        $program = Program::withTrashed()->find($id);
        if (!is_null($program)) {
            $program->forceDelete();
        }
        return redirect()->back()->with([
            'message' => 'Program Deleted Successfully!'
        ]);
    }
}
