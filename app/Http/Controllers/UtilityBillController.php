<?php

namespace App\Http\Controllers;

use App\Models\BillType;
use App\Models\Campus;
use App\Models\ExpenseType;
use App\Models\PaymentRefferenceNumber;
use App\Models\RefferenceNumber;
use App\Models\UtilityBills;
use Illuminate\Http\Request;

class UtilityBillController extends Controller
{
    public function addbilltype(Request $request)
    {
        $request->validate([
            'name' => 'required',
        ]);

        $expenseType = BillType::create($request->except('_token'));

        return response()->json($expenseType, 201); // 201 status code indicates resource created
    }
    public function addd_bill_type()
    {
        $title = 'Add Bill Type';
        $billtype = 'open';
        $expense = 'active';
        $billtype = 'active';
        $campuses = Campus::all();

        $expensetype = BillType::all();

        return view('Admin.Expense.AddNewBillType', compact('title', 'campuses', 'billtype', 'expense', 'billtype', 'expensetype'));
    }
    public function store_bill_type(Request $request)
    {


        $request->validate([

            'name' => 'required',
        ]);
        BillType::create($request->all());
        return redirect()->route('add.biltype')->with([
            'message' => 'Bill  Type Added Successfully'
        ]);
    }
    public function addrefferencenumner(Request $request)
    {
        $request->validate([
            'refferencenumber' => 'required',
            'campus_id' => 'required'
        ]);

        $expenseType = RefferenceNumber::create($request->except('_token'));

        return response()->json($expenseType, 201); // 201 status code indicates resource created
    }
    public function store(Request $request)
    {
        $campus_id = $request->campus_id;
        $ref_no = $request->paymentrefferencenumber;
        $refferencenumb = new PaymentRefferenceNumber();
        $refferencenumb->campus_id = $campus_id;
        $refferencenumb->number = $ref_no;
        if ($refferencenumb->save()) {
            $expenseType = UtilityBills::create($request->all());
            if ($expenseType) {
                return redirect()->back()->with('scuccess', 'Bill added successfully');
            } else {
                return redirect()->back()->with('error', 'Something Went Wrong');
            }
        } else {
            return redirect()->back()->with([
                'error' => 'Something Went Wrong'
            ]);

        }
    }
    //api for sending  refference number on the base of campus id


    public function getReferenceByCampusId(Request $request)
    {
        $campus_id = $request->campus_id;
        $refferencenumbers = RefferenceNumber::where('campus_id', $campus_id)->get();
        return response()->json($refferencenumbers); // Correct usage of response()->json()
    }
    //crud for new Bill
    public function addnewBill()
    {
        $title = 'Add Bill Type';
        $newbill = 'open';
        $expense = 'active';
        $newbill = 'active';
        $campuses = Campus::all();

        $billtype = BillType::all();
        $expensetype = RefferenceNumber::with('billType', 'campus')->get();

        return view('Admin.Expense.addNewBill', compact('title', 'campuses', 'newbill', 'expense', 'newbill', 'expensetype', 'billtype'));
    }
    public function storenewbill(Request $request)
    {

        // dd($request->all());
        $request->validate([

            'billtype_id' => 'required',
            'campus_id' => 'required',
            'refferencenumber' => 'required'
        ]);
        RefferenceNumber::create($request->all());
        // die();

        return redirect()->route('add.newbill')->with([
            'message' => 'Bill  Type Added Successfully'
        ]);
    }

    public function refferencenumberapi(Request $req)
    {
        $campus = $req->campus_id;
        $billtype = $req->billtype;
        $refferencenumbers = RefferenceNumber::where('campus_id', $campus)->where('billtype_id', $billtype)->get();
        if ($refferencenumbers) {
            return response()->json($refferencenumbers);
        }
    }
}
