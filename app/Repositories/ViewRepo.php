<?php

namespace App\Repositories;

use App\Models\View;


class ViewRepo extends BaseRepo {

    public static function getLast($video_id,$limit = 24)
    {
        return View::where([
            'video_id'=>$video_id,
        ])->orderBy('id','desc')
            ->limit($limit)
            ->get();
    }

}