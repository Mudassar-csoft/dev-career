<?php

namespace App\Http\Controllers;

use App\Models\Campus;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class AllcampusController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function ownedCampus()
    {
        $title = 'Owned Campuses';
        $campus_open = 'open';
        $campus = 'active';
        $all_campus_open = 'open';
        $owned_campus = 'active';
        $campuses = Campus::where('campus_type', 'owned')->get();

        return view('Admin.Campus.ownedcampus', compact('title', 'campus_open', 'campus', 'all_campus_open', 'owned_campus', 'campuses'));
    }

    public function franchiseCampus()
    {
        $title = 'Franchise Campuses';
        $campus_open = 'open';
        $campus = 'active';
        $all_campus_open = 'open';
        $franchise_campus = 'active';
        $campuses = Campus::where('campus_type', 'franchise')->get();

        return view('Admin.Campus.franchisecampus', compact('title', 'campus_open', 'campus', 'all_campus_open', 'franchise_campus', 'campuses'));
    }

    public function suspendedCampus()
    {
        $title = 'Suspended Campuses';
        $campus_open = 'open';
        $campus = 'active';
        $suspended_campus = 'active';
        $campuses = Campus::onlyTrashed()->get();
        return view('Admin.Campus.suspendedcampus', compact('title', 'campus_open', 'campus', 'suspended_campus', 'campuses'));
    }

    public function restoreCampus($id)
    {
        $campus = Campus::withTrashed()->find($id);
        if (!is_null($campus)) {
            $campus->restore();
        }
        return redirect('suspended-campus')->with([
            'message' => 'Campus Restored Successfully!'
        ]);
    }

    public function forceDeleteCampus($id)
    {
        $campus = Campus::withTrashed()->find($id);
        if (!is_null($campus)) {
            $campus->forceDelete();
        }
        return redirect('suspended-campus');
    }

    public function allCampus()
    {
        $title = 'All Campuses';
        $campus_open = 'open';
        $campus = 'active';
        $all_campus_open = 'open';
        $all_campus = 'active';

        $campuses = Campus::all();

        return view('Admin.Campus.allcampus', compact('title', 'campus_open', 'campus', 'all_campus_open', 'all_campus', 'campuses'));
    }

    public function selectCity($city)
    {
        $city_count = Campus::withTrashed()->where('city_abbreviation', $city)->get()->count();
        $count = $city_count+1;
        if ($city_count < 10) {
            return response()->json([
                'campus_code' => "CI".$city."0".$count,
            ]);
        }else{
            return response()->json([
                'campus_code' => "CI".$city.$count,
            ]);
        }

    }

}
