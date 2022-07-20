<?php

namespace App\Http\Controllers\Vehicles;

use App\Http\Controllers\BaseController;
use App\Models\Vehicle;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;

class VehicleController extends BaseController
{
    //

    public function index()
    {

        return view('vehicle.vehicle_dash');
    }

    public function getVehicleRecapData()
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
            'name' => 'required|min:2|max:255',
            'matricule' => 'required|min:2|max:255',
            'color' => 'required',
            'vehicle_file' => 'required',
            'conductor_file' => 'required',

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

        if ($new_vehicle) {
            $path = 'vehicle/' . $request->matricule;
            if (!Storage::exists($path)) {
                Storage::makeDirectory($path, 0775, true); //creates directory
            }

            if (Storage::exists($path)) {

                if ($request->hasFile('vehicle_file')) {
                    $vehicle = $request->file('vehicle_file');
                    $vehicle_name = 'VF_' . $request->id . '_' . time() . '_' . $vehicle->getClientOriginalName();
                    $path_vehicle = $request->file('vehicle_file')->storeAs($path, $vehicle_name);

                    if (!Str::contains($vehicle->getClientOriginalName(), 'VF_')) {

                        Vehicle::where('matricule', $request->matricule)->update([
                            'vehicle_file' =>  asset(Storage::url($path_vehicle)),
                        ]);
                    }
                }
                if ($request->hasFile('conductor_file')) {
                    $conductor = $request->file('conductor_file');
                    $conductor_name = 'CF_' . $request->id . '_' . time() . '_' . $conductor->getClientOriginalName();
                    $path_conductor = $request->file('conductor_file')->storeAs($path, $conductor_name);

                    if (!Str::contains($conductor->getClientOriginalName(), 'CF_')) {

                        Vehicle::where('matricule', $request->matricule)->update([
                            'conductor_file' =>  asset(Storage::url($path_conductor)),
                        ]);
                    }
                }
            }
        }
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

        if ($vehicle) {
            $path = 'vehicle/' . $request->matricule;
            if (!Storage::exists($path)) {
                Storage::makeDirectory($path, 0775, true); //creates directory
            }

            if (Storage::exists($path)) {

                if ($request->hasFile('vehicle_file')) {
                    $vehicle = $request->file('vehicle_file');
                    $vehicle_name = 'VF_' . $request->id . '_' . time() . '_' . $vehicle->getClientOriginalName();
                    $path_vehicle = $request->file('vehicle_file')->storeAs($path, $vehicle_name);

                    if (!Str::contains($vehicle->getClientOriginalName(), 'VF_')) {

                        Vehicle::where('matricule', $request->matricule)->update([
                            'vehicle_file' =>  asset(Storage::url($path_vehicle)),
                        ]);
                    }
                }
                if ($request->hasFile('conductor_file')) {
                    $conductor = $request->file('conductor_file');
                    $conductor_name = 'CF_' . $request->id . '_' . time() . '_' . $conductor->getClientOriginalName();
                    $path_conductor = $request->file('conductor_file')->storeAs($path, $conductor_name);

                    if (!Str::contains($conductor->getClientOriginalName(), 'CF_')) {

                        Vehicle::where('matricule', $request->matricule)->update([
                            'conductor_file' =>  asset(Storage::url($path_conductor)),
                        ]);
                    }
                }
            }
        }
        return  $this->sendResponse("Enregistrement réussi");
    }

    public function getMatriculesList()
    {
        $vehicle = Vehicle::where('status', 1)->where('current_state', 'LIBRE')->get();

        $reponse = json_encode(array('data' => $vehicle), TRUE);

        return $reponse;
    }
}
