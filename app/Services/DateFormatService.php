<?php

declare(strict_types=1);

namespace App\Services;


use App\Models\Setting;
use DateTime;
use DateTimeZone;

final class DateFormatService
{
    public function getLocalDateTime($value, $userId = null): string
    {
        $timezone = Setting::query()
            ->where('name', 'default_timezone')
            ->first()
            ->value;

        $today = new DateTime($value, new DateTimeZone(config('app.timezone')));
        $today->setTimezone(new DateTimeZone($timezone));
        $value = $today->format('Y-m-d H:i:s');

        return $value;
    }
}
