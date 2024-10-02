<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class admin_history extends Model
{
    use HasFactory;
    protected $table = 'history_reports';
    protected $fillable = ['user_id', 'name', 'data', 'mode'];
}
