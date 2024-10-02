<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class bord extends Model
{
    use HasFactory;
    protected $table = 'bord_of_director'; 
    protected $fillable = ['id', 'user_id', 'name' , 'qualification', 'designation', 'image', 'created_at', 'updated_at'];
}
