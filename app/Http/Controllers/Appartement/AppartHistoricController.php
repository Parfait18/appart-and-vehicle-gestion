<?php

namespace App\Http\Controllers\Appartement;

use App\Http\Controllers\BaseController;
use App\Models\Appartement;
use App\Models\AppartementHistoric;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AppartHistoricController extends BaseController
{
    //

    public function getAppartActivities(Request $request)
    {

        $total_appartement = Appartement::all()->count();

        $disabled_appartement = Appartement::where('status', 0)->get()->count();

        $active_appartement = Appartement::where('status', 1)->get()->count();

        return view('appartement.appart_historic_dash', ["total" => $total_appartement, "disabled_appartement" => $disabled_appartement, "active_appartement" => $active_appartement]);
    }



    public function store(Request $request)
    {

        $user_id = Auth::user()->id;

        $request->validate([
            'start_time' => 'required',
            'end_time' => 'required',
            'stay_length' => 'required',
            'occupant' => 'required',
            "amount" => 'required',
            "paid_amount" => 'required',
            'rest' => 'required',
            'appart_id' => 'required',
        ]);


        $start_time = Carbon::parse($request->start_time);
        $end_time = Carbon::parse($request->end_time);
        $today = Carbon::now();

        if ($today->gt($end_time)) {
            Appartement::where('id', $request->appart_id)
                ->update([
                    'current_state' => 'LIBRE'
                ]);

            $historic_create = AppartementHistoric::create([
                'start_time' =>   $request->start_time,
                'end_time' =>   $request->end_time,
                'stay_length' =>   $request->stay_length,
                'occupant' =>   $request->occupant,
                "amount" =>   $request->amount,
                "paid_amount" =>   $request->paid_amount,
                'rest' =>   $request->rest,
                'appart_id' =>   $request->appart_id,
                'user_id' => $user_id,
                'ca_daily' => $request->paid_amount,
                'caution' => 55555,
                'status' => 'DEJA PASSE'
            ]);
        } else if ($start_time->lt($today) && $today->lt($end_time)) {
            //date of today is less than start date
            Appartement::where('id', $request->appart_id)
                ->update([
                    'current_state' => 'OCCUPE'
                ]);

            $historic_create = AppartementHistoric::create([
                'start_time' =>   $request->start_time,
                'end_time' =>   $request->end_time,
                'stay_length' =>   $request->stay_length,
                'occupant' =>   $request->occupant,
                "amount" =>   $request->amount,
                "paid_amount" =>   $request->paid_amount,
                'rest' =>   $request->rest,
                'appart_id' =>   $request->appart_id,
                'ca_daily' => $request->paid_amount,
                'user_id' => $user_id,
                'caution' => 55555,
                'status' => 'EN COURS'
            ]);
        } else if ($start_time->gt($today) && $today->lt($end_time)) {
            Appartement::where('id', $request->appart_id)
                ->update([
                    'current_state' => 'RESERVE'
                ]);

            $historic_create = AppartementHistoric::create([
                'start_time' =>   $request->start_time,
                'end_time' =>   $request->end_time,
                'stay_length' =>   $request->stay_length,
                'occupant' =>   $request->occupant,
                "amount" =>   $request->amount,
                "paid_amount" =>   $request->paid_amount,
                'rest' =>   $request->rest,
                'appart_id' =>   $request->appart_id,
                'ca_daily' => $request->paid_amount,
                'user_id' => $user_id,
                'caution' => 55555,
                'status' => 'REVERVE'
            ]);
        }

        return  $this->sendResponse("Enregistrement réussi", $historic_create);
    }


    public function getAppartHistoric()
    {

        $appartement = AppartementHistoric::join('appartements', 'appartement_historics.appart_id', '=', 'appartements.id')
            ->select(
                'appartements.code',
                'appartements.price',
                'appartements.type',
                // 'appartements.status',
                'appartements.current_state',
                'appartement_historics.*',
            )->get();
        // ->where('appartements.status', 1)

        $response = json_encode(array('data' => $appartement), TRUE);

        return $response;
    }



    public function getAppartHistoricById(Request $request)
    {


        $historic = AppartementHistoric::join('appartements', 'appartement_historics.appart_id', '=', 'appartements.id')
            ->select(
                'appartements.code',
                'appartements.price',
                'appartements.type',
                'appartements.status',
                'appartements.current_state',
                'appartement_historics.*',
            )->where('appartement_historics.id', $request->id)->first();

        $reponse = json_encode(array('data' => $historic), TRUE);

        return $reponse;
    }

    public function updateAppartHistoric(Request $request)
    {

        $request->validate([
            'start_time' => 'required',
            'end_time' => 'required',
            'stay_length' => 'required',
            'occupant' => 'required',
            "amount" => 'required',
            "paid_amount" => 'required',
            'rest' => 'required',
            'id' => 'required',
            'last_id' => 'required',
        ]);



        $start_time = Carbon::parse($request->start_time);
        $end_time = Carbon::parse($request->end_time);
        $today = Carbon::now();
        if ($request->appart_id) {
            if ($today->gt($end_time)) {
                Appartement::where('id', $request->appart_id)
                    ->update([
                        'current_state' => 'LIBRE'
                    ]);

                Appartement::where('id', $request->last_id)
                    ->update([
                        'current_state' => 'LIBRE'
                    ]);

                $historic_create = AppartementHistoric::where('id', $request->id)->update([
                    'start_time' =>   $request->start_time,
                    'end_time' =>   $request->end_time,
                    'stay_length' =>   $request->stay_length,
                    'occupant' =>   $request->occupant,
                    "amount" =>   $request->amount,
                    "paid_amount" =>   $request->paid_amount,
                    'rest' =>   $request->rest,
                    'appart_id' =>   $request->appart_id,
                    'caution' => 55555,
                    'status' => 'DEJA PASSE'
                ]);
            } else if ($start_time->lt($today) && $today->lt($end_time)) {
                //date of today is less than start date
                Appartement::where('id', $request->appart_id)
                    ->update([
                        'current_state' => 'OCCUPE'
                    ]);

                Appartement::where('id', $request->last_id)
                    ->update([
                        'current_state' => 'LIBRE'
                    ]);

                AppartementHistoric::where('id', $request->id)->update([
                    'start_time' =>   $request->start_time,
                    'end_time' =>   $request->end_time,
                    'stay_length' =>   $request->stay_length,
                    'occupant' =>   $request->occupant,
                    "amount" =>   $request->amount,
                    "paid_amount" =>   $request->paid_amount,
                    'rest' =>   $request->rest,
                    'appart_id' =>   $request->appart_id,
                    'caution' => 55555,
                    'status' => 'EN COURS'
                ]);
            } else if ($start_time->gt($today) && $today->lt($end_time)) {
                Appartement::where('id', $request->appart_id)
                    ->update([
                        'current_state' => 'RESERVE'
                    ]);


                Appartement::where('id', $request->last_id)
                    ->update([
                        'current_state' => 'LIBRE'
                    ]);
                AppartementHistoric::where('id', $request->id)->update([
                    'start_time' =>   $request->start_time,
                    'end_time' =>   $request->end_time,
                    'stay_length' =>   $request->stay_length,
                    'occupant' =>   $request->occupant,
                    "amount" =>   $request->amount,
                    "paid_amount" =>   $request->paid_amount,
                    'rest' =>   $request->rest,
                    'appart_id' =>   $request->appart_id,
                    'caution' => 55555,
                    'status' => 'REVERVE'
                ]);
            }
        } else {
            if ($today->gt($end_time)) {

                Appartement::where('id', $request->last_id)
                    ->update([
                        'current_state' => 'LIBRE'
                    ]);

                $historic_create = AppartementHistoric::where('id', $request->id)->update([
                    'start_time' =>   $request->start_time,
                    'end_time' =>   $request->end_time,
                    'stay_length' =>   $request->stay_length,
                    'occupant' =>   $request->occupant,
                    "amount" =>   $request->amount,
                    "paid_amount" =>   $request->paid_amount,
                    'rest' =>   $request->rest,
                    'appart_id' =>   $request->last_id,
                    'caution' => 55555,
                    'status' => 'DEJA PASSE'
                ]);
            } else if ($start_time->lt($today) && $today->lt($end_time)) {
                //date of today is less than start date

                Appartement::where('id', $request->last_id)
                    ->update([
                        'current_state' => 'LIBRE'
                    ]);

                AppartementHistoric::where('id', $request->id)->update([
                    'start_time' =>   $request->start_time,
                    'end_time' =>   $request->end_time,
                    'stay_length' =>   $request->stay_length,
                    'occupant' =>   $request->occupant,
                    "amount" =>   $request->amount,
                    "paid_amount" =>   $request->paid_amount,
                    'rest' =>   $request->rest,
                    'appart_id' =>   $request->last_id,
                    'caution' => 55555,
                    'status' => 'EN COURS'
                ]);
            } else if ($start_time->gt($today) && $today->lt($end_time)) {

                Appartement::where('id', $request->last_id)
                    ->update([
                        'current_state' => 'LIBRE'
                    ]);
                AppartementHistoric::where('id', $request->id)->update([
                    'start_time' =>   $request->start_time,
                    'end_time' =>   $request->end_time,
                    'stay_length' =>   $request->stay_length,
                    'occupant' =>   $request->occupant,
                    "amount" =>   $request->amount,
                    "paid_amount" =>   $request->paid_amount,
                    'rest' =>   $request->rest,
                    'appart_id' =>   $request->last_id,
                    'caution' => 55555,
                    'status' => 'REVERVE'
                ]);
            }
        }


        return  $this->sendResponse("Enregistrement réussi");
    }
}
