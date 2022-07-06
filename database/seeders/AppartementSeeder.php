<?php

namespace Database\Seeders;

use App\Models\Appartement;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class AppartementSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //CURRENT STATE CAN BE FREE,OCCUPED OR RESERVED

        $appart_one = Appartement::create([
            'name' => 'Appart1',
            'price' => 5000,
            'code' => 'AP123',
            'type' => 'SIMPLE',
            "current_state" => "OCCUPE"
        ]);

        $appart_two = Appartement::create([
            'name' => 'Appart2',
            'price' => 5000,
            'code' => 'AP143',
            'type' => 'SIMPLE',
            "current_state" => "LIBRE"

        ]);
    }
}
