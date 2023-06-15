<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Absence extends Model
{
    protected $table = 'absence';
    protected $fillable =[
        'employee_id',
        'money'
    ];
    use HasFactory;
}
