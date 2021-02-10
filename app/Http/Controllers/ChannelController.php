<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\GroupService;
use App\Services\ChannelService;
use App\Services\VideoService;
use App\Services\ViewService;
use App\Repositories\GroupRepo;
use App\Repositories\ChannelRepo;
use App\Repositories\VideoRepo;
use App\Repositories\ViewRepo;
use Alaouy\Youtube\Facades\Youtube;
use App\Models\View;

class ChannelController extends Controller
{
    public function test(Request $request, string $name)
    {

        $data = View::orderBy('id','desc')->limit(1)->get();
        $data = $data[0]['time_to'];

        return view('vardump',compact('data'));
    }
    public function show(Request $request, string $id)
    {
        # show channel with data & without stats (for stats use api - getstats)

        $channel = ChannelRepo::getOneById($id);

        $list = ChannelService::show($id);

        $header = ViewService::lastTime();

        return view('channel',compact('channel','list','header'));
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
            $this->answer['data'] = $th->getTraceAsString();
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
    public function getstats(Request $request, string $id)
    {

        try {
            $list = ChannelService::show($id);

            // создать объект статистики
            $stats = [];
            // перебрать list
            foreach ($list as $item) {
                // вызвать отношение view под условием (limit 24)
                $view = ViewService::getStats($item['id']);
                // добавить его в объект статистики

                foreach ($view as $v) {
                    $stats[ $item['id'] ][ $view[0]['time_to'] ] = $view[0]['count_up'];
                }
            }

            // вернуть объект статистики
            $this->answer['data'] = $stats;
            $this->answer['status'] = 1;

        } catch (\Throwable $th) {
            $this->answer['error'] = $th->getMessage() . ' ' . $th->getFile() . ' : ' . $th->getLine();
        }

        return $this->answerJson();

    }
}
