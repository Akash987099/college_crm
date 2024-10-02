<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class user_facility extends Model
{
    use HasFactory;
    protected $table = 'user_facility'; 
    protected $fillable = ['id', 'user_id', 'title' , 'description', 'title_tmp', 'description_tmp', 'created_at', 'updated_at'];
}
