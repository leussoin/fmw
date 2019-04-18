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
        // dd($request->aProductName);


        $sRecipeName = htmlspecialchars(Request('sRecipeName'));
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
                                    $iInsertedProduct = \App\RecipeAssoc::addProductForRecipeTableAssoc($aParams);

                                    if ($iInsertedProduct === true) {
                                        $iTotalInsertedProduct++;


                                    } else {
                                        echo "Une erreur sur l'insertion des produit s'est passée";
                                    }
                                } else {
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
                    echo "Une erreur s'est produite sur la requette AddRecipe";
                }
            } else {
                echo "Erreur sur nom de la recette";
            }
        } else {
            echo "Il manque des informations (un ou plusieurs champs sont vides)";
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

        $aProduct = array();

        // recupére les infos de la recette + jointure sur recipe assoc + jointure => fail :'(
        //$aDataFullRecipe = \App\Recipe::getRecipeAndProduct($id);
        //todo : optimiser les objets (un seul objet produit ou bien un objet recette avec un tableau de produit)


        //recupération du tableau d'unités
        $aUnit = \App\Misc::getUnit();
        // récupération des informations de la recette
        $oRecipe = \App\Recipe::getRecipeByID($id);
        // récupération des product à partir de l'ID de la recete
        $oProduct = \App\Product::getProductByIdRecipe($id);


        // pour chacun d'entre eux => recupére le nom par l'ID
        foreach ($oProduct as $key => $product) {
            $aProduct[$key] = \App\Product::getProductById($product->product_id);

            // je veux la quantité pour chaque produit
            $aProduct[$key][0]->quantity = $oProduct[$key]->quantity;
        }


        return view('add_recipe', [
            'aUnit' => $aUnit,
            'oRecipe' => $oRecipe,
            'aProduct' => $aProduct,
        ]);

    }


    /**
     * Update a recipe
     * @return void
     */
    public function updateRecipePost(request $request) {

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
            \App\Misc::setInitTransaction();

            $iRowUpdated = \App\Recipe::updateRecipe($aData);
            if ($iRowUpdated > 0) {

                // si j'ai modifié, alors je supprime tous mes enregistrements where id recette = pouet
                $iRowDeleted = \App\RecipeAssoc::deleteProductAssocTable($aData);

                if ($iRowDeleted > 0) {
                    echo "Deletion des produits dans la table d'asso OK";
                } else {
                    echo "Deletion des produits dans la table d'asso KO";
                }

            } else {
                echo "Erreur sur l'update du nom de ma recette";
                // rajouter une valeur kaikpart pour à la fin de la fonction rollback
            }
        }

        foreach ($aProductName as $key => $product) {
            if (!empty($product[$key]) && !empty($aQuantity[$key]) && !empty($aUnit[$key])) {
                if (Validator::isValidStr($product[$key]) !== false) {
                    if (Validator::isValidInt($aQuantity[$key]) !== false) {
                        if (Validator::isValidInt($aUnit[$key]) !== false) {

                            $oProduct = \App\Product::getIdProductByName($product);

                            if (count($oProduct) !== 0) {
                                $aDataProduct['id_recipe'] = (int)$id;
                                $aDataProduct['id_product'] = $oProduct[0]->id;
                                $aDataProduct['quantity'] = (int)$aQuantity[$key];
                                $aDataProduct['id_unit'] = (int)$aUnit[$key];
                                // j'ai toutes les informations du produit dont l'ID je peux les add dans la table d'association

                                $iInsertedProduct = \App\RecipeAssoc::addProductForRecipeTableAssoc($aDataProduct);

                                if ($iInsertedProduct === true) {
                                    $iCptAddedProduct++;
                                }
                            } else {
                                $sError = "Erreur sur la recupération du produit (requette 'getIdProductByName' erreur ou bien produit inconu en base ?";
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


    public function getUnitAjax() {

        $aUnit = \App\Misc::getUnit();
        return json_encode($aUnit);
    }








}
