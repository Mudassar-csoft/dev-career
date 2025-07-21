<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\Campus;
use App\Models\Country;
use App\Models\Lead;
use App\Models\LeadFollowUp;
use App\Models\OldLeads;
use App\Models\Program;
use App\Models\WebLead;
// use Dotenv\Validator;
use Illuminate\Contracts\Validation\Validator as ValidationValidator;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Validator;

class LeadController extends Controller
{
    public function index()
    {
        $title = 'Create Lead';
        $enquiry_open = 'open';
        $enquiry = 'active';
        $enq_manage = 'active';
        $programmes = Program::where('status', 'On Going')->get();
        $data['countries'] = Country::get(["name", "id"]);
        $campuses = Campus::all();

        return view('Admin.Enquiry.addenquiry', $data, compact('title', 'enq_manage', 'enquiry_open', 'enquiry', 'programmes', 'campuses'));
    }
    public function save(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'program_id' => 'required',
            'primary_contact' => 'required|unique:leads,primary_contact,null,null|numeric',
            'gender' => 'required',
            'country_id' => 'required',
            'city' => 'required',
            'marketing_source' => 'required',
            'campus_id' => 'required',
            'next_follow_up' => 'required|date',
            'probability' => 'required',
            'origin'=>'required'
        ]);

        if ($validator->fails()) {
            return Redirect::back()->with([
                'message' => 'Something went wrong!!'
            ])->withErrors($validator)->withInput();
        }else{
            $lead = new Lead();
            $lead->user_id = $request->input('user_id');
            $lead->program_id = $request->input('program_id');
            $lead->campus_id = $request->input('campus_id');
            $lead->status = $request->input('status');
            $lead->classes=$request->input('classes');
            $lead->name = $request->input('name');
            $lead->primary_contact = $request->input('primary_contact');
            $lead->guardian_contact = $request->input('guardian_contact');
            $lead->email = $request->input('email');
            $lead->country_id = $request->input('country_id');
            $lead->state_id = $request->input('state_id');
            $lead->city = $request->input('city');
            $lead->area = $request->input('area');
            $lead->origin=$request->input('origin');
            $lead->gender = $request->input('gender');
            $lead->marketing_source = $request->input('marketing_source');
            $lead->probability = $request->input('probability');
            $lead->remarks = $request->input('remarks');
            $lead->next_follow_up = $request->input('next_follow_up');
            $lead->save();
            if ($lead->save()) {
                $lead_id = Lead::all()->last()->id;

                $lead_follow_up = new LeadFollowUp();
                $lead_follow_up->user_id = $request->input('user_id');
                $lead_follow_up->lead_id = $lead_id;
                $lead_follow_up->campus_id = $request->input('campus_id');
                $lead_follow_up->follow_up_method = $request->input('follow_up_method');
                $lead_follow_up->status = $request->input('status');
                $lead_follow_up->next_follow_up = $request->input('next_follow_up');
                $lead_follow_up->probability = $request->input('probability');
                $lead_follow_up->remarks = $request->input('remarks');
                $lead_follow_up->save();
            }
            if ($lead_follow_up->save()) {
                if(isset($request->webleadupdate))
                {
                    $leads = WebLead::where('id', $request->webleadupdate)->update([
                        'status'=> 'Followed',
                    ]);
                }
                elseif (isset($request->oldid)) {
                    $oldleads = OldLeads::find($request->oldid);
                    $oldleads->status = 'Followed';
                    $oldleads->user_id = $request->user_id;
                    $oldleads->save();
                }

            }

                return redirect('/create-lead')->with([
                    'success' => 'Lead Added Successfully!'
                ]);
         
        }
    }
  public function allleads()
    {
        $title = "All Leads";
        $enquiry_open = 'open';
        $enquiry = 'active';
        $courses = Program::select('id', 'title')->paginate(20);


        $all_enquiry = 'active';
        if (Auth::user()->role == 'Super Admin' || Auth::user()->role == 'Admin' || Auth::user()->role == 'Telesales Representative') {
            $leads = Lead::with('program', 'campus')->orderBy('created_at', 'desc')->get();
        } else {
            $leads = Lead::where('campus_id', Auth::user()->campus_id)->with('program', 'campus')->orderBy('created_at', 'desc')->get();
        }
        $campuses = Campus::where('id', '!=', Auth::user()->campus_id)->get();
        return view('Admin.Enquiry.allenquiries', compact('title', 'all_enquiry', 'enquiry_open', 'enquiry', 'campuses', 'courses'))->with('leads', json_decode($leads, true));
    }
    public function pipelineenquiry()
    {
        $title = "Leads In Pipeline";
        $enquiry_open = 'open';
        $enquiry = 'active';
        $pipeline_enquiry = 'active';
        if (Auth::user()->role == 'Super Admin' || Auth::user()->role == 'Admin' || Auth::user()->role=='Telesales Representative') {
            $leads = Lead::where('status', 'Pending')->with('program', 'campus') ->orderBy('created_at', 'desc')->get();
        }else{
            $leads = Lead::where('status', 'Pending')->where('campus_id', Auth::user()->campus_id)->with('program', 'campus')->get();
        }

        $campuses = Campus::where('id', '!=', Auth::user()->campus_id)->get();

        return view('Admin.Enquiry.pipelineenruiry', compact('title', 'pipeline_enquiry', 'enquiry_open', 'enquiry', 'campuses','leads'));
    }
    public function followUp()
    {
        $title = 'Lead Follow-Up';
        $enquiry_open = 'open';
        $enquiry = 'active';
        $enq_follow_up = 'active';
        $date = date('Y-m-d');
        if (Auth::user()->role == 'Super Admin' || Auth::user()->role == 'Admin' || Auth::user()->role=='Telesales Representative') {
            $leads = Lead::whereDate('next_follow_up', $date)->where('status', 'Pending')->with('program', 'campus')->orderBy('created_at', 'desc')->get();
            $leads_count = Lead::whereDate('next_follow_up', $date)->where('status', 'Pending')->count();

            // $pending_leads = Lead::whereDate('next_follow_up', '<', $date)->where('status', 'Pending')->with('program', 'campus')->orderBy('next_follow_up', 'ASC')->get();
            // $pending_leads_count = Lead::whereDate('next_follow_up', '<', $date)->where('status', 'Pending')->count();
        }else {
            $leads = Lead::whereDate('next_follow_up', $date)->where('status', 'Pending')->where('campus_id', Auth::user()->campus_id)->with('program', 'campus')->orderBy('created_at', 'desc')->get();
            $leads_count = Lead::whereDate('next_follow_up', $date)->where('status', 'Pending')->where('campus_id', Auth::user()->campus_id)->count();

            // $pending_leads = Lead::whereDate('next_follow_up', '<', $date)->where('status', 'Pending')->where('campus_id', Auth::user()->campus_id)->with('program', 'campus')->orderBy('next_follow_up', 'ASC')->get();
            // $pending_leads_count = Lead::whereDate('next_follow_up', '<', $date)->where('status', 'Pending')->where('campus_id', Auth::user()->campus_id)->count();
        }
        $campuses = Campus::where('id', '!=', Auth::user()->campus_id)->get();

        return view('Admin.Enquiry.enquiryfollowup', compact('title', 'enq_follow_up', 'enquiry_open', 'enquiry', 'campuses', 'leads_count','leads'));
    }
    public function pendingfollowups(){
        $title = 'Lead Follow-Up';
        $enquiry_open = 'open';
        $enquiry = 'active';
        $pending_follow_up = 'active';
        $date = date('Y-m-d');
        if (Auth::user()->role == 'Super Admin' || Auth::user()->role == 'Admin' || Auth::user()->role=='Telesales Representative') {
            $leads = Lead::whereDate('next_follow_up', '<', $date)->where('status', 'Pending')->with('program', 'campus')->orderBy('next_follow_up', 'ASC')->get();
            $leads_count = Lead::whereDate('next_follow_up', '<', $date)->where('status', 'Pending')->count();
        }else {


            $leads = Lead::whereDate('next_follow_up', '<', $date)->where('status', 'Pending')->where('campus_id', Auth::user()->campus_id)->with('program', 'campus')->orderBy('next_follow_up', 'ASC')->get();
            $leads_count = Lead::whereDate('next_follow_up', '<', $date)->where('status', 'Pending')->where('campus_id', Auth::user()->campus_id)->count();
        }
        $campuses = Campus::where('id', '!=', Auth::user()->campus_id)->get();
        return view('Admin.Enquiry.pendingleads', compact('title', 'pending_follow_up', 'enquiry_open', 'enquiry', 'campuses', 'leads_count','leads'));

    }
    public function successfullyEnrolled()
    {
        $title = "Successfully Enrolled Leads";
        $enquiry_open = 'open';
        $enquiry = 'active';
        $successfully_enrolled = 'active';
        if (Auth::user()->role == 'Super Admin' || Auth::user()->role == 'Admin' || Auth::user()->role=='Telesales Representative') {
            $leads = Lead::where('status', 'Enrolled')->with('program', 'campus')->get();
        }else {
            $leads = Lead::where('status', 'Enrolled')->where('campus_id', Auth::user()->campus_id)->with('program', 'campus')->get();
        }
        $campuses = Campus::where('id', '!=', Auth::user()->campus_id)->get();
        return view('Admin.Enquiry.successfullyenrolled', compact('title', 'successfully_enrolled', 'enquiry_open', 'enquiry', 'campuses','leads'));
    }
}
