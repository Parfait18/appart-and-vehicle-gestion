<?php

namespace Database\Seeders;

use App\Models\VehicleHistoric;
use Carbon\Carbon;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class VehiculeHistoricSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //


        // $historic_one = VehicleHistoric::create([
        //     'start_time' => Carbon::today(),
        //     'arrival_time' =>  Carbon::today()->addDays(1),
        //     'start_km' => 12.5,
        //     'arrival_km' => 23.5,
        //     'amount_repaid' => 5000,
        //     'ca_daily' => 8000,
        //     'travel_time' => '1 heure',
        //     'travel_km' => 8000,
        //     'user_id' => 1,
        //     'vehicle_id' => 1,
        //     'status'=> "EN COURS"


        // ]);

        // $historic_two = VehicleHistoric::create([
        //     'start_time' => Carbon::today(),
        //     'arrival_time' =>  Carbon::today()->addDays(3),
        //     'start_km' => 12.5,
        //     'arrival_km' => 23.5,
        //     'amount_repaid' => 5000,
        //     'ca_daily' => 8000,
        //     'travel_time' => '3 minutes',
        //     'travel_km' => 58.5,
        //     'user_id' => 1,
        //     'vehicle_id' => 1,


        // ]);
    }
}
