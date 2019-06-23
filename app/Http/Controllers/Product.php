<?php
/**
 * Created by PhpStorm.
 * User: Fixe
 * Date: 23/02/2019
 * Time: 13:49
 */

namespace App\Http\Controllers;


use App\Misc;
use DB;
use Illuminate\Contracts\View\Factory;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\View\View;

/**
 * Handle all that refers to products
 * @package App\Http\Controllers
 */
class Product extends Controller {

    /**
     * Display the form to add a product
     *
     * @return Response
     */
    public function productAddGet() {
        $aSeason = Misc::getSeasons();
        return view('add_product')->with(compact('aSeason'));
    }

    /**
     * Display all product into a table
     * @return Factory|View
     */
    public function productList() {
        $aProduct = \App\Product::getAllProduct();
        $aSeasonProduct = array();
        foreach ($aProduct as $key => $product) {
            $mResult = Misc::getProductMonth($product->id);
            if (!empty($mResult)) {
                if ($key) {
                    foreach ($mResult as $lemois) {
                        $aSeasonProduct[$lemois->id_produit][] = $lemois->id_season;
                    }
                }
            }
        }

        return view('product_list',
            ['aProduct' => $aProduct,
                'aSeasonProduct' => $aSeasonProduct
            ]);
    }


    /**
     * add one or many products
     * @return Factory|View add product
     */
    public function productAddPost() {

        $iInsertedRow = 0;
        $sMonths = '';
        $aNomProduit = Request('aNomProduit');
        $aPrixProduit = Request('aPrixProduit');
        $aSeason = Request('aSeason');

        $aListSeason = Misc::getSeasons();

        //$input = $request->all();
        $iLastInsertedIdProduct = 0;

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
                $iLastInsertedIdProduct = \App\Product::addProduct($aCaloriesProduit[$key], $aNomProduit[$key], $aPrixProduit[$key], $sMonths);
            }

            if ($iLastInsertedIdProduct != 0) {
                foreach ($aSeason as $idSaison) {
                    $mResult = Misc::setProductSeason($iLastInsertedIdProduct, $idSaison);
                }
            } else {
                echo "Une erreur est survenue sur l'insertion du produit";
            }
        }

        if ($iInsertedRow > 0) {
            $mResult = "Insertion(s) réussie(s).";
        } else {
            $mResult = "Une erreur s'est produite sur la requette.";
        }

        return view('add_product',
            ['mResult' => $mResult,
                'aSeason' => $aListSeason
            ]);

    }

    /**
     * Handle update product view
     * @return RedirectResponse
     */
    public function updateProductGet($id) {
        $aProduct = \App\Product::getProductById($id);
        $aMonths = Misc::getSeasons();
        $aMonthsProduct = array();

        $mResult = Misc::getProductMonth($id);
        if (!empty($mResult)) {
            foreach ($mResult as $lemois) {
                $aMonthsProduct[$lemois->id_produit][] = $lemois->id_season;
            }
        }

        $mResult = Misc::getProductMonth($id);

        return view('modify_product', ['aProduct' => $aProduct, 'aMonths' => $aMonths, 'aMonthsProduct' => $aMonthsProduct]);
    }

    /**
     * Update a product
     * @return RedirectResponse
     */
    public function updateProductPost() {

        $id = Request('id');
        $sName = Request('sName');
        $fPrice = Request('fPrice');
        $iCal = Request('iCal');
        $aSelectedMonth = Request('aSelectedMonth');

        //$aProduct = \App\Product::getProductById($id);
        $aProduct = \App\Product::getAllProduct();


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

        //suppression des mois TODO: les retours les retours.........
        \App\Misc::deleteProductSeason($id);

        foreach ($aSelectedMonth as $month) {
            // TODO: les retours les retours.........
            \App\Misc::setProductSeason($id, $month);
        }

        // TODO : si y'a une erreur l'afficher sinon, rediriger
        //return view('product_list')->with(compact('aProduct'));
        return redirect('produit/lister');

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