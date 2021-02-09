<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;


    public $answer = array(
        'status' => 0,
        'mess' => null,
        'error' => null,
        'data' => array(),
    );

    public function answerJson() {

        if ($this->answer['status'] === 1) {
            unset($this->answer['error']);
        } else {
            //unset($this->answer['data']);
            if ($this->answer['mess'] == null) {
                $this->answer['mess'] = 'Неизвестная ошибка';
            }
        }


        return response()->json($this->answer);
    }

}
