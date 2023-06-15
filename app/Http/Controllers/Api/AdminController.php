<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

use App\Models\Admin;
use App\Models\Employee;
use App\Models\Project;
use App\Models\Over;
use App\Models\Absence;
use App\Models\Attendance;
use App\Models\Loan;
use App\Models\Income;
use App\Models\Outcome;
use App\Models\Mince;
use App\Models\User;


class AdminController extends Controller
{
    //=================================== Admin =========================================================================================
    public function login(Request $request){
        $credntials = $request->only(['username' , 'password']);
       // $token = Auth::guard('api-admin')->attempt($credntials);
        $token = auth('api-admin')->attempt($credntials);

        if(!$token){
            return response()->json([
                'statues' => false,
                'msg' =>'This Admin is Not Found >>> No token',
            ]);
        }
        $admin = Auth::guard('api-admin')->user();
        $admin -> api_token = $token;

        return response() -> json([
            'status' => true ,
            'admin' => $admin
        ]);
    }

    public function getDayData(Request $request){
        $day = $request->day;
        $month = $request->month;
        $year = $request->year;
        $attendaces = Attendance::whereYear('created_at', '=', $year)->whereMonth('created_at', '=', $month)->whereDay('created_at', '=', $day)->get();
        for($n =0; $n < count($attendaces); $n++){
            $employee_name = Employee::where("id" , $attendaces[$n]-> employee_id)->pluck("name");
            $attendaces[$n]->employee_name = $employee_name[0];
        }
        $absences = Absence::whereYear('created_at', '=', $year)->whereMonth('created_at', '=', $month)->whereDay('created_at', '=', $day)->get();
        for($n =0; $n < count($absences); $n++){
            $employee_name = Employee::where("id" , $absences[$n]-> employee_id)->pluck("name");
            $absences[$n]->employee_name = $employee_name[0];
        }
        $loans = Loan::whereYear('created_at', '=', $year)->whereMonth('created_at', '=', $month)->whereDay('created_at', '=', $day)->get();
        for($n =0; $n < count($loans); $n++){
            $employee_name = Employee::where("id" , $loans[$n]-> employee_id)->pluck("name");
            $loans[$n]->employee_name = $employee_name[0];
        }
        $minces = Mince::whereYear('created_at', '=', $year)->whereMonth('created_at', '=', $month)->whereDay('created_at', '=', $day)->get();
        for($n =0; $n < count($minces); $n++){
            $employee_name = Employee::where("id" , $minces[$n]-> employee_id)->pluck("name");
            $minces[$n]->employee_name = $employee_name[0];
        }
        $overs = Over::whereYear('created_at', '=', $year)->whereMonth('created_at', '=', $month)->whereDay('created_at', '=', $day)->get();
        for($n =0; $n < count($overs); $n++){
            $employee_name = Employee::where("id" , $overs[$n]-> employee_id)->pluck("name");
            $overs[$n]->employee_name = $employee_name[0];
        }

        $incomes = Income::whereYear('created_at', '=', $year)->whereMonth('created_at', '=', $month)->whereDay('created_at', '=', $day)->get();
        $outcomes = Outcome::whereYear('created_at', '=', $year)->whereMonth('created_at', '=', $month)->whereDay('created_at', '=', $day)->get();


        return response() -> json([
            'status' => true ,
            'attendaces' => $attendaces,
            'absences' => $absences,
            'loans' => $loans,
            'minces' => $minces,
            'overs' => $overs,
            'incomes' => $incomes,
            'outcomes' => $outcomes,
        ]);
    }

    public function getMonthData(Request $request){
        $month = $request->month;
        $year = $request->year;
        $employee = Employee::get("id");
        $employees_total = 0;

        for($n = 0; $n < count($employee); $n++){
            $emp = Employee::find($employee[$n]->id);

            $name = $emp->name;
            $salary = $emp->money;

            $employee_attendance = Attendance::where("employee_id" , $employee[$n]->id)->whereYear('created_at', '=', $year)->whereMonth('created_at', '=', $month)->get();
            $attendance_count = count($employee_attendance);
            $attendaces_money = $employee_attendance->pluck("money")->sum();

            $employee_absence = Absence::where("employee_id" , $employee[$n]->id)->whereYear('created_at', '=', $year)->whereMonth('created_at', '=', $month)->get();
            $absence_count = count($employee_absence);
            $absences_money = $employee_absence->pluck("money")->sum();

            $employee_loan = Loan::where("employee_id" , $employee[$n]->id)->whereYear('created_at', '=', $year)->whereMonth('created_at', '=', $month)->get();
            $loan_count = count($employee_loan);
            $loans_money = $employee_loan->pluck("money")->sum();

            $employee_mince = Mince::where("employee_id" , $employee[$n]->id)->whereYear('created_at', '=', $year)->whereMonth('created_at', '=', $month)->get();
            $mince_count = count($employee_mince);
            $minces_money = $employee_mince->pluck("money")->sum();

            $employee_over = Over::where("employee_id" , $employee[$n]->id)->whereYear('created_at', '=', $year)->whereMonth('created_at', '=', $month)->get();
            $over_count = count($employee_over);
            $overs_money = $employee_over->pluck("money")->sum();

            $total = ($attendaces_money  + $overs_money) - ($absences_money + $loans_money + $minces_money );

            $employee[$n]-> name = $name;
            $employee[$n]-> salary = $salary;
            $employee[$n]-> attendance_count = $attendance_count;
            $employee[$n]-> absence_count = $absence_count;
            $employee[$n]-> loans_money = $loans_money;
            $employee[$n]-> minces_money = $minces_money;
            $employee[$n]-> overs_money = $overs_money;
            $employee[$n]-> total = $total;

            if($attendance_count != 0){
                $employees_total = $employees_total + $total;
            }
        }


        $incomes = Income::whereYear('created_at', '=', $year)->whereMonth('created_at', '=', $month)->get();
        $outcomes = Outcome::whereYear('created_at', '=', $year)->whereMonth('created_at', '=', $month)->get();

        return response() -> json([
            'status' => true ,
            'employee' => $employee,
            "employees_total" => $employees_total,
            'incomes' => $incomes,
            'outcomes' => $outcomes,
        ]);
    }
    public function getEmployees(){
        $employees = Employee::where("existed" , 1)->get();
        return response() -> json([
            'status' => true ,
            'employees' => $employees
        ]);
    }

    public function getEmployeeId(Request $request){
        $month = $request->month;
        $year = $request->year;
        //$year = Date('Y');
        //$month = Date('m');
        //$day = Date("d");
        $employee = Employee::find($request ->id);
        $empolyeeLoans = Loan::where("employee_id" , $request ->id)->whereYear('created_at', '=', $year)->whereMonth('created_at', '=', $month)->get();
        $empolyeeMinces = Mince::where("employee_id" , $request ->id)->whereYear('created_at', '=', $year)->whereMonth('created_at', '=', $month)->get();
        $empolyeeOver = Over::where("employee_id" , $request ->id)->whereYear('created_at', '=', $year)->whereMonth('created_at', '=', $month)->get();
        $empolyeeAttendance = Attendance::where("employee_id" , $request ->id)->whereYear('created_at', '=', $year)->whereMonth('created_at', '=', $month)->get();
        $empolyeeAbsence = Absence::where("employee_id" , $request ->id)->whereYear('created_at', '=', $year)->whereMonth('created_at', '=', $month)->get();

        return response() -> json([
            'status' => true ,
            'employee' => $employee,
            'empolyeeLoans' => $empolyeeLoans,
            'empolyeeMinces' => $empolyeeMinces,
            'empolyeeOver' => $empolyeeOver,
            'empolyeeAttendance' => $empolyeeAttendance,
            'empolyeeAbsence' => $empolyeeAbsence,
        ]);
    }

    public function addEmployee(Request $request){
      $employee =  Employee::create([
            'name' => $request->name,
            'phone' => $request ->phone,
            'address'=> $request -> address,
            'money'=> $request -> money,
            'existed'=> 1,
        ]);
        return response() -> json([
            'status' => true ,
            'msg' => 'تم اضافة الموظف',
            'id' => $employee->id,
            "date" => $employee->created_at
        ]);
    }

    public function updatesEmployee(Request $request){
        $employee = Employee::find($request ->id);
        $employee ->update([
            'name' => $request->name,
            'phone' => $request ->phone,
            'address'=> $request -> address,
            'money'=> $request -> money,
            'created_at'=> $request -> start_date,
        ]);
        return response() -> json([
            'status' => true ,
            'msg' => 'تم تعديل الموظف'
        ]);
    }

    public function deleteEmployee(Request $request){
        $employee = Employee::find($request ->id);
        $employee -> update([
            'existed'=> 0,
    ]);
        return response() -> json([
            'status' => true ,
            'msg' => 'تم حذف الموظف'
        ]);
    }

    //================================= Projects ======================================================================================

    public function getProjects(){
        $projects = Project::get();
        return response() -> json([
            'status' => true ,
            'projects' => $projects
        ]);
    }

    public function getProjectId(Request $request){
        $project = Project::find($request ->id);
        return response() -> json([
            'status' => true ,
            'project' => $project
        ]);
    }

    public function addProject(Request $request){
      $project =  Project::create([
            'kind' => $request->kind,
            'client_name' => $request ->client_name,
            'client_phone'=> $request -> client_phone,
            'deposit'=> $request -> deposit,
            'total'=> $request -> total,
            'description'=> $request -> description,
            'done'=> 0,
        ]);

        $project ->update([
            'start_at'=> $request -> start_at,
            'end_at'=> $request -> end_at,
        ]);

        return response() -> json([
            'status' => true ,
            'id' => $project->id ,
            'msg' => 'تم اضافة المشروع'
        ]);
    }

    public function updateProject(Request $request){
        $project = Project::find($request ->id);
        $project->update([
            'kind' => $request->kind,
            'client_name' => $request ->client_name,
            'client_phone'=> $request -> client_phone,
            'deposit'=> $request -> deposit,
            'total'=> $request -> total,
            'start_at'=> $request -> start_at,
            'end_at'=> $request -> end_at,
            'done'=> $request -> done,
        ]);
        return response() -> json([
            'status' => true ,
            'msg' => 'تم تعديل المشروع'
        ]);
    }

    public function deleteProject(Request $request){
        $project = Project::find($request ->id);
        $project -> delete();
        return response() -> json([
            'status' => true ,
            'msg' => 'تم حذف المشروع'
        ]);
    }

    //================================= Loans  ==========================================================================================
    public function getLoans(){
        $loans = Loan::get();

        for($n = 0; $n < count($loans); $n++){
            $name = Employee::where("id" , $loans[$n]->employee_id)->pluck("name");
            $loans[$n] -> name = $name[0];
        }
        return response() -> json([
            'status' => true ,
            'loans' => $loans
        ]);
    }

    public function addLoan(Request $request){
       $loan = Loan::create([
        'employee_id' => $request -> id,
        'money' => $request-> money,
        ]);

        $loan ->update([
          'created_at' => $request -> date
        ]);

        return response() -> json([
            'status' => true ,
            'id' => $loan -> id ,
            'date' => $loan -> created_at,
            'msg' => "تم اضافة السلفة للموظف"
        ]);
    }

    public function updateLoan(Request $request){
        $loan = Loan::find($request ->id);
        $loan ->update([
            'money' => $request-> money,
            'created_at' => $request-> date ,
        ]);
        return response() -> json([
            'status' => true ,
            'msg' => "تم تعديل السلفة للموظف"
        ]);
    }

    public function deleteLoan(Request $request){
        $loan = Loan::find($request ->id);
        $loan -> delete();
        return response() -> json([
            'status' => true ,
            'msg' => 'تم حذف السلفة'
        ]);
    }

    //================================= Minces  ==========================================================================================

    public function getMinces(){
        $minces = Mince::get();
        for($n = 0; $n < count($minces); $n++){
            $name = Employee::where("id" , $minces[$n]->employee_id)->pluck("name");
            $minces[$n] -> name = $name[0];
        }

        return response() -> json([
            'status' => true ,
            'mince' => $minces
        ]);
    }

    public function addMince(Request $request){
       $mince = Mince::create([
        'employee_id' => $request -> id,
        'money' => $request-> money,
        ]);

       $mince -> update([
        'created_at' => $request -> date
       ]);


        return response() -> json([
            'status' => true ,
            'id' => $mince->id ,
            'date' => $mince->created_at ,
            'msg' => "تم اضافة الخصم للموظف"
        ]);
    }

    public function updateMince(Request $request){
        $mince = Mince::find($request ->id);
        $mince ->update([
            'money' => $request-> money,
            'created_at' => $request-> date ,
        ]);
        return response() -> json([
            'status' => true ,
            'msg' => "تم تعديل الخصم للموظف"
        ]);
    }

    public function deleteMince(Request $request){
        $mince = Mince::find($request ->id);
        $mince -> delete();
        return response() -> json([
            'status' => true ,
            'msg' => 'تم حذف الخصم'
        ]);
    }

   //================================= Overs  ==========================================================================================

   public function getOvers(){
    $overs = Over::get();
    for($n = 0; $n < count($overs); $n++){
        $name = Employee::where("id" , $overs[$n]->employee_id)->pluck("name");
        $overs[$n] -> name = $name[0];
    }
    return response() -> json([
        'status' => true ,
        'overs' => $overs
    ]);
}

public function addOver(Request $request){
   $over = Over::create([
    'employee_id' => $request -> id,
    'money' => $request-> money,
    ]);
   $over ->update([
      'created_at'=> $request->date
   ]);


    return response() -> json([
        'status' => true ,
        'id' => $over ->id ,
        'date' => $over ->created_at ,
        'msg' => "تم اضافة الزيادة للموظف"
    ]);
}

public function updateOver(Request $request){
    $over = Over::find($request ->id);
    $over ->update([
        'money' => $request-> money,
        'created_at' => $request-> date,
    ]);
    return response() -> json([
        'status' => true ,
        'msg' => "تم تعديل الزيادة للموظف"
    ]);
}

public function deleteOver(Request $request){
    $over = Over::find($request ->id);
    $over -> delete();
    return response() -> json([
        'status' => true ,
        'msg' => 'تم حذف الزيادة'
    ]);
}
   //================================= Attendance  ==========================================================================================

   public function getAttendances (Request $request){
    $attendances = Attendance::where("employee_id" , $request ->id)->get();
    for($n = 0; $n < count($attendances); $n++){
        $name = Employee::where("id" , $attendances[$n]->employee_id)->pluck("name");
        $attendances[$n] -> name = $name[0];
    }
    return response() -> json([
        'status' => true ,
        'attendances' => $attendances
    ]);
}

public function addAttendance(Request $request){
    $employee = Employee::find($request->id);
  $attendance  =  Attendance::create([
    'employee_id' => $request -> id,
    'from' => $request -> from,
    'to' => $request -> to,
    'money' => $employee->money
    ]);

    $attendance->update([
       'created_at' => $request->date
    ]);
    return response() -> json([
        'status' => true ,
        'id' => $attendance -> id,
        'date' => $attendance -> created_at,
        'money' => $attendance -> money,
        'msg' => "تم اضافة الحضور للموظف"
    ]);
}

public function updateAttendance(Request $request){
  $attendance = Attendance::find($request ->id);
   $attendance ->update([
    'employee_id' => $request -> employee_id,
    'from' => $request -> from,
    'to' => $request -> to,
    'created_at' => $request->date
    ]);

    return response() -> json([
        'status' => true ,
        'msg' => "تم تعديل الحضور للموظف"
    ]);
}


public function deleteAttendance(Request $request){
    $attendance = Attendance::find($request ->id);
    $attendance -> delete();
    return response() -> json([
        'status' => true ,
        'msg' => 'تم حذف الحضور'
    ]);
}


   //================================= Absence  ==========================================================================================

   public function getAbsences(){
    $absences = Absence::where("employee_id" , $request ->id)->get();
    for($n = 0; $n < count($absences); $n++){
        $name = Employee::where("id" , $absences[$n]->employee_id)->pluck("name");
        $absences[$n] -> name = $name[0];
    }
    return response() -> json([
        'status' => true ,
        'absences' => $absences
    ]);
}

public function addAbsence(Request $request){
    $employee = Employee::find($request->id);
   $absence = Absence::create([
    'employee_id' => $request -> id,
    'money' => $employee -> money,
    ]);
   $absence -> update([
      'created_at'=> $request -> date
   ]);
    return response() -> json([
        'status' => true ,
        'id' => $absence-> id ,
        'date' => $absence -> created_at ,
        'money' => $absence -> money ,
        'msg' => "تم اضافة الغياب للموظف"
    ]);
}


public function deleteAbsence(Request $request){
    $absence = Absence::find($request ->id);
    $absence -> delete();
    return response() -> json([
        'status' => true ,
        'msg' => 'تم حذف الغياب'
    ]);
}

//================================= outcomes  ===========================================================================================
public function getOutcomes(){
    $outcomes = Outcome::get();
    return response() -> json([
        'status' => true ,
        'outcomes' => $outcomes
    ]);
}

public function addOutcome(Request $request){
   $outcome = Outcome::create([
    'money' => $request -> money,
    'description' => $request -> description,
    ]);
    $outcome ->update([
        'created_at' => $request->date
    ]);

    return response() -> json([
        'status' => true ,
        "id" => $outcome->id,
        'msg' => "تم اضافة العملية"
    ]);
}

public function updateOutcome(Request $request){
    $outcome = Outcome::find($request ->id);
    $outcome -> update([
        'money' => $request -> money,
        'description' => $request -> description,
        ]);
        return response() -> json([
            'status' => true ,
            'msg' => "تم تعديل العملية"
        ]);
    }

    public function deleteOutcome(Request $request){
        $outcome = Outcome::find($request ->id);
        $outcome -> delete();
        return response() -> json([
            'status' => true ,
            'msg' => "تم حذف العملية"
        ]);
    }

//================================= incomes  ===========================================================================================
public function getIncomes(){
    $incomes = Income::get();
    return response() -> json([
        'status' => true ,
        'incomes' => $incomes
    ]);
}

public function addIncome(Request $request){
   $income = Income::create([
    'money' => $request -> money,
    'description' => $request -> description,
    ]);

    $income ->update([
        'created_at' => $request->date
    ]);

    return response() -> json([
        'status' => true ,
        'id' => $income->id,
        'msg' => "تم اضافة العملية"
    ]);
}

public function updateIncome(Request $request){
    $income = Income::find($request ->id);
    $income -> update([
        'money' => $request -> money,
        'description' => $request -> description,
        ]);
        return response() -> json([
            'status' => true ,
            'msg' => "تم تعديل العملية"
        ]);
    }

    public function deleteIncome(Request $request){
        $income = Income::find($request ->id);
        $income -> delete();
        return response() -> json([
            'status' => true ,
            'msg' => "تم حذف العملية"
        ]);
    }


}

