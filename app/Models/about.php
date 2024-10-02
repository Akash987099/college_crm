<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class about extends Model
{
    use HasFactory;
    protected $table = 'about_master'; 
    protected $fillable = ['id', 'user_id', 'title' , 'description', 'title_tmp', 'description_tmp', 'created_at', 'updated_at'];
}
