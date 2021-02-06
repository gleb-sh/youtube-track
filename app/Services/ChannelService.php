<?php

namespace App\Services;

use App\Models\Channel;
use App\Repositories\ChannelRepo;
use Alaouy\Youtube\Facades\Youtube;

class ChannelService extends BaseService {


    public static function getInfoById($c_id) {

        return $channel = Youtube::getChannelById($c_id);

    }

    public static function getVideoList($c_id) {

        return Youtube::listChannelVideos($c_id, '50');

    } 


    public static function updateInfo($id) {

        $channel = ChannelRepo::getOneById($id);

        $data = ChannelService::getInfoById($channel->c_id);

        $channel->title = $data->snippet->title;
        $channel->medium = $data->snippet->thumbnails->medium->url;
        $channel->subs_count = $data->statistics->subscriberCount;

        $channel->save();

        return $channel;

    }

    public static function create($data, $group) {

        // создаём канал, записываем о нём общую инфрмацию
        $channel = new Channel;
        $channel->c_id = $data->id;
        $channel->title = $data->snippet->title;
        $channel->medium = $data->snippet->thumbnails->medium->url;
        $channel->subs_count = $data->statistics->subscriberCount;
        $channel->group_id = $group;
        $channel->save();

        // получаем данные о всех видео
        $videos = ChannelService::getVideoList($channel['c_id']);
        // записываем данные о всех видосах
        foreach ($videos as $video) {
            // на будущее: добавить в очередь задачу по записи видоса в бд - ?
            VideoService::newByChannel($video,$channel['id']);
            sleep(0.04);

        }

        // ставим задачу на обновление данных о канале
        // ! не ставим. её нужно написать в кернел

        // ставим задачу на обновление данных о видео 
        // ! не ставим. её нужно написать в кернел

        // возвращаем объект с данными о канале
        return $channel;

    }


}