<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Over extends Model
{
    protected $table = 'over';
    protected $fillable =[
        'employee_id',
        'money',
        'created_at'
    ];
    use HasFactory;
}
