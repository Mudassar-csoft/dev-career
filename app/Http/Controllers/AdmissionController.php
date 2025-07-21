<?php

namespace App\Http\Controllers;

use App\Models\Campus;
use App\Models\Program;
use App\Models\WebLead;
use App\Models\Admission;
use App\Models\Registration;
use Illuminate\Http\Request;
use App\Models\FeeCollection;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Validator;

class AdmissionController extends Controller
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
        $title = 'New Admission';
        $admission_open = 'open';
        $admission = 'active';
        $new_admission = 'active';
        $campuses='';
        $year = date('y');
        $programmes = Program::where('status', 'On Going')->get();
        $reg_count = Registration::where('campus_id', Auth::user()->campus_id)->get()->count();
         if (Auth::user()->role == 'Super Admin' ||
                                    Auth::user()->role == 'Admin' ||
                                    Auth::user()->role == 'Telesales Representative' ||
                                    Auth::user()->role == 'Business Operations Manager' ||
                                    Auth::user()->role == 'Admin & Finance') {
            $campus = Campus::all();
            $campuses = Campus::all();
        } else {

            $campus = Campus::where('id', Auth::user()->campus_id)->get();
        }
        $fee_count = FeeCollection::where('campus_id', Auth::user()->campus_id)->where('status', 'Clear')->get()->count();
        foreach ($campus as $data) {
        }
        $campus_code = $data->campus_code;
        if ($reg_count < 10) {
            $registration_no = $campus_code . '-' . $year . '-' . '0' . ($reg_count + 1);
        } else {
            $registration_no = $campus_code . '-' . $year . '-' . ($reg_count + 1);
        }

        if ($fee_count < 9) {
            $receipt_number = $campus_code . '-' . $year . '-' . '00000' . ($fee_count + 1);
        } elseif ($fee_count < 99) {
            $receipt_number = $campus_code . '-' . $year . '-' . '0000' . ($fee_count + 1);
        } elseif ($fee_count < 999) {
            $receipt_number = $campus_code . '-' . $year . '-' . '000' . ($fee_count + 1);
        } elseif ($fee_count < 9999) {
            $receipt_number = $campus_code . '-' . $year . '-' . '00' . ($fee_count + 1);
        } elseif ($fee_count < 99999) {
            $receipt_number = $campus_code . '-' . $year . '-' . '0' . ($fee_count + 1);
        } else {
            $receipt_number = $campus_code . '-' . $year . '-' . ($fee_count + 1);
        }

        return view('Admin.Admission.newadmission', compact('title', 'admission_open', 'admission', 'new_admission', 'programmes', 'registration_no', 'receipt_number','campuses'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
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
            'primary_contact' => 'unique:registrations,primary_contact,null,null|numeric',
            'cnic' => 'unique:registrations,cnic,null,null',
            'registration_number' => 'unique:registrations,registration_number,null,null',
            'roll_number' => 'unique:admissions,roll_number,null,null',
            'receipt_number' => 'unique:fee_collections,receipt_number,null,null',
        ]);
        if ($validator->fails()) {
            return Redirect::back()->with([
                'message' => 'Something went wrong!!'
            ])->withErrors($validator);
        } else {
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
                    if (isset($request->wenadmissionid)) {
                        $leads = WebLead::where('id', $request->wenadmissionid)->update([
                            'status' => 'Enrolled',
                        ]);
                    }
                }
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
                        return redirect()->route('admission.show', $registration_id)->with([
                            'message' => 'Admission successfull with full fee!'
                        ]);
                    } elseif ($request->input('fee_type') == 'Installment') {
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
                            return redirect()->route('admission.show', $registration_id)->with([
                                'message' => 'Admission successfull with 2 installments!'
                            ]);
                        } elseif ($request->input('third_installment') > 0) {
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

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $title = 'Student Profile';
        $admission_open = 'open';
        $admission = 'active';
        $student = Registration::find($id);
        $registrations = Registration::where('id', $id)->with('fee', 'admission')->get();
        $students = Admission::with('registration', 'program', 'fee')->where('registration_id', $id)->get();
        $fees = FeeCollection::where('registration_id', $id)->with('registration', 'admission')->get();
        // counting admission of single student in different courses
        $total_course = $students->count();

        // counting paid amount
          $paid_amount = FeeCollection::where('registration_id', $id)
        ->where('status', 'clear')
        ->where('registration_amount', 0)
        ->sum('paid_amount');
        $registeration_amount = FeeCollection::where('registration_id', $id)->where('status', 'clear')->sum('registration_amount');
        $total_amount_paid = $registeration_amount + $paid_amount;

        // counting pending amount
        $pending_amount = FeeCollection::where('registration_id', $id)->where('status', 'Pending')->sum('paid_amount');

        return view('Admin.Admission.studentprofile', compact('title', 'admission_open', 'admission', 'students', 'registrations', 'fees', 'total_course', 'total_amount_paid', 'student', 'pending_amount'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $title = 'Edit Student Profile';
        $admission_open = 'open';
        $admission = 'active';

        $student = Registration::with('admission')->find($id);
        if (!$student) {
            return redirect()->back()->with([
                'message' => 'Something went wrong!'
            ]);
        } else {
            return view('Admin.Admission.editregisteration', compact('title', 'admission_open', 'admission', 'student'));
        }
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
        $registration = Registration::find($id);
        if (!$registration) {
            return redirect()->back()->with([
                'message' => 'Something went wrong!'
            ]);
        } else {
            $registration->name = $request->input('name');
            $registration->primary_contact = $request->input('primary_contact');
            $registration->guardian_name = $request->input('guardian_name');
            $registration->guardian_contact = $request->input('guardian_contact');
            $registration->cnic = $request->input('cnic');
            $registration->email = $request->input('email');
            $registration->address = $request->input('address');
            $registration->dob = $request->input('dob');
            $registration->gender = $request->input('gender');
            $registration->education = $request->input('education');
            $registration->save();

            return redirect()->route('admission.show', $id)->with([
                'message' => 'Student profile updated successfully!'
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
