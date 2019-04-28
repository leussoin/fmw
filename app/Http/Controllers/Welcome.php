<?php
/**
 * Created by PhpStorm.
 * User: Fixe
 * Date: 23/02/2019
 * Time: 12:42
 */

namespace App\Http\Controllers;


class welcome extends Controller {

    public function welcome() {

        $oUser = session('oUser');

        return view('welcome', ['oUser' => $oUser]);

    }

}