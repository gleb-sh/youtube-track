<?php

namespace App\Services;

use App\Models\View;

class VideoService extends BaseService {

    public static function write($video,$count)
    {

        date_default_timezone_set('Europe/Moscow');

        $v = new View;
        $v->video_id = $video;
        $v->count = $count;
        $v->time_to = date('H');
        $v->save();

        $last_v = View::where(['id',$v['id'] - 1]);

        if ($last_v) {
            $v->time_from = $last_v->time_to;
            $v->save();
        }

    }

}