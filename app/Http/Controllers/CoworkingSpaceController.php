<?php

namespace App\Http\Controllers;

use App\Models\WebsiteAdmin\CoworkingSpace;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Mail;
use App\Mail\CoworkingSpaceMail;


class CoworkingSpaceController extends Controller
{
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
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        
        $data = CoworkingSpace::updateOrCreate(['id' => $request->id], $request->all());
        //dd($data);
        $emailData = [
            'name' => $data->name,
            'email' => $data->email,
            'no_of_persons' => $data->no_of_persons,
            'city' => $data->city,
            'contact' => $data->contact,
            'space' => $data->space,
        ];
       // dd($emailData);
        Mail::mailer('account3')->to('workspace@career.edu.pk')->send(new CoworkingSpaceMail($emailData));
        return redirect('/sharedWorkspace')->with([
            'message' => 'Requests submitted successfully!'
        ]);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\WebsiteAdmin\CoworkingSpace  $coworkingSpace
     * @return \Illuminate\Http\Response
     */
    public function show(CoworkingSpace $coworkingSpace)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\WebsiteAdmin\CoworkingSpace  $coworkingSpace
     * @return \Illuminate\Http\Response
     */
    public function edit(CoworkingSpace $coworkingSpace)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\WebsiteAdmin\CoworkingSpace  $coworkingSpace
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, CoworkingSpace $coworkingSpace)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\WebsiteAdmin\CoworkingSpace  $coworkingSpace
     * @return \Illuminate\Http\Response
     */
    public function destroy(CoworkingSpace $coworkingSpace)
    {
        //
    }
}
