<?php
/**
 * Created by PhpStorm.
 * User: Fixe
 * Date: 23/02/2019
 * Time: 13:49
 */

namespace App\Http\Controllers;


class c_add_recipe {

    public function add_recipe_get() {
        return view('add_recipe');
    }
}