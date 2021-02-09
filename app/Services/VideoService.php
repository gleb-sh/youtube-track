<?php

namespace App\Services;

use App\Models\Video;
use App\Services\ViewService;
use Alaouy\Youtube\Facades\Youtube;


class VideoService extends BaseService {

    public static function setDayUp($id,$up)
    {
        $v = Video::where([
            'id'=>$id,
        ])->first();

        $v->view_up = $up;
        $v->save();
        return true;
        
    }

    public static function getInfoAll($YID)
    {
        // тестовый метод
        return Youtube::getVideoInfo($YID);
    }

    public static function getInfo($YID)
    {
        // временно не используется

        $data = Youtube::getVideoInfo($YID);

        $info = [
            'v_id'=>$data->id,
            'c_id'=>$data->snippet->channelId,
            'title'=>$data->snippet->title,
            'pub_date'=>$data->snippet->publishedAt,
            'pik'=>$data->snippet->thumbnails->default->url,
            'comment_count'=>$data->statistics->commentCount,
            'like_count'=>$data->statistics->likeCount,
            'dislike_count'=>$data->statistics->dislikeCount,
            'view_count'=>$data->statistics->viewCount,
        ];

        return $info;

    }

    public static function newByChannel($v_id,$cannel_id)
    {

        $data = Youtube::getVideoInfo($v_id);

        $v = new Video;
        $v->v_id = $data->id;
        $v->channel_id = $cannel_id;
        $v->c_id = $data->snippet->channelId;
        $v->title = $data->snippet->title;
        $v->pub_date = $data->snippet->publishedAt;
        $v->pik = $data->snippet->thumbnails->default->url;
        if (isset($data->statistics->commentCount)) {
            $v->comment_count = $data->statistics->commentCount;
        }
        if (isset($data->statistics->likeCount)) {
            $v->like_count = $data->statistics->likeCount;
        }
        if (isset($data->statistics->dislikeCount)) {
            $v->dislike_count = $data->statistics->dislikeCount;
        }
        $v->save();

        // ++ забор просмотров в нужную таблицу

        ViewService::write($v['id'],$data->statistics->viewCount);


    }

    // метод обновления видео вызвается из updateAll
    public static function update($v)
    {

        $data = Youtube::getVideoInfo($v['c_id']);

        $v->v_id = $data->id->videoId;
        $v->c_id = $data->snippet->channelId;
        $v->title = $data->snippet->title;
        $v->pub_date = $data->snippet->publishedAt;
        $v->pik = $data->snippet->thumbnails->default->url;
        if (isset($data->statistics->commentCount)) {
            $v->comment_count = $data->statistics->commentCount;
        }
        if (isset($data->statistics->likeCount)) {
            $v->like_count = $data->statistics->likeCount;
        }
        if (isset($data->statistics->dislikeCount)) {
            $v->dislike_count = $data->statistics->dislikeCount;
        }
        $v->save();
        // ++ забор просмотров в нужную таблицу

        ViewService::write($v['id'],$data->statistics->viewCount);

    }

    // метод обновления всех видео, вызвается каждый час из Kernel

    public static function updateAll() 
    {
        // ищем все видосы, не исключенные из отслеживания
        $videos = Video::where([
            'in_check'=>true,
        ])->get();
        // производитм апдейт всех значений
        foreach ($videos as $video) {
            VideoService::update($video);
        }
        // перебираем все видосы и проверяем на конрольные значения
        // исключаем из отслеживания те, которые не могу нормально набрать
        // исключаем из вывода те, которые тоже не могут нормально набрать
    }
}