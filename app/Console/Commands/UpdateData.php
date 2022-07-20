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
    protected $signature = 'command:udapteAppart';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Update historic to already pass, or pending or reserved appart';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $all_apprt_historic =  AppartementHistoric::all();
        $all_apprt =  Appartement::all();


        foreach ($all_apprt_historic as $item) {
            $this->info($item->end_time);

            $start_time = Carbon::parse($item->start_time);
            $end_time = Carbon::parse($item->end_time);
            $today = Carbon::now()->addHour(1);


            if ($today->gt($end_time)) {

                Appartement::where('id', $item->appart_id)
                    ->update([
                        'current_state' => 'LIBRE'
                    ]);

                AppartementHistoric::where('id', $item->id)->update([

                    'status' => 'TERMINE'
                ]);
            } else if ($start_time->lte($today) && $today->lt($end_time)) {
                Appartement::where('id', $item->appart_id)
                    ->update([
                        'current_state' => 'OCCUPE'
                    ]);
                AppartementHistoric::where('id', $item->id)->update([
                    'status' => 'EN COURS'
                ]);
            } else if ($start_time->gt($today) && $today->lt($end_time)) {

                Appartement::where('id', $item->appart_id)
                    ->update([
                        'current_state' => 'RESERVE'
                    ]);
                AppartementHistoric::where('id', $$item->id)->update([
                    'status' => 'RESERVE'
                ]);
            }
        }

        $this->info("Successfully appartement's data  updated !! ");
    }
}
