<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Program extends Model
{
    use HasFactory;

    protected $table = 'program_master';
    // replace programs
	
    protected $fillable = [
        'name',
        'user_id',
        'status',
        'created_by',
    ];
    
}
