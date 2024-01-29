<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Company;
use Illuminate\Support\Facades\Storage;
class CompanyController extends Controller
{
    
    public function index(Request $request)
    {
        $companies = Company::paginate(10);
        $apicompanies = Company::all();
        if ($request->expectsJson()) {
            return response()->json(['companies' => $apicompanies]);
        } else {
            return view('companies.index', compact('companies'));
        }
    }

    public function create()
    {
        return view('companies.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string',
            'address' => 'nullable',
            'email' => 'required|email',
            'logo' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048|dimensions:min_width=100,min_height=100',
            'website' => 'required|url',
        ]);

        $logoPath = $request->file('logo')->store('public/logos');
        $logoUrl = Storage::url($logoPath);

        $company = Company::create([
            'name' => $request->input('name'),
            'address' =>  $request->input('address'),
            'email' => $request->input('email'),
            'logo' => $logoUrl,
            'website' => $request->input('website'),
        ]);

        $message = 'Company created successfully.';

        if ($request->expectsJson()) {
            return response()->json(['company' => $company,'success' => $message]);
        }

        return redirect()->route('companies.index')->with('success', 'Company created successfully.');
    }

    public function show($id)
    {
        $company = Company::findOrFail($id);
        
        if (request()->expectsJson()) {
            return response()->json($company, 200);
        }
        return view('companies.show', compact('company'));
    }

    public function edit($id)
    {
        $company = Company::findOrFail($id);
        return view('companies.edit', compact('company'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'required|string',
            'address' => 'nullable',
            'email' => 'required|email',
            'logo' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048|dimensions:min_width=100,min_height=100',
            'website' => 'required|url',
        ]);

        $company = Company::findOrFail($id);

       
        if ($request->hasFile('logo')) {
          
            Storage::delete($company->logo);
            $logoPath = $request->file('logo')->store('public/logos');
            $logoUrl = Storage::url($logoPath);
            $company->logo = $logoUrl;
        }

        $company->name = $request->input('name');
        $company->address = $request->input('address');
        $company->email = $request->input('email');
        $company->website = $request->input('website');

        $company->save();

        $message = 'Company updated successfully.';

        if ($request->expectsJson()) {
            return response()->json(['company' => $company, 'success' => $message]);
        }

        return redirect()->route('companies.index')->with('success', $message);
    }

    public function destroy($id, Request $request)
    {
        $company = Company::findOrFail($id);
        Storage::delete($company->logo);
        $company->delete();

        if ($request->expectsJson()) {
            return response()->json(['success' => "Company deleted successfully."]);
        }

        return redirect()->route('companies.index')->with('success', 'Company deleted successfully.');
    }
}
