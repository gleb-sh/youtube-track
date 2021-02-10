<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\SettingsService;
use App\Models\Settings;


class SettingsController extends Controller
{
    public function show(Request $request)
    {
        $set = [];
        $set['in_table'] = Settings::where('name','in_table')->first();
        $set['in_table'] = $set['in_table']['value'];
        $set['in_check'] = Settings::where('name','in_check')->first();
        $set['in_check'] = $set['in_check']['value'];
        return view('settings',compact('set'));
    }
    public function rewrite(Request $request)
    {
        $data = $request->json()->all();

        //$data = $data['data'];

        try {
            if (SettingsService::rewrite($data) ) {
                $this->answer['status'] = 1;
            }
        } catch (\Throwable $th) {
            $this->answer['error'] = $th->getMessage() . ' ' . $th->getFile() . ' : ' . $th->getLine() . '<br>' . $th->getTraceAsString();
        }

        return $this->answerJson();
    }
}
