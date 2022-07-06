<?php

namespace App\Http\Controllers\Vehicles;

use App\Http\Controllers\BaseController;
use App\Models\Vehicle;
use Illuminate\Http\Request;

class VehicleController extends BaseController
{
    //

    public function index()
    {

        $total_vehicle = Vehicle::all()->count();



        $disabled_vehicle = Vehicle::where('status', 0)->get()->count();

        $active_vehicle = Vehicle::where('status', 1)->get()->count();

        return view('vehicle.vehicle_dash', ["total" => $total_vehicle, "disabled_vehicle" => $disabled_vehicle, "active_vehicle" => $active_vehicle]);
    }


    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|min:2|max:255',
            'matricule' => 'required|min:2|max:255',
            'color' => 'required',

        ]);

        $vehicle = Vehicle::where('matricule', $request->matricule)->first();

        if ($vehicle) {

            return  $this->sendError("Un vehicule avec un même matricule existe déjà");
        }

        $new_vehicle =  Vehicle::create([
            'name' => $request->name,
            'color' =>  $request->color,
            'matricule' => $request->matricule,
            'status' => 1,
        ]);

        return  $this->sendResponse("Enregistrement réussi", $new_vehicle);
    }


    public function getVehicles()
    {
        $vehicle_list = Vehicle::all();

        $reponse = json_encode(array('data' => $vehicle_list), TRUE);

        return $reponse;
    }

    public function getVehicleById(Request $request)
    {

        $vehicle = Vehicle::where('id', $request->id)->first();

        $reponse = json_encode(array('data' => $vehicle), TRUE);

        return $reponse;
    }

    public function updateVehicle(Request $request)
    {
        $request->validate([
            'name' => 'required|min:2|max:255',
            'matricule' => 'required|min:2|max:255',
            'color' => 'required',
            'status' => 'required|integer'

        ]);

        $vehicle = Vehicle::where('matricule', $request->matricule)->first();

        if (!$vehicle) {

            return  $this->sendError("Aucun vehicule avec cet matricule");
        }

        Vehicle::where('matricule', $request->matricule)
            ->update([
                'name' => $request->name,
                'color' =>  $request->color,
                'status' =>  $request->status,

            ]);

        return  $this->sendResponse("Enregistrement réussi");
    }

    public function getMatriculesList()
    {
        $vehicle = Vehicle::where('status', 1)->where('current_state', 'LIBRE')->get();

        $reponse = json_encode(array('data' => $vehicle), TRUE);

        return $reponse;
    }
}
