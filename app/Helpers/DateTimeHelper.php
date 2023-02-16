<?php

namespace App\Helpers;

use Carbon\Carbon;

class DateTimeHelper
{
    /**
     * Format date
     *
     * @param $date
     * @return string
     */
    public static function formatDateJapan($date)
    {
        return Carbon::parse($date)->isoFormat('Y年MM月DD日');
    }
}
