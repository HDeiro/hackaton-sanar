<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Role extends Model
{
	public $timestamps = true;
    protected $table = 'role';
    protected $fillable = [
		'id',
		'description',
    ];
}
