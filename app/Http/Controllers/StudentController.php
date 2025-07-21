<?php

namespace App\Http\Controllers;

use App\Models\Admission;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\FeeCollection;


class StudentController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function currentStudents()
    {
        $title = "Current Students";
        $student_open = 'open';
        $student = 'active';
        $current_student = 'active';

        if (Auth::user()->role == 'Super Admin' || Auth::user()->role == 'Admin') {
            $students = Admission::where('status', 'Enrolled')->with('registration', 'batch', 'program')->get();
        } else {
            $students = Admission::where('campus_id', Auth::user()->campus_id)->where('status', 'Enrolled')->with('registration', 'batch', 'program')->get();
        }

        return view('Admin.Student.currentstudent', compact('title', 'student_open', 'student', 'current_student'))->with('students', json_decode($students, true));
    }

    public function freezeStudents()
    {
        $title = "Freeze Students";
        $student_open = 'open';
        $student = 'active';
        $freeze_student = 'active';

        if (Auth::user()->role == 'Super Admin' || Auth::user()->role == 'Admin') {
            $students = Admission::where('status', 'Freeze')->with('registration', 'batch','campus')->get();
        } else {
            $students = Admission::where('campus_id', Auth::user()->campus_id)->where('status', 'Freeze','campus')->with('registration', 'batch')->get();
        }

        return view('Admin.Student.freezestudent', compact('title', 'student_open', 'student', 'freeze_student', 'students'));
    }

    public function concludedStudents()
    {
        $title = "Concluded Students";
        $student_open = 'open';
        $student = 'active';
        $concluded_student = 'active';

        if (Auth::user()->role == 'Super Admin' || Auth::user()->role == 'Admin') {
            $students = Admission::where('status', 'Conclude')->with('registration', 'program')->get();
        } else {
            $students = Admission::where('campus_id', Auth::user()->campus_id)->where('status', 'Conclude')->with('registration', 'program')->get();
        }

        return view('Admin.Student.concludedstudent', compact('title', 'student_open', 'student', 'concluded_student'))->with('students', json_decode($students, true));
    }

    public function notCompletedStudents()
    {
        $title = "Not Completed Students";
        $student_open = 'open';
        $student = 'active';
        $not_completed_student = 'active';

        if (Auth::user()->role == 'Super Admin' || Auth::user()->role == 'Admin') {
            $students = Admission::where('status', 'Not Completed')->with('registration', 'program')->get();
        } else {
            $students = Admission::where('campus_id', Auth::user()->campus_id)->where('status', 'Not Completed')->with('registration', 'program')->get();
        }

        return view('Admin.Student.notcompletedstudent', compact('title', 'student_open', 'student', 'not_completed_student', 'students'));
    }

    public function suspendedStudents()
    {
        $title = "Suspended Students";
        $student_open = 'open';
        $student = 'active';
        $suspended_student = 'active';

        if (Auth::user()->role == 'Super Admin' || Auth::user()->role == 'Admin') {
            $students = Admission::where('status', 'Suspend')->with('registration', 'program')->get();
        } else {
            $students = Admission::where('campus_id', Auth::user()->campus_id)->where('status', 'Suspend')->with('registration', 'program')->get();
        }

        return view('Admin.Student.suspendedstudent', compact('title', 'student_open', 'student', 'suspended_student', 'students'));
    }

   public function conclude($id)
    {
        $student = Admission::find($id);
        $fee=FeeCollection::where('admission_id',$id)->where('status','Pending')->count();
        // dd($fee);
        if($fee>0){
            return redirect()->back()->with([
                'error' => 'Student Fee is Not Cleared'
            ]);

        }else{
            $student->status = 'Conclude';
            $student->save();
            return redirect()->back()->with([
                'message' => 'Student concluded successfully!'
            ]);

        }
    }
    public function freezestudent($id)
    {
        $student = Admission::find($id);
        $student->status = 'Freeze';
        $student->save();
        return redirect()->back()->with([
            'message' => 'Student Freezed successfully!'
        ]);
    }
    public function setenrolled($id)
    {
        $student = Admission::find($id);
        $student->status = 'Enrolled';
        $student->save();
        return redirect()->back()->with([
            'message' => 'Student Enrolled successfully!'
        ]);
    }
    public function suspendst($id)
    {
        $student = Admission::find($id);
        $student->status = 'Suspend';
        $student->save();
        return redirect()->back()->with([
            'message' => 'Student Suspend successfully!'
        ]);
    }
    public function notcompleted($id)
    {
        $student = Admission::find($id);
        $student->status = 'Not Completed';
        $student->save();
        return redirect()->back()->with([
            'message' => 'Student Not Completed successfully!'
        ]);
    }
}
