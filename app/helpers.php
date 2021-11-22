<?php
use App\Models\User;
use Illuminate\Support\Facades\Auth;

if (!function_exists('checkDateFormat')) {
    function checkDateFormat($date) {
        if (!preg_match('/\d{4}-\d{2}-\d{2}/', $date)) {
            return false;
        }
        $arDate = explode('-', $date);
        $year = $arDate[0];
        $month = $arDate[1];
        $day = $arDate[2];
        return checkdate($month, $day, $year);
    }
}

if (!function_exists('getSubordinatesForCurrentUser')) {
    function getSubordinatesForCurrentUser() {
        $currentId = Auth::user()->id;
        return User::where('supervisor', '=', $currentId)->get();
    }
}
