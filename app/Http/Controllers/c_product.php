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


    public function list_product() {
        $aProduit = DB::select("SELECT * from product where status = 1");
        return view('product_list')->with(compact('aProduit'));

    }

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

        foreach ($aNomProduit as $key => $nom) {
            if (Validator::isValidStr($nom) !== false) {
                if (Validator::isValidInt($aPrixProduit[$key])) {
                    if (Validator::isValidInt($aCaloriesProduit[$key])) {
                        // tous les champs sont OK
                    } else {
                        $error = "la valeur calorifique est incorecte";
                    }
                } else {
                    $error = "le prix du produit est incorect";
                }
            } else {
                $error = "le nom du produit est incorect";
            }
        }

        if (empty($error)) {
            foreach ($aNomProduit as $key => $info) {

                DB::insert('insert into product (cal, name, price, status, created_at, modified_at) values(?,?,?,?,?,?)',
                    [$aCaloriesProduit[$key], $aNomProduit[$key], $aPrixProduit[$key], 1, date("Y-m-d H:i:s"), date("Y-m-d H:i:s")]);
                $aData[] = array("nom" => $aNomProduit[$key], "prix" => $aPrixProduit[$key], "calories" => $aCaloriesProduit[$key]);
            }
        }

        return view('add_product')->with(compact('mResult'));
    }

    public function update_product_get($id) {

        $aProduct = DB::select("SELECT * from product where id = " . $id);
        return view('modify_product')->with(compact('aProduct'));
    }

    public function update_product_post($id) {

        echo "ok";

        $id = Request('id'); // TODO: tester valeur
        $sName = Request('sName'); // TODO: tester valeur
        $fPrice = Request('fPrice'); // TODO: tester valeur
        $iCal = Request('iCal'); // TODO: tester valeur

        $iQueryModif = 0;

        if (!empty($sName) && !empty($fPrice) && !empty($iCal)) {

            if (Validator::isValidStr($sName) !== false) {
                if (Validator::isValidInt($fPrice) !== false) {
                    if (Validator::isValidInt($iCal) !== false) {
                        $iQueryModif = DB::update('UPDATE product set name = "' . $sName . '", price =' . $fPrice . ', cal = ' . $iCal . ', modified_at = "' . date("Y-m-d H:i:s") . '"   where id = ' . $id);

                    } else {
                        $error = "la valeur énérgetique du produit est incorecte.";
                    }
                } else {
                    $error = "le prix du produit est incorect.";
                }
            } else {
                $error = "le nom du produit est incorect.";
            }

        }

        //TODO: gérer l'affichage des cas d'erreur (conerver les données etc ...)

        return redirect()->action('c_product@list_product');
    }

    public
    function ajax_delete_product($id) {

        $iQueryModif = DB::update('UPDATE product set status = 0, modified_at = "' . date("Y-m-d H:i:s") . '" where id = ' . $id);
        if ($iQueryModif > 0) {
            $sMessage = "Suppression effectuée.";
        } else {
            $sMessage = "Erreur sur la suppression du produit.";
        }
        return json_encode($sMessage);

    }


    public
    function ajax_get_produit(Request $request) {
        $data = produit::select("nom_produit")
            ->where("nom_produit", "LIKE", "%{$request->input('query')}%")
            ->get();
        return response()->json($data);

    }


}