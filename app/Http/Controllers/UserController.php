<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Campus;
use Illuminate\Http\Request;
use App\Mail\VerificationMail;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Validator;

class UserController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function addUser()
    {
        $title = 'Add User';
        $user_open = 'open';
        $user = 'active';
        $add_user = 'active';

        $campuses = Campus::all();

        if (Auth::user()->role == "Super Admin") {
            return view('Admin.User.adduser', compact('title', 'user_open', 'user', 'add_user', 'campuses'));
        }else{
            return redirect()->route('home')->with([
                'error' => "Access Denied",
            ]);
        }
    }

    public function manageUser()
    {
        Session::forget('token');
        $title = 'Manage Users';
        $user_open = 'open';
        $user = 'active';
        $manage_user = 'active';
        $users = User::with('campus')->get();
        // $campuses = Campus::with('user')->get();

        if (Auth::user()->role == "Super Admin") {
            return view('Admin.User.manageuser', compact('title', 'user_open', 'user', 'manage_user', 'users'));
        }else{
            return redirect()->route('home')->with([
                'error' => "Access Denied",
            ]);
        }
    }

    public function userProfile($id)
    {
        $title = 'User Profile';
        $user_open = 'open';
        $user = 'active';
        $users = User::with('campus')->find($id);

        return view('Admin.User.userprofile', compact('title', 'user_open', 'user', 'users'));
    }

    public function edit($id)
    {
        if (Session::has('token')) {
            Session::forget('token');
            $title = 'Edit User';
            $user_open = 'open';
            $user = 'active';
            $campuses = Campus::all();
            $users = User::find($id);

            return view('Admin.User.edituser', compact('title', 'user_open', 'user', 'campuses', 'users'));
        }
        else{
            return redirect()->route('manageUser')->with([
                'error' => 'Access Denied'
            ]);
        }
    }

    public function update(Request $req, $id)
    {
        if (!$req->password) {
            $user = User::find($id);
            $user->name = $req->input('name');
            $user->email = $req->input('email');
            if ($req->campus_id) {
                $user->campus_id = $req->input('campus_id');
            }
            $user->role = $req->input('role');
            $user->remarks = $req->input('remarks');
            $user->save();
            return redirect('/manage-users')->with([
                'message' => 'User Updated Successfully!'
            ]);
        }else{
            $validator = Validator::make($req->all(), [
                'password' => 'min:8',
                'password_confirmation' => 'same:password',
            ]);
            if ($validator->fails()) {
                return Redirect::back()->with([
                    'error' => 'Password error!'
                ])->withErrors($validator);
            }else{
                $user = User::find($id);
                $user->name = $req->input('name');
                $user->email = $req->input('email');
                if ($user->password) {
                    $user->password = Hash::make($req['password']);
                }
                if ($req->campus_id) {
                    $user->campus_id = $req->input('campus_id');
                }
                $user->role = $req->input('role');
                $user->remarks = $req->input('remarks');
                $user->save();
                return redirect('/manage-users')->with([
                    'message' => 'User Updated Successfully!'
                ]);
            }
        }
    }

    public function loginAs($id)
    {
        if (Auth::user()->role == 'Super Admin') {
        $user = User::where('id', $id)->first();
        session()->put('isAdmin', 1);
        session()->put('adminID', Auth::id());
        if (Auth::loginUsingId($user->id)) {
            return redirect('/home');
        }
        }else{
            return redirect()->back();
        }
    }

    public function verificationEmail($id)
    {
        if (!session()->has('token')) {
            $token = sprintf("%06d", mt_rand(1, 999999));
            Session::put('token', $token);
            $emails = new VerificationMail($token);
            Mail::to('adeeljavaid.pk@gmail.com')->send($emails);
            // Mail::to(Auth::user()->email)->send($emails);
        }

        $title = 'Verification';
        $user_open = 'open';
        $user = 'active';
        $user_id = $id;
        return view('Admin.User.verification', compact('title', 'user_open', 'user', 'user_id'));
    }

    public function resendEmail($id)
    {
        Session::forget('token');
        $token = sprintf("%06d", mt_rand(1, 999999));
        Session::put('token', $token);
        $emails = new VerificationMail($token);
        Mail::to('adeeljavaid.pk@gmail.com')->send($emails);
        // Mail::to(Auth::user()->email)->send($emails);
        $user_id = $id;
        return redirect()->route('verificationEmail', $user_id)->with([
            'error' => 'Email Sent'
        ]);
    }

    public function verifyEmail(Request $req, $id)
    {
        if ($req->token == Session::get('token')) {
            return redirect()->route('editUser', $id);
        }else{
            return redirect()->route('verificationEmail', $id)->with([
                'message' => 'Invalid OTP'
            ]);
        }
    }

}
