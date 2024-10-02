<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class admission extends Model
{
    use HasFactory;
    protected $table = 'admission_master'; 
    protected $fillable = ['id', 'user_id', 'link' , 'content', 'link_tmp', 'description_tmp', 'created_at', 'updated_at'];
}
