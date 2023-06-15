<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Project extends Model
{
    protected $table = 'projects';
    protected $fillable =[
        'kind',
        'client_name',
        'client_phone',
        'deposit',
        'total',
        'description',
        'start_at',
        'end_at',
        'done',
    ];


    use HasFactory;
}
