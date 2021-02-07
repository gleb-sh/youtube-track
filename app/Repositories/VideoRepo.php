<?php

namespace App\Repositories;

use App\Models\Video;


class VideoRepo extends BaseRepo {
    
    public static function getByChannelId($id,$sort = null) {
        return Video::where([
            'in_table'=>true,
            'channel_id'=>$id,
            ])
            ->orderBy($sort['by'],$sort['type'])
            ->get();
    }

}