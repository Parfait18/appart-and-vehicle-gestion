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
            'code' => '001/GH/APT001',
            'type' => 'RV1',
            "current_state" => "OCCUPE"
        ]);

        $appart_two = Appartement::create([
            'name' => 'Appart2',
            'code' => '002/GH/APT002',
            'type' => 'RV2',
            "current_state" => "LIBRE"

        ]);
    }
}
