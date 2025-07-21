<?php

namespace App\Http\Controllers;

use App\Models\DiscountLimit;
use App\Models\Program;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LimitController extends Controller
{
    //

    public function create()
    {
        $title = 'Discount Limit';
        $limit_open = 'open';
        $course = 'active';
        $create_course = 'active';
        $limits = DiscountLimit::with('program', 'user')->get();
        $programs = Program::where('status', 'On Going')->latest()->get();
        $users = User::all();
        return view('Admin.discountlimit.addlimit', compact('programs', 'users', 'title', 'limits'));
    }
    public function store(Request $request)
    {
        $program_id = $request->program_id;
        $title = 'Discount Limit';
        $limit_open = 'open';
        $course = 'active';
        $create_course = 'active';
        $user_id = $request->user_id;
        $discount = $request->discount;
        $limit = new DiscountLimit();
        $limit->program_id = $program_id;
        $limit->user_id = $user_id;
        $limit->discount = $discount;
        if ($limit->save()) {
            $limits = DiscountLimit::with('program', 'user')->get();
            $programs = Program::where('status', 'On Going')->latest()->get();
            $users = User::all();
            return view('Admin.discountlimit.addlimit', compact('title', 'limits', 'programs', 'users'));
        }
    }
    public function checkuserexists(Request $req)
    {
        if ($req->user_id && $req->program_id) {
            $limit = DiscountLimit::where('user_id', $req->user_id)->where('program_id', $req->program_id)->count();
            if ($limit > 0) {
                return response()->json([['exists' => true]]);
            } else {
                return response()->json([['exists' => false]]);
            }
        }
    }
    public function getDiscountPercentage(Request $request)
    {
        if(Auth::user()->role=='Super Admin'){
            return response()->json(['percentage' => 100]);
        }else{
            if ($request->user_id && $request->program_id) {
                $limit = DiscountLimit::where('user_id', $request->user_id)
                    ->where('program_id', $request->program_id)
                    ->first();
                $percentage = $limit ? $limit->discount : 50;
                return response()->json(['percentage' => $percentage]);
            }
        }

    }
}
