<?php

namespace App\Services;

use App\Models\Video;

class VideoService extends BaseService {

    public static function newByChannel($data,$id) {
        // метод, который нужно переделать
        // и заменить на задачу в очереди

        $v = new Video;
        $v->v_id = $data->id->videoId;
        $v->channel_id = $id;
        $v->title = $data->snippet->title;
        $v->pik = $data->snippet->thumbnails->default->url;
        //$v->comment_count = $data;
        //$v->like_count = $data;
        //$v->dislike_count = $data;
        //$v->in_checK = $data;
        //$v->in_table = $data;
        $v->save();

    }
}