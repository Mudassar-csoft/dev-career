<?php

namespace App\Http\Controllers;

use App\Models\BillType;
use App\Models\Payee;
use App\Models\Campus;
use App\Models\Departments;
use App\Models\Employee;
use App\Models\Expense;
use App\Models\ExpenseType;
use App\Models\Months;
use App\Models\PaymentRefferenceNumber;
use App\Models\Payroll;
use App\Models\RefferenceNumber;
use App\Models\UtilityBills;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;


class ExpenseController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }
    public function paybills()
    {

        $title = 'Pay Bills';
        $bill_open = 'open';
        $expense = 'active';
        $bill = 'active';
        $campuses = Campus::all();

        $billtype = BillType::all();
        $expensetype = ExpenseType::all();
        $refferencenumber = RefferenceNumber::where('status', 'approved')->get();
        $months = Months::all();

        if (Auth::user()->role == "Super Admin") {
            $payee = UtilityBills::with('campus', 'refferencenumber', 'billtyp')->get();
        } else {
            $payee = UtilityBills::with('campus', 'refferencenumber', 'billtyp')->where('campus_id', Auth::user()->campus->id)->get();
        }



        return view('Admin.Expense.utilitybills', compact('title', 'campuses', 'bill_open', 'expense', 'bill', 'billtype', 'refferencenumber', 'months', 'payee'));
    }
    public function payroll()
    {

        $title = 'Pay Bills';
        $bill_open = 'open';
        $expense = 'active';
        $payroll = 'active';
        $campuses = Campus::all();
        $departments = Departments::all();
        $expensetype = ExpenseType::all();
        $refferencenumber = RefferenceNumber::where('status', 'approved')->get();
        $months = Months::all();
        $employee = Employee::all();
        return view('Admin.Expense.payroll', compact('title', 'campuses', 'bill_open', 'expense', 'payroll', 'departments', 'refferencenumber', 'months', 'employee'));
    }
    public function addExpense()
    {
        $title = 'Add Expense';
        $expense_open = 'open';
        $expense = 'active';
        $add_expense = 'active';
        $payees = Payee::all();
        $campuses = Campus::all();


            $expensetype = ExpenseType::all();


            return view('Admin.Expense.addexpense', compact('title', 'campuses',  'expense_open', 'expense', 'add_expense', 'payees', 'expensetype'));

    }

    function expenseRefNo(Request $request)
    {

        $campus_codes = Campus::where('id', $request->campus_id)->first();
        $ref_no2 = $campus_codes->campus_code;


        $ref_num = Expense::where('campus_id', $campus_codes->id)->count();

        if ($ref_num < 9) {
            $receipt_number = $ref_no2 . '-' . date('ym') . '-' . '00000' . ($ref_num + 1);
        } elseif ($ref_num < 99) {
            $receipt_number = $ref_no2 . '-' . date('ym') . '-' . '0000' . ($ref_num + 1);
        } elseif ($ref_num < 999) {
            $receipt_number = $ref_no2 . '-' . date('ym') . '-' . '000' . ($ref_num + 1);
        } elseif ($ref_num < 9999) {
            $receipt_number = $ref_no2 . '-' . date('ym') . '-' . '00' . ($ref_num + 1);
        } elseif ($ref_num < 99999) {
            $receipt_number = $ref_no2 . '-' . date('ym') . '-' . '0' . ($ref_num + 1);
        } else {
            $receipt_number = $ref_no2 . '-' . date('ym') . '-' . ($ref_num + 1);
        }


        $payee = Payee::all();
        $paytype = ExpenseType::all();
        return response()->json(['receipt_number' => $receipt_number, 'payee' => $payee, 'paytype' => $paytype]);
    }


    public function addExpenseType()
    {
        $title = 'Add Expense Type';
        $expense_open = 'open';
        $expense = 'active';
        $add_expense_type = 'active';
        $campuses = Campus::all();

        $expensetype = ExpenseType::with('campus')->get();

        return view('Admin.Expense.addexpensetype', compact('title', 'campuses', 'expense_open', 'expense', 'add_expense_type', 'expensetype'));
    }

    public function payeeExpense()
    {
        $title = 'Manage Payee';
        $expense_open = 'open';
        $expense = 'active';
        $manage_payee = 'active';
        $campuses = Campus::all();
        if (Auth::user()->role == "Super Admin") {
            $payee = payee::with('campus')->get();
        } else {
            $payee = payee::with('campus')->where('campus_id', Auth::user()->campus->id)->get();
        }
        return view('Admin.Expense.payeeexpense', compact('title', 'campuses', 'expense_open', 'expense', 'manage_payee', 'payee'));
    }
    public function payeeExpenseStore(Request $request)
    {

        $payee = new Payee();
        $payee->name = $request->name;
        $payee->user_id = $request->user_id;
        $payee->campus_id = $request->campus_id;
        $payee->dname = $request->dname;
        $payee->phone = $request->phone;
        $payee->mobile = $request->mobile;
        $payee->email = $request->email;
        $payee->cnic = $request->cnic;
        $payee->postaladdress = $request->postaladdress;
        $payee->companyname = $request->companyname;
        $payee->companywebsite = $request->companywebsite;
        $payee->taxregisterationnumber = $request->taxregisterationnumber;
        $payee->bankname1 = $request->bankname1;
        $payee->banktitle1 = $request->banktitle1;
        $payee->accountnumber1 = $request->accountnumber1;
        $payee->bankname2 = $request->bankname2;
        $payee->banktitle2 = $request->banktitle2;
        $payee->accountnumber2 = $request->accountnumber2;
        $payee->iban2 = $request->iban2;
        $payee->iban1 = $request->iban1;
        $payee->term = $request->term;
        $payee->remarks = $request->remarks;
        if ($payee->save()) {

            return redirect()->route('payeeExpense')->with([
                'message' => 'Payee Aadded Successfully'
            ]);
        } else {

            return redirect()->route('payeeExpense')->with([
                'message' => 'Something Went Wrong'
            ]);
        }
    }

    public function payeeExpenseEdit(Request $request)
    {

        $payeeid = Payee::with('campus')->find($request->id);
        return $payeeid;
    }

    public function payeeExpenseUpdate(Request $request)
    {
        Payee::where('id', $request->id)->update($request->except('_token'));
        return redirect()->route('payeeExpense')->with([
            'message' => 'Payee Update Successfully'
        ]);
    }
    public function payeeExpenseDestroy($id)
    {
        Payee::where('id', $id)->delete();
        return redirect()->route('payeeExpense')->with([
            'message' => 'Payee Delete Successfully'
        ]);
    }



    public function addExpenseTypeUpdateajax(Request $request)
    {
        $request->validate([
            'user_id' => 'required',
            'name' => 'required',
        ]);
        ExpenseType::create($request->except('_token'));
        return response()->json('message', 'Expense Type Added Successfully');
    }
    public function addExpenseTypeUpdate(Request $request)
    {
        $request->validate([
            'user_id' => 'required',
            'name' => 'required',
        ]);
        ExpenseType::create($request->except('_token'));
        return redirect()->route('addExpenseType')->with([
            'message' => 'Expense Type Added Successfully'
        ]);
    }
    public function addexpensetypajax(Request $request)
    {
        $request->validate([
            'user_id' => 'required',
            'name' => 'required',
        ]);

        $expenseType = ExpenseType::create($request->except('_token'));

        return response()->json($expenseType, 201); // 201 status code indicates resource created
    }
    public function addExpenseTypeEdit(Request $request)
    {
        $payeeid = ExpenseType::find($request->id);
        return $payeeid;
    }

    public function addExpenseupdate(Request $request)
    {

        ExpenseType::where('id', $request->id)->update($request->except('_token'));
        return redirect()->route('addExpenseType')->with([
            'message' => 'Expense Type Update Successfully'
        ]);
    }
    public function ExpenseDestroy($id)
    {
        ExpenseType::where('id', $id)->delete();
        return redirect()->route('addExpenseType')->with([
            'message' => 'Expense Type Delete Successfully'
        ]);
    }
    public function ExpenseStore(Request $request)
    {
        $validate = Validator::make($request->all(), [
            'payee_id' => 'required',
            'expense_type_id' => 'required',
            'payment_date' => 'required',
            'payment_method' => 'required',
            'ref_no' => 'required|unique:expenses,ref_no,null,null',
            'amount' => 'required',
            'user_id' => 'required',
            'campus_id' => 'required',
        ]);
        if ($validate->fails()) {
            return redirect()->back()->with([
                'error' => 'Something went wrong!!'
            ])->withErrors($validate);
        } else {

            $campus_id=$request->campus_id;
            $ref_no=$request->ref_no;
            $refferencenumb= new PaymentRefferenceNumber();
            $refferencenumb->campus_id=$campus_id;
            $refferencenumb->number=$ref_no;
            if($refferencenumb->save()){

                Expense::create($request->except('_token'));
            }else{
                return redirect()->back()->with([
                    'error' => 'Something Went Wrong'
                ]);
            }
            return redirect()->route('allexpenseindex')->with([
                'success' => 'Expense Added Successfully'
            ]);
        }
    }
    public function index()
    {
        $title = 'All Expenses';
        $expense_open = 'open';
        $expense = 'active';
        $all_expense = 'active';
        if (Auth::user()->role == "Super Admin") {
            $expense = Expense::with('payee', 'expensetype')->get();
        } else {

            $expense = Expense::with('payee', 'expensetype')->where('campus_id', Auth::user()->campus->id)->get();
            // return $expense;
        }
        return view('Admin.Expense.index', compact('title', 'expense_open', 'expense', 'all_expense', 'expense'));
    }
    public function showempayee($id)

    {
        $title = 'Add Expense';
        $expense_open = 'open';
        $expense = 'active';
        $expense_open = 'active';
        $campuses = Campus::all();
        $employee = Payee::with('user', 'campus')->find($id);

        return view('Admin.Expense.shoepayee', compact('title', 'expense_open', 'expense', 'expense_open', 'employee', 'campuses'));
    }
    public function getrefbycampus(Request $request)
    {
        $campus_id = $request->campus_id;
        $methode = $request->payment_methhode;
        $latestReferenceNumber = PaymentRefferenceNumber::where('campus_id', $campus_id)
            ->latest()
            ->first();
            $monthYear = date('my');
        $methode_character = "";
        if ($methode == "Easypaisa") {
            $methode_character = 'EP';
        } elseif ($methode == "JazzCash") {
            $methode_character = 'JC';
        } elseif ($methode == "online transfer") {
            $methode_character = 'OT';
        } elseif ($methode == "cheque") {

            $methode_character = 'CQ';
        } elseif ($methode == "cash") {
            $methode_character = 'CH';
        }
        $campus = Campus::find($campus_id);
        $campus_code = $campus->campus_code;
        if ($latestReferenceNumber) {
            $latestReference = $latestReferenceNumber->number;
            $lastDigit = substr($latestReference, -1);

        } else {
            $lastDigit = 0;
        }
        $nextdigit=$lastDigit+1;
        $refferencenumber=$campus_code.'-'.$methode_character .'-'.$monthYear.'-'.$nextdigit;
        return response()->json($refferencenumber);

        // Now, $lastDigit contains the last digit of the latest reference number

    }
}
