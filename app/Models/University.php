<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class University extends Model
{
    use HasFactory;

    protected $table = 'university_master'; 
    protected $fillable = [
        'name',
        'address',
        'state',
        'pincode',
        'country',
        'university_type',
        'established',
        'description',
    ];

}
