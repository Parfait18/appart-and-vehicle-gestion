<?php

namespace App\Http\Controllers\Vehicles;

use App\Http\Controllers\BaseController;
use App\Models\Vehicle;
use App\Models\VehicleHistoric;
use Carbon\Carbon;
use DateTime;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class VehicleHistoricController extends BaseController
{
    //
    public function getVehicleActivities(Request $request)
    {
        return view('vehicle.vehicle_historic_dash');
    }

    public function store(Request $request)
    {
        $user_id = Auth::user()->id;

        $request->validate([
            'start_time' => 'required',
            'start_km' => 'required',
            'vehicle_id' => 'required',
        ]);

        $historic_update_orcreate = VehicleHistoric::create([
            //     'vehicle_id'  => $request->vehicle_id,
            //     'created_at' => Carbon::now(),
            // ], [

            'start_time' => $request->start_time,
            'start_km' => $request->start_km,
            'vehicle_id' => $request->vehicle_id,
            'user_id' => $user_id,
            'status' => 'EN COURS',
        ]);
        Vehicle::where('id', $request->vehicle_id)->update([
            'current_state' => 'OCCUPE',
        ]);

        return $this->sendResponse(
            'Enregistrement réussi',
            $historic_update_orcreate
        );
    }

    public function getHistoric(Request $request)
    {
        $last_two_month = Carbon::now()->startOfMonth();
        $this_month = Carbon::now()->endOfMonth();

        if ($request->date_debut != null && $request->date_fin != null) {
            $last_two_month = $request->date_debut;
            $this_month = $request->date_fin;
        }

        $vehicle = VehicleHistoric::join(
            'vehicles',
            'vehicle_historics.vehicle_id',
            '=',
            'vehicles.id'
        )
            ->select(
                'vehicles.matricule',
                'vehicles.name',
                'vehicles.color',
                'vehicles.status',
                'vehicle_historics.*'
            )
            // ->where('vehicles.status', 1)
            ->whereBetween('vehicle_historics.start_time', [
                $last_two_month . ' 00:00:00',
                $this_month . ' 23:59:59',
            ])
            ->get();

        $reponse = json_encode(['data' => $vehicle], true);

        return $reponse;
    }

    public function getHistoricById(Request $request)
    {
        $historic = VehicleHistoric::join(
            'vehicles',
            'vehicle_historics.vehicle_id',
            '=',
            'vehicles.id'
        )
            ->select(
                'vehicles.matricule',
                'vehicles.name',
                'vehicles.color',
                'vehicles.status',
                'vehicle_historics.*'
            )
            ->where('vehicle_historics.id', $request->id)
            ->first();

        $reponse = json_encode(['data' => $historic], true);

        return $reponse;
    }

    public function updateHistoric(Request $request)
    {
        $request->validate([
            'start_time' => 'required',
            'start_km' => 'required',
            'arrival_time' => 'required',
            'arrival_km' => 'required',
            'historic_id' => 'required',
            'travel_time' => 'required',
            'amount_repaid' => 'required',
        ]);

        // 'ca_daily' => 'required',
        // 'travel_time' => 'required',
        // 'travel_km' => 'required',

        $historic = VehicleHistoric::where(
            'id',
            $request->historic_id
        )->first();

        if (!$historic) {
            return $this->sendError('Aucune donnée trouvée');
        }

        $start_time = Carbon::parse($request->start_time);
        $arrival_time = Carbon::parse($request->arrival_time);
        $today = Carbon::now()->addHour(1);

        if ($request->start_time != null && $request->arrival_time != null) {
            if ($today->gt($arrival_time)) {
                Vehicle::where('matricule', $request->vehicle_id)->update([
                    'current_state' => 'LIBRE',
                ]);

                VehicleHistoric::where('id', $request->historic_id)->update([
                    'ca_daily' => $request->amount_repaid,
                    'start_km' => $request->start_km,
                    'travel_time' => $request->travel_time,
                    'travel_km' => get_km_diff(
                        $request->start_km,
                        $request->arrival_km
                    ),
                    'start_km' => $request->start_km,
                    'arrival_time' => $request->arrival_time,
                    'arrival_km' => $request->arrival_km,
                    'amount_repaid' => $request->amount_repaid,
                    'status' => 'TERMINE',
                ]);
            } elseif ($start_time->lte($today) && $today->lte($arrival_time)) {
                Vehicle::where('matricule', $request->vehicle_id)->update([
                    'current_state' => 'OCCUPE',
                ]);

                VehicleHistoric::where('id', $request->historic_id)->update([
                    'ca_daily' => $request->amount_repaid,
                    'start_km' => $request->start_km,
                    'travel_time' => $request->travel_time,
                    'travel_km' => get_km_diff(
                        $request->start_km,
                        $request->arrival_km
                    ),
                    'arrival_time' => $request->arrival_time,
                    'arrival_km' => $request->arrival_km,
                    'amount_repaid' => $request->amount_repaid,
                    'status' => 'EN COURS',
                ]);
            } elseif ($start_time->gt($today) && $today->lt($arrival_time)) {
                Vehicle::where('matricule', $request->vehicle_id)->update([
                    'current_state' => 'OCCUPE',
                ]);

                VehicleHistoric::where('id', $request->historic_id)->update([
                    'ca_daily' => $request->amount_repaid,
                    'start_km' => $request->start_km,
                    'travel_time' => $request->travel_time,
                    'travel_km' => get_km_diff(
                        $request->start_km,
                        $request->arrival_km
                    ),
                    'arrival_time' => $request->arrival_time,
                    'arrival_km' => $request->arrival_km,
                    'amount_repaid' => $request->amount_repaid,
                    'status' => 'RESERVE',
                ]);
            }
        } else {
            Vehicle::where('matricule', $request->vehicle_id)->update([
                'current_state' => 'OCCUPE',
            ]);

            VehicleHistoric::where('id', $request->historic_id)->update([
                'ca_daily' => $request->amount_repaid,
                'start_km' => $request->start_km,
                'travel_time' => $request->travel_time,
                'status' => 'TERMINE',
            ]);
        }

        return $this->sendResponse('Enregistrement réussi');
    }
}
