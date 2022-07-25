<?php

namespace Database\Seeders;

use App\Models\Appartement;
use App\Models\User;
use App\Models\AppartementHistoric;
use Carbon\Carbon;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;


class AppartementHistoricSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //STATUS CAN TAKE EN COURS, TERMINE, REVERVE
        // $appart_one = Appartement::create([
        //     'name' => 'Appart1',
        //     'code' => '001/LH/APT001',
        //     'type' => 'RV1',
        //     "current_state" => "OCCUPE"
        // ]);

        $agent_apt_meuble = User::create([
            'name' => 'Agent Appartement',
            'email' => 'appart@webcoomgroup.net',
            'password' => Hash::make('password'),
            'email_verified_at' => Carbon::today(),
            'role' => 'appartement',
            'status' => 1,
            'password_changed_at' => Carbon::today()

        ]);

        // $historic_one = AppartementHistoric::create([
        //     'start_time' => Carbon::today(),
        //     'end_time' =>  Carbon::today()->addDays(2),
        //     'stay_length' => '2 jours',
        //     'caution' => 5000,
        //     "amount" => 160000,
        //     "paid_amount" => 100000,
        //     "day_amount" => 80000,
        //     'rest' => 60000,
        //     'ca_daily' => 80000,
        //     'user_id' => $agent_apt_meuble->id,
        //     'appart_id' => $appart_one->id,
        //     'occupant' => "Tony Stark",
        //     'cni_number' => 57575,
        //     'expire_date' => Carbon::today()->addDays(10),
        //     'status' => 'EN COURS',
        //     'contrat_file' => '/storage/app/public/file.pdf'



        // ]);

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
