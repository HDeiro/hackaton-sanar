<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PrescriptionItem extends Model
{
	public $timestamps = true;
    protected $table = 'prescription_item';
    protected $fillable = [
      'id',
      'description',
      'extra_info',
      'periodicity',
      'prescription_id',
      'created_at',
      'updated_at',
    ];
}
