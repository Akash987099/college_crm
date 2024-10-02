<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class City extends Model
{
    use HasFactory;
    protected $table = 'city_master'; // Specify the table name if it's different
    protected $fillable = ['name', 'pincode', 'region_id'];
}
