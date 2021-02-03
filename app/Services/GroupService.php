<?php

namespace App\Services;

use App\Models\Group;

class GroupService extends BaseServices {

    public static function create($data) {
        $group = new Group();
        $group->name = trim($data['name']);
        $group->save();
        return true;
    }

    public static function rename($data) {
        $group = Group::where('id',$data['id'])->first();
        $group->name = trim($data['name']);
        $group->save();
        return true;
    }

    public static function delete($data) {
        if ($group = Group::where( 'id', $data['id'] ) ) {
            $group->delete();
            return true;
        } else {
            return false;
        }
    }

}