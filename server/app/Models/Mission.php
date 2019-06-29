<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Mission extends Model
{
	public $timestamps = true;
    protected $table = 'mission';
    protected $fillable = [
      'id',
      'description',
      'author_id',
      'score',
      'prescription_item_id',
      'created_at',
      'updated_at',
      'mission_deadline',
      'patient_id',
      'is_completed'
    ];
}
