<?php

namespace App\Models;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
use App\Functions;

class User extends Authenticatable
{
    use Notifiable;

    public function __construct(array $attributes = array()) {
        parent::__construct($attributes);
    }

    public $timestamps = true;
    protected $table = 'user';
    protected $hidden = [
        'password',
    ];
    protected $fillable = [
        'id',
        'name',
        'email',
        'password',
        'created_at',
        'updated_at',
    ];
}
