<?php

namespace App\Http\Controllers;

use App\Models\User;
use Carbon\Carbon;
use Illuminate\Validation\ValidationException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session as FacadesSession;

class AuthController extends Controller
{
    //

    public static function index()
    {
        if (Auth::check()) {
            return Redirect('dashboard');
        }else{
             return view('auth.login');
        }

       
    }

    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required',
            'password' => 'required'
        ]);


        $user = User::where('email', $request->email)->first();

        if (!$user) {
            return redirect()->route('login');
        }
        if ($user->status == 0) {
            throw ValidationException::withMessages(['email' => "Votre compte est désactivé"]);
        }

        if ($user->password_changed_at == null) {

            Auth::login($user);

            return redirect()->route('getChangePassword');
        }


        if (!$user || !Hash::check($request->password, $user->password)) {
            throw ValidationException::withMessages(['password' => trans('auth.failed')]);
        }

        if (!$user->email_verified_at) {
            throw ValidationException::withMessages(['email' => "Veuillez confirmer votre email pour accéder à votre compte"]);
        }



        Auth::login($user);


        return redirect()->route('dashboard');
    }
    public function getChangePassword()
    {

        return view('auth.reset_password');
    }

    public function signOut()
    {
        // Session::flush();
        Auth::logout();

        return Redirect('login');
    }

    public function changePassword(Request $request)
    {

        $request->validate([
            'password' => 'required|min:8|max:16',
            'password_confirmation' => ['same:password'],
        ]);


        if (Auth::check()) {

            $agent = Auth::user();

            if ($agent->password_changed_at != null) {
                Auth::guard('web')->logout();
                return $this->sendError('Error Pass Invalid');
            }


            User::where('id', $agent->id)
                ->update(['password' => Hash::make($request->password), 'password_changed_at' => Carbon::now()]);

            Auth::guard('web')->logout();

            return Redirect('login');
        }

        return $this->sendError('Error Pass Invalid');
    }
}
