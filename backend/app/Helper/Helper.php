<?php

namespace App\Helpers;

use App\Models\Accessory;
use App\Models\Component;
use App\Models\Consumable;
use App\Models\CustomField;
use App\Models\CustomFieldset;
use App\Models\Depreciation;
use App\Models\Setting;
use App\Models\Statuslabel;
use Crypt;
use Illuminate\Contracts\Encryption\DecryptException;
use Image;
use Carbon\Carbon;

class Helper
{
    
    public static function getFormattedDateObject($date, $type = 'datetime', $array = true)
    {
        // dd('hihih');
        if ($date == '') {
            return null;
        }

        // $settings = Setting::getSettings();

        /**
         * Wrap this in a try/catch so that if Carbon crashes, for example if the $date value
         * isn't actually valid, we don't crash out completely.
         *
         * While this *shouldn't* typically happen since we validate dates before entering them
         * into the database (and we use date/datetime fields for native fields in the system),
         * it is a possible scenario that a custom field could be created as an "ANY" field, data gets
         * added, and then the custom field format gets edited later. If someone put bad data in the
         * database before then - or if they manually edited the field's value - it will crash.
         *
         */



        $tmp_date = new Carbon($date);

        if ($type == 'datetime') {
            $dt['datetime'] = $tmp_date->format('Y-m-d H:i:s');
            // $dt['formatted'] = $tmp_date->format($settings->date_display_format.' '.$settings->time_display_format);
        } else {
            $dt['date'] = $tmp_date->format('Y-m-d');
            // $dt['formatted'] = $tmp_date->format($settings->date_display_format);
        }

        if ($array == 'true') {
            return $dt;
        }

        return $dt['formatted'];
    }
}
