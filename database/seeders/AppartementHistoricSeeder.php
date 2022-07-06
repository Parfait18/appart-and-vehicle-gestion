<?php

namespace Database\Seeders;

use App\Models\AppartementHistoric;
use Carbon\Carbon;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class AppartementHistoricSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //STATUS CAN TAKE EN COURS, DEJA PASSE, REVERVE
        $historic_one = AppartementHistoric::create([
            'start_time' => Carbon::today(),
            'end_time' =>  Carbon::today()->addDays(2),
            'stay_length' => '2 jours',
            'caution' => 5000,
            "amount" => 4000,
            "paid_amount" => 2000,
            'rest' => 2000,
            'ca_daily' => 5000,
            'user_id' => 2,
            'appart_id' => 1,
            'occupant' => "Tony Stark",
            'status' => 'EN COURS'



        ]);

        // $historic_two = AppartementHistoric::create([
        //     'start_time' => Carbon::today(),
        //     'end_time' =>  Carbon::today()->addDays(2),
        //     'stay_length' => '5 jours',
        //     'caution' => 5000,
        //     "amount" => 4000,
        //     "paid_amount" => 2000,
        //     'rest' => 2000,
        //     'user_id' => 2,
        //     'appart_id' => 1,
        //     'occupant' => "Jack Bauer",
        //     'status' => 'EN COURS'

        // ]);
    }
}
