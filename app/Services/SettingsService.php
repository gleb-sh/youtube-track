<?php

namespace App\Services;

use App\Models\Settings;

class SettingsService extends BaseService {
    public static function rewrite($data)
    {

        if ( isset($data['in_table']) ) {

            Settings::updateOrCreate(
                ['name'=>'in_table'],
                ['value'=>$data['in_table']]
            );

        }

        if ( isset($data['in_check']) ) {

            Settings::updateOrCreate(
                ['name'=>'in_check'],
                ['value'=>$data['in_check']]
            );
            
        }
        
        return true;

    }
}

