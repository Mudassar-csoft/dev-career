<?php

namespace App\Http\Controllers;

use App\Models\Batch;
use App\Models\Campus;
use App\Models\Program;
use App\Models\OldAdmission;
use App\Models\Admission;
use App\Models\Registration;
use Illuminate\Http\Request;
use App\Models\FeeCollection;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Validator;

class OtherAdmissionController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function todayAdmission()
    {
        $title = "Today's Admission";
        $admission_open = 'open';
        $admission = 'active';
        $today_admission = 'active';
        $today_date = date('Y-m-d');

        if (Auth::user()->role == 'Super Admin' || Auth::user()->role == 'Admin' || Auth::user()->role == 'Telesales Representative' || Auth::user()->role == 'Business Operations Manager' || Auth::user()->role == 'Admin & Finance') {
            $admissions = Admission::where('admission_date', $today_date)->with('registration', 'program', 'campus')->orderBy('id', 'desc')->get();
        } else {
            $admissions = Admission::where('admission_date', $today_date)->where('campus_id', Auth::user()->campus_id)->with('registration', 'program', 'campus')->orderBy('id', 'desc')->get();
        }

        return view('Admin.Admission.todayadmission', compact('title', 'admission_open', 'admission', 'today_admission'))->with('admissions', json_decode($admissions, true));
    }

    public function currentMonthAdmission()
    {
        $title = "Current Month Admissions";
        $admission_open = 'open';
        $admission = 'active';
        $current_month_admission = 'active';
        $month_start = date('Y-m-01');
        $month_end = date('Y-m-31');

        if (Auth::user()->role == 'Super Admin' || Auth::user()->role == 'Admin' || Auth::user()->role == 'Telesales Representative' || Auth::user()->role == 'Business Operations Manager' || Auth::user()->role == 'Admin & Finance') {
            $admissions = Admission::where('admission_date', '>=', $month_start)->where('admission_date', '<=', $month_end)->with('registration', 'program', 'campus')->orderBy('id', 'desc')->get();
        } else {
            $admissions = Admission::where('admission_date', '>=', $month_start)->where('admission_date', '<=', $month_end)->where('campus_id', Auth::user()->campus_id)->with('registration', 'program', 'campus')->orderBy('id', 'desc')->get();
        }

        return view('Admin.Admission.currentmonthadmission', compact('title', 'admission_open', 'admission', 'current_month_admission'))->with('admissions', json_decode($admissions, true));
    }

    public function currentYearAdmission()
    {
        $title = "Current Year Admissions";
        $admission_open = 'open';
        $admission = 'active';
        $current_year_admission = 'active';
        $year_start = date('Y-01-01');
        $year_end = date('Y-12-31');

        if (Auth::user()->role == 'Super Admin' || Auth::user()->role == 'Admin' || Auth::user()->role == 'Telesales Representative' || Auth::user()->role == 'Business Operations Manager' || Auth::user()->role == 'Admin & Finance') {
            $admissions = Admission::where('admission_date', '>=', $year_start)->where('admission_date', '<=', $year_end)->with('registration', 'program', 'campus')->orderBy('id', 'desc')->get();
        } else {
            $admissions = Admission::where('admission_date', '>=', $year_start)->where('admission_date', '<=', $year_end)->where('campus_id', Auth::user()->campus_id)->with('registration', 'program', 'campus')->orderBy('id', 'desc')->get();
        }

        return view('Admin.Admission.currentyearadmission', compact('title', 'admission_open', 'admission', 'current_year_admission'))->with('admissions', json_decode($admissions, true));
    }

    public function allAdmission()
    {
        $title = "All Admissions";
        $admission_open = 'open';
        $admission = 'active';
        $all_admission = 'active';

        if (Auth::user()->role == 'Super Admin' || Auth::user()->role == 'Admin' || Auth::user()->role == 'Telesales Representative' || Auth::user()->role == 'Business Operations Manager' || Auth::user()->role == 'Admin & Finance') {
            $admissions = Admission::with('registration', 'program', 'campus')->orderBy('id', 'desc')->get();
        } else {
            $admissions = Admission::where('campus_id', Auth::user()->campus_id)->with('registration', 'program', 'campus')->orderBy('id', 'desc')->get();
        }

        return view('Admin.Admission.alladmission', compact('title', 'admission_open', 'admission', 'all_admission'))->with('admissions', json_decode($admissions, true));
    }

    public function fetchBadge($id, $campus_id=null)
    {
        $start_date = date('Y-m-d', strtotime('-31 days'));
        $current_date = date('Y-m-d');
        if (Auth::user()->role == 'Super Admin' || Auth::user()->role == 'Business Operations Manager' || Auth::user()->role == 'Admin & Finance') {
            $campusidd = $campus_id;
        } else {

            $campusidd = Auth::user()->campus_id;
        }
        $batches = Batch::where('program_id', $id)->where('status', 'Not Suspended')->where('campus_id', $campusidd)->where('start_date', '>=', $start_date)->get();
        $program = Program::find($id);
        $program_fee = $program->fee;
        $program_discount = $program->discount_limit;

        return response()->json([
            'batches' => $batches,
            'program_fee' => $program_fee,
            'program_discount' => $program_discount,
        ]);
    }

    public function fetchRollNo($id,$campus_id=null)
    {
        $admissions_count = Admission::where('batch_id', $id)->get()->count();
        if(Auth::user()->role == 'Super Admin' || Auth::user()->role == 'Business Operations Manager' || Auth::user()->role == 'Admin & Finance'){

            $campus = Campus::where('id', $campus_id)->get();
        }else{
            $campus = Campus::where('id', Auth::user()->campus_id)->get();

        }
        foreach ($campus as $data) {
        }
        $campus_code = $data->campus_code;
        $batch = Batch::find($id);
        $batch_code = $batch->batch_code;
        if ($admissions_count < 10) {
            $roll_no = $campus_code . '-' . $batch_code . '-' . '0' . ($admissions_count + 1);
        } else {
            $roll_no = $campus_code . '-' . $batch_code . '-' . ($admissions_count + 1);
        }
        return response()->json([
            'roll_no' => $roll_no,
        ]);
    }


    public function newAdmission($id)
    {
        $title = 'New Admission';
        $admission_open = 'open';
        $admission = 'active';
        $registration_id = $id;

        $year = date('y');
        $programmes = Program::where('status', 'On Going')->get();
        $reg_count = Registration::where('campus_id', Auth::user()->campus_id)->get()->count();

        if (Auth::user()->role == 'Super Admin' || Auth::user()->role == 'Business Operations Manager' || Auth::user()->role == 'Admin & Finance') {
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

        return view('Admin.Admission.addtoanothercourse', compact('title', 'admission_open', 'admission',  'programmes', 'registration_no', 'receipt_number', 'registration_id','campuses'));
    }

    public function storeNewAdmission(Request $request)
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
            'roll_number' => 'unique:admissions,roll_number,null,null',
            'receipt_number' => 'unique:fee_collections,receipt_number,null,null',
        ]);

        if ($validator->fails()) {
            return Redirect::back()->with([
                'message' => 'Something went wrong!!'
            ])->withErrors($validator);
        } else {
            $admission = new Admission();
            $admission->roll_number = $request->input('roll_number');
            $admission->user_id = $request->input('user_id');
            $admission->registration_id = $request->input('registration_id');
            $admission->program_id = $request->input('program_id');
            $admission->campus_id = $request->input('campus_id');
            $admission->batch_id = $request->input('batch_id');
            $admission->admission_date = $request->input('admission_date');
            $admission->fee_package = $request->input('discounted_fee');
            $admission->discount = $request->input('discount');
            $admission->status = $request->input('status');
            $admission->save();

            if ($admission->save()) {
                $admission_id = Admission::all()->last()->id;

                if ($request->input('fee_type') == 'Full Fee') {
                    $fee = new FeeCollection();
                    $fee->registration_id = $request->input('registration_id');
                    $fee->admission_id = $admission_id;
                    $fee->user_id = $request->input('user_id');
                    $fee->campus_id = $request->input('campus_id');
                    $fee->admission_date = $request->input('admission_date');
                    $fee->fee_type = $request->input('fee_type');
                    $fee->total_amount = $request->input('discounted_fee');
                    $fee->paid_amount = $request->input('discounted_fee');
                    $fee->pay_date = $date;
                    $fee->status = 'Clear';
                    $fee->receipt_number = $request->input('receipt_number');
                    $fee->save();

                    return redirect('/all-admissions')->with([
                        'message' => 'Admission successfull with full fee!'
                    ]);
                } elseif ($request->input('fee_type') == 'Installment') {

                    if ($request->input('third_installment') == 0) {
                        $fee = new FeeCollection();
                        $fee->registration_id = $request->input('registration_id');
                        $fee->admission_id = $admission_id;
                        $fee->user_id = $request->input('user_id');
                        $fee->campus_id = $request->input('campus_id');
                        $fee->admission_date = $request->input('admission_date');
                        $fee->fee_type = $request->input('fee_type');
                        $fee->installment_number = 1;
                        $fee->total_amount = $request->input('discounted_fee');
                        $fee->paid_amount = $request->input('first_installment');
                        $fee->pay_date = $date;
                        $fee->status = 'Clear';
                        $fee->receipt_number = $request->input('receipt_number');
                        $fee->save();

                        if ($fee->save()) {
                            $fee = new FeeCollection();
                            $fee->registration_id = $request->input('registration_id');
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

                        return redirect('/all-admissions')->with([
                            'message' => 'Admission successfull with 2 installments!'
                        ]);
                    } elseif ($request->input('third_installment') > 0) {
                        $fee = new FeeCollection();
                        $fee->registration_id = $request->input('registration_id');
                        $fee->admission_id = $admission_id;
                        $fee->user_id = $request->input('user_id');
                        $fee->campus_id = $request->input('campus_id');
                        $fee->admission_date = $request->input('admission_date');
                        $fee->fee_type = $request->input('fee_type');
                        $fee->installment_number = 1;
                        $fee->total_amount = $request->input('discounted_fee');
                        $fee->paid_amount = $request->input('first_installment');
                        $fee->pay_date = $date;
                        $fee->status = 'Clear';
                        $fee->receipt_number = $request->input('receipt_number');
                        $fee->save();

                        if ($fee->save()) {
                            $fee = new FeeCollection();
                            $fee->registration_id = $request->input('registration_id');
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
                                $fee->registration_id = $request->input('registration_id');
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

                        return redirect('/all-admissions')->with([
                            'message' => 'Admission successfull with 3 installments!'
                        ]);
                    }
                }
            }
        }
    }


    public function collectInstallment($id)
    {
        $title = 'Collect Installment';
        $admission_open = 'open';
        $admission = 'active';
        $fee = FeeCollection::find($id);

        $year = date('y');
        $campus_id=$fee->campus_id;
        $campus = Campus::where('id', $campus_id)->get();
        $fee_count = FeeCollection::where('campus_id', Auth::user()->campus_id)->where('status', 'Clear')->get()->count();
        foreach ($campus as $data) {
        }
        $campus_code = $data->campus_code;
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

        return view('Admin.Admission.collectinstallment', compact('title', 'admission_open', 'admission', 'fee', 'receipt_number'));
    }


    public function updateInstallment(Request $request, $id)
    {
        $date = date('Y-m-d');
        $due_date = date('Y-m-d', strtotime('+30 days'));

        $fee = FeeCollection::find($id);

        $installment_number = $fee->installment_number;

        if ($installment_number == 3 && $request->paid_amount == $request->total_amount) {
            $fee->status = 'Clear';
            $fee->pay_date = $date;
            $fee->receipt_number = $request->input('receipt_number');
            $fee->save();
            return redirect()->route('admission.show', $fee->registration_id)->with([
                'message' => '3rd Installment status updated.'
            ]);
        } elseif ($installment_number == 2 && $request->paid_amount < $request->total_amount) {
            $fee->paid_amount = $request->input('paid_amount');
            $fee->status = 'Clear';
            $fee->pay_date = $date;
            $fee->receipt_number = $request->input('receipt_number');
            $fee->save();
            if ($fee->save()) {
                $last_installment_no = FeeCollection::where('admission_id', $fee->admission_id)->pluck('installment_number')->last();
                $last_installment_id = FeeCollection::where('admission_id', $fee->admission_id)->pluck('id')->last();
                if ($last_installment_no == 3) {
                    $third_installment = FeeCollection::find($last_installment_id);
                    $total_amount = $third_installment->paid_amount + $request->input('remaining_amount');
                    $third_installment->paid_amount = $total_amount;
                    $third_installment->save();

                    return redirect()->route('admission.show', $fee->registration_id)->with([
                        'message' => 'Installment status updated.'
                    ]);
                } else {
                    $new_installment = new FeeCollection();
                    $new_installment->registration_id = $fee->registration_id;
                    $new_installment->admission_id = $fee->admission_id;
                    $new_installment->user_id = $request->input('user_id');
                    $new_installment->campus_id = $request->input('campus_id');
                    $new_installment->admission_date = $fee->admission_date;
                    $new_installment->fee_type = 'Installment';
                    $new_installment->installment_number = 3;
                    $new_installment->total_amount = $fee->total_amount;
                    $new_installment->paid_amount = $request->input('remaining_amount');
                    $new_installment->due_date = $due_date;
                    $new_installment->status = 'Pending';
                    $new_installment->save();

                    return redirect()->route('admission.show', $fee->registration_id)->with([
                        'message' => 'Installment status updated.'
                    ]);
                }
            }
        } elseif ($installment_number == 2 && $request->paid_amount == $request->total_amount) {
            $fee->status = 'Clear';
            $fee->pay_date = $date;
            $fee->receipt_number = $request->input('receipt_number');
            $fee->save();
            return redirect()->route('admission.show', $fee->registration_id)->with([
                'message' => 'Installment status updated.'
            ]);
        } else {
            return redirect()->back()->with([
                'message' => 'Paid amount is not equal to Installment amount.'
            ]);
        }
    }


    public function feeReceipt($id)
    {
        $fee = FeeCollection::with('registration', 'admission', 'campus', 'user')->find($id);
        $pending_amount = FeeCollection::where('admission_id', $fee->admission_id)->where('status', 'Pending')->sum('paid_amount');
        $due_date = FeeCollection::where('admission_id', $fee->admission_id)->where('status', 'Pending')->pluck('due_date')->first();

        return view('Admin.Admission.feeslip', compact('fee', 'pending_amount', 'due_date'));
    }

    public function RegisterCheckNumber($num)
    {
        $admission = Registration::where('primary_contact', $num)->get();
        if ($admission->count() > 0) {
            return response()->json([
                'message' => "Not Ok",
            ]);
        } else {
            return response()->json([
                'message' => "Ok",
            ]);
        }
    }



    public function oldAdmissions()
    {
        $title = "Old Admissions";
        $admission_open = 'open';
        $admission = 'active';
        $old_admission = 'active';

        if (Auth::user()->role == 'Super Admin' || Auth::user()->role == 'Admin' || Auth::user()->role == 'Telesales Representative' || Auth::user()->role == 'Business Operations Manager' || Auth::user()->role == 'Admin & Finance') {
            $admissions = OldAdmission::all();
        } else {
            $admissions = OldAdmission::where('campus', Auth::user()->campus->campus_code)->get();
        }

        return view('Admin.Admission.oladadmission', compact('title', 'admission_open', 'admission', 'old_admission'))->with('admissions', json_decode($admissions, true));
    }

    public function oldAdmissionsCertified($id)
    {
        if (Auth::user()->role == 'Super Admin') {
            $old = OldAdmission::find($id);
            if ($old) {
                $old->status = "Certified";
                $old->save();
                return redirect()->back()->with([
                    'message' => 'Status Updated!',
                ]);
            } else {
                return redirect()->back()->with([
                    'error' => 'Student Not Found!',
                ]);
            }
        } else {
            return redirect()->back()->with([
                'error' => 'Access Denied!'
            ]);
        }
    }

    public function addOldAdmission()
    {
        $title = "Add Old Admissions";
        $admission_open = 'open';
        $admission = 'active';
        $old_admission = 'active';

        $campuses = Campus::all();
        if (Auth::user()->role == 'Super Admin') {
            return view('Admin.Admission.addoldadmission', compact('title', 'admission_open', 'admission', 'old_admission', 'campuses'));
        } else {
            return redirect()->back()->with([
                'error' => 'Access Denied!'
            ]);
        }
    }

    public function storeOldAdmission(Request $req)
    {

        $admission = new OldAdmission();
        $admission->name = $req->input('name');
        $admission->roll_number = $req->input('roll_number');
        $admission->primary_contact = $req->input('primary_contact');
        $admission->cnic = $req->input('cnic');
        $admission->email = $req->input('email');
        $admission->campus = $req->input('campus');
        $admission->batch = $req->input('batch');
        $admission->status = $req->input('status');
        $admission->save();
        return redirect()->route('oldAdmissions')->with([
            'message' => 'Admission Added Successfully!',
        ]);
    }
    public function fetchregforadmin($id)
    {
        $year = date('y');
        $reg_count = Registration::where('campus_id', $id)->get()->count();
        $campus = Campus::where('id', $id)->first();
        $campus_code = $campus->campus_code;
        $reg_count = Registration::where('campus_id', $id)->get()->count();
        $fee_count = FeeCollection::where('campus_id', $id)->where('status', 'Clear')->get()->count();

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

        return response()->json(['reg' => $registration_no, 'fee' => $receipt_number]);
    }
}
