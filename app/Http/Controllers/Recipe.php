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
        $aUnit = \App\Misc::getUnit();

        return view('add_recipe', ['aUnit' => $aUnit]);
    }


    /**
     * Add a recipe
     *
     * @return \Illuminate\Http\Response
     */
    public function addRecipePost() {

        $aUnitSelect = \App\Misc::getUnit();


        $sRecipeName = Request('sRecipeName');
        $aProductName = Request('aProductName');
        $aQuantity = Request('aQuantity');
        $aUnit = Request('aUnit');

        $iTotalInsertedProduct = 0;

        if (count($aProductName) === count($aQuantity) && count($aQuantity) === count($aUnit)) {
            if (Validator::isValidStr($sRecipeName)) {
                \App\Misc::setInitTransaction();
                $iRecipeNameInserted = \App\Recipe::setRecipeName($sRecipeName);
                if ($iRecipeNameInserted > 0) {
                    $oRecipe = \App\Recipe::getRecipeIdByName($sRecipeName);
                    $idRecipe = $oRecipe[0]->id;

                    foreach ($aProductName as $key => $name) {
                        if (Validator::isValidStr($name)) {
                            if (Validator::isValidInt($aQuantity[$key])) {

                                $oProduct = \App\Product::getIdProductByName($name);

                                $iIdProduct = $oProduct[0]->id;
                                if (!empty($iIdProduct)) {

                                    $aParams['id_recipe'] = $idRecipe;
                                    $aParams['id_product'] = $iIdProduct;
                                    $aParams['quantity'] = (float)$aQuantity[$key];
                                    $aParams['id_unit'] =  (int)$aUnit[$key];


                                    // j'ai validé toutes mes informations et j'ai mes ID, plus qu'à les rentrer
                                    $iInsertedProduct = \App\Recipe::addProductForRecipeTableAssoc($aParams);

                                    if ($iInsertedProduct === true) {
                                        $iTotalInsertedProduct++;


                                    } else {
                                        echo "Une erreur sur l'insertion des produit s'est passée";
                                        \App\Misc::setRollbackTransaction();
                                        break;
                                    }
                                } else {
                                    \App\Misc::setRollbackTransaction();
                                    unset($aParams);
                                    echo "Un des produit est inconnu.";
                                }
                            } else {
                                echo "Erreur sur la quantité";
                            }
                        } else {
                            echo "Erreur sur nom d'un des produits";
                        }
                    }
                } else {
                    // si une erreur est survenue alors on rollback
                    \App\Misc::setRollbackTransaction();
                    echo "Une erreur s'est produite sur la requette AddRecipe";
                }
            } else {
                echo "Erreur sur nom de la recette";
            }
        } else {
            echo "Il manque des informations.";
        }

        if (count($aProductName) === $iTotalInsertedProduct && $iRecipeNameInserted === true) {
            \App\Misc::setCommitTransaction();
            echo "Ajout de la recette OK";
        } else {
            echo "Ajout de la recette KO";
        }

        return view('add_recipe', ['aUnitSelect' => $aUnitSelect]);
    }

    /**
     * Handle select like to suggest products to users
     * Handle select like to suggest products to users
     * @return \Illuminate\Http\JsonResponse
     */
    public
    function getProductByPartialNameAjaxPost() {
        $term = Request('term');
        $sProduct = \App\Product::getProductByPartialNameAjax($term);
        return response()->json($sProduct);

    }


    public function deleteRecipeAjaxPost($id) {

        $iModifiedRow = \App\Recipe::deleteRecipe($id);
        if ($iModifiedRow > 0) {
            $sMessage = "Suppression effectuée.";
        } else {
            $sMessage = "Erreur sur la suppression du produit.";
        }
        return json_encode($sMessage);

    }



}
