<?php

namespace App\Console\Commands;

use App\Models\Appartement;
use App\Models\AppartementHistoric;
use Carbon\Carbon;
use Database\Seeders\AppartementHistoricSeeder;
use Illuminate\Console\Command;

class UpdateData extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'command:udapteData';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Update historic to already pass, or pending or reserved';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $all_apprt_historic =  AppartementHistoric::all();
        $all_apprt =  Appartement::all();
        $today = Carbon::now();


        foreach ($all_apprt_historic as $item) {

            if ($today->gt($item->end_time)) {

                Appartement::where('id', $item->appart_id)
                    ->update([
                        'current_state' => 'LIBRE'
                    ]);

                AppartementHistoric::where('id', $item->id)->update([

                    'status' => 'TERMINE'
                ]);
            } else if ($item->start_time->lt($today) && $today->lt($item->end_time)) {
                Appartement::where('id', $$item->appart_id)
                    ->update([
                        'current_state' => 'OCCUPE'
                    ]);
                AppartementHistoric::where('id', $$item->id)->update([
                    'status' => 'EN COURS'
                ]);
            } else if ($item->start_time->gt($today) && $today->lt($item->end_time)) {

                Appartement::where('id', $$item->appart_id)
                    ->update([
                        'current_state' => 'RESERVE'
                    ]);
                AppartementHistoric::where('id', $$item->id)->update([
                    'status' => 'RESERVE'
                ]);
            }
        }
    }
}
