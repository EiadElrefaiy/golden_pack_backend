<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

//============================== admin Api ===========================================================

Route::group(['middleware' => ['api'] ,'prefix' =>'admins'] , function(){
    Route::post('login' , [App\Http\Controllers\Api\AdminController::class , 'login']);

    Route::post('get-employees' , [App\Http\Controllers\Api\AdminController::class , 'getEmployees']);
    Route::post('get-employee-id' , [App\Http\Controllers\Api\AdminController::class , 'getEmployeeId']);
    Route::post('add-employee' , [App\Http\Controllers\Api\AdminController::class , 'addEmployee']);
    Route::post('update-employee' , [App\Http\Controllers\Api\AdminController::class , 'updatesEmployee']);
    Route::post('delete-employee' , [App\Http\Controllers\Api\AdminController::class , 'deleteEmployee']);


    Route::post('get-projects' , [App\Http\Controllers\Api\AdminController::class , 'getProjects']);
    Route::post('get-project-id' , [App\Http\Controllers\Api\AdminController::class , 'getProjectId']);
    Route::post('add-project' , [App\Http\Controllers\Api\AdminController::class , 'addProject']);
    Route::post('update-project' , [App\Http\Controllers\Api\AdminController::class , 'updateProject']);
    Route::post('delete-project' , [App\Http\Controllers\Api\AdminController::class , 'deleteProject']);


    Route::post('get-loans' , [App\Http\Controllers\Api\AdminController::class , 'getLoans']);
    Route::post('add-loan' , [App\Http\Controllers\Api\AdminController::class , 'addLoan']);
    Route::post('update-loan' , [App\Http\Controllers\Api\AdminController::class , 'updateLoan']);
    Route::post('delete-loan' , [App\Http\Controllers\Api\AdminController::class , 'deleteLoan']);


    Route::post('get-absences' , [App\Http\Controllers\Api\AdminController::class , 'getAbsences']);
    Route::post('add-absence' , [App\Http\Controllers\Api\AdminController::class , 'addAbsence']);
    Route::post('delete-absence' , [App\Http\Controllers\Api\AdminController::class , 'deleteAbsence']);

    Route::post('get-attendances' , [App\Http\Controllers\Api\AdminController::class , 'getAttendances']);
    Route::post('add-attendance' , [App\Http\Controllers\Api\AdminController::class , 'addAttendance']);
    Route::post('update-attendance' , [App\Http\Controllers\Api\AdminController::class , 'updateAttendance']);
    Route::post('delete-attendance' , [App\Http\Controllers\Api\AdminController::class , 'deleteAttendance']);


    Route::post('get-minces' , [App\Http\Controllers\Api\AdminController::class , 'getMinces']);
    Route::post('add-mince' , [App\Http\Controllers\Api\AdminController::class , 'addMince']);
    Route::post('update-mince' , [App\Http\Controllers\Api\AdminController::class , 'updateMince']);
    Route::post('delete-mince' , [App\Http\Controllers\Api\AdminController::class , 'deleteMince']);


    Route::post('get-overs' , [App\Http\Controllers\Api\AdminController::class , 'getOvers']);
    Route::post('add-over' , [App\Http\Controllers\Api\AdminController::class , 'addOver']);
    Route::post('update-over' , [App\Http\Controllers\Api\AdminController::class , 'updateOver']);
    Route::post('delete-over' , [App\Http\Controllers\Api\AdminController::class , 'deleteOver']);


    Route::post('get-outcomes' , [App\Http\Controllers\Api\AdminController::class , 'getOutcomes']);
    Route::post('add-outcome' , [App\Http\Controllers\Api\AdminController::class , 'addOutcome']);
    Route::post('update-outcome' , [App\Http\Controllers\Api\AdminController::class , 'updateOutcome']);
    Route::post('delete-outcome' , [App\Http\Controllers\Api\AdminController::class , 'deleteOutcome']);


    Route::post('get-incomes' , [App\Http\Controllers\Api\AdminController::class , 'getIncomes']);
    Route::post('add-income' , [App\Http\Controllers\Api\AdminController::class , 'addIncome']);
    Route::post('update-income' , [App\Http\Controllers\Api\AdminController::class , 'updateIncome']);
    Route::post('delete-income' , [App\Http\Controllers\Api\AdminController::class , 'deleteIncome']);




    Route::post('get-day' , [App\Http\Controllers\Api\AdminController::class , 'getDayData']);
    Route::post('get-month' , [App\Http\Controllers\Api\AdminController::class , 'getMonthData']);

});

//============================== end admin Api =======================================================
