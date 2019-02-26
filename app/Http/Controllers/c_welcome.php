<?php
/**
 * Created by PhpStorm.
 * User: Fixe
 * Date: 23/02/2019
 * Time: 12:42
 */

namespace App\Http\Controllers;

use DB;
use Request;

class c_welcome extends Controller {

    public function welcome_get() {
        return view('welcome');
    }

    public function index_post() {
        $a = "formulaire reçu";
        return view('welcome')->with('a', $a);
    }

    public function index_inscription() {
        return view('t_inscription');

    }

}