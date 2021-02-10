<?php

namespace App\Repositories;

use App\Models\Video;


class VideoRepo extends BaseRepo {
    
    public static function getByChannelId($id,$sort = null) {
        return Video::where([
            'in_table'=>true,
            'channel_id'=>$id,
        ])->orderBy($sort['by'],$sort['type'])
            ->get();
    }

    public static function getAllByChannelId($id)
    {
        return Video::where([
            'channel_id'=>$id,
        ])->get();
    }

    public static function getOneByYID($YID)
    {
        return Video::where([
            'v_id'=>$YID,
        ])->first();
    }

}