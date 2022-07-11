<?php

namespace App\Http\Controllers;

use App\Models\IndicePrice;
use Illuminate\Http\Request;

class IndicePriceController extends Controller
{
    //


    public function getIndiceByTypeDays(Request $request)
    {

        $indice = $request->min_nbr_day;
        $min_nbr_day = 0;

        if (0 <= $indice && $indice <= 14) {
            $min_nbr_day = 0;
        } else if (15 <= $indice && $indice <= 31) {
            $min_nbr_day = 15;
        } else if (32 <= $indice) {
            $min_nbr_day = 32;
        }


        $indices = IndicePrice::where('appart_type', $request->type)->where('min_nbr_day', $min_nbr_day)->first();

        $reponse = json_encode(array('data' => $indices), TRUE);

        return $reponse;
    }
}
