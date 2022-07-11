<?php

namespace App\Http\Controllers;

use App\Models\Appartement;
use App\Models\Vehicle;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    //

    public function index()
    {


        $total_appartement = Appartement::all()->count();


        $disabled_appartement = Appartement::where('status', 0)->get()->count();

        $active_appartement = Appartement::where('status', 1)->where('current_state', 'OCCUPE')->get()->count();


        $available_appartement = Appartement::where('status', 1)->where('current_state', 'LIBRE')->get()->count();



        $total_vehicle = Vehicle::all()->count();

        $disabled_vehicle = Vehicle::where('status', 0)->get()->count();

        $active_vehicle = Vehicle::where('status', 1)
            ->where('current_state', 'OCCUPE')
            ->get()->count();

        $available_vehicle = Vehicle::where('status', 1)->where('current_state', 'LIBRE')->get()->count();



        return view(
            'dashboard',
            [
                "total_appartement" => $total_appartement,
                "disabled_appartement" => $disabled_appartement,
                "active_appartement" => $active_appartement,
                "available_appartement" => $available_appartement,

                "total_vehicle" => $total_vehicle,
                "disabled_vehicle" => $disabled_vehicle,
                "active_vehicle" => $active_vehicle,
                "available_vehicle" => $available_vehicle
            ]
        );
    }
}
