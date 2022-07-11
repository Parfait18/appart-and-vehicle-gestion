<?php

namespace App\Http\Controllers\Vehicles;

use App\Http\Controllers\BaseController;
use App\Models\Vehicle;
use App\Models\VehicleHistoric;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class VehiclesRecapController extends BaseController
{
    //

    public function indexRecap()
    {
        return view('vehicle.vehicle_recap');
    }



    public function recapVehicles(Request $request)
    {

        $last_two_month = Carbon::now()->startOfMonth();
        $this_month = Carbon::now()->endOfMonth();

        if ($request->date_debut != null && $request->date_fin != null) {
            $last_two_month = $request->date_debut;
            $this_month = $request->date_fin;
        }

        $vehicle = VehicleHistoric::join('vehicles', 'vehicle_historics.vehicle_id', '=', 'vehicles.id')
            ->whereBetween('vehicle_historics.created_at', [$last_two_month . ' 00:00:00', $this_month . ' 23:59:59'])
            ->select(
                DB::raw('SUM(vehicle_historics.ca_daily) as ca_total'),
                DB::raw('SUM(vehicle_historics.travel_km) as km_total'),
                'vehicles.current_state',
                'vehicles.matricule'
            )
            ->groupBy('matricule')
            ->get();


        //list to get vehicle who don't have hsitorique
        $not_hist =  Vehicle::select('current_state', 'matricule')->whereNotIn(
            'id',
            VehicleHistoric::whereBetween(
                'vehicle_historics.created_at',
                [
                    $last_two_month . ' 00:00:00',
                    $this_month . ' 23:59:59'
                ]
            )
                ->groupBy('vehicle_id')
                ->pluck('vehicle_id')
        )
            ->get();


        $length = count($vehicle);
        foreach ($not_hist as $key => $value) {

            $vehicle[$length] = $value;
            $vehicle[$length]['ca_total'] = 0;
            $vehicle[$length]['km_total'] = 0;

            $length += 1;
        }


        $reponse = json_encode(array('data' => $vehicle), TRUE);

        return $reponse;
    }
}
