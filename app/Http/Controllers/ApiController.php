<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Company;
use App\Models\Employee;

class ApiController extends Controller
{
    public function getCompanyWithEmployees($id)
    {
        $company = Company::with('employees')->find($id);

        if (!$company) {
            return response()->json(['message' => 'Company not found'], 404);
        }

        $employeeCount = $company->employees->count();

        $response = [
            'company' => $company,
            'employee_count' => $employeeCount,
        ];

        return response()->json($response);
    }
    
}
