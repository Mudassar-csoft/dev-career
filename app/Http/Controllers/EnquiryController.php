<?php

namespace App\Http\Controllers;

use App\Models\Lead;
use App\Models\Campus;
use App\Models\Country;
use App\Models\Program;
use App\Models\WebLead;
use App\Models\OldLeads;
use App\Models\LeadFollowUp;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Validator;

class EnquiryController extends Controller
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
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
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

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'program_id' => 'required',
            'primary_contact' => 'required|unique:leads,primary_contact,null,null|numeric',
            'gender' => 'required',
            'country_id' => 'required',
            'state_id' => 'required',
            'city' => 'required',
            'marketing_source' => 'required',
            'campus_id' => 'required',
            'next_follow_up' => 'required|date',
            'probability' => 'required',
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
            $lead->name = $request->input('name');
            $lead->primary_contact = $request->input('primary_contact');
            $lead->guardian_contact = $request->input('guardian_contact');
            $lead->email = $request->input('email');
            $lead->country_id = $request->input('country_id');
            $lead->state_id = $request->input('state_id');
            $lead->city = $request->input('city');
            $lead->area = $request->input('area');
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
            // Web Lead's Status Update

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
            return redirect('/all-enquiries')->with([
                'message' => 'Lead Added Successfully!'
            ]);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $title = "Lead's Profile";
        $enquiry_open = 'open';
        $enquiry = 'active';
        $lead = Lead::with('program', 'campus', 'country', 'state', 'leadFollowUp')->find($id);
        $lead_follow_up = LeadFollowUp::where('lead_id', $id)->with('lead', 'user', 'campus')->get();

        return view('Admin.Enquiry.leadview', compact('title', 'enquiry_open', 'enquiry', 'lead', 'lead_follow_up'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $title = 'Edit Lead';
        $enquiry_open = 'open';
        $enquiry = 'active';
        $programmes = Program::where('status', 'On Going')->get();
        $data['countries'] = Country::get(["name", "id"]);
        $campuses = Campus::all();
        $lead = Lead::with('program', 'campus', 'country', 'state')->find($id);

        return view('Admin.Enquiry.editlead', $data, compact('title', 'enquiry_open', 'enquiry', 'programmes', 'campuses', 'lead'));
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
        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'program_id' => 'required',
            'primary_contact' => 'required',
            'gender' => 'required',
            'country_id' => 'required',
            'state_id' => 'required',
            'city' => 'required',
            'marketing_source' => 'required',
            'campus_id' => 'required',
            'probability' => 'required',
        ]);

        if ($validator->fails()) {
            return Redirect::back()->withErrors($validator);
        }else{
            $lead = Lead::find($id);
            $lead->program_id = $request->input('program_id');
            $lead->campus_id = $request->input('campus_id');
            $lead->status = $request->input('status');
            $lead->name = $request->input('name');
            $lead->primary_contact = $request->input('primary_contact');
            $lead->guardian_contact = $request->input('guardian_contact');
            $lead->email = $request->input('email');
            $lead->country_id = $request->input('country_id');
            $lead->state_id = $request->input('state_id');
            $lead->city = $request->input('city');
            $lead->area = $request->input('area');
            $lead->gender = $request->input('gender');
            $lead->marketing_source = $request->input('marketing_source');
            $lead->probability = $request->input('probability');
            $lead->remarks = $request->input('remarks');
            $lead->save();
            return redirect('/all-enquiries')->with([
                'message' => 'Lead Updated Successfully!'
            ]);
        }
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
