<?php

namespace App\Http\Controllers;

use App\Models\Lead;
use App\Models\Campus;
use App\Models\Country;
use App\Models\Program;
use App\Models\WebLead;
use App\Models\OldLeads;
use App\Models\Admission;
use App\Models\LeadFollowUp;
use App\Models\WebsiteAdmin\WebsiteCourse;
use App\Models\Registration;
use Illuminate\Http\Request;
use App\Models\FeeCollection;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Validator;

class OtherEnquiryController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function followUp()
    {
        $title = 'Lead Follow-Up';
        $enquiry_open = 'open';
        $enquiry = 'active';
        $enq_follow_up = 'active';
        $date = date('Y-m-d');
        if (Auth::user()->role == 'Super Admin' || Auth::user()->role == 'Admin' || Auth::user()->role == 'Telesales Representative' || Auth::user()->role == 'Business Operations Manager' || Auth::user()->role == 'Admin & Finance') {
            $leads = Lead::whereDate('next_follow_up', $date)->where('status', 'Pending')->with('program', 'campus')->get();
            $leads_count = Lead::whereDate('next_follow_up', $date)->where('status', 'Pending')->count();

            $pending_leads = Lead::whereDate('next_follow_up', '<', $date)->where('status', 'Pending')->with('program', 'campus')->orderBy('next_follow_up', 'ASC')->get();
            $pending_leads_count = Lead::whereDate('next_follow_up', '<', $date)->where('status', 'Pending')->count();
        }else {
            $leads = Lead::whereDate('next_follow_up', $date)->where('status', 'Pending')->where('campus_id', Auth::user()->campus_id)->with('program', 'campus')->get();
            $leads_count = Lead::whereDate('next_follow_up', $date)->where('status', 'Pending')->where('campus_id', Auth::user()->campus_id)->count();

            $pending_leads = Lead::whereDate('next_follow_up', '<', $date)->where('status', 'Pending')->where('campus_id', Auth::user()->campus_id)->with('program', 'campus')->orderBy('next_follow_up', 'ASC')->get();
            $pending_leads_count = Lead::whereDate('next_follow_up', '<', $date)->where('status', 'Pending')->where('campus_id', Auth::user()->campus_id)->count();
        }
        $campuses = Campus::where('id', '!=', Auth::user()->campus_id)->get();

        return view('Admin.Enquiry.enquiryfollowup', compact('title', 'enq_follow_up', 'enquiry_open', 'enquiry', 'campuses', 'leads_count', 'pending_leads_count'))->with(['leads' => json_decode($leads, true), 'pending_leads' => json_decode($pending_leads, true)]);
    }

    public function todayEnquiry()
    {
        $title = "Today's Leads";
        $enquiry_open = 'open';
        $enquiry = 'active';
        $today_enquiry = 'active';
        $date = date('Y-m-d');
        if (Auth::user()->role == 'Super Admin' || Auth::user()->role == 'Admin' || Auth::user()->role == 'Telesales Representative' || Auth::user()->role == 'Business Operations Manager' || Auth::user()->role == 'Admin & Finance') {
            $leads = Lead::with('program', 'campus')->whereDate('created_at', $date)->get();
        }else{
            $leads = Lead::with('program', 'campus')->whereDate('created_at', $date)->where('campus_id', Auth::user()->campus_id)->get();
        }
        $campuses = Campus::where('id', '!=', Auth::user()->campus_id)->get();
        return view('Admin.Enquiry.todayenquiry', compact('title', 'today_enquiry', 'enquiry_open', 'enquiry', 'campuses'))->with('leads', json_decode($leads, true));
    }

    public function successfullyEnrolled()
    {
        $title = "Successfully Enrolled Leads";
        $enquiry_open = 'open';
        $enquiry = 'active';
        $successfully_enrolled = 'active';
        if (Auth::user()->role == 'Super Admin' || Auth::user()->role == 'Admin' || Auth::user()->role == 'Telesales Representative' || Auth::user()->role == 'Business Operations Manager' || Auth::user()->role == 'Admin & Finance') {
            $leads = Lead::where('status', 'Enrolled')->with('program', 'campus')->get();
        }else {
            $leads = Lead::where('status', 'Enrolled')->where('campus_id', Auth::user()->campus_id)->with('program', 'campus')->get();
        }
        $campuses = Campus::where('id', '!=', Auth::user()->campus_id)->get();
        return view('Admin.Enquiry.successfullyenrolled', compact('title', 'successfully_enrolled', 'enquiry_open', 'enquiry', 'campuses'))->with('leads', json_decode($leads, true));
    }

    public function notInterested()
    {
        $title = "Not Interested Leads";
        $enquiry_open = 'open';
        $enquiry = 'active';
        $not_interested = 'active';
        if (Auth::user()->role == 'Super Admin' || Auth::user()->role == 'Admin' || Auth::user()->role == 'Telesales Representative' || Auth::user()->role == 'Business Operations Manager' || Auth::user()->role == 'Admin & Finance') {
            $leads = Lead::where('status', 'Not Interested')->with('program', 'campus')->get();
        }else {
            $leads = Lead::where('status', 'Not Interested')->where('campus_id', Auth::user()->campus_id)->with('program', 'campus')->get();
        }
        $campuses = Campus::where('id', '!=', Auth::user()->campus_id)->get();
        return view('Admin.Enquiry.notinterested', compact('title', 'not_interested', 'enquiry_open', 'enquiry', 'campuses'))->with('leads', json_decode($leads, true));
    }

    public function pipelineEnquiry()
    {
        $title = "Leads In Pipeline";
        $enquiry_open = 'open';
        $enquiry = 'active';
        $pipeline_enquiry = 'active';
        if (Auth::user()->role == 'Super Admin' || Auth::user()->role == 'Admin' || Auth::user()->role == 'Telesales Representative' || Auth::user()->role == 'Business Operations Manager' || Auth::user()->role == 'Admin & Finance') {
            $leads = Lead::where('status', 'Pending')->with('program', 'campus')->get();
        }else{
            $leads = Lead::where('status', 'Pending')->where('campus_id', Auth::user()->campus_id)->with('program', 'campus')->get();
        }

        $campuses = Campus::where('id', '!=', Auth::user()->campus_id)->get();

        return view('Admin.Enquiry.pipelineenruiry', compact('title', 'pipeline_enquiry', 'enquiry_open', 'enquiry', 'campuses'))->with('leads', json_decode($leads, true));
    }

    public function allEnquiry()
    {
          $title = "All Leads";
        $enquiry_open = 'open';
        $enquiry = 'active';
        // $courses = Program::select('id', 'title')->paginate(20);


        $all_enquiry = 'active';
        if (Auth::user()->role == 'Super Admin' || Auth::user()->role == 'Admin' || Auth::user()->role == 'Telesales Representative') {
            $leads = Lead::with('program', 'campus')->orderBy('created_at', 'desc')->get();
        } else {
            $leads = Lead::where('campus_id', Auth::user()->campus_id)->with('program', 'campus')->orderBy('created_at', 'desc')->get();
        }
        $campuses = Campus::where('id', '!=', Auth::user()->campus_id)->get();
        return view('Admin.Enquiry.allenquiries', compact('title', 'all_enquiry', 'enquiry_open', 'enquiry', 'campuses'))->with('leads', json_decode($leads, true));
    }

    public function selectId()
    {
        $lead_id = Lead::all()->last()->id;
        $lead = $lead_id+1;
        return response()->json([
            'lead' => $lead,
        ]);

    }

    public function addFollowUp($id)
    {
        $title = "Add Follow-Up";
        $enquiry_open = 'open';
        $enquiry = 'active';
        $lead_id = $id;

        return view('Admin.Enquiry.addfollowup', compact('title', 'enquiry_open', 'enquiry', 'lead_id'));
    }

    public function saveFollowUp(Request $request)
    {
        // updating last follow up status to 'Followed' from 'Not Followed'
        $follow_up_status = LeadFollowUp::where('lead_id', $request->input('lead_id'))->get()->last();
        if ($follow_up_status) {
            $follow_up_status->follow_up_status = "Followed";
            $follow_up_status->save();

            if ($follow_up_status->save()) {
                // creating new follow up
                $lead_follow_up = new LeadFollowUp();
                $lead_follow_up->user_id = $request->input('user_id');
                $lead_follow_up->lead_id = $request->input('lead_id');
                $lead_follow_up->campus_id = $request->input('campus_id');
                $lead_follow_up->follow_up_method = $request->input('follow_up_method');
                $lead_follow_up->status = $request->input('status');
                $lead_follow_up->next_follow_up = $request->input('next_follow_up');
                $lead_follow_up->probability = $request->input('probability');
                $lead_follow_up->remarks = $request->input('remarks');
                $lead_follow_up->save();

                if ($request->input('status') == 'Pending') {
                    // updating next follow up date and time in Lead table
                    $lead = Lead::find($request->input('lead_id'));
                    $lead->next_follow_up = $request->input('next_follow_up');
                    $lead->status = $request->input('status');
                    $lead->save();
                }elseif ($request->input('status') == 'Not Interested') {
                    $lead = Lead::find($request->input('lead_id'));
                    $lead->status = $request->input('status');
                    $lead->save();
                }
            }

        }else{
            // creating new follow up
            $lead_follow_up = new LeadFollowUp();
            $lead_follow_up->user_id = $request->input('user_id');
            $lead_follow_up->lead_id = $request->input('lead_id');
            $lead_follow_up->campus_id = $request->input('campus_id');
            $lead_follow_up->follow_up_method = $request->input('follow_up_method');
            $lead_follow_up->status = $request->input('status');
            $lead_follow_up->next_follow_up = $request->input('next_follow_up');
            $lead_follow_up->probability = $request->input('probability');
            $lead_follow_up->remarks = $request->input('remarks');
            $lead_follow_up->save();

            if ($request->input('status') == 'Pending') {
                // updating next follow up date and time in Lead table
                $lead = Lead::find($request->input('lead_id'));
                $lead->next_follow_up = $request->input('next_follow_up');
                $lead->status = $request->input('status');
                $lead->save();
            }elseif ($request->input('status') == 'Not Interested') {
                $lead = Lead::find($request->input('lead_id'));
                $lead->status = $request->input('status');
                $lead->save();
            }
        }

        return redirect()->back()->with([
            'message' => 'Follow-Up Added Successfully!'
        ]);
    }

    public function transferLead(Request $request)
    {
        $lead = Lead::find($request->input('lead_id'));
        $lead->campus_id = $request->input('campus_id');
        $lead->remarks = $request->input('remarks');
        $lead->status = $request->input('status');
        $lead->save();
        return redirect()->back()->with([
            'message' => 'Lead Transferred Successfully!'
        ]);
    }

    public function transferredLead(Request $request)
    {
        $title = "Transferred Leads";
        $enquiry_open = 'open';
        $enquiry = 'active';
        $transfer_lead = 'active';

        if (Auth::user()->role == 'Super Admin' || Auth::user()->role == 'Admin' || Auth::user()->role == 'Telesales Representative' || Auth::user()->role == 'Business Operations Manager' || Auth::user()->role == 'Admin & Finance') {
            $leads = Lead::where('status', 'Transferred')->with('program', 'campus')->get();
        }else{
            $leads = Lead::where('status', 'Transferred')->where('campus_id', Auth::user()->campus_id)->with('program', 'campus')->get();
        }

        $campuses = Campus::where('id', '!=', Auth::user()->campus_id)->get();
        return view('Admin.Enquiry.transferredlead', compact('title', 'transfer_lead', 'enquiry_open', 'enquiry', 'leads', 'campuses'));
    }


    public function enrollNow($id)
    {
        $title = 'New Admission';
        $admission_open = 'open';
        $admission = 'active';
        $new_admission = 'active';

        $lead = Lead::find($id);

        $year = date('y');
        $programmes = Program::where('status', 'On Going')->get();
        $reg_count = Registration::where('campus_id', Auth::user()->campus_id)->get()->count();

        $campus = Campus::where('id', Auth::user()->campus_id)->get();
        $fee_count = FeeCollection::where('campus_id', Auth::user()->campus_id)->where('status', 'Clear')->get()->count();
        foreach ($campus as $data) {
        }
        $campus_code = $data->campus_code;
        if ($reg_count<10) {
            $registration_no = $campus_code.'-'.$year.'-'.'0'.($reg_count+1);
        }else{
            $registration_no = $campus_code.'-'.$year.'-'.($reg_count+1);
        }

        if ($fee_count<9) {
            $receipt_number = $campus_code.'-'.$year.'-'.'00000'.($fee_count+1);
        }elseif ($fee_count<99) {
            $receipt_number = $campus_code.'-'.$year.'-'.'0000'.($fee_count+1);
        }elseif ($fee_count<999) {
            $receipt_number = $campus_code.'-'.$year.'-'.'000'.($fee_count+1);
        }elseif ($fee_count<9999) {
            $receipt_number = $campus_code.'-'.$year.'-'.'00'.($fee_count+1);
        }elseif ($fee_count<99999) {
            $receipt_number = $campus_code.'-'.$year.'-'.'0'.($fee_count+1);
        }else {
            $receipt_number = $campus_code.'-'.$year.'-'.($fee_count+1);
        }

        return view('Admin.Enquiry.enrollnow', compact('title', 'admission_open', 'admission', 'new_admission', 'programmes', 'registration_no', 'receipt_number', 'lead'));
    }


    public function storeEnroll(Request $request, $id)
    {
        if ($request->input('fee_type') == 'Installment') {
            $total = $request->first_installment + $request->second_installment + $request->third_installment;
            if ($request->input('discounted_fee') != $total) {
                return redirect()->back()->with([
                    'message' => 'Installments are not equal to discounted fee!'
                ]);
            }
        }

        // date
        $date = date('Y-m-d');

        $due_date = date('Y-m-d', strtotime('+30 days'));

        $second_due_date = date('Y-m-d', strtotime('+60 days'));

        $validator = Validator::make($request->all(), [
            'primary_contact' => 'unique:registrations,primary_contact,null,null',
            'cnic' => 'unique:registrations,cnic,null,null',
            'registration_number' => 'unique:registrations,registration_number,null,null',
            'roll_number' => 'unique:admissions,roll_number,null,null',
            'receipt_number' => 'unique:fee_collections,receipt_number,null,null',
        ]);

        if ($validator->fails()) {
            return Redirect::back()->with([
                'message' => 'Something went wrong!!'
            ])->withErrors($validator);
        }
        else{
            $registration = new Registration();
            $registration->name = $request->input('name');
            $registration->user_id = $request->input('user_id');
            $registration->campus_id = $request->input('campus_id');
            $registration->registration_number = $request->input('registration_number');
            $registration->primary_contact = $request->input('primary_contact');
            $registration->guardian_name = $request->input('guardian_name');
            $registration->guardian_contact = $request->input('guardian_contact');
            $registration->cnic = $request->input('cnic');
            $registration->email = $request->input('email');
            $registration->address = $request->input('address');
            $registration->dob = $request->input('dob');
            $registration->gender = $request->input('gender');
            $registration->education = $request->input('education');
            $registration->remarks = $request->input('remarks');
            $registration->save();

            if ($registration->save()) {
                $registration_id = Registration::all()->last()->id;

                $admission = new Admission();
                $admission->roll_number = $request->input('roll_number');
                $admission->user_id = $request->input('user_id');
                $admission->registration_id = $registration_id;
                $admission->program_id = $request->input('program_id');
                $admission->campus_id = $request->input('campus_id');
                $admission->batch_id = $request->input('batch_id');
                $admission->admission_date = $request->input('admission_date');
                $admission->fee_package = $request->input('discounted_fee');
                $admission->discount = $request->input('discount');
                $admission->status = $request->input('status');
                $admission->save();

                if ($admission->save()) {
                    $registration_id = Registration::all()->last()->id;
                    $admission_id = Admission::all()->last()->id;

                    if ($request->input('fee_type') == 'Full Fee') {
                        $fee = new FeeCollection();
                        $fee->registration_id = $registration_id;
                        $fee->admission_id = $admission_id;
                        $fee->user_id = $request->input('user_id');
                        $fee->campus_id = $request->input('campus_id');
                        $fee->admission_date = $request->input('admission_date');
                        $fee->fee_type = $request->input('fee_type');
                        $fee->total_amount = $request->input('discounted_fee');
                        $fee->registration_amount = $request->input('registration_fee');
                        $fee->paid_amount = $request->input('discounted_fee');
                        $fee->pay_date = $date;
                        $fee->status = 'Clear';
                        $fee->receipt_number = $request->input('receipt_number');
                        $fee->save();

                        if ($fee->save()) {
                            $lead = Lead::find($id);
                            $lead->status = 'Enrolled';
                            $lead->save();
                        }

                        return redirect()->route('admission.show', $registration_id)->with([
                            'message' => 'Admission successfull with full fee!'
                        ]);
                    }
                    elseif ($request->input('fee_type') == 'Installment') {

                        if ($request->input('third_installment') == 0) {
                            $fee = new FeeCollection();
                            $fee->registration_id = $registration_id;
                            $fee->admission_id = $admission_id;
                            $fee->user_id = $request->input('user_id');
                            $fee->campus_id = $request->input('campus_id');
                            $fee->admission_date = $request->input('admission_date');
                            $fee->fee_type = $request->input('fee_type');
                            $fee->installment_number = 1;
                            $fee->total_amount = $request->input('discounted_fee');
                            $fee->registration_amount = $request->input('registration_fee');
                            $fee->paid_amount = $request->input('first_installment');
                            $fee->pay_date = $date;
                            $fee->status = 'Clear';
                            $fee->receipt_number = $request->input('receipt_number');
                            $fee->save();

                            if ($fee->save()) {
                                $fee = new FeeCollection();
                                $fee->registration_id = $registration_id;
                                $fee->admission_id = $admission_id;
                                $fee->user_id = $request->input('user_id');
                                $fee->campus_id = $request->input('campus_id');
                                $fee->admission_date = $request->input('admission_date');
                                $fee->fee_type = $request->input('fee_type');
                                $fee->installment_number = 2;
                                $fee->total_amount = $request->input('discounted_fee');
                                $fee->paid_amount = $request->input('second_installment');
                                $fee->due_date = $due_date;
                                $fee->status = 'Pending';
                                $fee->save();
                            }
                            if ($fee->save()) {
                                $lead = Lead::find($id);
                                $lead->status = 'Enrolled';
                                $lead->save();
                            }

                            return redirect()->route('admission.show', $registration_id)->with([
                                'message' => 'Admission successfull with 2 installments!'
                            ]);
                        }
                        elseif ($request->input('third_installment') > 0) {
                            $fee = new FeeCollection();
                            $fee->registration_id = $registration_id;
                            $fee->admission_id = $admission_id;
                            $fee->user_id = $request->input('user_id');
                            $fee->campus_id = $request->input('campus_id');
                            $fee->admission_date = $request->input('admission_date');
                            $fee->fee_type = $request->input('fee_type');
                            $fee->installment_number = 1;
                            $fee->total_amount = $request->input('discounted_fee');
                            $fee->registration_amount = $request->input('registration_fee');
                            $fee->paid_amount = $request->input('first_installment');
                            $fee->pay_date = $date;
                            $fee->status = 'Clear';
                            $fee->receipt_number = $request->input('receipt_number');
                            $fee->save();

                            if ($fee->save()) {
                                $fee = new FeeCollection();
                                $fee->registration_id = $registration_id;
                                $fee->admission_id = $admission_id;
                                $fee->user_id = $request->input('user_id');
                                $fee->campus_id = $request->input('campus_id');
                                $fee->admission_date = $request->input('admission_date');
                                $fee->fee_type = $request->input('fee_type');
                                $fee->installment_number = 2;
                                $fee->total_amount = $request->input('discounted_fee');
                                $fee->paid_amount = $request->input('second_installment');
                                $fee->due_date = $due_date;
                                $fee->status = 'Pending';
                                $fee->save();

                                if ($fee->save()) {
                                    $fee = new FeeCollection();
                                    $fee->registration_id = $registration_id;
                                    $fee->admission_id = $admission_id;
                                    $fee->user_id = $request->input('user_id');
                                    $fee->campus_id = $request->input('campus_id');
                                    $fee->admission_date = $request->input('admission_date');
                                    $fee->fee_type = $request->input('fee_type');
                                    $fee->installment_number = 3;
                                    $fee->total_amount = $request->input('discounted_fee');
                                    $fee->paid_amount = $request->input('third_installment');
                                    $fee->due_date = $second_due_date;
                                    $fee->status = 'Pending';
                                    $fee->save();
                                }
                                if ($fee->save()) {
                                    $lead = Lead::find($id);
                                    $lead->status = 'Enrolled';
                                    $lead->save();
                                }
                            }


                            return redirect()->route('admission.show', $registration_id)->with([
                                'message' => 'Admission successfull with 3 installments!'
                            ]);
                        }
                    }
                }
            }
        }
    }


    public function notInterestedAction($id)
    {
        $lead = Lead::find($id);
        $lead->status = 'Not Interested';
        $lead->save();
        return redirect()->back()->with([
            'message' => 'Lead status updated!'
        ]);
    }

 public function leadsshow()
    {
        $title = 'Lead Website';
        $enquiry_open = 'open';
        $enquiry = 'active';
        $web_follow_up = 'active';
        if (Auth::user()->role == 'Super Admin' || Auth::user()->role == 'Telesales Representative') {
            $allleadscount = WebLead::all()->count();
            $allleads = WebLead::with('campus')->orderBy('created_at', 'desc')->get();
            $webleads = WebLead::with('campus')
                ->where('status', 'Pending')
                ->orderBy('created_at', 'desc')
                ->get();

            $webleadscount = WebLead::where('status', 'Pending')->count();
            $webadmission = WebLead::with('campus')->where('status', 'Pending')->where('type', 'Admission')->get();
            $webadmissioncount = WebLead::where('type', 'Admission')->where('status', 'Pending')->count();
        } else {
            $allleadscount = WebLead::where('campus_id', Auth::user()->campus_id)->count();
            $allleads = WebLead::where('campus_id', Auth::user()->campus_id)->get();

            $webleads = WebLead::with('campus')->where('status', 'Pending')->where('campus_id', Auth::user()->campus_id)->get();

            $webleadscount = WebLead::where('campus_id', Auth::user()->campus_id)->where('status', 'Pending')->count();
            $webadmission = WebLead::with('campus')->where('status', 'Pending')->where('type', 'Admission')->where('campus_id', Auth::user()->campus_id)->get();
            $webadmissioncount = WebLead::where('type', 'Admission')->where('campus_id', Auth::user()->campus_id)->where('status', 'Pending')->count();
        }
        return view('Admin.Enquiry.websitelead', compact('title', 'allleadscount', 'web_follow_up', 'enquiry_open', 'enquiry', 'webadmissioncount', 'webleadscount'))->with(['weblead' => json_decode($webleads, true), 'webadmission' => json_decode($webadmission, true), 'allleads' => json_decode($allleads, true)]);
    }


    public function addweblead($id)
    {
        $title = 'Create Lead';
        $enquiry_open = 'open';
        $enquiry = 'active';
        $enq_manage = 'active';
        $programmes = Program::where('status', 'On Going')->get();
        $data['countries'] = Country::get(["name", "id"]);
        $campuses = Campus::all();

        $webleadid = WebLead::where('id',$id)->first();
        return view('Admin.Enquiry.addenquiry', $data,compact('webleadid','title','enquiry_open','enquiry','enq_manage','programmes','campuses'));
    }

    public function addwebadmission($id)
    {
        $title = 'New Admission';
        $admission_open = 'open';
        $admission = 'active';
        $new_admission = 'active';

        $year = date('y');
        $programmes = Program::where('status', 'On Going')->get();
        $reg_count = Registration::where('campus_id', Auth::user()->campus_id)->get()->count();

        $campus = Campus::where('id', Auth::user()->campus_id)->get();
        $fee_count = FeeCollection::where('campus_id', Auth::user()->campus_id)->where('status', 'Clear')->get()->count();
        foreach ($campus as $data) {
        }
        $campus_code = $data->campus_code;
        if ($reg_count<10) {
            $registration_no = $campus_code.'-'.$year.'-'.'0'.($reg_count+1);
        }else{
            $registration_no = $campus_code.'-'.$year.'-'.($reg_count+1);
        }

        if ($fee_count<9) {
            $receipt_number = $campus_code.'-'.$year.'-'.'00000'.($fee_count+1);
        }elseif ($fee_count<99) {
            $receipt_number = $campus_code.'-'.$year.'-'.'0000'.($fee_count+1);
        }elseif ($fee_count<999) {
            $receipt_number = $campus_code.'-'.$year.'-'.'000'.($fee_count+1);
        }elseif ($fee_count<9999) {
            $receipt_number = $campus_code.'-'.$year.'-'.'00'.($fee_count+1);
        }elseif ($fee_count<99999) {
            $receipt_number = $campus_code.'-'.$year.'-'.'0'.($fee_count+1);
        }else {
            $receipt_number = $campus_code.'-'.$year.'-'.($fee_count+1);
        }

        $webadmissionid = WebLead::where('id',$id)->first();

        return view('Admin.Admission.newadmission', compact('title', 'admission_open', 'admission', 'new_admission', 'programmes', 'registration_no', 'receipt_number','webadmissionid'));


    }

    public function webnotinterested($id)
    {
        $lead = WebLead::find($id);
        $lead->status = 'Not Interested';
        $lead->save();
        return redirect()->back()->with([
            'message' => 'Lead status updated!'
        ]);


    }

    public function oldLeads()
    {
        $title = 'Old Leads';
        $enquiry_open = 'open';
        $enquiry = 'active';
        $old_leads = 'active';

        if (Auth::user()->role == 'Super Admin') {
            $leads = OldLeads::where('status', 'Followed')->with('program', 'campus', 'user')->get();
            $leads_count = OldLeads::where('status', 'Followed')->count();

            $pending_leads = OldLeads::where('status', 'Pending')->with('program', 'campus', 'user')->get();
            $pending_leads_count = OldLeads::where('status', 'Pending')->count();
        }else {
            $leads = OldLeads::where('campus_id', Auth::user()->campus_id)->where('status', 'Followed')->with('program', 'campus', 'user')->get();
            $leads_count = OldLeads::where('campus_id', Auth::user()->campus_id)->where('status', 'Followed')->count();

            $pending_leads = OldLeads::where('campus_id', Auth::user()->campus_id)->where('status', 'Pending')->with('program', 'campus', 'user')->get();
            $pending_leads_count = OldLeads::where('campus_id', Auth::user()->campus_id)->where('status', 'Pending')->count();
        }

        return view('Admin.Enquiry.oldleads', compact('title', 'enquiry_open', 'enquiry', 'old_leads', 'leads_count', 'pending_leads_count'))->with(['leads' => json_decode($leads, true), 'pending_leads' => json_decode($pending_leads, true)]);
    }


    public function createOldLead($id)
    {
        $title = 'Create Lead';
        $enquiry_open = 'open';
        $enquiry = 'active';
        $enq_manage = 'active';
        $programmes = Program::where('status', 'On Going')->get();
        $data['countries'] = Country::get(["name", "id"]);
        $campuses = Campus::all();
        $oldlead = OldLeads::find($id);

        return view('Admin.Enquiry.createleadfromoldlead', $data, compact('title', 'enq_manage', 'enquiry_open', 'enquiry', 'programmes', 'campuses', 'oldlead'));
    }


    public function checkNumber($num)
    {
        $admission = Registration::where('primary_contact', $num)->get();
        $lead = Lead::where('primary_contact', $num)->get();
        if ($admission->count() > 0) {
            return response()->json([
                'message' => "Not Ok",
            ]);
        }
        elseif ($lead->count() > 0) {
            return response()->json([
                'message' => "Not Ok",
            ]);
        }
        else{
            return response()->json([
                'message' => "Ok",
            ]);
        }
    }
     public function filterallenquir(Request $req)
    {
        //    dd($req);

        $title = "All Leads";
        $enquiry_open = 'open';
        $enquiry = 'active';
        $all_enquiry = 'active';
        $courses = WebsiteCourse::select('id', 'title')->paginate(20);
        $query = Lead::with('program', 'campus');

        if (Auth::user()->role != 'Super Admin' && Auth::user()->role != 'Admin' && Auth::user()->role != 'Telesales Representative') {
            $query->where('campus_id', Auth::user()->campus_id);
        }

        $query->where(function ($subQuery) use ($req) {

            if ($req->has('campus_id') && $req->status != null && $req->has('st_date') && $req->has('end_date') && $req->st_date != null && $req->end_date != null) {
                $subQuery->where('campus_id', $req->campus_id)->Where('status', $req->status)->whereBetween('created_at', [$req->st_date, $req->end_date]);
                //checking for three conditions with and
            } else {

                //checking each two one by one
                if ($req->has('campus_id') && $req->campus_id!=null && $req->has('status') && $req->status != null) {
                    $subQuery->where('campus_id', $req->campus_id)->Where('status', $req->status);
                    //checking each campus and status wirh status

                }
                elseif ($req->has('campus_id') && $req->campus_id!=null && $req->has('st_date')  && $req->has('end_date') && $req->st_date != null && $req->end_date != null)
                //checking each campus and date range
            {
                $subQuery->where('campus_id', $req->campus_id)->whereBetween('created_at', [$req->st_date, $req->end_date]);
            }
            elseif($req->has('st_date') && $req->has('end_date') && $req->st_date != null && $req->end_date != null && $req->status!=null && $req->has('status')){
                    //checking date and status
                    $subQuery->where('status', $req->status)->whereBetween('created_at', [$req->st_date, $req->end_date]);
                }
                 else {
                    if ($req->has('campus_id') && $req->campus_id != null) {
                        $subQuery->where('campus_id', $req->campus_id);
                    }
                    if ($req->has('status') &&  $req->status != null) {
                        $subQuery->where('status', $req->status);
                    }if($req->has('st_date') && $req->has('end_date') && $req->st_date != null && $req->end_date != null){

                        $subQuery->whereBetween('created_at', [$req->st_date, $req->end_date]);
                    }
                }
            }

        });

      $leads = $query->orderBy('created_at', 'desc')->get();
        $campuses = Campus::where('id', '!=', Auth::user()->campus_id)->get();

        return view('Admin.Enquiry.allenquiries', compact('title', 'all_enquiry', 'enquiry_open', 'enquiry', 'campuses', 'courses'))
            ->with('leads', json_decode($leads, true));
    }

}
