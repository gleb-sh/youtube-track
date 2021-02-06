<?php

namespace App\Repositories;

use App\Models\Video;


class VideoRepo extends BaseRepo {
    
    public static function getByChannelId($id) {
        return Video::where(['in_table'=>true])->get();
        //return Group::select(['id','name'])->orderByDesc('id')->get();
    }

}