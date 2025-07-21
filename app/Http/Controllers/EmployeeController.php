<?php

namespace App\Http\Controllers;

use App\Models\Campus;
use App\Models\Employee;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Validator;

class EmployeeController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function addEmployee()
    {
        $title = 'Add Employee';
        $human_resource_open = 'open';
        $human_resource = 'active';
        $employee_open = 'open';
        $add_employee = 'active';
        $campuses = Campus::all();

        return view('Admin.HumanResource.addemployee', compact('title', 'human_resource_open', 'human_resource', 'employee_open', 'add_employee', 'campuses'));
    }

    public function saveEmployee(Request $request)
    {
        if ($request->hasFile('related_document')) {
            $related_document = asset('storage/'. $request->related_document->store('allUploadedFiles'));
        }
        if ($request->hasFile('profile_picture')) {
            $profile_picture = asset('storage/'. $request->profile_picture->store('allUploadedFiles'));
        }

        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'title' => 'required',
            'campus_id' => 'required',
            'primary_contact' => 'required',
            'cnic' => 'required',
            'email' => 'required',
            'dob' => 'required',
            'religion' => 'required',
            'gender' => 'required',
            'marital_status' => 'required',
            'postal_address' => 'required',
            'designation' => 'required',
            'basic_salary' => 'required',
            'hiring_date' => 'required',
            'employee_type' => 'required',
        ]);

        if ($validator->fails()) {
            return Redirect::back()->withErrors($validator)->withInput();
        }else{
            $employee = new Employee();
            $employee->name = $request->input('name');
            $employee->title = $request->input('title');
            $employee->user_id = $request->input('user_id');
            $employee->campus_id = $request->input('campus_id');
            $employee->status = $request->input('status');
            $employee->primary_contact = $request->input('primary_contact');
            $employee->cnic = $request->input('cnic');
            $employee->email = $request->input('email');
            $employee->dob = $request->input('dob');
            $employee->religion = $request->input('religion');
            $employee->gender = $request->input('gender');
            $employee->marital_status = $request->input('marital_status');
            $employee->postal_address = $request->input('postal_address');
            $employee->designation = $request->input('designation');
            $employee->basic_salary = $request->input('basic_salary');
            $employee->hiring_date = $request->input('hiring_date');
            $employee->employee_type = $request->input('employee_type');
            if ($request->related_document) {
                $employee->related_document = $related_document;
            }
            if ($request->profile_picture) {
                $employee->profile_picture = $profile_picture;
            }
            $employee->save();
        }

        return redirect('/current-employee')->with([
            'message' => 'Employee Added Successfully!'
        ]);
    }

    public function editEmployee($id)
    {
        $title = 'Edit Employee';
        $human_resource_open = 'open';
        $human_resource = 'active';
        $employee_open = 'open';
        $campuses = Campus::all();
        $employee = Employee::find($id);

        return view('Admin.HumanResource.editemployee', compact('title', 'human_resource_open', 'human_resource', 'employee_open', 'employee', 'campuses'));
    }

    public function showEmployee($id)
    {
        $title = 'Employee Details';
        $human_resource_open = 'open';
        $human_resource = 'active';
        $employee_open = 'open';
        $campuses = Campus::all();
        $employee = Employee::with('user', 'campus')->find($id);

        return view('Admin.HumanResource.showemployee', compact('title', 'human_resource_open', 'human_resource', 'employee_open', 'employee', 'campuses'));
    }

    public function updateEmployee(Request $request, $id)
    {
        if ($request->hasFile('related_document')) {
            $related_document = asset('storage/'. $request->related_document->store('allUploadedFiles'));
        }
        if ($request->hasFile('profile_picture')) {
            $profile_picture = asset('storage/'. $request->profile_picture->store('allUploadedFiles'));
        }

        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'title' => 'required',
            'campus_id' => 'required',
            'primary_contact' => 'required',
            'cnic' => 'required',
            'email' => 'required',
            'dob' => 'required',
            'religion' => 'required',
            'gender' => 'required',
            'marital_status' => 'required',
            'postal_address' => 'required',
            'designation' => 'required',
            'basic_salary' => 'required',
            'hiring_date' => 'required',
            'employee_type' => 'required',
        ]);

        if ($validator->fails()) {
            return Redirect::back()->withErrors($validator)->withInput();
        }else{
            $employee = Employee::find($id);
            $employee->name = $request->input('name');
            $employee->title = $request->input('title');
            $employee->campus_id = $request->input('campus_id');
            $employee->status = $request->input('status');
            $employee->primary_contact = $request->input('primary_contact');
            $employee->cnic = $request->input('cnic');
            $employee->email = $request->input('email');
            $employee->dob = $request->input('dob');
            $employee->religion = $request->input('religion');
            $employee->gender = $request->input('gender');
            $employee->marital_status = $request->input('marital_status');
            $employee->postal_address = $request->input('postal_address');
            $employee->designation = $request->input('designation');
            $employee->basic_salary = $request->input('basic_salary');
            $employee->hiring_date = $request->input('hiring_date');
            $employee->employee_type = $request->input('employee_type');
            if ($request->related_document) {
                $employee->related_document = $related_document;
            }
            if ($request->profile_picture) {
                $employee->profile_picture = $profile_picture;
            }
            $employee->save();
        }

        return redirect('/current-employee')->with([
            'message' => 'Employee Updated Successfully!'
        ]);
    }

    public function currentEmployee()
    {
        $title = 'Current Employees';
        $human_resource_open = 'open';
        $human_resource = 'active';
        $employee_open = 'open';
        $current_employee = 'active';
         if (Auth::user()->role == 'Super Admin' ||
                                    Auth::user()->role == 'Admin' ||
                                    Auth::user()->role == 'Telesales Representative' ||
                                    Auth::user()->role == 'Business Operations Manager' ||
                                    Auth::user()->role == 'Admin & Finance') {
            $employees = Employee::where('status', 'Employee')->with('campus')->get();
        }else {
            $employees = Employee::where('status', 'Employee')->where('campus_id', Auth::user()->campus_id)->with('campus')->get();
        }

        return view('Admin.HumanResource.currentemployee', compact('title', 'human_resource_open', 'human_resource', 'employee_open', 'current_employee', 'employees'));
    }

    public function terminatedEmployee()
    {
        $title = 'Terminated Employees';
        $human_resource_open = 'open';
        $human_resource = 'active';
        $employee_open = 'open';
        $terminated_employee = 'active';
        if (Auth::user()->role == 'Super Admin' ||
                                    Auth::user()->role == 'Admin' ||
                                    Auth::user()->role == 'Telesales Representative' ||
                                    Auth::user()->role == 'Business Operations Manager' ||
                                    Auth::user()->role == 'Admin & Finance') {
            $employees = Employee::where('status', 'Terminated')->with('campus')->get();
        }else {
            $employees = Employee::where('status', 'Terminated')->where('campus_id', Auth::user()->campus_id)->with('campus')->get();
        }

        return view('Admin.HumanResource.terminatedemployee', compact('title', 'human_resource_open', 'human_resource', 'employee_open', 'terminated_employee', 'employees'));
    }

    public function resignedEmployee()
    {
        $title = 'Resigned Employees';
        $human_resource_open = 'open';
        $human_resource = 'active';
        $employee_open = 'open';
        $resigned_employee = 'active';
       if (Auth::user()->role == 'Super Admin' ||
                                    Auth::user()->role == 'Admin' ||
                                    Auth::user()->role == 'Telesales Representative' ||
                                    Auth::user()->role == 'Business Operations Manager' ||
                                    Auth::user()->role == 'Admin & Finance') {
            $employees = Employee::where('status', 'Resigned')->with('campus')->get();
        }else {
            $employees = Employee::where('status', 'Resigned')->where('campus_id', Auth::user()->campus_id)->with('campus')->get();
        }
        return view('Admin.HumanResource.resignedemployee', compact('title', 'human_resource_open', 'human_resource', 'employee_open', 'resigned_employee', 'employees'));
    }

}
