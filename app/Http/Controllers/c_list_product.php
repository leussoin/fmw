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


class c_list_product {

    public function index_get() {
        $aProduit = DB::select("SELECT * from product where status = 1");
        return view('product_list')->with(compact('aProduit'));

    }
}