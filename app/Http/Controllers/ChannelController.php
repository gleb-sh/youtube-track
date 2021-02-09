<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\ChannelService;
use App\Repositories\ChannelRepo;
use App\Repositories\VideoRepo;
use App\Services\VideoService;
use App\Services\GroupService;
use App\Repositories\GroupRepo;

class ChannelController extends Controller
{
    public function test(Request $request, string $name)
    {

        $data = GroupService::delete($name);

        //$data = GroupRepo::getOne($name);

        //$data = ChannelService::getVideoList($name);


        return view('vardump',compact('data'));
    }
    public function show(Request $request, string $id)
    {
        # show channel with data & without stats (for stats use api - getstats)

        $channel = ChannelRepo::getOneById($id);
        // параметры сортировки
        $sort = [
            'by'=>'pub_date',
            'type'=>'desc',
        ];
        // список без статистики
        $list = VideoRepo::getByChannelId($id,$sort);

        return view('channel',compact('channel','list'));
    }
    public function add(Request $request)
    {

        $data = $request->json()->all();

        // string $data['name'] - channel name or channel id (update: only ID)

        try {

            if ($channel = ChannelRepo::getOneByYid($data['name'])) {

                // здесь нужен рефакторинг (вывести в отношения или join)
                $group = GroupRepo::getOne($channel['group_id']);

                $this->answer['mess'] = 'Канал уже добавлен в группу ' . $group['name'];
    
            } else {
    
                if ($info = ChannelService::getInfoById($data['name'])) {

                    if ($channel = ChannelService::create($info,$data['group'])) {

                        $this->answer['mess'] = 'link';
                        $this->answer['data']['link'] = '/ch/' . $channel['id'];
                        $this->answer['status'] = 1;

                    } else {
                        $this->answer['mess'] = 'Не удалось собрать информацию о канале';
                    }

                } else {
                    $this->answer['mess'] = 'Канал с таким ID не существует';
                }
    
            }

        } catch (\Throwable $th) {
            $this->answer['error'] = $th->getMessage() . ' ' . $th->getFile() . ' : ' . $th->getLine();
        }

        return $this->answerJson();
    }
    public function delete(Request $request, string $id)
    {

        try {
            if ($result = ChannelService::delete(ChannelRepo::getOneById($id)) ) {
                $this->answer['mess'] = 'link';
                $this->answer['data']['link'] = '/gr/' . $result;
                $this->answer['status'] = 1;
            }
        } catch (\Throwable $th) {
            $this->answer['error'] = $th->getMessage() . ' ' . $th->getFile() . ' : ' . $th->getLine();
        }

        return $this->answerJson();

    }
}
