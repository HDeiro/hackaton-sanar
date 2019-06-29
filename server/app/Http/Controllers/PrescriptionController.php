<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\DB;
use App\Models\Prescription;
use App\Models\PrescriptionItem;
use App\Models\Mission;
use App\Utils;
use Carbon\Carbon;

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
        $prescription = Prescription::find($id);

        return [
            'success' => isset($prescription),
            'data' => $prescription
        ];
    }

    public function store(Request $request) {
        DB::beginTransaction();
        try {
            $prescription_items = Input::get('prescription_items');
			$data = Input::except([
                'prescription_items'
            ]);

            $prescription = Prescription::create($data);

            foreach($prescription_items as $prescription_item) {
                $prescription_item['prescription_id'] = $prescription['id'];
                $prescription_item = PrescriptionItem::create($prescription_item);

                $initial_date = Carbon::createFromFormat(
                    Utils::$default_date_format, 
                    $prescription_item['initial_date']
                );
                $final_date = Carbon::createFromFormat(
                    Utils::$default_date_format, 
                    $prescription_item['final_date']
                );

                while($initial_date->lessThanOrEqualTo($final_date)) {
                    $prescription_item_date = $initial_date->format(Utils::$default_date_format);

                    switch (strtolower($prescription_item['periodicity_type'])) {
                        case 'i': $initial_date->addMinutes($prescription_item['periodicity']); break;    
                        case 'h': $initial_date->addHours($prescription_item['periodicity']); break;                        
                        case 'd': $initial_date->addDays($prescription_item['periodicity']); break;                        
                        case 'w': $initial_date->addWeeks($prescription_item['periodicity']); break;                        
                        case 'm': $initial_date->addMonths($prescription_item['periodicity']); break;
                        default: $initial_date->addDays($prescription_item['periodicity']); break;                         
                    }

                    $mission = Mission::create([
                        'description' => $prescription_item['description'],
                        'author_id' => $prescription['author_id'],
                        'prescription_item_id' => $prescription_item['id'],
                        'patient_id' => $prescription['patient_id'],
                        'mission_deadline' => $prescription_item_date
                    ]);
                }

            }

           DB::commit();

            return [
                'success' => true
            ];
        } catch (\Exception $ex) {
            DB::rollback();
            return Utils::treatException($ex, 'Não foi possível criar Usuário');
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
