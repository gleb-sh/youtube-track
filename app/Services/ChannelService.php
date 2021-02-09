<?php

namespace App\Services;

use App\Models\Channel;
use App\Repositories\ChannelRepo;
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


    public static function updateInfo($id)
    {

        $channel = ChannelRepo::getOneById($id);

        $data = ChannelService::getInfoById($channel->c_id);

        $channel->title = $data->snippet->title;
        $channel->medium = $data->snippet->thumbnails->medium->url;
        $channel->subs_count = $data->statistics->subscriberCount;

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
        $channel->subs_count = $data->statistics->subscriberCount;
        $channel->group_id = $groupID;
        $channel->save();

        // получаем данные о всех видео
        $videos = ChannelService::getVideoList($data->id);
        // записываем данные о всех видосах
        foreach ($videos as $video) {

            //return response( var_dump($video) );

            VideoService::newByChannel($video->id->videoId, $channel['id']);
            sleep(0.04);
            // добавить в очередь задачу по записи видоса в бд 
            //\dispatch( new NewVideo($video,$channel['id']) );

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


}