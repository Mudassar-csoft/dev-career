<?php

namespace App\Http\Controllers;

use PDF;
use App\Models\Printing;
use App\Models\Admission;
use App\Models\Registration;
use Illuminate\Http\Request;
use App\Mail\CertificateMail;
use App\Models\CertificateRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use App\Models\CertificateCollectedBy;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Validator;

class CertificateController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }


    public function pendingForApproval()
    {
        $title = 'Requested Certificates';
        $certificate_open = 'open';
        $certificate = 'active';
        $req_certificate = 'active';

        if (Auth::user()->role == 'Super Admin') {
            $admissions = Admission::with('registration', 'program', 'campus')->where('status', 'Requested')->get();

            $reprintings = CertificateRequest::with('admission', 'campus', 'approve_id')->where('status', 'Requested')->get();
        } else {
            $admissions = Admission::with('registration', 'program', 'campus')->where('campus_id', Auth::user()->campus_id)->where('status', 'Requested')->get();

            $reprintings = CertificateRequest::with('admission', 'campus', 'approve_id')->where('campus_id', Auth::user()->campus_id)->where('status', 'Requested')->get();
        }

        return view('Admin.Certificate.requestcertificate', compact('title', 'certificate_open', 'certificate', 'req_certificate', 'admissions', 'reprintings'));
    }

    public function onPrinting()
    {
        $title = 'On Printing';
        $certificate_open = 'open';
        $certificate = 'active';
        $on_printing = 'active';

        if (Auth::user()->role == 'Super Admin') {
            $admissions = Admission::with('registration', 'program', 'campus')->where('status', 'Approved')->get();

            $reprintings = CertificateRequest::with('admission', 'campus', 'approve_id')->where('status', 'Approved')->get();
        } else {
            $admissions = Admission::with('registration', 'program', 'campus')->where('campus_id', Auth::user()->campus_id)->where('status', 'Approved')->get();

            $reprintings = CertificateRequest::with('admission', 'campus', 'approve_id')->where('campus_id', Auth::user()->campus_id)->where('status', 'Approved')->get();
        }

        return view('Admin.Certificate.onprinting', compact('title', 'certificate_open', 'certificate', 'on_printing', 'admissions', 'reprintings'));
    }

    public function certificateApprove($id)
    {
        $admission = Admission::find($id);
        if ($admission->status == 'Requested') {
            $admission->status = 'Approved';
            $admission->save();
            if ($admission->save()) {
                $printing = new Printing();
                $printing->admission_id = $id;
                $printing->count = 1;
                $printing->approve_id = Auth::user()->id;
                $printing->hard_copy = 1;
                $printing->status = 'Approved';
                $printing->campus_id = $admission->campus_id;
                $printing->save();
                return redirect()->route('onPrinting')->with([
                    'message' => 'Certificate Request Approved',
                ]);
            } else {
                return redirect()->back()->with([
                    'error' => 'Something Went Wrong',
                ]);
            }
        } else {
            return redirect()->back()->with([
                'error' => 'Something Went Wrong',
            ]);
        }
    }

    public function certificatePrint($id)
    {
        $admission = Admission::with('registration', 'program', 'campus')->find($id);
        $date = date('M d Y');
        return view('Admin.Certificate.certificate', compact('admission', 'date'));
    }

    public function printed($id)
    {
        $admission = Admission::find($id);
        if ($admission->status == 'Approved') {
            $admission->status = 'Ready';
            $admission->save();
            if ($admission->save()) {
                $printing = Printing::where('admission_id', $id)->where('status', 'Approved')->orderBy('id', 'desc')->first();
                $printing->status = 'Ready';
                $printing->save();
                return redirect()->route('certificateReady')->with([
                    'message' => 'Certificate Ready to Collect',
                ]);
            } else {
                return redirect()->back()->with([
                    'error' => 'Something Went Wrong',
                ]);
            }
        } else {
            return redirect()->back()->with([
                'error' => 'Something Went Wrong',
            ]);
        }
    }

    public function certificateReady()
    {
        $title = 'Ready To Collect';
        $certificate_open = 'open';
        $certificate = 'active';
        $ready_to_collect = 'active';

        if (Auth::user()->role == 'Super Admin') {
            $admissions = Admission::with('registration', 'program', 'campus')->where('status', 'Ready')->get();

            $reprintings = CertificateRequest::with('admission', 'campus', 'approve_id')->where('status', 'Ready')->get();
        } else {
            $admissions = Admission::with('registration', 'program', 'campus')->where('campus_id', Auth::user()->campus_id)->where('status', 'Ready')->get();

            $reprintings = CertificateRequest::with('admission', 'campus', 'approve_id')->where('campus_id', Auth::user()->campus_id)->where('status', 'Ready')->get();
        }

        return view('Admin.Certificate.readytocollect', compact('title', 'certificate_open', 'certificate', 'ready_to_collect', 'admissions', 'reprintings'));
    }

    public function certificateCollectedBy(Request $req)
    {
        $validator = Validator::make($req->all(), [
            'name' => 'required',
            'contact' => 'required|numeric',
            'remarks' => 'required',
            'admission_id' => 'required',
            'cnic' => 'required'
        ]);
        if ($validator->fails()) {
            return Redirect::back()->with([
                'error' => 'Invalid Inputs!!'
            ]);
        } else {
            $data = Printing::where('admission_id', $req->admission_id)->where('status', 'Ready')->orderBy('id', 'desc')->first();
            $collected_by = new CertificateCollectedBy();
            $collected_by->name = $req->name;
            $collected_by->contact = $req->contact;
            $collected_by->cnic = $req->cnic;
            $collected_by->remarks = $req->remarks;
            $collected_by->user_id = Auth::user()->id;
            $collected_by->admission_id = $req->admission_id;
            $collected_by->printing_id = $data->id;
            $collected_by->save();

            if ($collected_by->save()) {
                $admission = Admission::find($req->admission_id);
                $admission->status = 'Delivered';
                $admission->save();
                if ($admission->save()) {
                    $printing = Printing::where('admission_id', $req->admission_id)->where('status', 'Ready')->first();
                    $printing->status = 'Delivered';
                    $printing->save();
                    return redirect()->route('certificateDelivered')->with([
                        'message' => 'Certificate Delivered Successfully!'
                    ]);
                } else {
                    return Redirect::back()->with([
                        'error' => 'Something went wrong!!'
                    ]);
                }
            } else {
                return Redirect::back()->with([
                    'error' => 'Something went wrong!!'
                ]);
            }
        }
    }

    public function certificateDelivered()
    {
        $title = 'Delivered';
        $certificate_open = 'open';
        $certificate = 'active';
        $certificate_delivered = 'active';

        if (Auth::user()->role == 'Super Admin') {
            $admissions = Admission::with('registration', 'program', 'campus', 'collectedBy')->where('status', 'Delivered')->orderBy('id', 'desc')->get();
        } else {
            $admissions = Admission::with('registration', 'program', 'campus', 'collectedBy')->where('campus_id', Auth::user()->campus_id)->where('status', 'Delivered')->orderBy('id', 'desc')->get();
        }
        return view('Admin.Certificate.delivered', compact('title', 'certificate_open', 'certificate', 'certificate_delivered', 'admissions'));
    }

    public function certificateRequest($id)
    {
        $admission = Admission::find($id);
        if ($admission->status == 'Enrolled') {
            $admission->status = 'Requested';
            $admission->save();
            return redirect()->back()->with([
                'message' => 'Certificate Request Successfull!',
            ]);
        } else {
            return redirect()->back()->with([
                'error' => 'Something Went Wrong',
            ]);
        }
    }

    public function certificateReprinting()
    {
        $title = 'Certificate Reprinting';
        $certificate_open = 'open';
        $certificate = 'active';
        $certificate_reprinting = 'active';

        if (Auth::user()->role == 'Super Admin') {
            $printings = Printing::with('admission', 'approve_id', 'collected')->where('status', 'Delivered')->orderBy('id', 'desc')->get();
            $admissions = Admission::with('registration', 'program')->where('status', 'Delivered')->get();
        } else {
            $printings = Printing::with('admission', 'approve_id', 'collected')->where('status', 'Delivered')->orderBy('id', 'desc')->where('campus_id', Auth::user()->campus_id)->get();
            $admissions = Admission::with('registration', 'program')->where('campus_id', Auth::user()->campus_id)->where('status', 'Delivered')->get();
        }

        return view('Admin.Certificate.reprinting', compact('title', 'certificate_open', 'certificate', 'certificate_reprinting', 'printings', 'admissions'));
    }

    public function certificateReprintingRequest(Request $req)
    {
        // return $req;
        // if ($req->soft_copy < 1 && $req->hard_copy < 1) {
        //     return Redirect::back()->with([
        //         'error' => 'Soft Copy or Hard Copy is Required for this request.'
        //     ]);
        // }
        $request = CertificateRequest::whereIn('status', ['Requested', 'Approved', 'Ready'])->where('admission_id', $req->admission_id)->count();
        // return $request;
        if ($request > 0) {
            return Redirect::back()->with([
                'error' => 'Reprinting Request Already in Queue!'
            ]);
        }
        $validator = Validator::make($req->all(), [
            'admission_id' => 'required'
        ]);
        if ($validator->fails()) {
            return Redirect::back()->with([
                'error' => 'Something went wrong!!'
            ])->withErrors($validator);
        } else {
            $campus_id = Admission::find($req->admission_id)->pluck('campus_id')->first();
            $certificate = new CertificateRequest();
            $certificate->admission_id = $req->admission_id;
            $certificate->requested_id = Auth::user()->id;
            $certificate->campus_id = $campus_id;
            // $certificate->soft_copy = $req->soft_copy;
            // $certificate->hard_copy = $req->hard_copy;
            $certificate->status = 'Requested';
            $certificate->save();
            return Redirect::back()->with([
                'message' => 'Reprinting Request Successfull!'
            ]);
        }
    }

    public function certificateReprintingApprove($id)
    {
        $print = Printing::where('admission_id', $id)->count();
        $count = $print + 1;
        $certificate = CertificateRequest::where('admission_id', $id)->orderBy('id', 'desc')->first();
        if ($certificate->status == 'Requested') {
            $certificate->status = 'Approved';
            $certificate->approve_id = Auth::user()->id;
            $certificate->save();
            if ($certificate->save()) {
                $printing = new Printing();
                $printing->admission_id = $id;
                $printing->campus_id = $certificate->campus_id;
                $printing->count = $count;
                $printing->approve_id = Auth::user()->id;
                // $printing->soft_copy = $certificate->soft_copy;
                // $printing->hard_copy = $certificate->hard_copy;
                $printing->status = 'Approved';
                $printing->save();
                return redirect()->route('onPrinting')->with([
                    'message' => 'Certificate Request Approved',
                ]);
            } else {
                return redirect()->back()->with([
                    'error' => 'Something Went Wrong',
                ]);
            }
        }
    }

    public function certificateReprintingPrinting($id)
    {
        $certificate = CertificateRequest::where('admission_id', $id)->orderBy('id', 'desc')->first();
        if ($certificate->status == 'Approved') {
            $certificate->status = 'Ready';
            $certificate->save();
            if ($certificate->save()) {
                $printing = Printing::where('admission_id', $id)->where('status', 'Approved')->orderBy('id', 'desc')->first();
                $printing->status = 'Ready';
                $printing->save();
                return redirect()->route('certificateReady')->with([
                    'message' => 'Certificate Ready to Collect',
                ]);
            } else {
                return redirect()->back()->with([
                    'error' => 'Something Went Wrong',
                ]);
            }
        } else {
            return redirect()->back()->with([
                'error' => 'Something Went Wrong',
            ]);
        }
    }

    public function certificateReprintingCollected(Request $req)
    {
        $validator = Validator::make($req->all(), [
            'name' => 'required',
            'contact' => 'required|numeric',
            'remarks' => 'required',
            'admission_id' => 'required',
            'cnic' => 'required'
        ]);
        if ($validator->fails()) {
            return Redirect::back()->with([
                'error' => 'Invalid Inputs!!'
            ]);
        } else {
            $data = Printing::where('admission_id', $req->admission_id)->where('status', 'Ready')->orderBy('id', 'desc')->first();
            $collected_by = new CertificateCollectedBy();
            $collected_by->name = $req->name;
            $collected_by->contact = $req->contact;
            $collected_by->cnic = $req->cnic;
            $collected_by->remarks = $req->remarks;
            $collected_by->user_id = Auth::user()->id;
            $collected_by->admission_id = $req->admission_id;
            $collected_by->printing_id = $data->id;
            $collected_by->save();

            if ($collected_by->save()) {
                $admission = CertificateRequest::where('admission_id', $req->admission_id)->where('status', 'Ready')->orderBy('id', 'desc')->first();
                $admission->status = 'Delivered';
                $admission->save();
                if ($admission->save()) {
                    $printing = Printing::where('admission_id', $req->admission_id)->where('status', 'Ready')->orderBy('id', 'desc')->first();
                    $printing->status = 'Delivered';
                    $printing->save();
                    return redirect()->route('certificateReprinting')->with([
                        'message' => 'Certificate Delivered Successfully!'
                    ]);
                } else {
                    return Redirect::back()->with([
                        'error' => 'Something went wrong!!'
                    ]);
                }
            } else {
                return Redirect::back()->with([
                    'error' => 'Something went wrong!!'
                ]);
            }
        }
    }

    public function certificatedownloadpdf($id)
    {
        // return view('Admin.Certificate.downloadpdf');
        $details['admission'] = Admission::with('registration', 'program', 'campus')->find($id);
        set_time_limit(5000);
        $pdf = app('dompdf.wrapper');
        $pdf->loadView('Admin.Certificate.downloadpdf', compact('details'));
        $pdf->setPaper('A4', 'landscape');
        return $pdf->download($details['admission']->registration->name . ' ' . $details['admission']->roll_number . '.pdf');
        // return $pdf->stream();
    }

    public function certificateemail($id)
    {
        $details['admission'] = Admission::with('registration', 'program', 'campus')->find($id);
        $email = new CertificateMail($details);
        Mail::to($details['admission']->registration->email)->send($email);
        return redirect()->back()->with([
            'message' => 'Email Sent Successfully!'
        ]);
    }

    public function certificateReprintingCinc(Request $request)
    {
        $cnic = $request->cnic;
        $reg = Registration::where('cnic', $cnic)->first();
        if ($reg) {
            $admissions = Admission::with('registration', 'program')->where('registration_id', $reg->id)->where('status', 'Delivered')->get();
            $admission_count = Admission::with('registration')->where('registration_id', $reg->id)->where('status', 'Delivered')->count();
            return response()->json([
                'reg' => $reg,
                'admissions' => $admissions,
                'admission_count' => $admission_count
            ]);
        }
    }

    public function certificateReprintingRollNumber(Request $request)
    {
        $admission_id = $request->admissionId;
        $admission = Admission::find($admission_id);
        return response()->json([
            'admission' => $admission,
        ]);
    }
}
