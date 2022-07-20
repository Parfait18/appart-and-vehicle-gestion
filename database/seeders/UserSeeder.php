<?php

namespace Database\Seeders;

use App\Models\User;
use Carbon\Carbon;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //

        $agent_vehicul = User::create([
            'name' => 'Agent Vehicule',
            'email' => 'vehicule@gmail.com',
            'password' => Hash::make('password'),
            'email_verified_at' => Carbon::today(),
            'role' => 'vehicule',
            'status' => 1,
            'password_changed_at' => Carbon::today()

        ]);

      
        $agent_admin = User::create([
            'name' => 'Agent Admin',
            'email' => 'admin@gmail.com',
            'password' => Hash::make('password'),
            'email_verified_at' => Carbon::today(),
            'role' => 'admin',
            'status' => 1,
            'password_changed_at' => Carbon::today()


        ]);
    }
}
