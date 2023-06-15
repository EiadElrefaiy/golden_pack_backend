<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Mince extends Model
{
    protected $table = 'mince';
    protected $fillable = [
        'employee_id',
        'money',
        'created_at'
    ];
    use HasFactory;
}
