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
class Product extends Controller {

    /**
     * Display the form to add a product
     *
     * @return \Illuminate\Http\Response
     */
    public function productAddGet() {
        return view('add_product');
    }

    /**
     * Display all product into a table
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function productList() {
        $aProduct = \App\Product::getAllProduct();
        return view('product_list')->with(compact('aProduct'));
    }


    /**
     * add one or many products
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View add product
     */
    public function productAddPost() {

        $iInsertedRow = 0;

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

                $iInsertedRow = \App\Product::addProduct($aCaloriesProduit[$key], $aNomProduit[$key], $aPrixProduit[$key]);
                //$aData[] = array("nom" => $aNomProduit[$key], "prix" => $aPrixProduit[$key], "calories" => $aCaloriesProduit[$key]);
            }
        }

        if ($iInsertedRow > 0) {
            $mResult = "Insertion(s) réussie(s).";
        } else {
            $mResult = "Une erreur s'est produite sur la requette.";
        }

        return view('add_product')->with(compact('mResult'));
    }

    public function updateProductGet($id) {
        $aProduct = \App\Product::getProductById($id);
        return view('modify_product')->with(compact('aProduct'));
    }

    /**
     * Update a product
     * @return \Illuminate\Http\RedirectResponse
     */
    public function updateProductPost() {

        $id = Request('id');
        $sName = Request('sName');
        $fPrice = Request('fPrice');
        $iCal = Request('iCal');
        $aProduct = \App\Product::getProductById($id);

        if (!empty($sName) && !empty($fPrice) && !empty($iCal)) {

            if (Validator::isValidStr($sName) !== false) {
                if (Validator::isValidInt($fPrice) !== false) {
                    if (Validator::isValidInt($iCal) !== false) {
                        $iModifiedRow = \App\Product::updateProduct($sName, $fPrice, $iCal, $id);
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
        return view('Product@productList')->with(compact('aProduct'));
    }

    /**
     * Soft delete product in ajax
     * @param $id
     * @return false|string
     */
    public function deleteProductAjaxPost($id) {

        $iModifiedRow = \App\Product::deleteProduct($id);
        if ($iModifiedRow > 0) {
            $sMessage = "Suppression effectuée.";
        } else {
            $sMessage = "Erreur sur la suppression du produit.";
        }
        return json_encode($sMessage);
    }


    /**
     * Get product name with ajax
     * @param Request $request
     * @return array
     */
    public function getProductByPartialName(Request $request) {

        $term = $request->get('term');
        $data = DB::select("select name from product where name like '%$term%'");
        $aData[] = array();
        foreach ($data as $a) {
            foreach ($a as $i) {
                $aData[] = $i;
            }
        }
        return $aData;
    }

}