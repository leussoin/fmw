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
 * Handle all that refers to products
 * @package App\Http\Controllers
 */
class Login extends Controller {

    public static function Login() {


        return view('login');
    }

}