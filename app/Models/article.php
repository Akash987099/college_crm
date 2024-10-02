<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class article extends Model
{
    use HasFactory;
    protected $table = 'articles'; 
    protected $fillable = ['id', 'user_id', 'image' , 'title', 'description', 'title_tmp' , 'description_tmp', 'created_at', 'updated_at'];
}
