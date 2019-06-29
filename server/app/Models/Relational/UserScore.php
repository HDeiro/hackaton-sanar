<?php

namespace App\Models\Relational;

use Illuminate\Database\Eloquent\Model;

class UserScore extends Model
{
	public $timestamps = true;
    protected $table = 'user_score';
    protected $fillable = [
      'id',
      'mission_id',
      'user_id',
      'is_completed',
      'created_at',
      'updated_at'
    ];
}
