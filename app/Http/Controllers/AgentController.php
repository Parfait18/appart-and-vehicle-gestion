<?php

namespace App\Http\Controllers;


use App\Mail\confirmAccount;
use App\Mail\ConfirmedAccount;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\URL;

class AgentController extends BaseController
{
    //

    public function index(Request $request)
    {

        return view('agent.agent_dash');
    }


    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|min:2|max:255',
            'email' => 'required|email|max:255',
            'role' => 'required|string',


        ]);

        $agent = User::where('email', $request->email)->first();

        if ($agent) {

            return  $this->sendError("Un agent avec un même email existe déjà");
        }

        $requestslist = User::count();

        $pass = "GAV" . ($requestslist + 1) . random_string(2);

        $new_agent =  User::create([
            'name' => $request->name,
            'email' => $request->email,
            'role' => $request->role,
            'password' => Hash::make($pass),
        ]);


        $generatedURL = URL::signedRoute('validate_account', [
            'user' => $new_agent->id,
        ]);

        $data_email = [
            'name' => $new_agent->name,
            'email' => $new_agent->email,
            'password' => $pass,
            'role' => 'Gestion des ' . $new_agent->role . 's',
            'url' => $generatedURL,
        ];

        if ($new_agent) {
            Mail::to($new_agent->email)->send(
                new confirmAccount($data_email)
            );
            return  $this->sendResponse("Enregistrement réussi, Veuillez activé le compte en vérifiant le email", $new_agent);

            // return $this->sendResponse('successfully', $new_agent);
        }
    }

    public function verify(Request $request, $user)
    {

        if (!$request->hasValidSignature()) {

            abort(404);
        }

        User::where('id', $user)->update([
            'email_verified_at' => Carbon::today(),
        ]);
        return redirect(env('BACK_OFFICE_URL') . '/login');
    }

    public function getAgents()
    {
        $agent_list = User::all();

        $reponse = json_encode(array('data' => $agent_list), TRUE);

        return $reponse;
    }

    public function getAgentById(Request $request)
    {

        $agent = User::where('id', $request->id)->first();

        $reponse = json_encode(array('data' => $agent), TRUE);

        return $reponse;
    }

    public function updateAgent(Request $request)
    {
        $request->validate([
            'name' => 'required|min:2|max:255',
            'email' => 'required|email',
            'role' => 'required',
            'status' => 'required',

        ]);

        $agent = User::where('email', $request->email)->first();

        if (!$agent) {

            return  $this->sendError("Aucun agent avec cet code");
        }

        User::where('email', $request->email)
            ->update([
                'name' => $request->name,
                'role' =>  $request->role,
                'status' => $request->status,
            ]);

        return  $this->sendResponse("Enregistrement réussi");
    }

    public function getValidAgent()
    {
        $agent = User::where('status', 1)->where('current_state', 'LIBRE')->get();

        $reponse = json_encode(array('data' => $agent), TRUE);

        return $reponse;
    }

    public function getRecapAgent()
    {

        $total_agent = User::all()->count();

        $disabled_agent = User::where('status', 0)->get()->count();

        $active_agent = User::where('status', 1)->get()->count();

        $data =  ["total" => $total_agent, "disabled_agent" => $disabled_agent, "active_agent" => $active_agent];

        return $data;;
    }
}
