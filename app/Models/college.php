<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class college extends Model
{
    use HasFactory;
    protected $table = 'college_master'; 
    protected $fillable = [
        'name',
        'address',
        'state',
        'pincode',
        'university_type',
        'department',
        'Established',
        'description',
        'logo', 
        'image',
    ];

}
