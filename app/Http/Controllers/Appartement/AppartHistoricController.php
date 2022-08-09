<?php

namespace App\Http\Controllers\Appartement;

use App\Http\Controllers\BaseController;
use App\Models\Appartement;
use App\Models\AppartementHistoric;
use Carbon\Carbon;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class AppartHistoricController extends BaseController
{
    //

    public function getAppartActivities(Request $request)
    {
        return view('appartement.appart_historic_dash');
    }

    public function store(Request $request)
    {
        $user_id = Auth::user()->id;

        $request->validate([
            'start_time' => 'required',
            'end_time' => 'required',
            'stay_length' => 'required',
            'occupant' => 'required',
            'amount' => 'required',
            'paid_amount' => 'required',
            'day_amount' => 'required',
            'rest' => 'required',
            'appart_id' => 'required',
            'cni_number' => 'required',
            'expire_date' => 'required',
            'contrat_file' => 'required',
        ]);
        date_default_timezone_set('UTC');

        $start_time = Carbon::parse($request->start_time);
        $end_time = Carbon::parse($request->end_time);
        $today = Carbon::now()->addHour(1);

        $historic_create = null;

        if ($today->gt($end_time)) {
            Appartement::where('id', $request->appart_id)->update([
                'current_state' => 'LIBRE',
            ]);

            $historic_create = AppartementHistoric::create([
                'start_time' => $request->start_time,
                'end_time' => $request->end_time,
                'stay_length' => $request->stay_length,
                'occupant' => $request->occupant,
                'amount' => $request->amount,
                'paid_amount' => $request->paid_amount,
                'day_amount' => $request->day_amount,
                'rest' => $request->rest,
                'appart_id' => $request->appart_id,
                'user_id' => $user_id,
                'ca_daily' => $request->paid_amount,
                'caution' => 55555,
                'cni_number' => $request->cni_number,
                'expire_date' => $request->expire_date,
                'status' => 'TERMINE',
            ]);
        } elseif ($start_time->lte($today) && $today->lt($end_time)) {
            //date of today is less than start date
            Appartement::where('id', $request->appart_id)->update([
                'current_state' => 'OCCUPE',
            ]);

            $historic_create = AppartementHistoric::create([
                'start_time' => $request->start_time,
                'end_time' => $request->end_time,
                'stay_length' => $request->stay_length,
                'occupant' => $request->occupant,
                'amount' => $request->amount,
                'paid_amount' => $request->paid_amount,
                'rest' => $request->rest,
                'appart_id' => $request->appart_id,
                'ca_daily' => $request->paid_amount,
                'day_amount' => $request->day_amount,
                'user_id' => $user_id,
                'caution' => 55555,
                'cni_number' => $request->cni_number,
                'expire_date' => $request->expire_date,
                'status' => 'EN COURS',
            ]);
        } elseif ($start_time->gt($today) && $today->lt($end_time)) {
            Appartement::where('id', $request->appart_id)->update([
                'current_state' => 'RESERVE',
            ]);

            $historic_create = AppartementHistoric::create([
                'start_time' => $request->start_time,
                'end_time' => $request->end_time,
                'stay_length' => $request->stay_length,
                'occupant' => $request->occupant,
                'amount' => $request->amount,
                'paid_amount' => $request->paid_amount,
                'day_amount' => $request->day_amount,
                'rest' => $request->rest,
                'appart_id' => $request->appart_id,
                'ca_daily' => $request->paid_amount,
                'user_id' => $user_id,
                'caution' => 55555,
                'cni_number' => $request->cni_number,
                'expire_date' => $request->expire_date,
                'status' => 'REVERVE',
            ]);
        }

        if ($historic_create) {
            $path = 'historic/000' . $historic_create->id;
            if (!Storage::exists($path)) {
                Storage::makeDirectory($path, 0775, true); //creates directory
            }

            if (Storage::exists($path)) {
                if ($request->hasFile('contrat_file')) {
                    $contrat = $request->file('contrat_file');
                    $contrat_name =
                        'AC_' .
                        $historic_create->id .
                        '_' .
                        time() .
                        '_' .
                        $contrat->getClientOriginalName();
                    $path_contrat = $request
                        ->file('contrat_file')
                        ->storeAs($path, $contrat_name);

                    if (
                        !Str::contains($contrat->getClientOriginalName(), 'AC_')
                    ) {
                        AppartementHistoric::where(
                            'id',
                            $historic_create->id
                        )->update([
                            'contrat_file' => asset(
                                Storage::url($path_contrat)
                            ),
                        ]);
                    }
                }
            }
        }

        return $this->sendResponse('Enregistrement réussi', $historic_create);
    }

    public function getAppartHistoric(Request $request)
    {
        $last_two_month = Carbon::now()->startOfMonth();
        $this_month = Carbon::now()->endOfMonth();

        if ($request->date_debut != null && $request->date_fin != null) {
            $last_two_month = $request->date_debut;
            $this_month = $request->date_fin;
        }

        $appartement = AppartementHistoric::join(
            'appartements',
            'appartement_historics.appart_id',
            '=',
            'appartements.id'
        )
            ->whereBetween('appartement_historics.start_time', [
                $last_two_month . ' 00:00:00',
                $this_month . ' 23:59:59',
            ])
            ->select(
                'appartements.code',
                'appartements.type',
                // 'appartements.status',
                'appartements.current_state',
                'appartement_historics.*'
            )
            ->get();
        // ->where('appartements.status', 1)

        $response = json_encode(['data' => $appartement], true);

        return $response;
    }

    public function getAppartHistoricById(Request $request)
    {
        $historic = AppartementHistoric::join(
            'appartements',
            'appartement_historics.appart_id',
            '=',
            'appartements.id'
        )
            ->select(
                'appartements.code',

                'appartements.type',
                'appartements.status',
                'appartements.current_state',
                'appartement_historics.*'
            )
            ->where('appartement_historics.id', $request->id)
            ->first();

        $reponse = json_encode(['data' => $historic], true);

        return $reponse;
    }

    public function updateAppartHistoric(Request $request)
    {
        $request->validate([
            'start_time' => 'required',
            'end_time' => 'required',
            'stay_length' => 'required',
            'occupant' => 'required',
            'amount' => 'required',
            'day_amount' => 'required',
            'paid_amount' => 'required',
            'rest' => 'required',
            'id' => 'required',
            'last_id' => 'required',
            'cni_number' => 'required',
            'expire_date' => 'required',
        ]);

        $start_time = Carbon::parse($request->start_time);
        $end_time = Carbon::parse($request->end_time);
        $today = Carbon::now()->addHour(1);

        if ($request->appart_id) {
            if ($today->gt($end_time)) {
                Appartement::where('id', $request->appart_id)->update([
                    'current_state' => 'LIBRE',
                ]);

                Appartement::where('id', $request->last_id)->update([
                    'current_state' => 'LIBRE',
                ]);

                $historic_create = AppartementHistoric::where(
                    'id',
                    $request->id
                )->update([
                    'start_time' => $request->start_time,
                    'end_time' => $request->end_time,
                    'stay_length' => $request->stay_length,
                    'occupant' => $request->occupant,
                    'amount' => $request->amount,
                    'day_amount' => $request->day_amount,
                    'paid_amount' => $request->paid_amount,
                    'rest' => $request->rest,
                    'appart_id' => $request->appart_id,
                    'cni_number' => $request->cni_number,
                    'expire_date' => $request->expire_date,
                    'caution' => 55555,
                    'status' => 'TERMINE',
                ]);
            } elseif ($start_time->lte($today) && $today->lt($end_time)) {
                //date of today is less than start date
                Appartement::where('id', $request->appart_id)->update([
                    'current_state' => 'OCCUPE',
                ]);

                Appartement::where('id', $request->last_id)->update([
                    'current_state' => 'LIBRE',
                ]);

                AppartementHistoric::where('id', $request->id)->update([
                    'start_time' => $request->start_time,
                    'end_time' => $request->end_time,
                    'stay_length' => $request->stay_length,
                    'occupant' => $request->occupant,
                    'amount' => $request->amount,
                    'day_amount' => $request->day_amount,
                    'paid_amount' => $request->paid_amount,
                    'rest' => $request->rest,
                    'appart_id' => $request->appart_id,
                    'cni_number' => $request->cni_number,
                    'expire_date' => $request->expire_date,
                    'caution' => 55555,
                    'status' => 'EN COURS',
                ]);
            } elseif ($start_time->gt($today) && $today->lt($end_time)) {
                Appartement::where('id', $request->appart_id)->update([
                    'current_state' => 'RESERVE',
                ]);

                Appartement::where('id', $request->last_id)->update([
                    'current_state' => 'LIBRE',
                ]);
                AppartementHistoric::where('id', $request->id)->update([
                    'start_time' => $request->start_time,
                    'end_time' => $request->end_time,
                    'stay_length' => $request->stay_length,
                    'occupant' => $request->occupant,
                    'amount' => $request->amount,
                    'day_amount' => $request->day_amount,
                    'paid_amount' => $request->paid_amount,
                    'rest' => $request->rest,
                    'appart_id' => $request->appart_id,
                    'cni_number' => $request->cni_number,
                    'expire_date' => $request->expire_date,
                    'caution' => 55555,
                    'status' => 'REVERVE',
                ]);
            }
        } else {
            if ($today->gt($end_time)) {
                Appartement::where('id', $request->last_id)->update([
                    'current_state' => 'LIBRE',
                ]);

                $historic_create = AppartementHistoric::where(
                    'id',
                    $request->id
                )->update([
                    'start_time' => $request->start_time,
                    'end_time' => $request->end_time,
                    'stay_length' => $request->stay_length,
                    'occupant' => $request->occupant,
                    'amount' => $request->amount,
                    'day_amount' => $request->day_amount,
                    'cni_number' => $request->cni_number,
                    'expire_date' => $request->expire_date,
                    'paid_amount' => $request->paid_amount,
                    'rest' => $request->rest,
                    'appart_id' => $request->last_id,
                    'caution' => 55555,
                    'status' => 'TERMINE',
                ]);
            } elseif ($start_time->lte($today) && $today->lt($end_time)) {
                //date of today is less than start date

                Appartement::where('id', $request->last_id)->update([
                    'current_state' => 'OCCUPE',
                ]);

                AppartementHistoric::where('id', $request->id)->update([
                    'start_time' => $request->start_time,
                    'end_time' => $request->end_time,
                    'stay_length' => $request->stay_length,
                    'occupant' => $request->occupant,
                    'amount' => $request->amount,
                    'day_amount' => $request->day_amount,
                    'cni_number' => $request->cni_number,
                    'expire_date' => $request->expire_date,
                    'paid_amount' => $request->paid_amount,
                    'rest' => $request->rest,
                    'appart_id' => $request->last_id,
                    'caution' => 55555,
                    'status' => 'EN COURS',
                ]);
            } elseif ($start_time->gt($today) && $today->lt($end_time)) {
                Appartement::where('id', $request->last_id)->update([
                    'current_state' => 'RESERVE',
                ]);
                AppartementHistoric::where('id', $request->id)->update([
                    'start_time' => $request->start_time,
                    'end_time' => $request->end_time,
                    'stay_length' => $request->stay_length,
                    'occupant' => $request->occupant,
                    'amount' => $request->amount,
                    'day_amount' => $request->day_amount,
                    'cni_number' => $request->cni_number,
                    'expire_date' => $request->expire_date,
                    'paid_amount' => $request->paid_amount,
                    'rest' => $request->rest,
                    'appart_id' => $request->last_id,
                    'caution' => 55555,
                    'status' => 'REVERVE',
                ]);
            }
        }
        $historic_create = AppartementHistoric::where(
            'id',
            $request->id
        )->first();

        if ($historic_create) {
            $path = 'historic/000' . $request->id;
            if (!Storage::exists($path)) {
                Storage::makeDirectory($path, 0775, true); //creates directory
            }

            if (Storage::exists($path)) {
                if ($request->hasFile('contrat_file')) {
                    $contrat = $request->file('contrat_file');
                    $contrat_name =
                        'AC_' .
                        $request->id .
                        '_' .
                        time() .
                        '_' .
                        $contrat->getClientOriginalName();
                    $path_contrat = $request
                        ->file('contrat_file')
                        ->storeAs($path, $contrat_name);

                    if (
                        !Str::contains($contrat->getClientOriginalName(), 'AC_')
                    ) {
                        AppartementHistoric::where('id', $request->id)->update([
                            'contrat_file' => asset(
                                Storage::url($path_contrat)
                            ),
                        ]);
                    }
                }
            }
        }

        return $this->sendResponse('Enregistrement réussi');
    }
}
