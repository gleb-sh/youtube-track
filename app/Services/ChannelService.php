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
        //
        return Youtube::listChannelVideos($c_id, '50');
        //
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
        //

        // ставим задачу на обновление данных о канале
        //

        // ставим задачу на обновление данных о видео 
        //

        // возвращаем объект с данными о канале
        // return $channel;

        return false;

    }


}