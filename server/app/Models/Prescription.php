<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Prescription extends Model
{
    public $timestamps = true;
    protected $table = 'prescription';
    protected $fillable = [
		'id',
		'author_id',
		'patient_id'
    ];
}
