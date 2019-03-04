<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;


class Recipe extends Controller {

    /*public $sRecipeName;
    public $aQuantity;
    public $aUnit;
    public $aProductName;

    public function __construct($sRecipeName = null, $aProductName = null, $aQuantity = null, $aUnit = null) {

        $this->aProductName = $aProductName;
        $this->aQuantity = $aQuantity;
        $this->aUnit = $aUnit;
        $this->sRecipeName = $sRecipeName;

    }
*/

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function recipeList() {
        $aRecipe = \App\Recipe::getAllRecipe();
        return view('recipe_list', ['aRecipe' => $aRecipe]);
    }


    /**
     * Display the form to add a recipe
     *
     * @return \Illuminate\Http\Response
     */
    public function addRecipeGet() {
        return view('add_recipe');
    }


    /**
     * Add a recipe
     *
     * @return \Illuminate\Http\Response
     */
    public function addRecipePost() {
        $sRecipeName = Request('sRecipeName');
        $aProductName = Request('aProductName');
        $aQuantity = Request('aQuantity');
        $aUnit = Request('aUnit');

        if (Validator::isValidStr($sRecipeName)) {
            //$iRowInserted = \App\Recipe::addRecipe($sRecipeName);
            //if ($iRowInserted > 0) {
            foreach ($aProductName as $key => $name) {
                if (Validator::isValidStr($name)) {
                    if (Validator::isValidInt($aQuantity[$key])) {
                        $iIdProduct = \App\Product::getIdProductByName($name);
                        if (!empty($iIdProduct)) {
                            echo "tout est OK";
                            $aParams['quantity'] = $aQuantity[$key];
                            $aParams['name'] = $name;
                            $aParams['id_product'] = $iIdProduct;
                        } else {
                            unset($aParams);
                            break;
                            //TODO: ajouter un message d'erreur : un produit est foiré ou bien quantité n'est pas un int
                        }
                    } else {
                        echo "Erreur sur la quantité";
                    }
                } else {
                    echo "Erreur sur nom d'un des produits";
                }
            }
            /*} else {
                $sError = "Une erreur s'est produite sur la requette AddRecipe";
            }
        } else {
            echo "Erreur sur nom de la recette";
        */
        }

        if (!empty($aParams)) {
            foreach ($aParams as $param) {
                dd($param);
            }
        }

        return view('add_recipe');
    }

    /**
     * Handle select like to suggest products to users
     * @return \Illuminate\Http\JsonResponse
     */
    public function getProductByPartialNameAjaxPost() {
        $term = Request('term');
        $sProduct = \App\Product::getProductByPartialNameAjax($term);
        return response()->json($sProduct);

    }


}
