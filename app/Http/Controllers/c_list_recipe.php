<?php
/**
 * Created by PhpStorm.
 * User: Fixe
 * Date: 23/02/2019
 * Time: 13:49
 */

namespace App\Http\Controllers;


class c_list_recipe {

    public function index_get() {
        return view('recipe_list');
    }
}