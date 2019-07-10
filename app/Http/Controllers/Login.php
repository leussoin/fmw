<?php
/**
 * Created by PhpStorm.
 * User: Fixe
 * Date: 23/02/2019
 * Time: 13:49
 */

namespace App\Http\Controllers;

use App\Misc;
use Session;


/**
 * Handle all that refers to products
 * @package App\Http\Controllers
 */
class Login extends Controller {

    /*
     * Show login page connexion
     */
    public static function getLogin() {
        return view('login');
    }

    /*
 * Handle login connexion
 */
    public static function postLogin() {
        $aData['name'] = Request('login');
        $password = Request('password');

        //dd(addslashes($aData['name']));
        $aData['password'] = hash('sha512', $password);

        $oUser = Misc::getUserByNameAndPass($aData);
        if (!empty($oUser)) {

            Session::put('oUser', $oUser);
            return redirect()->action('Welcome@welcome');

        } else {
            echo 'Erreur sur les identifiants';
        }
        return view('login');
    }

}