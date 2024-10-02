<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LoginHistory extends Model
{
    protected $primaryKey = 'id';
	
	protected $table = 'login_history';
	
	public $timestamps = false;

    protected $fillable = [
        'user_id', 'login_time', 'logout_time', 'duration', 'duration_time', 'total_duration', 'total_duration_time', 'logout', 'date'
    ];

    use HasFactory;
}
