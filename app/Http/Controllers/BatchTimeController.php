<?php

namespace App\Http\Controllers;

use App\Models\Batch;
use App\Models\Program;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class BatchTimeController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function upcomingBatch()
    {
        $title = 'Upcoming Batch';
        $batch_open = 'open';
        $batch = 'active';
        $upcoming_batch = 'active';
        $date = date('Y-m-d');
        if (Auth::user()->role == 'Super Admin' || Auth::user()->role == 'Business Operations Manager' || Auth::user()->role == 'Admin & Finance') {
            $batches = Batch::where('status', 'Not Suspended')->where('start_date', '>', $date)->with('campus', 'program', 'employee')->orderBy('id', 'desc')->get();
        }else{
            $batches = Batch::where('status', 'Not Suspended')->where('start_date', '>', $date)->where('campus_id', Auth::user()->campus_id)->with('campus', 'program', 'employee')->orderBy('id', 'desc')->get();
        }

        return view('Admin.Batch&Time.upcomingbatch', compact('title', 'batch_open', 'batch', 'upcoming_batch', 'batches'));
    }

    public function recentBatch()
    {
        $title = 'Recently Started Batch';
        $batch_open = 'open';
        $batch = 'active';
        $recent_started_batch = 'active';
        $start_date = date('Y-m-d', strtotime('-30 days'));
        $current_date = date('Y-m-d');
        if (Auth::user()->role == 'Super Admin' || Auth::user()->role == 'Business Operations Manager' || Auth::user()->role == 'Admin & Finance') {
            $batches = Batch::where('status', 'Not Suspended')->where('start_date', '>=', $start_date)->where('start_date', '<=', $current_date)->with('campus', 'program', 'employee')->orderBy('id', 'desc')->get();
        }else{
            $batches = Batch::where('status', 'Not Suspended')->where('start_date', '>=', $start_date)->where('start_date', '<=', $current_date)->where('campus_id', Auth::user()->campus_id)->with('campus', 'program', 'employee')->orderBy('id', 'desc')->get();
        }

        return view('Admin.Batch&Time.recentstartedbatch', compact('title', 'batch_open', 'batch', 'recent_started_batch', 'batches'));
    }

    public function inprogressBatch()
    {
        $title = 'In Progress Batch';
        $batch_open = 'open';
        $batch = 'active';
        $inprogress_batch = 'active';

        $start_date = date('Y-m-d', strtotime('-30 days'));
        $current_date = date('Y-m-d');

    if (Auth::user()->role == 'Super Admin' ||
                                    Auth::user()->role == 'Admin' ||
                                    Auth::user()->role == 'Telesales Representative' ||
                                    Auth::user()->role == 'Business Operations Manager' ||
                                    Auth::user()->role == 'Admin & Finance') {
            $batches = Batch::where('status', 'Not Suspended')->where('start_date', '<', $start_date)->where('end_date', '>', $current_date)->with('campus', 'program', 'employee')->orderBy('id', 'desc')->get();
        }else{
            $batches = Batch::where('status', 'Not Suspended')->where('start_date', '<', $start_date)->where('end_date', '>', $current_date)->where('campus_id', Auth::user()->campus_id)->with('campus', 'program', 'employee')->orderBy('id', 'desc')->get();
        }

        return view('Admin.Batch&Time.inprogressbatch', compact('title', 'batch_open', 'batch', 'inprogress_batch', 'batches'));
    }

    public function suspendedBatch()
    {
        $title = 'Suspended Batch';
        $batch_open = 'open';
        $batch = 'active';
        $suspended_batch = 'active';

       if (Auth::user()->role == 'Super Admin' ||
                                    Auth::user()->role == 'Admin' ||
                                    Auth::user()->role == 'Telesales Representative' ||
                                    Auth::user()->role == 'Business Operations Manager' ||
                                    Auth::user()->role == 'Admin & Finance') {
            $batches = Batch::where('status', 'Suspended')->with('campus', 'program', 'employee')->orderBy('id', 'desc')->get();
        }else{
            $batches = Batch::where('status', 'Suspended')->where('campus_id', Auth::user()->campus_id)->with('campus', 'program', 'employee')->orderBy('id', 'desc')->get();
        }

        return view('Admin.Batch&Time.suspendedbatch', compact('title', 'batch_open', 'batch', 'suspended_batch', 'batches'));
    }

    public function recentlyEndBatch()
    {
        $title = 'Recently End Batch';
        $batch_open = 'open';
        $batch = 'active';
        $recently_end_batch = 'active';
        $start_date = date('Y-m-d', strtotime('-30 days'));
        $current_date = date('Y-m-d');

        if (Auth::user()->role == 'Super Admin' || Auth::user()->role == 'Business Operations Manager' || Auth::user()->role == 'Admin & Finance') {
            $batches = Batch::where('status', 'Not Suspended')->where('end_date', '>', $start_date)->where('end_date', '<', $current_date)->with('campus', 'program', 'employee')->orderBy('id', 'desc')->get();
        }else{
            $batches = Batch::where('status', 'Not Suspended')->where('end_date', '>', $start_date)->where('end_date', '<', $current_date)->where('campus_id', Auth::user()->campus_id)->with('campus', 'program', 'employee')->orderBy('id', 'desc')->get();
        }

        return view('Admin.Batch&Time.recentlyendbatch', compact('title', 'batch_open', 'batch', 'recently_end_batch', 'batches'));
    }

    public function endedBatch()
    {
        $title = 'Ended Batch';
        $batch_open = 'open';
        $batch = 'active';
        $ended_batch = 'active';

        $start_date = date('Y-m-d', strtotime('-30 days'));
        $current_date = date('Y-m-d');

        if (Auth::user()->role == 'Super Admin' || Auth::user()->role == 'Business Operations Manager' || Auth::user()->role == 'Admin & Finance') {
            $batches = Batch::where('status', 'Not Suspended')->where('end_date', '<', $start_date)->with('campus', 'program', 'employee')->orderBy('id', 'desc')->get();
        }else{
            $batches = Batch::where('status', 'Not Suspended')->where('end_date', '<', $start_date)->where('campus_id', Auth::user()->campus_id)->with('campus', 'program', 'employee')->orderBy('id', 'desc')->get();
        }

        return view('Admin.Batch&Time.endedbatch', compact('title', 'batch_open', 'batch', 'ended_batch', 'batches'));
    }

    public function batchCode($id)
    {
        $program = Program::find($id);
        $batch = Batch::where('program_id', $id)->where('campus_id', Auth::user()->campus_id)->count();
        $year = date("y");

        if ($program->program_type == 'Certification') {
            $certification_code = $program->certification_code;
            if ($batch<10) {
                return response()->json([
                    'batch_code' => $certification_code.'0'.($batch+1).'-'.$year,
                ]);
            }else {
                return response()->json([
                    'batch_code' => $certification_code.($batch+1).'-'.$year,
                ]);
            }
        }
        elseif ($program->program_type == 'Diploma') {
            $diploma_code = $program->diploma_code;
            if ($batch<10) {
                return response()->json([
                    'batch_code' => $diploma_code.'0'.($batch+1).'-'.$year,
                ]);
            }else {
                return response()->json([
                    'batch_code' => $diploma_code.($batch+1).'-'.$year,
                ]);
            }
        }
        elseif ($program->program_type == 'Short Course') {
            $course_code = $program->course_code;
            if ($batch<10) {
                return response()->json([
                    'batch_code' => $course_code.'0'.($batch+1).'-'.$year,
                ]);
            }else {
                return response()->json([
                    'batch_code' => $course_code.($batch+1).'-'.$year,
                ]);
            }
        }
    }



}
