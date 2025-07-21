<?php

namespace App\Http\Controllers;

use App\Models\Lead;
use App\Models\Batch;
use App\Models\Program;
use App\Models\WebLead;
use App\Models\OldLeads;
use App\Models\Admission;
use App\Models\Campus;
use App\Models\Employee;
use App\Models\Registration;
use Illuminate\Http\Request;
use App\Models\FeeCollection;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Artisan;

class DashboardController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }


    public function index()
    {
        $title = 'Dashboard';
        $dash = 'active';
        $date = date('Y-m-d');
        $start_date = date('Y-m-d', strtotime('-14 days'));
        $current_date = date('Y-m-d');

        $month_start = date('Y-m-01');
        $totalYearCollection = 0;
        $month_end = date('Y-m-31');
        $totalEmployee = 0;
        if (Auth::user()->role == 'Super Admin' || Auth::user()->role == 'Admin' || Auth::user()->role == 'Telesales Representative' || Auth::user()->role == 'Business Operations Manager' || Auth::user()->role == 'Admin & Finance') {
            $today_lead = Lead::whereDate('created_at', $date)->count();
            $pipeline_leads = Lead::where('status', 'Pending')->count();
            $upcoming_batches = Batch::where('status', 'Not Suspended')->where('start_date', '>', $date)->count();
            $current_batches = Batch::where('status', 'Not Suspended')->where('start_date', '<', $start_date)->where('end_date', '>', $current_date)->count();
            $students = Admission::where('status', 'Enrolled')->count();
            $website_leads = WebLead::where('status', 'Pending')->count();
            $paid_amount = FeeCollection::where('status', 'Clear')->where('pay_date', '>=', $month_start)->where('pay_date', '<=', $month_end)->sum('paid_amount');
            $registeration_amount = FeeCollection::where('status', 'clear')->where('pay_date', '>=', $month_start)->where('pay_date', '<=', $month_end)->sum('registration_amount');
            $total_amount_paid = $registeration_amount + $paid_amount;
            $currentMonth = Carbon::now()->month;
            $currentYear = Carbon::now()->year;
            $currentMonthAdmissions = Admission::where('status', 'Enrolled')
                ->whereYear('created_at', $currentYear)
                ->whereMonth('created_at', $currentMonth)
                ->count();
            $pending_amount = FeeCollection::where('status', 'Pending')->sum('paid_amount');
            $total_leads = Lead::whereDate('next_follow_up', '<=', $date)
                ->where('status', 'Pending')->count();
            $totalEmployee = Employee::all()->count();
        } elseif (Auth::user()->role == 'Campus Head' || Auth::user()->role == 'Campus Owner') {
            $today_lead = Lead::whereDate('created_at', $date)->where('campus_id', Auth::user()->campus_id)->count();
            $pipeline_leads = Lead::where('status', 'Pending')->where('campus_id', Auth::user()->campus_id)->count();
            $upcoming_batches = Batch::where('status', 'Not Suspended')->where('start_date', '>', $date)->where('campus_id', Auth::user()->campus_id)->count();
            $current_batches = Batch::where('status', 'Not Suspended')->where('start_date', '<', $start_date)->where('end_date', '>', $current_date)->where('campus_id', Auth::user()->campus_id)->count();
            $students = Admission::where('campus_id', Auth::user()->campus_id)->where('status', 'Enrolled')->count();
            $website_leads = WebLead::where('status', 'Pending')->count();
            $paid_amount = FeeCollection::where('campus_id', Auth::user()->campus_id)->where('status', 'Clear')->where('pay_date', '>=', $month_start)->where('pay_date', '<=', $month_end)->sum('paid_amount');
            $registeration_amount = FeeCollection::where('campus_id', Auth::user()->campus_id)->where('status', 'clear')->where('pay_date', '>=', $month_start)->where('pay_date', '<=', $month_end)->sum('registration_amount');
            $total_amount_paid = $registeration_amount + $paid_amount;
            $total_leads = Lead::whereDate('next_follow_up', '<=', $date)
                ->where('status', 'Pending')->count();
            $pending_amount = FeeCollection::where('campus_id', Auth::user()->campus_id)->where('status', 'Pending')->sum('paid_amount');
            $currentMonth = Carbon::now()->month;
            $currentYear = Carbon::now()->year;
            $currentMonthAdmissions = Admission::where('status', 'Enrolled')
                ->whereYear('created_at', $currentYear)
                ->whereMonth('created_at', $currentMonth)->where('campus_id', Auth::user()->campus_id)->count();
            $currentYear = Carbon::now()->year;
            $yearPaidAmount = FeeCollection::where('campus_id', Auth::user()->campus_id)
                ->where('status', 'Clear')
                ->whereYear('pay_date', $currentYear)
                ->sum('paid_amount');
            $yearRegistrationAmount = FeeCollection::where('campus_id', Auth::user()->campus_id)
                ->where('status', 'Clear')
                ->whereYear('pay_date', $currentYear)
                ->sum('registration_amount');
            $totalYearCollection = $yearPaidAmount + $yearRegistrationAmount;
            $totalEmployee = Employee::where('campus_id', Auth::user()->campus_id)->count();
        } else {
            $today_lead = Lead::whereDate('created_at', $date)->where('campus_id', Auth::user()->campus_id)->count();
            $pipeline_leads = Lead::where('status', 'Pending')->where('campus_id', Auth::user()->campus_id)->count();
            $upcoming_batches = Batch::where('status', 'Not Suspended')->where('start_date', '>', $date)->where('campus_id', Auth::user()->campus_id)->count();
            $current_batches = Batch::where('status', 'Not Suspended')->where('start_date', '<', $start_date)->where('end_date', '>', $current_date)->where('campus_id', Auth::user()->campus_id)->count();
            $students = Admission::where('campus_id', Auth::user()->campus_id)->where('status', 'Enrolled')->count();
            $website_leads = WebLead::where('status', 'Pending')->count();
            $paid_amount = FeeCollection::where('campus_id', Auth::user()->campus_id)->where('status', 'Clear')->where('pay_date', '>=', $month_start)->where('pay_date', '<=', $month_end)->sum('paid_amount');
            $registeration_amount = FeeCollection::where('campus_id', Auth::user()->campus_id)->where('status', 'clear')->where('pay_date', '>=', $month_start)->where('pay_date', '<=', $month_end)->sum('registration_amount');
            $total_amount_paid = $registeration_amount + $paid_amount;
            $total_leads = Lead::whereDate('next_follow_up', '<=', $date)
                ->where('status', 'Pending')->count();
            $pending_amount = FeeCollection::where('campus_id', Auth::user()->campus_id)->where('status', 'Pending')->sum('paid_amount');

            $currentMonth = Carbon::now()->month;
            $currentYear = Carbon::now()->year;
            $currentMonthAdmissions = Admission::where('status', 'Enrolled')
                ->whereYear('created_at', $currentYear)
                ->whereMonth('created_at', $currentMonth)->where('campus_id', Auth::user()->campus_id)->count();
        }
        $programmes = Program::with('admission')->where('status', 'On Going')->whereHas('admission', function ($query) {
            $query->where('program_id', '!=', "");
        })->get();
        $programmes_leads = Program::with('lead')->where('status', 'On Going')->whereHas('lead', function ($query) {
            $query->where('program_id', '!=', "");
        })->get();

        return view('Admin.Dashboard.index', compact('title', 'dash', 'today_lead', 'pipeline_leads', 'upcoming_batches', 'current_batches', 'students', 'total_amount_paid', 'pending_amount', 'programmes', 'programmes_leads', 'website_leads', 'total_leads', 'currentMonthAdmissions', 'totalYearCollection', 'totalEmployee'));
    }


    public function search(Request $req)
    {
        $search = $req->search;

        if ($search == "") {
            $title = 'Search Results';
            $name = "all data";
            return view('Admin.Dashboard.search', compact('title', 'name'));
        }

        $registrations = Registration::with('campus', 'admission')->where('name', "LIKE", "%$search%")->orwhere('email', "LIKE", "%$search%")->orwhere('primary_contact', "LIKE", "%$search%")->orwhere('cnic', "LIKE", "%$search%")->get();
        if ($registrations->count() > 0) {
            $title = 'Search Results';
            $name = "Admission";
            $datas = $registrations;
            return view('Admin.Dashboard.search', compact('title', 'name', 'datas'));
        }

        $leads = Lead::where('name', "LIKE", "%$search%")->orwhere('email', "LIKE", "%$search%")->orwhere('primary_contact', "LIKE", "%$search%")->get();
        if ($leads->count() > 0) {
            $name = "Leads";
            $title = 'Search Results';
            $datas = $leads;
            return view('Admin.Dashboard.search', compact('title', 'name', 'datas'));
        }

        $webleads = WebLead::where('name', "LIKE", "%$search%")->orwhere('email', "LIKE", "%$search%")->orwhere('primary_contact', "LIKE", "%$search%")->get();
        if ($webleads->count() > 0) {
            $name = "Website Leads";
            $title = 'Search Results';
            $datas = $webleads;
            return view('Admin.Dashboard.search', compact('title', 'name', 'datas'));
        }

        $oldleads = OldLeads::with('campus', 'program')->where('name', "LIKE", "%$search%")->orwhere('email', "LIKE", "%$search%")->orwhere('primary_contact', "LIKE", "%$search%")->get();
        if ($oldleads->count() > 0) {
            $name = "Bulk Leads";
            $title = 'Search Results';
            $datas = $oldleads;
            return view('Admin.Dashboard.search', compact('title', 'name', 'datas'));
        }

        $title = 'Search Results';
        $name = "all";
        return view('Admin.Dashboard.search', compact('title', 'name'));
    }

    public function searchResult()
    {
        $title = 'Search Results';

        return view('Admin.Dashboard.search', compact('title'));
    }


public function thisMonthCollection()
{
    $title = 'Collection';
    $month_start = date('Y-m-01');
    $month_end = date('Y-m-31');
    $first_week_start = date('Y-m-01');
    $second_week_start = date('Y-m-08');
    $third_week_start = date('Y-m-15');
    $forth_week_start = date('Y-m-22');

    $data = [];

    if (Auth::user()->role == 'Super Admin') {
        $campuses = Campus::all(); // Fetch all campuses

        foreach ($campuses as $campus) {
            $campus_id = $campus->id;

            $t_a_f_w = FeeCollection::where('campus_id', $campus_id)
                ->where('status', 'Clear')
                ->where('pay_date', '>=', $first_week_start)
                ->where('pay_date', '<', $second_week_start)
                ->sum('paid_amount') + FeeCollection::where('campus_id', $campus_id)
                ->where('status', 'Clear')
                ->where('pay_date', '>=', $first_week_start)
                ->where('pay_date', '<', $second_week_start)
                ->sum('registration_amount');

            $t_a_s_w = FeeCollection::where('campus_id', $campus_id)
                ->where('status', 'Clear')
                ->where('pay_date', '>=', $second_week_start)
                ->where('pay_date', '<', $third_week_start)
                ->sum('paid_amount') + FeeCollection::where('campus_id', $campus_id)
                ->where('status', 'Clear')
                ->where('pay_date', '>=', $second_week_start)
                ->where('pay_date', '<', $third_week_start)
                ->sum('registration_amount');

            $t_a_t_w = FeeCollection::where('campus_id', $campus_id)
                ->where('status', 'Clear')
                ->where('pay_date', '>=', $third_week_start)
                ->where('pay_date', '<', $forth_week_start)
                ->sum('paid_amount') + FeeCollection::where('campus_id', $campus_id)
                ->where('status', 'Clear')
                ->where('pay_date', '>=', $third_week_start)
                ->where('pay_date', '<', $forth_week_start)
                ->sum('registration_amount');

            $t_a_fr_w = FeeCollection::where('campus_id', $campus_id)
                ->where('status', 'Clear')
                ->where('pay_date', '>=', $forth_week_start)
                ->where('pay_date', '<=', $month_end)
                ->sum('paid_amount') + FeeCollection::where('campus_id', $campus_id)
                ->where('status', 'Clear')
                ->where('pay_date', '>=', $forth_week_start)
                ->where('pay_date', '<=', $month_end)
                ->sum('registration_amount');

            $t_a_t_m = $t_a_f_w + $t_a_s_w + $t_a_t_w + $t_a_fr_w;

            $o_a_p = FeeCollection::where('campus_id', $campus_id)
                ->where('status', 'Pending')
                ->sum('paid_amount');

            $data[] = [
                'campus_code' => $campus->campus_code,
                'campus_id' => $campus_id,
                't_a_f_w' => $t_a_f_w,
                't_a_s_w' => $t_a_s_w,
                't_a_t_w' => $t_a_t_w,
                't_a_fr_w' => $t_a_fr_w,
                't_a_t_m' => $t_a_t_m,
                'o_a_p' => $o_a_p,
            ];
        }
    } else {
        $campus_id = Auth::user()->campus_id;

        $t_a_f_w_01 = FeeCollection::where('campus_id', $campus_id)
            ->where('status', 'Clear')
            ->where('pay_date', '>=', $first_week_start)
            ->where('pay_date', '<', $second_week_start)
            ->sum('paid_amount') + FeeCollection::where('campus_id', $campus_id)
            ->where('status', 'Clear')
            ->where('pay_date', '>=', $first_week_start)
            ->where('pay_date', '<', $second_week_start)
            ->sum('registration_amount');

        $t_a_s_w_01 = FeeCollection::where('campus_id', $campus_id)
            ->where('status', 'Clear')
            ->where('pay_date', '>=', $second_week_start)
            ->where('pay_date', '<', $third_week_start)
            ->sum('paid_amount') + FeeCollection::where('campus_id', $campus_id)
            ->where('status', 'Clear')
            ->where('pay_date', '>=', $second_week_start)
            ->where('pay_date', '<', $third_week_start)
            ->sum('registration_amount');

        $t_a_t_w_01 = FeeCollection::where('campus_id', $campus_id)
            ->where('status', 'Clear')
            ->where('pay_date', '>=', $third_week_start)
            ->where('pay_date', '<', $forth_week_start)
            ->sum('paid_amount') + FeeCollection::where('campus_id', $campus_id)
            ->where('status', 'Clear')
            ->where('pay_date', '>=', $third_week_start)
            ->where('pay_date', '<', $forth_week_start)
            ->sum('registration_amount');

        $t_a_fr_w_01 = FeeCollection::where('campus_id', $campus_id)
            ->where('status', 'Clear')
            ->where('pay_date', '>=', $forth_week_start)
            ->where('pay_date', '<=', $month_end)
            ->sum('paid_amount') + FeeCollection::where('campus_id', $campus_id)
            ->where('status', 'Clear')
            ->where('pay_date', '>=', $forth_week_start)
            ->where('pay_date', '<=', $month_end)
            ->sum('registration_amount');

        $t_a_t_m_01 = $t_a_f_w_01 + $t_a_s_w_01 + $t_a_t_w_01 + $t_a_fr_w_01;

        $data[] = [
            'campus_code' => Auth::user()->campus->campus_code,
            'campus_id' => $campus_id,
            't_a_f_w' => $t_a_f_w_01,
            't_a_s_w' => $t_a_s_w_01,
            't_a_t_w' => $t_a_t_w_01,
            't_a_fr_w' => $t_a_fr_w_01,
            't_a_t_m' => $t_a_t_m_01,
            'o_a_p' => 0, // Placeholder for non-super admin
        ];
    }

    $total_t_a_t_m = array_sum(array_column($data, 't_a_t_m'));
    $total_o_a_p = array_sum(array_column($data, 'o_a_p'));

    $data = [
        'campus_data' => $data,
        'total_t_a_t_m' => $total_t_a_t_m,
        'total_o_a_p' => $total_o_a_p,
    ];

    return view('Admin.Dashboard.thismonthcollection', compact('data', 'title'));
}




    public function thisMonthPendingRecovery()
    {
        $title = 'Pending Recovery';
        $month_start = date('Y-m-01');
        $month_end = date('Y-m-31');
        $first_week_start = date('Y-m-01');
        $second_week_start = date('Y-m-08');
        $third_week_start = date('Y-m-15');
        $forth_week_start = date('Y-m-22');

        $data = [];

        // Check if the user is a super admin
        if (Auth::user()->role == 'Super Admin') {
            $campuses = Campus::all(); // Fetch all campuses
        } else {
            $campuses = Campus::where('id', Auth::user()->campus_id)->get(); // Fetch only the campus of the authenticated user
        }
        foreach ($campuses as $campus) {
            $campus_id = $campus->id;


            $t_a_f_w = FeeCollection::where('campus_id', $campus_id)->where('status', 'Pending')
                ->where('due_date', '>=', $first_week_start)->where('due_date', '<', $second_week_start)->sum('paid_amount');
            $t_a_s_w = FeeCollection::where('campus_id', $campus_id)->where('status', 'Pending')
                ->where('due_date', '>=', $second_week_start)->where('due_date', '<', $third_week_start)->sum('paid_amount');
            $t_a_t_w = FeeCollection::where('campus_id', $campus_id)->where('status', 'Pending')
                ->where('due_date', '>=', $third_week_start)->where('due_date', '<', $forth_week_start)->sum('paid_amount');
            $t_a_fr_w = FeeCollection::where('campus_id', $campus_id)->where('status', 'Pending')
                ->where('due_date', '>=', $forth_week_start)->where('due_date', '<=', $month_end)->sum('paid_amount');
            $t_a_t_m = $t_a_f_w + $t_a_s_w + $t_a_t_w + $t_a_fr_w;

            $o_a_p = FeeCollection::where('campus_id', $campus_id)->where('status', 'Pending')->sum('paid_amount');

            $data[] = [
                'campus_code' => $campus->campus_code,
                'campus_id'=>$campus->id,
                't_a_f_w' => $t_a_f_w,
                't_a_s_w' => $t_a_s_w,
                't_a_t_w' => $t_a_t_w,
                't_a_fr_w' => $t_a_fr_w,
                't_a_t_m' => $t_a_t_m,
                'o_a_p' => $o_a_p
            ];
        }
        // dd($data);
        return view('Admin.Dashboard.thismonthpending', compact('title', 'data'));
    }
}
