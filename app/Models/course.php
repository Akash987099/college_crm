<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class course extends Model
{
    use HasFactory;
    protected $table = 'courses'; 
    protected $fillable = ['id', 'user_id', 'description', 'description_tmp', 'created_at', 'updated_at'];
}
