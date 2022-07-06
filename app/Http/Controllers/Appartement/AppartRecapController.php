<?php

namespace App\Http\Controllers\Appartement;

use App\Http\Controllers\Controller;
use App\Models\Appartement;
use App\Models\AppartementHistoric;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class AppartRecapController extends Controller
{
    //
    public function indexRecap()
    {
        $total_appartement = Appartement::all()->count();

        $disabled_appartement = Appartement::where('status', 0)->get()->count();

        $active_appartement = Appartement::where('status', 1)->get()->count();

        return view('appartement.appart_recap', ["total" => $total_appartement, "disabled_appartement" => $disabled_appartement, "active_appartement" => $active_appartement]);
    }

    public function getAppartRecapData()
    {
        $total_appartement = Appartement::all()->count();

        $disabled_appartement = Appartement::where('status', 0)->get()->count();

        $active_appartement = Appartement::where('status', 1)
            ->where('current_state', "OCCUPE")
            ->get()->count();

        $available_appartement = Appartement::where('status', 1)->where('current_state', "LIBRE")->get()->count();

        return  ["total" => $total_appartement, "disabled_appartement" => $disabled_appartement, "active_appartement" => $active_appartement, "available_appartement" => $available_appartement];
    }

    public function recapAppartements(Request $request)
    {

        $last_two_month = Carbon::now()->startOfMonth();
        $this_month = Carbon::now()->endOfMonth();

        if ($request->date_debut != null && $request->date_fin != null) {
            $last_two_month = $request->date_debut;
            $this_month = $request->date_fin;
        }

        $apparts = AppartementHistoric::join('appartements', 'appartement_historics.appart_id', '=', 'appartements.id')
            ->whereBetween('appartement_historics.created_at', [$last_two_month . ' 00:00:00', $this_month . ' 23:59:59'])
            ->select(
                DB::raw('SUM(appartement_historics.ca_daily) as ca_total'),
                // DB::raw('SUM(vehicle_historics.travel_km) as km_total'),
                'appartements.current_state',
                'appartements.code'
            )
            ->groupBy('code')
            ->get();

        $reponse = json_encode(array('data' => $apparts), TRUE);

        return $reponse;
    }
}
