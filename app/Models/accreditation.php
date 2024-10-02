<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class accreditation extends Model
{
    use HasFactory;
    protected $table = 'accreditations_master'; 
    protected $fillable = ['id', 'user_id', 'title' , 'content', 'title_tmp', 'description_tmp', 'created_at', 'updated_at'];
}
