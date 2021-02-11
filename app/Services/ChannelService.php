<?php

namespace App\Services;

use App\Models\Channel;
use App\Repositories\ChannelRepo;
use App\Repositories\VideoRepo;
use Alaouy\Youtube\Facades\Youtube;
use App\Services\VideoService;
use App\Job\NewVideo;

class ChannelService extends BaseService {


    public static function getInfoById($c_id) 
    {

        return $channel = Youtube::getChannelById($c_id);

    }

    public static function getVideoList($c_id) 
    {

        return Youtube::listChannelVideos($c_id, '50');

    } 

    public static function updateAll()
    {
        $channels = ChannelRepo::getAll();

        foreach ($channels as $channel) {
            ChannelService::updateInfo($channel);
            \sleep(0.1);
        }

        return true;

    }

    public static function updateVideoList()
    {
        $channels = ChannelRepo::getAll();

        foreach ($channels as $channel) {
            $newlist = ChannelService::getVideoList($channel['c_id']);
            foreach ($newlist as $item) {
                // first or create
                if (VideoRepo::getOneByYID($item->id->videoId)) {} else {
                    VideoService::newByChannel($item->id->videoId,$channel['id']);
                    \sleep(0.04);
                }
            }
            \sleep(0.04);
        }

        return true;
    }


    public static function updateInfo($channel)
    {

        //$channel = ChannelRepo::getOneById($id);

        $data = ChannelService::getInfoById($channel->c_id);

        $channel->title = $data->snippet->title;
        $channel->medium = $data->snippet->thumbnails->medium->url;
        if ($data->statistics->hiddenSubscriberCount !== true) {
            $channel->subs_count = $data->statistics->subscriberCount;
        }

        $channel->save();

        return $channel;

    }

    public static function create($data, $groupID)
    {

        // создаём канал, записываем о нём общую инфрмацию
        $channel = new Channel;
        $channel->c_id = $data->id;
        $channel->title = $data->snippet->title;
        $channel->medium = $data->snippet->thumbnails->medium->url;
        if ($data->statistics->hiddenSubscriberCount !== true) {
            $channel->subs_count = $data->statistics->subscriberCount;
        }
        $channel->group_id = $groupID;
        $channel->save();

        // получаем данные о всех видео
        $videos = ChannelService::getVideoList($data->id);
        // записываем данные о всех видосах
        foreach ($videos as $video) {

            VideoService::newByChannel($video->id->videoId, $channel['id']);
            sleep(0.04);

        }

        // возвращаем объект с данными о канале
        return $channel;

    }

    public static function deleteAll($group)
    {
        return response( var_dump($group) );
        $channels = $group->channels;

        foreach ($channels as $channel) {
            ChannelService::delete($channel);
        }

        return true;

    }

    public static function delete($channel)
    {
        $id = $channel['group_id'];

        // рекурсивное удаление канала и его видосов
        $videos = $channel->videos;
        // удалить видосы
        foreach ($videos as $video) {
            $views = $video->views;
            // удалить просмотры на видосах
            foreach ($views as $view) {
                $view->delete();
            }
            $video->delete();
        }
        // удалить канал
        $channel->delete();

        return $id;

    }

    public static function show($id)
    {

        // параметры сортировки
        $sort = [
            'by'=>'pub_date',
            'type'=>'desc',
        ];
        // список без статистики
        return $list = VideoRepo::getByChannelId($id,$sort);
    }


}