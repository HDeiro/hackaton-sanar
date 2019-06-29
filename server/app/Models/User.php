<?php

namespace App\Models;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Support\Facades\DB;
use App\Models\Mission;
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

    public function calcScore() {
        $this['score'] = Mission::select(DB::raw('NVL(SUM(mission.score), 0) as sum_score'))
            ->where('mission.is_completed', 1)
            ->where('patient_id', $this['id'])
            ->pluck('sum_score')
            ->first();
        return $this['score'];
    }
}
