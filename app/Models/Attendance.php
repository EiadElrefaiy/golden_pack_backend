<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Attendance extends Model
{
    protected $table = 'attendance';
    protected $fillable =[
        'employee_id',
        'from',
        'to',
        'money',
        'created_at'
    ];
    use HasFactory;
}
