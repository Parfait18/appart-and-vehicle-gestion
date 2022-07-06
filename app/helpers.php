<?php


use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;

// On vérifie si la fonction n'existe pas déjà avant de la créer

if (!function_exists("get_date_diff")) {
    // On crée l'helper de récupération d'un User à partir d'une adresse email
    function get_date_diff($date_one, $date_two)
    {
    }
}


if (!function_exists("get_km_diff")) {

    function get_km_diff($start_km, $end_km)
    {

        return round($end_km - $start_km, 2);
    }
}

if (!function_exists("random_string")) {

    function random_string($length)
    {

        $key = '';
        $keys = array_merge(range('A', 'Z'));

        for ($i = 0; $i < $length; $i++) {
            $key .= $keys[array_rand($keys)];
        }

        return $key;
    }
}
