<?php

namespace App\Repositories;

use App\Models\Group;


class GroupRepo extends BaseRepo {

    public static function getAll() : object
    {
        return Group::select(['id','name'])->orderByDesc('id')->get();
    }

    public static function getOne($id) : object
    {
        return Group::where('id',$id)->first();
    }

}