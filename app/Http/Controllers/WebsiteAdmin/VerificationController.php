<?php

namespace App\Http\Controllers\WebsiteAdmin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\WebsiteAdmin\Verification;

class VerificationController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }
    public function index()
    {
        $title = "show Verification";
        $varifications = Verification::all();
        return view('WebsiteAdmin.Verification.index',compact('varifications','title'));
    }





}
