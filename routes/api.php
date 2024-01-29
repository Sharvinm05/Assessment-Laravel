<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ApiController;
use App\Http\Controllers\CompanyController;
use App\Http\Controllers\EmployeeController;


Route::middleware('api')->group(function () {
    Route::resource('companies', CompanyController::class)->only(['index', 'show', 'update', 'store', 'destroy']);
    Route::resource('employees', EmployeeController::class)->only(['index','show', 'update', 'store', 'destroy']);

    Route::get('/company-with-employees/{id}', [ApiController::class, 'getCompanyWithEmployees']);
});
