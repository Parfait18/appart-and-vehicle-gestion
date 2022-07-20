<?php

namespace App\Http\Controllers\Vehicles;

use App\Http\Controllers\BaseController;
use App\Http\Controllers\Controller;
use App\Models\Repair;
use App\Models\Vehicle;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Illuminate\Support\Str;


class VehicleRepairController extends BaseController
{

    public function indexRepair()
    {

        return view('vehicle.vehicle_repair');
    }

    public function geVehicleRecapData()
    {
        $total_vehicle = Vehicle::all()->count();

        $disabled_vehicle = Vehicle::where('status', 0)->get()->count();

        $active_vehicle = Vehicle::where('status', 1)
            ->where('current_state', "OCCUPE")
            ->get()->count();

        $available_vehicle = Vehicle::where('status', 1)->where('current_state', "LIBRE")->get()->count();

        return  ["total" => $total_vehicle, "disabled_vehicle" => $disabled_vehicle, "active_vehicle" => $active_vehicle, "available_vehicle" => $available_vehicle];
    }


    public function store(Request $request)
    {
        $request->validate([
            'vehicle_matricule' => 'required|min:2|max:255',
            'oil_change_date' => 'required',
            'pneumatic_change_date' => 'required',
            'brake_change_date' => 'required',

        ]);



        $new_repair =  Repair::create([
            'vehicle_matricule' => $request->vehicle_matricule,
            'oil_change_date' =>  $request->oil_change_date,
            'pneumatic_change_date' => $request->pneumatic_change_date,
            'brake_change_date' => $request->brake_change_date
        ]);

        return  $this->sendResponse("Enregistrement réussi", $new_repair);
    }


    public function getRepairs()
    {
        $vehicle_list = Repair::all();

        $reponse = json_encode(array('data' => $vehicle_list), TRUE);

        return $reponse;
    }

    public function getRepairById(Request $request)
    {

        $vehicle = Repair::where('id', $request->id)->first();

        $reponse = json_encode(array('data' => $vehicle), TRUE);

        return $reponse;
    }

    public function updateRepair(Request $request)
    {
        $request->validate([
            'vehicle_matricule' => 'required|min:2|max:255',
            'oil_change_date' => 'required',
            'pneumatic_change_date' => 'required',
            'brake_change_date' => 'required',

        ]);


        Repair::where('id', $request->repair_id)
            ->update([
                'vehicle_matricule' => $request->vehicle_matricule,
                'oil_change_date' =>  $request->oil_change_date,
                'pneumatic_change_date' => $request->pneumatic_change_date,
                'brake_change_date' => $request->brake_change_date
            ]);


        return  $this->sendResponse("Enregistrement réussi");
    }
}
