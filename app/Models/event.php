<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class event extends Model
{
    use HasFactory;
    protected $table = 'events_master'; 
    protected $fillable = ['id', 'user_id', 'link' , 'content', 'link_tmp', 'description_tmp', 'created_at', 'updated_at'];
}
