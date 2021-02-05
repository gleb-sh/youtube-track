<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class UserController extends Controller
{
    public function login(Request $request) {

        $data = $request->json()->all();

        try {

            if (
                env('LARAVEL_ADMIN_USERNAME') == $data['login'] && 
                env('LARAVEL_ADMIN_PASS') == $data['pass']
            ) {
                session( ['user' => 1]  );
                $this->answer['status'] = 1;
                $this->answer['data']['session'] = session()->get('user');
            } else {
                $this->answer['mess'] = env('LARAVEL_ADMIN_USERNAME');
            }

        } catch (\Throwable $th) {
            $this->answer['error'] = $th->getMessage() . ' ' . $th->getFile() . ' : ' . $th->getLine();
        }

        return $this->answerJson();

    }

    public function logout() {
        session()->flush();
        return redirect('/');
    }
}
