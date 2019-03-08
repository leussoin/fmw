<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Lcobucci\JWT\Signer\Ecdsa;


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
        $aUnitSelect = \App\Misc::getUnit();
        return view('add_recipe', ['aUnitSelect' => $aUnitSelect]);
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
                                    $aParams['id_unit'] = (int)$aUnit[$key];


                                    // j'ai validé toutes mes informations et j'ai mes ID, plus qu'à les rentrer
                                    $iInsertedProduct = \App\Recipe::addProductForRecipeTableAssoc($aParams);

                                    if ($iInsertedProduct === true) {
                                        $iTotalInsertedProduct++;


                                    } else {
                                        echo "Une erreur sur l'insertion des produit s'est passée";
                                        break;
                                    }
                                } else {
                                    unset($aParams);
                                    echo "Un des produit est inconnu.";
                                    break;
                                }
                            } else {
                                echo "Erreur sur la quantité";
                                break;
                            }
                        } else {
                            echo "Erreur sur nom d'un des produits";
                            break;
                        }
                    }
                } else {
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
            \App\Misc::setRollbackTransaction();
            echo "Ajout de la recette KO";
        }

        return view('add_recipe', ['aUnitSelect' => $aUnitSelect]);
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


    public function deleteRecipeAjaxPost($id) {

        $iModifiedRow = \App\Recipe::deleteRecipe($id);
        if ($iModifiedRow > 0) {
            $sMessage = "Suppression effectuée.";
        } else {
            $sMessage = "Erreur sur la suppression du produit.";
        }

        return json_encode($sMessage);
    }


    /**
     * Display view to allow update recipe
     * @param $id
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function updateRecipeGet($id) {

        //todo : optimiser les objets (un seul objet produit ou bien un objet recette avec un tableau de produit
        $aUnitSelect = \App\Misc::getUnit();
        $oRecipe = \App\Recipe::getRecipeByID($id);
        $oProduct = \App\Product::getProductByIdRecipe($id);
        $aProduct = array();
        foreach ($oProduct as $product) {
            $aProduct[] = \App\Product::getProductById($product->product_id);
        }

        return view('add_recipe', [
            'aUnitSelect' => $aUnitSelect,
            'oProduct' => $oProduct,
            'oRecipe' => $oRecipe,
            'aProduct' => $aProduct,
        ]);

    }


    /**
     * Update a recipe
     * @param Request $request
     * @return void
     */
    public function updateRecipePost(Request $request) {

        //dd($request->all());
        $sRecipeName = Request('sRecipeName');
        $aProductName = Request('aProductName');
        $aQuantity = Request('aQuantity');
        $aUnit = Request('aUnit');

        // id du nom de la recette
        $id = Request('id');
        $aData['id'] = $id;
        $aData['name'] = htmlspecialchars($sRecipeName);

        $sError = "";
        $iCptAddedProduct = 0;


        //modification de la recette
        if (!empty($sRecipeName) && Validator::isValidStr($sRecipeName)) {
            $iRowUpdated = \App\Recipe::updateRecipe($aData);
            if ($iRowUpdated > 0) {
                \App\Misc::setInitTransaction();
            }
        }

        foreach ($aProductName as $key => $product) {
            if (!empty($product[$key]) && !empty($aQuantity[$key]) && !empty($aUnit[$key])) {
                if (Validator::isValidStr($product[$key]) !== false) {
                    if (Validator::isValidInt($aQuantity[$key]) !== false) {
                        if (Validator::isValidInt($aUnit[$key]) !== false) {

                            $oProduct = \App\Product::getProductByName($product);

                            //ligne deleted > 1 je continue sinon break + rollback
                            $iRowDeleted = \App\Product::deleteProductAssocTable($oProduct[0]->id);

                            if ($iRowDeleted === 0) {
                                \App\Misc::setRollbackTransaction();
                                //todo: attention au message à portée technique !
                                $sError = "Il y'à une erreur sur l'a suppresion du produit";
                                break;
                            }
                        } else {
                            $sError = "L'unité est incorecte.";
                        }
                    } else {
                        $sError = "la quantité est incorecte.";
                    }
                } else {
                    $sError = "le nom du produit est incorect.";
                }
                if (!empty($sError)) {
                    echo $sError;
                }
            }
        }

        //pour chaque produit je l'ajoute
        foreach ($aProductName as $key => $product) {

            /*$sRecipeName = Request('sRecipeName');
            $aProductName = Request('aProductName');
            $aQuantity = Request('aQuantity');
            $aUnit = Request('aUnit');*/

            // je récupére l'ID du produit
            $oProduct = \App\Product::getProductByName($product);
            dd($oProduct);



            $aProduct['id_recipe'] = (int)$id;
            dd($product);
            $aProduct['id_product'] = $idProduct[0]->id;
            $aProduct['quantity'] = (int)$aQuantity[$key];
            $aProduct['id_unit'] = (int)$aUnit[$key];

            // j'envoie le tableau pour creer un produit
            $iInsertedProduct = \App\Recipe::addProductForRecipeTableAssoc($aProduct);
            if ($iInsertedProduct > 0) {
                $iCptAddedProduct++;
            }
        }


        if (count($aProductName) === $iCptAddedProduct) {
            // tout vas bien j'init la transaction

            \App\Misc::setCommitTransaction();
            echo "Ajout de la recette OK";
        } else {
            \App\Misc::setRollbackTransaction();
            echo "Ajout de la recette KO";
        }
        return redirect()->action('Recipe@recipeList');

    }

}
