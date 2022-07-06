<?php

namespace Database\Seeders;

use App\Models\Vehicle;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class VehiculeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //

        $vehicul_one = Vehicle::create([
            'name' => 'Vehicule1',
            'color' => 'red',
            'matricule' => 'CIV123',
            'status' => 1,
            "current_state" => "OCCUPE"

        ]);

        $vehicul_two = Vehicle::create([
            'name' => 'Vehicule2',
            'color' => 'blue',
            'matricule' => 'CIV143',
            'status' => 1,
            "current_state" => "LIBRE"
        ]);
    }
}
