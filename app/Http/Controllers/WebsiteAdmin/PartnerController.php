<?php

namespace App\Http\Controllers\WebsiteAdmin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\WebsiteAdmin\Partner;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Mail;
use App\Mail\PartnerFormSubmitted;
use App\Mail\ResponseToPartner;

class PartnerController extends Controller
{
    public function store(Request $request)
    {
        // Validate the request
        $validate = Validator::make($request->all(), [
            'name' => 'required|alpha',
            'number' => 'required|numeric',
            'email' => 'required|email',
            'city' => 'required|string',
            'discription' => 'required',
        ]);

        // If validation fails, redirect back with errors
        if ($validate->fails()) {
            return redirect()->back()->withErrors($validate)->withInput();
        }

        // Create a new Partner record
        $partner = new Partner;
        $partner->name = $request->name;
        $partner->number = $request->number;
        $partner->email = $request->email;
        $partner->city = $request->city;
        $partner->discription = $request->discription;
        $partner->save();

        // Prepare email data
        $partnerDetails = [
            'name' => $request->name,
            'number' => $request->number,
            'email' => $request->email,
            'city' => $request->city,
            'discription' => $request->discription,
            'from_email' => env('MAIL_FROM_ADDRESS_SECOND', 'ajwa082@gmail.com'), // Default sender for user response
            'from_name' => env('MAIL_FROM_NAME_SECOND', 'Career ajwa'),
        ];

        // Send email to franchise@career.edu.pk using the primary mailer
        Mail::mailer('smtp')->to('franchise@career.edu.pk')->send(new PartnerFormSubmitted($partnerDetails));

        // Send response email to the user using the secondary mailer
        Mail::mailer('smtp2')->to($request->email)->send(new ResponseToPartner($partnerDetails));

        // Redirect with success message
        return redirect('/')->with([
            'message' => 'Your request has been submitted successfully!'
        ]);
    }

    public function show()
    {
        $title = "Partner";
        $partner = "active";
        $allpartner = Partner::all();
        return view('WebsiteAdmin.Partner.index', compact('title', 'partner', 'allpartner'));
    }
}
