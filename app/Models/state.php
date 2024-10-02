<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class state extends Model
{
    use HasFactory;
    protected $table = 'state_master'; 
    protected $fillable = ['id', 'country_id', 'state_name','created_at', 'updated_at'];
}
