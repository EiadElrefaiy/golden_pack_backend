<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Outcome extends Model
{
    protected $table = 'outcome';
    protected $fillable =[
        'money',
        'description',
        'created_at'
    ];
    use HasFactory;
}
