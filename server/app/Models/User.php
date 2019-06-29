<?php

namespace App\Models;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
use App\Functions;
use App\Models\Relational\UserRole;

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

    public function listRoles() {
        $this['roles'] = UserRole::join('role', 'user_roles.role_id', 'role.id')
            ->where('user_roles.user_id', $this['id'])
            ->select('role.id', 'role.description')
            ->get();
    }
}
