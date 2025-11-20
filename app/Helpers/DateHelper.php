<?php

namespace App\Helpers;

use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class DateHelper
{
    public static function formatInUserTimezone($date, $format = 'd M Y H:i')
    {
        if (!$date) {
            return 'N/A';
        }

        $timezone = Auth::user()?->timezone ?? config('app.timezone', 'UTC');
        return Carbon::parse($date)->setTimezone($timezone)->format($format);
    }

    public static function getUserTimezone()
    {
        return Auth::user()?->timezone ?? config('app.timezone', 'UTC');
    }
}
