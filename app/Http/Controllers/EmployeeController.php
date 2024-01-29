<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Employee;
use App\Models\Company;

class EmployeeController extends Controller
{
    public function index(Request $request)
    {
        $employees = Employee::with('company')->paginate(10);
        
        $apiemployees = Employee::all();
        if ($request->expectsJson()) {
            return response()->json(['employees' => $apiemployees]);
        } else {
            return view('employees.index', compact('employees'));
        }
    }

    public function create()
    {
        $companies = Company::all();
        return view('employees.create', compact('companies'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'first_name' => 'required|string',
            'last_name' => 'required|string',
            'company_id' => 'required|exists:companies,id',
            'email' => 'required|email',
            'phone' => 'required|string',
        ]);

        $employee = Employee::create([
            'first_name' => $request->input('first_name'),
            'last_name' => $request->input('last_name'),
            'company_id' => $request->input('company_id'),
            'email' => $request->input('email'),
            'phone' => $request->input('phone'),
        ]);

        if ($request->expectsJson()) {
            return response()->json(['employee' => $employee, 'success' => 'Employee created successfully.']);
        }

        return redirect()->route('employees.index')->with('success', 'Employee created successfully.');
    }

    public function show($id, Request $request)
    {
        $employee = Employee::with('company')->findOrFail($id);
        if ($request->expectsJson()) {
            return response()->json(['employee' => $employee]);
        }
        return view('employees.show', compact('employee'));
    }

    public function edit($id)
    {
        $employee = Employee::findOrFail($id);
        $companies = Company::all();
        return view('employees.edit', compact('employee', 'companies'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'first_name' => 'required|string',
            'last_name' => 'required|string',
            'company_id' => 'required|exists:companies,id',
            'email' => 'required|email',
            'phone' => 'required|string',
        ]);

        $employee = Employee::findOrFail($id);

        $employee->update([
            'first_name' => $request->input('first_name'),
            'last_name' => $request->input('last_name'),
            'company_id' => $request->input('company_id'),
            'email' => $request->input('email'),
            'phone' => $request->input('phone'),
        ]);

        if ($request->expectsJson()) {
            return response()->json(['employee' => $employee]);
        }

        return redirect()->route('employees.index')->with('success', 'Employee updated successfully.');
    }

    public function destroy($id, Request $request)
    {
        $employee = Employee::findOrFail($id);
        $employee->delete();

        if ($request->expectsJson()) {
            return response()->json(['success' => "Employee deleted successfully."]);
        }

        return redirect()->route('employees.index')->with('success', 'Employee deleted successfully.');
    }
}
