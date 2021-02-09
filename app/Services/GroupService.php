<?php

namespace App\Services;

use App\Models\Group;
use App\Services\ChannelService;
use App\Repositories\ChannelRepo;
use App\Repositories\GroupRepo;

class GroupService extends BaseService {

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

    public static function delete($id) {
        if ($group = GroupRepo::getOne($id) ) {

            $channels = $group->channels;

            foreach ($channels as $channel) {
                ChannelService::delete($channel);
            }
            
            //ChannelService::deleteAll( $group );
            
            $group->delete();
            
            return true;
        
        } else {
            return false;
        }
    }

}