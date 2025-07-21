<?php

namespace App\Http\Controllers;

use App\Models\Admission;
use App\Models\Campus;
use App\Models\FeeCollection;
use App\Models\Lead;
use App\Models\Program;
use App\Models\Registration;
use App\Models\WebLead;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\Request;
use Illuminate\Queue\NullQueue;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Validator;
use SebastianBergmann\Type\NullType;

class RegisterationController extends Controller
{
    public function add_user()
    {
        $title = 'Add Bill Type';
        $newbill = 'open';
        $expense = 'active';
        $newbill = 'active';
        $campuses = Campus::all();
        return view('Admin.User.add_new_user', compact('title', 'campuses', 'newbill', 'expense', 'newbill'));
    }
    public function create($id)
    {
        $lead = Lead::find($id);
        // dd($lead);
        $alreadyregistered = Registration::where('lead_id', $id)->count();
        if ($alreadyregistered > 0) {
            return redirect()->back()->with('error', 'This lead is already registered');
        }else{



        $title = 'New Admission';
        $registeration_open = 'open';
        $registeration = 'active';
        $new_registeration = 'active';
        $year = date('my');
        $programmes = Program::where('status', 'On Going')->get();
        if (Auth::user()->role == 'Super Admin') {
            $campus_id = Campus::find($lead->campus_id);
            $reg_count = Registration::where('campus_id', $campus_id->id)->get()->count();
            $campus = Campus::where('id', $campus_id->id)->get();
            $fee_count = FeeCollection::where('campus_id', $campus_id->id)->where('status', 'Clear')->get()->count();
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
            $campuses = Campus::all();
            return view('Admin.Registeration.newregisteration', compact('title', 'registeration_open', 'registeration', 'new_registeration', 'programmes', 'campuses', 'lead', 'registration_no', 'receipt_number', 'id'));
        } else {
            $reg_count = Registration::where('campus_id', Auth::user()->campus_id)->get()->count();
            $campus = Campus::where('id', Auth::user()->campus_id)->get();
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
            return view('Admin.Registeration.newregisteration', compact('title', 'registeration_open', 'registeration', 'new_registeration', 'programmes', 'registration_no', 'receipt_number', 'lead', 'id'));
        }
    }
    }
    public function regandreceptapi(Request $request)
    {
        $campus_id = $request->campus_id;
        $campus = Campus::where('id', $campus_id)->first();
        $reg_count = Registration::where('campus_id', $campus_id)->get()->count();
        $campus_code = $campus->campus_code;
        $year = date('my');
        $fee_count = FeeCollection::where('campus_id', $campus_id)->where('status', 'Clear')->get()->count();
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
        return response()->json([
            'reg' => $registration_no,
            'rec' => $receipt_number
        ]);
    }
    public function store(Request $request)
    {

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
        $registration->lead_id = $request->lead_id;
        $registration->gender = $request->input('gender');
        $registration->education = $request->input('education');
        $registration->remarks = $request->input('remarks');
        $registration->save();
        if ($registration) {
            $registration_id = $registration->id;
            $fee = new FeeCollection();
            $fee->registration_id = $registration_id;
            $fee->admission_id = null;
            $fee->user_id = $request->input('user_id');
            $fee->campus_id = $request->input('campus_id');
            $fee->admission_date = $request->input('admission_date');
            $fee->pay_date = $request->admission_date;
            $fee->fee_type = 'Registration';
            $fee->total_amount = $request->registration_fee;
            $fee->registration_amount = $request->input('registration_fee');
            $fee->paid_amount = $request->registration_fee;
            $fee->status = 'Clear';
            $fee->receipt_number = $request->input('receipt_number');
            $fee->save();
            if ($fee) {
                $lead_id = $request->lead_id;
                $lead = Lead::find($lead_id);
                $lead->status = 'Registered';
                $lead->save();
            }
        }

        $title = "Today's Registration";
        $registration_open = 'open';
        $registration = 'active';
        $today_registeration = 'active';
        $date = date('Y-m-d');
        if (Auth::user()->role == 'Super Admin' || Auth::user()->role == 'Admin' || Auth::user()->role == 'Telesales Representative' || Auth::user()->role == 'Business Operations Manager' || Auth::user()->role == 'Admin & Finance') {
            $leads = Registration::with('campus')->whereDate('created_at', $date)->get();
        } else {
            $leads = Lead::with('campus')->whereDate('created_at', $date)->where('campus_id', Auth::user()->campus_id)->get();
        }
        $campuses = Campus::where('id', '!=', Auth::user()->campus_id)->get();
        return view('Admin.Registeration.todayaregisteration', compact('title', 'today_registeration', 'registration_open', 'registration', 'campuses', 'leads'));
    }
    public function todayregistration()
    {
        $title = "Today's Registration";
        $registration_open = 'open';
        $registration = 'active';
        $today_registeration = 'active';
        $date = date('Y-m-d');
        if (Auth::user()->role == 'Super Admin' || Auth::user()->role == 'Admin' || Auth::user()->role == 'Telesales Representative' || Auth::user()->role == 'Business Operations Manager' || Auth::user()->role == 'Admin & Finance') {
            $leads = Registration::with('campus')->whereDate('created_at', $date)->get();
        } else {
            $leads = Lead::with('campus')->whereDate('created_at', $date)->where('campus_id', Auth::user()->campus_id)->get();
        }
        $campuses = Campus::where('id', '!=', Auth::user()->campus_id)->get();
        return view('Admin.Registeration.todayaregisteration', compact('title', 'today_registeration', 'registration_open', 'registration', 'campuses', 'leads'));
    }
    public function currentmonthRegisteration()
    {
        $title = "This Month Registration";
        $registration_open = 'open';
        $registration = 'active';
        $current_month_registration = 'active';
        $month_start = date('Y-m-01');
        $month_end = date('Y-m-31');
        if (Auth::user()->role == 'Super Admin' || Auth::user()->role == 'Admin' || Auth::user()->role == 'Telesales Representative' || Auth::user()->role == 'Business Operations Manager' || Auth::user()->role == 'Admin & Finance') {
            $admissions = Registration::where('created_at', '>=', $month_start)->where('created_at', '<=', $month_end)->with('campus')->orderBy('id', 'desc')->get();
        } else {
            $admissions = Registration::where('created_at', '>=', $month_start)->where('created_at', '<=', $month_end)->where('campus_id', Auth::user()->campus_id)->with('campus')->orderBy('id', 'desc')->get();
        }
        return view('Admin.Registeration.thismonthregisteration', compact('title', 'registration_open', 'registration', 'current_month_registration', 'admissions'));
    }

    public function currentyearRegisteration()
    {
        $title = "Today's Registration";
        $registration_open = 'open';
        $registration = 'active';
        $current_year_registration = 'active';
        $month_start = date('Y-m-01');
        $month_end = date('Y-m-31');

        $year_start = date('Y-01-01');
        $year_end = date('Y-12-31');

        if (Auth::user()->role == 'Super Admin' || Auth::user()->role == 'Admin' || Auth::user()->role == 'Telesales Representative' || Auth::user()->role == 'Business Operations Manager' || Auth::user()->role == 'Admin & Finance') {
            $admissions = Registration::where('created_at', '>=', $year_start)->where('created_at', '<=', $year_end)->with('campus')->orderBy('id', 'desc')->get();
        } else {
            $admissions = Registration::where('created_at', '>=', $year_start)->where('created_at', '<=', $year_end)->where('campus_id', Auth::user()->campus_id)->with('campus')->orderBy('id', 'desc')->get();
        }
        return view('Admin.Registeration.thisyearregisteration', compact('title', 'registration_open', 'registration', 'current_year_registration', 'admissions'));
    }
    //admissions methodes

    public function admissioncreate($id = null)
    {
        $title = 'New Admission';
        $admission_open = 'open';
        $admission = 'active';
        $new_admission = 'active';
        $campuses = '';
        $year = date('y');
        $programmes = Program::where('status', 'On Going')->get();
        $reg_count = Registration::where('campus_id', Auth::user()->campus_id)->get()->count();
        $registration = Registration::find($id);

        if (Auth::user()->role == 'Super Admin' || Auth::user()->role == 'Business Operations Manager' || Auth::user()->role == 'Admin & Finance') {
            $campus = Campus::all();
            $campus_id = $registration->campus_id;
            $campus = Campus::where('id', $campus_id)->get();
            $fee_count = FeeCollection::where('campus_id', $campus_id)->where('status', 'Clear')->get()->count();

            $campuses = Campus::all();
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

        return view('Admin.Admission.newadmission', compact('title', 'admission_open', 'admission', 'new_admission', 'programmes', 'registration_no', 'receipt_number', 'campuses', 'registration'));
    }
    public function admissionstore(Request $request)
    {
        // dd($request->registration_id);

        if ($request->input('fee_type') == 'Installment') {
            $total = $request->first_installment + $request->second_installment + $request->third_installment;
            if ($request->input('discounted_fee') != $total) {
                return redirect()->back()->with([
                    'message' => 'Installments are not equal to discounted fee!'
                ]);
            }
        }
        $date = date('Y-m-d');
        $due_date = date('Y-m-d', strtotime('+30 days'));
        $second_due_date = date('Y-m-d', strtotime('+60 days'));
        $validator = Validator::make($request->all(), [
            // 'roll_number' => 'unique:admissions,roll_number,null,null',
            // 'receipt_number' => 'unique:fee_collections,receipt_number,null,null',
        ]);
        if ($validator->fails()) {
            return Redirect::back()->with([
                'message' => 'Something went wrong!!'
            ])->withErrors($validator);
        } else {
            $registration_id = $request->registration_id;
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
                  $registeration=Registration::where('id',$request->registration_id)->update([
'status'=>'Enrolled'
                ]);
                if (isset($request->wenadmissionid)) {
                    $leads = WebLead::where('id', $request->wenadmissionid)->update([
                        'status' => 'Enrolled',
                    ]);
                }
            }
            if ($admission->save()) {
                $registration_id = $request->registration_id;
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
                    $fee->registration_amount =0;
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
                        $fee->registration_amount =0;
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
                        $fee->registration_amount = 0;
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
