<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\DB;
use Mockery\CountValidator\Exception;
use App\Models\Mission;
use App\Models\User;
use App\Utils;

class MissionController extends Controller
{
    public function completeMission() {
        DB::beginTransaction();
        try {
            $mission_id = Input::get('mission_id');

            Mission::find($mission_id)->update(['is_completed' => 1]);
            DB::commit();
            
            return [
                'success' => true
            ];
        } catch (\Exception $ex) {
            DB::rollback();
            return Utils::treatException($ex, 'Não foi possível atualizar Usuário');
        }
    }

    public function calcUserScore() {
        $score = User::find(Input::get('patient_id'))->calcScore();

        return [
            'success' => true,
            'data' => ['score' => $score]
        ];
    }

    public function listUserMissions() {
        try {
            $missions = Mission::where(function($query) {
                if(Input::has('begin_date'))
                    $query->whereDate('mission_deadline', '>=', Input::get('begin_date'));
                if(Input::has('end_date'))
                    $query->whereDate('mission_deadline', '<=', Input::get('end_date'));
                if(Input::has('is_completed'))
                    $query->where('is_completed', Input::get('is_completed'));
                if(Input::has('author_id'))
                    $query->where('author_id', Input::get('author_id'));
                if(Input::has('description'))
                    $query->where('description', 'like', '%'.Input::get('description').'%');
            })->where('patient_id', Input::get('patient_id'))->get();

            $score = User::find(Input::get('patient_id'))->calcScore();

            return [
                'success' => true,
                'data' => $missions,
                'score' => $score
            ];
        } catch (\Exception $ex) {
            return Utils::treatException($ex, 'Não foi possível atualizar Usuário');
        }
    }
}
