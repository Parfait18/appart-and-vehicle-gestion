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

        $total_appartement = Appartement::all()->count();


        $disabled_appartement = Appartement::where('status', 0)->get()->count();

        $active_appartement = Appartement::where('status', 1)->get()->count();

        return view('appartement.appart_dash', ["total" => $total_appartement, "disabled_appartement" => $disabled_appartement, "active_appartement" => $active_appartement]);
    }


    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|min:2|max:255',
            'code' => 'required|min:2|max:255',
            'price' => 'required|integer',
            'type' => 'required',

        ]);

        $appartement = Appartement::where('code', $request->code)->first();

        if ($appartement) {

            return  $this->sendError("Un appartement avec un même code existe déjà");
        }

        $new_appartement =  Appartement::create([
            'name' => $request->name,
            'code' => $request->code,
            'price' => $request->price,
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

    public function updateAppart(Request $request)
    {
        $request->validate([
            'name' => 'required|min:2|max:255',
            'code' => 'required|min:2|max:255',
            'price' => 'required',
            'type' => 'required',
            'status' => 'required',

        ]);

        $appartement = Appartement::where('code', $request->code)->first();

        if (!$appartement) {

            return  $this->sendError("Aucun appartement avec cet code");
        }


        Appartement::where('code', $request->code)
            ->update([
                'name' => $request->name,
                'price' =>  $request->price,
                'type' => $request->type,
                'status' => $request->status,
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
