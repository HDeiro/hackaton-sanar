<?php

namespace App\Models\Relational;

use Illuminate\Database\Eloquent\Model;

class UserRole extends Model
{
	public $timestamps = true;
    protected $table = 'user_roles';
    protected $fillable = [
      'id',
      'user_id',
      'role_id',
      'created_at',
      'updated_at'
    ];
}
