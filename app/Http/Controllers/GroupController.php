<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\GroupService;
use App\Repositories\GroupRepo;

class GroupController extends Controller
{

    public function showAll()
    {

        $groups = GroupRepo::getAll();

        return view( 'groups',compact('groups') );
    }

    public function showOne(Request $request, $id)
    {
        $group = GroupRepo::getOne($id);
        $list = $group->channels;
        return view( 'group',compact('group','list') );
    }

    public function create(Request $request) {

        $data = $request->json()->all();

        try {
            if (GroupService::create($data)) {
                $this->answer['mess'] = 'reload';
                $this->answer['status'] = 1;
            }
        } catch (\Throwable $th) {
            $this->answer['error'] = $th->getMessage() . ' ' . $th->getFile() . ' : ' . $th->getLine();
        }

        return $this->answerJson();
    }

    public function rename(Request $request, $id) {

        $data = $request->json()->all();

        $data = [
            'id' => $id,
            'name'=>$data['name'],
        ];

        try {
            if (GroupService::rename($data)) {
                $this->answer['mess'] = 'reload';
                $this->answer['status'] = 1;
            }
        } catch (\Throwable $th) {
            $this->answer['error'] = $th->getMessage() . ' ' . $th->getFile() . ' : ' . $th->getLine();
        }

        return $this->answerJson();
    }

    public function delete(Request $request, $id) {

        $data = $request->json()->all();

        $data = ['id' => $id];

        try {
            if (GroupService::delete($data)) {
                $this->answer['mess'] = 'link';
                $this->answer['data']['link'] = '/welcome';
                $this->answer['status'] = 1;
            }
        } catch (\Throwable $th) {
            $this->answer['error'] = $th->getMessage() . ' ' . $th->getFile() . ' : ' . $th->getLine();
        }

        return $this->answerJson();
    }

}
