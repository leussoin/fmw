<?php
/**
 * Created by PhpStorm.
 * User: Fixe
 * Date: 23/02/2019
 * Time: 12:42
 */

namespace App\Http\Controllers;


class c_welcome extends Controller {

    public function welcome_get() {
        return view('welcome');
    }

}