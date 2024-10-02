<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class tbl extends Model
{
    use HasFactory;
    protected $table = 'user_tbl_placement'; 
    protected $fillable = ['id', 'user_id', 'link' , 'content', 'link_tmp', 'description_tmp', 'created_at', 'updated_at'];
}
