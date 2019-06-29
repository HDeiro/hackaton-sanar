<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class role extends Model
{
    public function __construct($attributes)
	{
		parent::__construct($attributes);
	}
	public $timestamps = true;
    protected $table = 'role';
    protected $fillable = [
		'id',
		'description',
    ];
}
