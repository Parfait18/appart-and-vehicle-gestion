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

        return view('appartement.appart_recap');
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
                'appartements.current_state',
                'appartements.code'
            )
            ->groupBy('code')
            ->get();

        //list to get vehicle who don't have hsitorique
        $not_hist =  Appartement::select('current_state', 'code')->whereNotIn(
            'id',
            AppartementHistoric::whereBetween(
                'appartement_historics.created_at',
                [
                    $last_two_month . ' 00:00:00',
                    $this_month . ' 23:59:59'
                ]
            )
                ->groupBy('appart_id')
                ->pluck('appart_id')
        )
            ->get();


        $length = count($apparts);
        foreach ($not_hist as $key => $value) {

            $apparts[$length] = $value;
            $apparts[$length]['ca_total'] = 0;

            $length += 1;
        }


        $reponse = json_encode(array('data' => $apparts), TRUE);

        return $reponse;
    }
}
