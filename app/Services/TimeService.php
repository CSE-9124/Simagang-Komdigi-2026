<?php

namespace App\Services;

use Carbon\Carbon;
use Illuminate\Support\Facades\Cache;

class TimeService
{
    /**
     * Dapatkan waktu WITA dari sumber eksternal (WorldTimeAPI) dengan cache singkat,
     * fallback ke waktu server jika API gagal.
     */
    public static function nowWita(): Carbon
    {
        $useExternal = env('ATTENDANCE_USE_EXTERNAL_TIME', false);
        if (!$useExternal) {
            return Carbon::now('Asia/Makassar');
        }

        return Cache::remember('time_wita_now', 30, function () {
            try {
                $resp = @file_get_contents('http://worldtimeapi.org/api/timezone/Asia/Makassar');
                if ($resp !== false) {
                    $data = json_decode($resp, true);
                    if (isset($data['datetime'])) {
                        return Carbon::parse($data['datetime'])->setTimezone('Asia/Makassar');
                    }
                }
            } catch (\Throwable $e) {
                // ignore and fallback
            }
            return Carbon::now('Asia/Makassar');
        });
    }
}


