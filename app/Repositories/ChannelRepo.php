<?php

namespace App\Repositories;

use App\Models\Channel;


class ChannelRepo extends BaseRepo {

    public static function getOneByYid($yid)
    {
        return Channel::where('c_id',$yid)->first();
    }

    public static function getOneById($id)
    {
        return Channel::where('id',$id)->first();
    }

    public static function getAll()
    {
        return Channel::all();
    }

}