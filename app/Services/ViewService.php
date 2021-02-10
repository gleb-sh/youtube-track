<?php

namespace App\Services;

use App\Models\View;
use App\Services\VideoService;


class ViewService extends BaseService {

    public static function write($video,$count)
    {

        date_default_timezone_set('Europe/Moscow');

        $v = new View;
        $v->video_id = $video;
        $v->count = $count;
        $v->time_to = date('H');
        $v->save();

        // вычисление прироста

        if ( $last_v = View::where([
            'video_id' => $video,
            'time_to' => $v['time_to'] - 1,
        ])->first() ) {
            $v->count_up = $v['count'] - $last_v['count'];
            $v->save();
        }

        // вычисление прироста за 24 часа

        if ($lastday = View::where([
            [ 'id', '<', $v['id'] ],
            'video_id' => $video,
        ])->orderBy('id','desc')->limit(24)->get() ) {

            $up = 0;

            foreach ($lastday as $day) {
                $up += $day['count_up'];
            }

            VideoService::setDayUp($video,$up);

        }
    }

    public static function getStats($video) {
        return $stats = View::where([
            'video_id'=>$video,
        ])->orderBy('id','desc')->limit(24)->get();
    }

    public static function lastTime() {
        if  ( $view = View::orderBy('id','desc')->limit(1)->get() ) {
            return $view[0]['time_to'];
        } else {
            date_default_timezone_set('Europe/Moscow');
            return date('H');
        }
    }

}