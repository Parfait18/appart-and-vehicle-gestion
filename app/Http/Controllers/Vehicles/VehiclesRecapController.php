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
        $total_vehicle = Vehicle::all()->count();

        $disabled_vehicle = Vehicle::where('status', 0)->get()->count();

        $active_vehicle = Vehicle::where('status', 1)->get()->count();

        return view('vehicle.vehicle_recap', ["total" => $total_vehicle, "disabled_vehicle" => $disabled_vehicle, "active_vehicle" => $active_vehicle]);
    }
    public function getVehicleRecapData()
    {
        $total_vehicle = Vehicle::all()->count();

        $disabled_vehicle = Vehicle::where('status', 0)->get()->count();

        $active_vehicle = Vehicle::where('status', 1)->where('current_state', "OCCUPE")->get()->count();

        $available_vehicle = Vehicle::where('status', 1)->where('current_state', "LIBRE")->get()->count();

        return  ["total" => $total_vehicle, "disabled_vehicle" => $disabled_vehicle, "active_vehicle" => $active_vehicle, "available_vehicle" => $available_vehicle];
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

        $reponse = json_encode(array('data' => $vehicle), TRUE);

        return $reponse;
    }
}
