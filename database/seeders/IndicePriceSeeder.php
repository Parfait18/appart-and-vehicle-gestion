<?php

namespace Database\Seeders;

use App\Models\IndicePrice;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class IndicePriceSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //

        //RV1
        IndicePrice::create([
            'stay_delay' => '1 - 2 SEMAINES',
            'amount' => 80000,
            'appart_type' => 'RV1',
            "min_nbr_day" => 0

        ]);

        IndicePrice::create([
            'stay_delay' => '3 SEMAINES - 1 mois',
            'amount' => 60000,
            'appart_type' => 'RV1',
            "min_nbr_day" => 15


        ]);

        IndicePrice::create([
            'stay_delay' => 'PLUS D\'UN MOIS',
            'amount' => 50000,
            'appart_type' => 'RV1',
            "min_nbr_day" => 32


        ]);


        //RV2

        IndicePrice::create([
            'stay_delay' => '1 - 2 SEMAINES',
            'amount' => 80000,
            'appart_type' => 'RV2',
            "min_nbr_day" => 0

        ]);

        IndicePrice::create([
            'stay_delay' => '3 SEMAINES - 1 mois',
            'amount' => 60000,
            'appart_type' => 'RV2',
            "min_nbr_day" => 15


        ]);

        IndicePrice::create([
            'stay_delay' => 'PLUS D\'UN MOIS',
            'amount' => 50000,
            'appart_type' => 'RV2',
            "min_nbr_day" => 32


        ]);

        //STUDIO

        IndicePrice::create([
            'stay_delay' => '1 - 2 SEMAINES',
            'amount' => 50000,
            'appart_type' => 'STUDIO',
            "min_nbr_day" => 0

        ]);

        IndicePrice::create([
            'stay_delay' => '3 SEMAINES - 1 mois',
            'amount' => 40000,
            'appart_type' => 'STUDIO',
            "min_nbr_day" => 15


        ]);

        IndicePrice::create([
            'stay_delay' => 'PLUS D\'UN MOIS',
            'amount' => 30000,
            'appart_type' => 'STUDIO',
            "min_nbr_day" => 32


        ]);

        //

    }
}
