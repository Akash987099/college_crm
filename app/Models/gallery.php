<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class gallery extends Model
{
    use HasFactory;
    protected $table = 'gallery_master'; 
    protected $fillable = ['id', 'user_id', 'image' ,'created_at', 'updated_at'];
}
