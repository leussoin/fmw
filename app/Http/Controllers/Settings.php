<?php
/**
 * Created by PhpStorm.
 * User: Fixe
 * Date: 23/02/2019
 * Time: 13:49
 */

namespace App\Http\Controllers;


use DB;
use Illuminate\Http\Request;

/**
 * Handle all that refers to users settings
 * @package App\Http\Controllers
 */
class Settings extends Controller {

    public function index() {
        return view('settings');
    }



}