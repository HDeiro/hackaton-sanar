<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\DB;
use App\Models\Prescription;
use App\Utils;

class PrescriptionController extends Controller
{
	public function index() {
        $query = Prescription::where(function($query) {
            /*if (Input::has('q') && !empty(Input::get('q'))) {
                $q = Input::get('q');
                $query->where('prescription.author_id', 'like', '%'.$q.'%');
            }*/
        });

        // Count the number of occurrences in Prescription table
        $count = $query->count();

        // Skips / Fetch elements
        if( !Input::has('skip') && !Input::has('take')) {
            $dataset = $query->get();
        } else {
            $dataset = $query->skip(Input::get('skip', 0))
                ->take(Input::get('take', Utils::$posts_per_page))
            ->get();
        }

        return [
            'success' => true,
            'data' => $dataset,
            'count' => $count
        ];
    }

    public function show($id) {
        $role = Prescription::find($id);

        return [
            'success' => isset($role),
            'data' => $role
        ];
    }

    public function store(Request $request) {
        DB::beginTransaction();
        try {
			$data = Input::except([]);

            $role = Prescription::create($data);

            DB::commit();

            return [
                'success' => true
            ];
        } catch (\Exception $ex) {
            DB::rollback();
            return Utils::treatException($ex, 'Não foi possível criar Usuário');
        }
    }

    public function update($id, Request $request) {
        DB::beginTransaction();
        try {
            $data = Input::except([]);

            Prescription::find($id)->update($data);

            DB::commit();
            return [
                'success' => true
            ];
        } catch (\Exception $ex) {
            DB::rollback();
            return Utils::treatException($ex, 'Não foi possível atualizar Usuário');
        }
    }

    public function destroy($id) {
        DB::beginTransaction();
        try {
            Prescription::where('id', $id)
                ->firstOrFail()
            ->delete();

            DB::commit();

            return [
				'success' => true
			];
        } catch (\Exception $ex) {
            DB::rollback();
            return Utils::treatException($ex, 'Não foi possível deletar Usuário');
        }
    }
}
