<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class user_trans extends Model
{
    use HasFactory;
    protected $table = 'user_facility_trans'; 
    protected $fillable = ['id', 'user_id', 'title' , 'content' , 'description_tmp' , 'title_tmp' ,'created_at', 'updated_at'];
}
