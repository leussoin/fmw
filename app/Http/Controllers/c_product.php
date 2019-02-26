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


class c_product extends Controller {

    public function add_product_get() {
        //select * from unit
        $aUnit = DB::select("SELECT * from unit");
        return view('add_product')->with(compact('aUnit'));
    }

    /**
     * add one or many products
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View add product
     */
    public function add_product_post() {

        $aNomProduit = Request('aNomProduit');
        $aPrixProduit = Request('aPrixProduit');
        $aCaloriesProduit = Request('aCaloriesProduit');
        foreach ($aNomProduit as $key => $info) {

            DB::insert('insert into product (cal, name, unit, price, status, created_at, modified_at) values(?,?,?,?,?,?)',
                [$aCaloriesProduit[$key], $aNomProduit[$key], $aPrixProduit[$key], 1, date("Y-m-d H:i:s"), date("Y-m-d H:i:s")]);
            $aProduit[] = array("nom" => $aNomProduit[$key], "prix" => $aPrixProduit[$key], "calories" => $aCaloriesProduit[$key]);
        }

        return view('add_product')->with(compact('aProduit'));

    }

    public function ajax_delete_product($id) {

        $iQueryModif = DB::update('UPDATE product set status = 0, modified_at = "'.date("Y-m-d H:i:s").'" where id = '.$id);
        if ($iQueryModif > 0) {
            $sMessage = "Suppression effectuée.";
        } else {
            $sMessage = "Erreur sur la suppression du produit.";
        }
        return json_encode($sMessage);

    }


    public function update_product_post($id) {

        $aProduct = DB::update('SELECT * from product where id = '.$id);
        return view('add_product')->with(compact($aProduct));
    }

    public function ajax_get_produit(Request $request) {
        $data = produit::select("nom_produit")
            ->where("nom_produit", "LIKE", "%{$request->input('query')}%")
            ->get();
        return response()->json($data);

    }


}