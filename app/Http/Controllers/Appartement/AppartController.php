<?php

namespace App\Http\Controllers\Appartement;

use App\Http\Controllers\BaseController;
use App\Models\Appartement;
use Illuminate\Http\Request;

class AppartController extends BaseController
{
    //


    public function index()
    {

        return view('appartement.appart_dash');
    }

    public function getAppartRecapData()
    {
        $total_appartement = Appartement::all()->count();

        $disabled_appartement = Appartement::where('status', 0)->get()->count();

        $active_appartement = Appartement::where('status', 1)
            ->where('current_state', "OCCUPE")
            ->get()->count();

        $available_appartement = Appartement::where('status', 1)->where('current_state', "LIBRE")->get()->count();
        $reserve_appartement = Appartement::where('status', 1)->where('current_state', "RESERVE")->get()->count();

        $data =  ["total" => $total_appartement, "disabled_appartement" => $disabled_appartement, "active_appartement" => $active_appartement, "available_appartement" => $available_appartement, 'reserve_appartement' => $reserve_appartement];

        return $data;
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|min:2|max:255',
            'type' => 'required',

        ]);

        $last_id = Appartement::all()->count();

        $code = '';
        if ($request->type == 'RV1') {
            $code = '001/LH/APT00' . $last_id + 1;
        } else if ($request->type == 'RV2') {
            $code = '002/GH/APT00' . $last_id + 1;
        } else if ($request->type == 'STUDIO') {
            $code = '003/LL/APT00' . $last_id + 1;
        }

        $appartement = Appartement::where('code', $code)->first();

        if ($appartement) {

            return  $this->sendError("Un appartement avec un même code existe déjà");
        }

        $new_appartement =  Appartement::create([
            'name' => $request->name,
            'code' => $code,
            'type' => $request->type,
        ]);

        return  $this->sendResponse("Enregistrement réussi", $new_appartement);
    }


    public function getApparts()
    {
        $appartement_list = Appartement::all();

        $reponse = json_encode(array('data' => $appartement_list), TRUE);

        return $reponse;
    }

    public function getAppartById(Request $request)
    {

        $appartement = Appartement::where('id', $request->id)->first();

        $reponse = json_encode(array('data' => $appartement), TRUE);

        return $reponse;
    }



    public function getAppartByType(Request $request)
    {

        $appartement = Appartement::where('type', $request->type)->where('status', 1)->where('current_state', 'LIBRE')->get();

        $reponse = json_encode(array('data' => $appartement), TRUE);

        return $reponse;
    }


    public function updateAppart(Request $request)
    {
        $request->validate([
            'name' => 'required|min:2|max:255',
            'code' => 'required|min:2|max:255',
            'type' => 'required',
            'status' => 'required',

        ]);

        $appartement = Appartement::where('code', $request->code)->first();

        if (!$appartement) {

            return  $this->sendError("Aucun appartement avec cet code");
        }

        $last_id = Appartement::all()->count();

        $code = '';

        if ($appartement->type != $request->type) {

            if ($request->type == 'RV1') {
                $code = '001/LH/APT00' . $last_id + 1;
            } else if ($request->type == 'RV2') {
                $code = '002/GH/APT00' . $last_id + 1;
            } else if ($request->type == 'STUDIO') {
                $code = '003/LL/APT00' . $last_id + 1;
            }
        } else {
            $code = $request->code;
        }

        Appartement::where('code', $request->code)
            ->update([
                'name' => $request->name,
                'type' => $request->type,
                'status' => $request->status,
                'code' => $code
            ]);

        return  $this->sendResponse("Enregistrement réussi");
    }

    public function getValidAppart()
    {
        $appartement = Appartement::where('status', 1)->where('current_state', 'LIBRE')->get();

        $reponse = json_encode(array('data' => $appartement), TRUE);

        return $reponse;
    }
}
