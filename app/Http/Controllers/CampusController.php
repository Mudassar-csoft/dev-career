<?php

namespace App\Http\Controllers;

use Redirect;
use Response;
use Validator;
use App\Models\Campus;
use App\Models\Country;
use Illuminate\Http\Request;

class CampusController extends Controller
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
        $title = 'Create Campus';
        $campus_open = 'open';
        $campus = 'active';
        $create_campus = 'active';
        $data['countries'] = Country::get(["name", "id"]);

        return view('Admin.Campus.addnewcampus', $data, compact('title', 'campus_open', 'campus', 'create_campus',));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        if ($request->hasFile('owner_cnic')) {
            $owner_cnic = asset('storage/'. $request->owner_cnic->store('allUploadedFiles'));
        }
        if ($request->hasFile('rent_deed')) {
            $rent_deed = asset('storage/'. $request->rent_deed->store('allUploadedFiles'));
        }
        if ($request->hasFile('building_map')) {
            $building_map = asset('storage/'. $request->building_map->store('allUploadedFiles'));
        }
        if ($request->hasFile('electricity_bill')) {
            $electricity_bill = asset('storage/'. $request->electricity_bill->store('allUploadedFiles'));
        }
        if ($request->hasFile('building_front')) {
            $building_front = asset('storage/'. $request->building_front->store('allUploadedFiles'));
        }
        if ($request->hasFile('building_right_side')) {
            $building_right_side = asset('storage/'. $request->building_right_side->store('allUploadedFiles'));
        }
        if ($request->hasFile('building_left_side')) {
            $building_left_side = asset('storage/'. $request->building_left_side->store('allUploadedFiles'));
        }

        $campus = new Campus();
        $campus->campus_title = $request->input('campus_title');
        $campus->campus_code = $request->input('campus_code');
        $campus->country_id = $request->input('country');
        $campus->state_id = $request->input('state');
        $campus->city = $request->input('city');
        $campus->city_abbreviation = $request->input('city_abbreviation');
        $campus->campus_landline_number = $request->input('campus_landline_number');
        $campus->campus_mobile_number = $request->input('campus_mobile_number');
        $campus->campus_email_address = $request->input('campus_email_address');
        $campus->campus_address = $request->input('campus_address');
        $campus->labs_in_campus = $request->input('labs_in_campus');
        $campus->status = $request->input('status');
        $campus->campus_type = $request->input('campus_type');
        if ($request->owner_cnic) {
            $campus->owner_cnic = $owner_cnic;
        }
        if ($request->rent_deed) {
            $campus->rent_deed = $rent_deed;
        }
        if ($request->building_map) {
            $campus->building_map = $building_map;
        }
        if ($request->electricity_bill) {
            $campus->electricity_bill = $electricity_bill;
        }
        if ($request->building_front) {
            $campus->building_front = $building_front;
        }
        if ($request->building_right_side) {
            $campus->building_right_side = $building_right_side;
        }
        if ($request->building_left_side) {
            $campus->building_left_side = $building_left_side;
        }
        $campus->remarks = $request->input('remarks');
        $campus->save();

        return redirect('/all-campus')->with([
            'message' => 'Campus Added Successfully!'
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
        $title = 'Campus Details';
        $campus_open = 'open';
        $campus = 'active';
        $all_campus_open = 'open';
        $campuses = Campus::with('country', 'state')->find($id);

        return view('Admin.Campus.campusdetails', compact('title', 'campus_open', 'campus', 'all_campus_open', 'campuses'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $title = 'Edit Campus';
        $campus_open = 'open';
        $campus = 'active';
        $all_campus_open = 'open';
        $data['countries'] = Country::get(["name", "id"]);
        $campuses = Campus::with('country', 'state')->find($id);

        return view('Admin.Campus.editcampus', $data, compact('title', 'campus_open', 'campus', 'all_campus_open', 'campuses'));
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
        if ($request->hasFile('owner_cnic')) {
            $owner_cnic = asset('storage/'. $request->owner_cnic->store('allUploadedFiles'));
        }
        if ($request->hasFile('rent_deed')) {
            $rent_deed = asset('storage/'. $request->rent_deed->store('allUploadedFiles'));
        }
        if ($request->hasFile('building_map')) {
            $building_map = asset('storage/'. $request->building_map->store('allUploadedFiles'));
        }
        if ($request->hasFile('electricity_bill')) {
            $electricity_bill = asset('storage/'. $request->electricity_bill->store('allUploadedFiles'));
        }
        if ($request->hasFile('building_front')) {
            $building_front = asset('storage/'. $request->building_front->store('allUploadedFiles'));
        }
        if ($request->hasFile('building_right_side')) {
            $building_right_side = asset('storage/'. $request->building_right_side->store('allUploadedFiles'));
        }
        if ($request->hasFile('building_left_side')) {
            $building_left_side = asset('storage/'. $request->building_left_side->store('allUploadedFiles'));
        }

        $campus = Campus::find($id);
        $campus->campus_title = $request->input('campus_title');
        $campus->campus_code = $request->input('campus_code');
        $campus->country_id = $request->input('country');
        $campus->state_id = $request->input('state');
        $campus->city = $request->input('city');
        $campus->city_abbreviation = $request->input('city_abbreviation');
        $campus->campus_landline_number = $request->input('campus_landline_number');
        $campus->campus_mobile_number = $request->input('campus_mobile_number');
        $campus->campus_email_address = $request->input('campus_email_address');
        $campus->campus_address = $request->input('campus_address');
        $campus->labs_in_campus = $request->input('labs_in_campus');
        $campus->status = $request->input('status');
        $campus->campus_type = $request->input('campus_type');
        if ($request->owner_cnic) {
            $campus->owner_cnic = $owner_cnic;
        }
        if ($request->rent_deed) {
            $campus->rent_deed = $rent_deed;
        }
        if ($request->building_map) {
            $campus->building_map = $building_map;
        }
        if ($request->electricity_bill) {
            $campus->electricity_bill = $electricity_bill;
        }
        if ($request->building_front) {
            $campus->building_front = $building_front;
        }
        if ($request->building_right_side) {
            $campus->building_right_side = $building_right_side;
        }
        if ($request->building_left_side) {
            $campus->building_left_side = $building_left_side;
        }
        $campus->remarks = $request->input('remarks');
        $campus->save();

        return redirect()->route('campus.show', $id)->with([
            'message' => 'Campus Updated Successfully!'
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
        $campus = Campus::find($id);
        if (!is_null($campus)) {
            $campus->delete();
        }
        return redirect('all-campus')->with([
            'message' => 'Campus Suspended Successfully!'
        ]);
    }
}
