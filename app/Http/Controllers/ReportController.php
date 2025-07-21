<?php

namespace App\Http\Controllers;

use App\Models\Lead;
use App\Models\Batch;
use App\Models\Campus;
use App\Models\Expense;
use App\Models\Program;
use App\Models\Admission;
use App\Models\Registration;
use Illuminate\Http\Request;
use App\Models\FeeCollection;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon; // Add this line

use Illuminate\Support\Facades\DB;

class ReportController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function recovery()
    {
        $title = "Recovery Report";
        $report_open = 'open';
        $report = 'active';
        $recovery_report = 'active';
        $campuses = Campus::all();

        return view('Admin.Report.recovery', compact('title', 'report_open', 'report', 'recovery_report', 'campuses'));
    }

    public function recoveryRequest(Request $req)
    {
        $title = "Recovery Report";
        $campus_id = $req->input('campus_id');
        $start_date = $req->input('start_date');
        $end_date = $req->input('end_date');
        $programmes = Program::with('admission')->where('status', 'On Going')->whereHas('admission', function ($query) {
            $query->where('program_id', '!=', "");
        })->get();
        if ($campus_id == 0) {
            $campus_title = 'All Campuses';
        } else {
            $campus = Campus::find($campus_id);
            $campus_title = $campus->campus_code;
        }
        return view('Admin.Report.recoveryreport', compact('title', 'programmes', 'campus_id', 'start_date', 'end_date', 'campus_title'));
    }

    public function enquiry()
    {
        $title = "Enquiry Report";
        $report_open = 'open';
        $report = 'active';
        $enquiry_report = 'active';
        $campuses = Campus::all();

        return view('Admin.Report.enquiry', compact('title', 'report_open', 'report', 'enquiry_report', 'campuses'));
    }

    public function enquiryRequest(Request $req)
    {
        $title = "Enquiry Report";
        $campus_id = $req->input('campus_id');
        $start_date = $req->input('start_date');
        $end_date = $req->input('end_date');
        $programmes = Program::with('lead')->where('status', 'On Going')->whereHas('lead', function ($query) {
            $query->where('program_id', '!=', "");
        })->get();
        if ($campus_id == 0) {
            $campus_title = 'All Campuses';
        } else {
            $campus = Campus::find($campus_id);
            $campus_title = $campus->campus_code;
        }
        return view('Admin.Report.enquiryreport', compact('title', 'programmes', 'campus_id', 'start_date', 'end_date', 'campus_title'));
    }

    public function admission()
    {
        $title = "Admission Report";
        $report_open = 'open';
        $report = 'active';
        $admission_report = 'active';
        $campuses = Campus::all();

        return view('Admin.Report.admission', compact('title', 'report_open', 'report', 'admission_report', 'campuses'));
    }

    public function admissionRequest(Request $req)
    {
        $title = "Admission Report";
        $campus_id = $req->input('campus_id');
        $start_date = $req->input('start_date');
        $end_date = $req->input('end_date');
        $programmes = Program::with('admission')->where('status', 'On Going')->whereHas('admission', function ($query) {
            $query->where('program_id', '!=', "");
        })->get();
        if ($campus_id == 0) {
            $campus_title = 'All Campuses';
        } else {
            $campus = Campus::find($campus_id);
            $campus_title = $campus->campus_code;
        }
        return view('Admin.Report.admissionreport', compact('title', 'programmes', 'campus_id', 'start_date', 'end_date', 'campus_title'));
    }


    public  function activeReport()
    {
        $title = "Recovery Report";
        $report_open = 'open';
        $report = 'active';
        $active_report = 'active';
        $campuses = Campus::all();
        return view('Admin.Report.ActivityReport.index', compact('title', 'report_open', 'report', 'active_report', 'campuses'));
    }

    public function dailyreport()
    {
        $date = date('Y-m-d');
        $title = "Daily Report";
        $report_open = 'open';
        $report = 'active';
        $daily_report = 'active';

        // Group pending leads by campus_id and count, include campus_code
        $pendingleads = Lead::select('campus_id', DB::raw('count(*) as total'))
            ->with('campus:id,campus_code')
            ->where('status', 'Pending')
            ->whereDate('created_at', $date)
            ->groupBy('campus_id')
            ->get();

        $totalPendingLeads = $pendingleads->sum('total');

        // Group admissions by campus_id and count, include campus_code
        $todaysadmission = Admission::select('campus_id', DB::raw('count(*) as total'))
            ->with('campus:id,campus_code')
            ->whereDate('created_at', $date)
            ->groupBy('campus_id')
            ->get();

        $totalAdmissions = $todaysadmission->sum('total');

        // Group registrations by campus_id and count, include campus_code
        $todaysregistration = Registration::select('campus_id', DB::raw('count(*) as total'))
            ->with('campus:id,campus_code')
            ->whereDate('created_at', $date)
            ->groupBy('campus_id')
            ->get();

        $totalRegistrations = $todaysregistration->sum('total');

        // Group fee collections by campus_id and sum paid_amount, include campus_code
        $feeCollections = FeeCollection::select('campus_id', DB::raw('sum(paid_amount) as total'))
            ->with('campus:id,campus_code')
            ->whereDate('pay_date', $date)
            ->where('status', 'Clear')
            ->groupBy('campus_id')
            ->get();

        $totalFeeCollection = $feeCollections->sum('total');

        return view('Admin.Report.daily-report', compact(
            'date',
            'title',
            'report_open',
            'report',
            'daily_report',
            'pendingleads',
            'todaysadmission',
            'todaysregistration',
            'feeCollections',
            'totalPendingLeads',
            'totalAdmissions',
            'totalRegistrations',
            'totalFeeCollection'
        ));
    }



    public function searchReport(Request $request)
    {
        $speradminid = $request->campus_id;
        $from = $request->start_date;
        $to = $request->end_date;
        $title = "Date: From: " . $from . " To: " . $to;

        if ($request->campus_id == 0) {

            // Leads========
            $totalleads = Lead::with('campus')->whereBetween('created_at', [$from . ' 00:00:00', $to . ' 23:59:59'])->where('campus_id', '!=', 10)->where('campus_id', '!=', 9)->count();
            $CIFSD01 = Lead::with('campus')->whereBetween('created_at', [$from . ' 00:00:00', $to . ' 23:59:59'])->where('campus_id', 6)->count();
            $CIFSD02 = Lead::with('campus')->whereBetween('created_at', [$from . ' 00:00:00', $to . ' 23:59:59'])->where('campus_id', 7)->count();
            $CIFSD03 = Lead::with('campus')->whereBetween('created_at', [$from . ' 00:00:00', $to . ' 23:59:59'])->where('campus_id', 8)->count();
            $CISWL01 = Lead::with('campus')->whereBetween('created_at', [$from . ' 00:00:00', $to . ' 23:59:59'])->where('campus_id', 12)->count();
            $campuses = Campus::with('lead')->get();

            // admission =============
            $totaladmission = Admission::whereBetween('admission_date', [$from . ' 00:00:00', $to . ' 23:59:59'])->where('campus_id', '!=', 10)->where('campus_id', '!=', 9)->count();
            $CIFSD01adm1 = Admission::whereBetween('admission_date', [$from . ' 00:00:00', $to . ' 23:59:59'])->where('campus_id', 6)->count();
            $CIFSD02admi2 = Admission::whereBetween('admission_date', [$from . ' 00:00:00', $to . ' 23:59:59'])->where('campus_id', 7)->count();
            $CIFSD03admi3 = Admission::whereBetween('admission_date', [$from . ' 00:00:00', $to . ' 23:59:59'])->where('campus_id', 8)->count();
            $CISWL01admi4 = Admission::whereBetween('admission_date', [$from . ' 00:00:00', $to . ' 23:59:59'])->where('campus_id', 12)->count();

            // Students

            $totalstudent =  Admission::whereBetween('admission_date', [$from . ' 00:00:00', $to . ' 23:59:59'])->where('status', 'Enrolled')->where('campus_id', '!=', 10)->where('campus_id', '!=', 9)->count();
            $CIFSD01student1 = Admission::whereBetween('admission_date', [$from . ' 00:00:00', $to . ' 23:59:59'])->where('campus_id', 6)->where('status', 'Enrolled')->count();
            $CIFSD02student2 = Admission::whereBetween('admission_date', [$from . ' 00:00:00', $to . ' 23:59:59'])->where('campus_id', 7)->where('status', 'Enrolled')->count();
            $CIFSD03student3 = Admission::whereBetween('admission_date', [$from . ' 00:00:00', $to . ' 23:59:59'])->where('campus_id', 8)->where('status', 'Enrolled')->count();
            $CISWL01student4 = Admission::whereBetween('admission_date', [$from . ' 00:00:00', $to . ' 23:59:59'])->where('campus_id', 12)->where('status', 'Enrolled')->count();

            //  Expanse
            $totalexpense = Expense::whereBetween('payment_date', [$from . ' 00:00:00', $to . ' 23:59:59'])->where('campus_id', '!=', 10)->where('campus_id', '!=', 9)->sum('amount');
            $CIFSD01expense1 = Expense::whereBetween('payment_date', [$from . ' 00:00:00', $to . ' 23:59:59'])->where('campus_id', 6)->sum('amount');
            $CIFSD02expense2 = Expense::whereBetween('payment_date', [$from . ' 00:00:00', $to . ' 23:59:59'])->where('campus_id', 7)->sum('amount');
            $CIFSD03expense3 = Expense::whereBetween('payment_date', [$from . ' 00:00:00', $to . ' 23:59:59'])->where('campus_id', 8)->sum('amount');
            $CISWL01expense4 = Expense::whereBetween('payment_date', [$from . ' 00:00:00', $to . ' 23:59:59'])->where('campus_id', 12)->sum('amount');



            $totalbatches = Batch::where('status', 'Not Suspended')->where('start_date', '<=', $to)->where('end_date', '>=', $to)->count();
            $CIFSD01batches1 = Batch::where('campus_id', 6)->where('status', 'Not Suspended')->where('start_date', '<=', $to)->where('end_date', '>=', $to)->count();
            $CIFSD02batches2 = Batch::where('campus_id', 7)->where('status', 'Not Suspended')->where('start_date', '<=', $to)->where('end_date', '>=', $to)->count();
            $CIFSD03batches3 = Batch::where('campus_id', 8)->where('status', 'Not Suspended')->where('start_date', '<=', $to)->where('end_date', '>=', $to)->count();
            $CISWL01batches4 = Batch::where('campus_id', 12)->where('status', 'Not Suspended')->where('start_date', '<=', $to)->where('end_date', '>=', $to)->count();


            // Collection ========
            $totalcollection = FeeCollection::whereBetween('pay_date', [$from . ' 00:00:00', $to . ' 23:59:59'])->where('campus_id', '!=', 10)->where('campus_id', '!=', 9)->where('status', 'Clear')->sum('paid_amount');
            $CIFSD01collection1 = FeeCollection::whereBetween('pay_date', [$from . ' 00:00:00', $to . ' 23:59:59'])->where('campus_id', 6)->where('status', 'Clear')->sum('paid_amount');
            $CIFSD02collection2 = FeeCollection::whereBetween('pay_date', [$from . ' 00:00:00', $to . ' 23:59:59'])->where('campus_id', 7)->where('status', 'Clear')->sum('paid_amount');
            $CIFSD03collection3 = FeeCollection::whereBetween('pay_date', [$from . ' 00:00:00', $to . ' 23:59:59'])->where('campus_id', 8)->where('status', 'Clear')->sum('paid_amount');
            $CISWL01collection4 = FeeCollection::whereBetween('pay_date', [$from . ' 00:00:00', $to . ' 23:59:59'])->where('campus_id', 12)->where('status', 'Clear')->sum('paid_amount');


            // Upcoming Batch
            $date = date('Y-m-d');
            $upcomingBatch = Batch::where('status', 'Not Suspended')->where('start_date', '>', $date)->whereBetween('created_at', [$from . ' 00:00:00', $to . ' 23:59:59'])->where('campus_id', '!=', 10)->where('campus_id', '!=', 9)->count();

            //   Pipeline Enquiries
            $PipelineEnquiries = Lead::where('status', 'Pending')->whereBetween('created_at', [$from . ' 00:00:00', $to . ' 23:59:59'])->where('campus_id', '!=', 10)->where('campus_id', '!=', 9)->count();

            // Enquire Graph

            $programmes = Program::where("status", "On Going")->get();
            return view('Admin.Report.ActivityReport.activity_report', ['totalleadsg' => $totalleads], compact('campuses', 'totalleads', 'speradminid', 'CIFSD01', 'CIFSD02', 'CIFSD03', 'CISWL01', 'totaladmission', 'CIFSD01adm1', 'CIFSD02admi2', 'CIFSD03admi3', 'CISWL01admi4', 'totalexpense', 'CIFSD01expense1', 'CIFSD02expense2', 'CIFSD03expense3', 'CISWL01expense4', 'totalstudent', 'CIFSD01student1', 'CIFSD02student2', 'CIFSD03student3', 'CISWL01student4', 'totalbatches', 'CIFSD01batches1', 'CIFSD02batches2', 'CIFSD02batches2', 'CIFSD03batches3', 'CISWL01batches4', 'totalcollection', 'CIFSD01collection1', 'CIFSD02collection2', 'CIFSD03collection3', 'CISWL01collection4', 'title', 'upcomingBatch', 'PipelineEnquiries', 'programmes', 'from', 'to'));
        } elseif ($request->campus_id == 10) {
            return redirect()->back();
        } elseif ($request->campus_id == 9) {
            return redirect()->back();
        } else {
            $speradminid = $request->campus_id;
            $from = $request->start_date;
            $to = $request->end_date;
            $title = "Date From: " . $from . " To: " . $to;
            // Leads==================
            $totalleadscampus = Lead::with('campus')->whereBetween('created_at', [$from . ' 00:00:00', $to . ' 23:59:59'])->where('campus_id', $request->campus_id)->count();
            $leadsidcampus = Campus::where('id', $speradminid)->first();

            //Admissions========================

            $totaladmissioncampus = Admission::whereBetween('admission_date', [$from . ' 00:00:00', $to . ' 23:59:59'])->where('campus_id', $speradminid)->count();


            // Expense

            $totalexpensecampus = Expense::whereBetween('payment_date', [$from . ' 00:00:00', $to . ' 23:59:59'])->where('campus_id', $request->campus_id)->sum('amount');


            //    Batches

            $totalbatchescampus = Batch::where('status', 'Not Suspended')->where('start_date', '<=', $to)->where('end_date', '>=', $to)->where('campus_id', $request->campus_id)->count();

            //    Collection

            $totalcollectioncampus = FeeCollection::whereBetween('pay_date', [$from . ' 00:00:00', $to . ' 23:59:59'])->where('campus_id', $request->campus_id)->where('status', 'Clear')->sum('paid_amount');
            // Student

            $currentStudent =  Admission::whereBetween('admission_date', [$from . ' 00:00:00', $to . ' 23:59:59'])->where('status', 'Enrolled')->where('campus_id', $request->campus_id)->count();


            // Upcoming Batch
            $date = date('Y-m-d');
            $upcomingBatch = Batch::where('status', 'Not Suspended')->where('start_date', '>', $date)->whereBetween('created_at', [$from . ' 00:00:00', $to . ' 23:59:59'])->where('campus_id', '!=', 10)->where('campus_id', '!=', 9)->where('campus_id', $request->campus_id)->count();

            //   Pipeline Enquiries
            $PipelineEnquiries = Lead::where('status', 'Pending')->whereBetween('created_at', [$from . ' 00:00:00', $to . ' 23:59:59'])->where('campus_id', '!=', 10)->where('campus_id', '!=', 9)->where('campus_id', $request->campus_id)->count();


            // Enquire Graph

            $programmes = Program::where("status", "On Going")->get();


            return view('Admin.Report.ActivityReport.activity_report', compact('speradminid', 'totalleadscampus', 'leadsidcampus', 'totaladmissioncampus', 'totalexpensecampus', 'totalbatchescampus', 'totalcollectioncampus', 'currentStudent', 'title', 'upcomingBatch', 'PipelineEnquiries', 'programmes', 'speradminid', 'from', 'to'));
        }
    }






public function campuspending($id)
{
    $title = "Campus Monthly Pending Report";
    $campus_id = $id;
    $start_date = Carbon::now()->startOfMonth()->format('Y-m-d');
    $end_date = Carbon::now()->endOfMonth()->format('Y-m-d');
    $programmes = Program::with('admission')->where('status', 'On Going')->whereHas('admission', function ($query) {
        $query->where('program_id', '!=', "");
    })->get();
    if ($campus_id == 0) {
        $campus_title = 'All Campuses';
    } else {
        $campus = Campus::find($campus_id);
        $campus_title = $campus->campus_code;
    }
    return view('Admin.Report.monthlyrecoveryreport', compact('title', 'programmes', 'campus_id', 'start_date', 'end_date', 'campus_title'));
}

}
