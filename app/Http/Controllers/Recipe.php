<?php

namespace App\Http\Controllers;

use App\Misc;
use App\RecipeAssoc;
use App\Users;
use DB;
use Illuminate\Http\Request;


class Recipe extends Controller {

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
        $aUnitSelect = Misc::getUnit();

        //calcul du total calorifique de ma recette
        //$iTotalCalorie = \App\RecipeAssoc::getRecipeProducts();   => besoin de l'ID de la recette

        return view('add_recipe', ['aUnitSelect' => $aUnitSelect]);
    }


    /**
     * Add a recipe
     *
     * @return \Illuminate\Http\Response
     */
    public function addRecipePost() {

        $aUnitSelect = Misc::getUnit();


        $sRecipeName = htmlspecialchars(Request('sRecipeName'));
        $aProductName = Request('aProductName');
        $aQuantity = Request('aQuantity');
        $aUnit = Request('aUnit');
        $sCookingRecipe = Request('cooking_recipe');
        $iNullCpt = 0;


        $iTotalInsertedProduct = 0;

        if (count($aProductName) === count($aQuantity) && count($aQuantity) === count($aUnit)) {

            if (Validator::isValidStr($sRecipeName)) {

                Misc::setInitTransaction();
                $iRecipeNameInserted = \App\Recipe::setRecipeData($sRecipeName, $sCookingRecipe);
                if ($iRecipeNameInserted > 0) {

                    $oRecipe = \App\Recipe::getRecipeIdByName($sRecipeName);

                    $idRecipe = $oRecipe[0]->id;
                    foreach ($aProductName as $key => $name) {

                        //if (!empty($name)) {


                        if (Validator::isValidStr($name) && !empty($name) && !is_null($name)) {

                            if (Validator::isValidInt($aQuantity[$key])) {
                                $oProduct = \App\Product::getIdProductByName($name);
                                $iIdProduct = $oProduct[0]->id;
                                if (!empty($iIdProduct)) {
                                    $aParams['id_recipe'] = $idRecipe;
                                    $aParams['id_product'] = $iIdProduct;
                                    $aParams['quantity'] = (float)$aQuantity[$key];
                                    $aParams['id_unit'] = (int)$aUnit[$key];
                                    $iInsertedProduct = RecipeAssoc::addProductForRecipeTableAssoc($aParams);
                                    if ($iInsertedProduct === true) {
                                        $iTotalInsertedProduct++;
                                    } else {
                                        echo "Une erreur sur l'insertion des produit s'est produite";
                                    }
                                } else {
                                    unset($aParams);
                                    echo "Un des produit est inconnu.";
                                }
                            } else {
                                echo "Erreur sur la quantité";
                            }
                        } else {
                            $iNullCpt++;                                //echo "Erreur sur nom d'un des produits";
                        }
                        //} else {
                        //    echo 'Le premier champs est vide';
                        //}
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
        var_dump(count($aProductName) - $iNullCpt);
        var_dump(($iTotalInsertedProduct));

        if (count($aProductName) - $iNullCpt === $iTotalInsertedProduct && $iRecipeNameInserted === true) {

            Misc::setCommitTransaction();
            echo "Ajout de la recette OK";
        } else {
            Misc::setRollbackTransaction();
            echo "Ajout de la recette KO";
        }

        return view('add_recipe', ['aUnitSelect' => $aUnitSelect]);
    }

    /**
     * Handle select like to suggest products to users
     * @return \Illuminate\Http\JsonResponse
     */
    /*public function getProductByPartialNameAjaxPost() {
        $term = Request('term');
        $sProduct = \App\Product::getProductByPartialNameAjax($term);
        return response()->json($sProduct);
    }*/


    /**
     * Handle select like to suggest recipe to users
     * @param Request $request
     * @return array
     */
    public function getRecipeByPartialName(Request $request) {
        $term = $request->get('term');
        $oUser = session('oUser');
        $aDislikedRecipeList = array();
        $aData[] = array();

        $aDislikedProduct = Users::getPreferences($oUser->id);
        foreach ($aDislikedProduct as $sProduct) {

            $cRecipe = \App\Recipe::getRecipeByOnceProductId($sProduct->product_disliked);
            if (!empty($cRecipe)) {
                foreach ($cRecipe as $iIdRecipe) {

                    $aDislikedRecipeList[] = \App\Recipe::getRecipeByID($iIdRecipe->recipe_id);
                }
            }
        }

        $data = \App\Recipe::getRecipeByPartialName($term);
        var_dump($data[0]->name);
        var_dump($aDislikedRecipeList[0]->name);


        foreach ($data as $cSuggeredRecipe) {
            foreach ($aDislikedRecipeList as $cDislikedRecipe) {
                var_dump($cSuggeredRecipe->name);
                var_dump($cDislikedRecipe->name);

                //si j'ai un plat que j'aime pas alors je l'ajoute pas
            }
        }


        dd('');

        foreach ($data as $k => $a) {
            foreach ($a as $i) {
                $aData[$k] = $i;
            }
        }
        return $aData;
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

        $aUnitSelect = Misc::getUnit();
        $aProduct = array();
        $iTotalCalorie = 0;


        //recupération du tableau d'unités
        $aUnit = Misc::getUnit();


        // récupération des informations de la recette
        $oRecipe = \App\Recipe::getRecipeByID($id);


        // récupération des product à partir de l'ID de la recete
        $listeObjProduit = \App\Product::getProductByIdRecipe($id);

        // pour chacun d'entre eux => recupére le nom par l'ID
        foreach ($listeObjProduit as $key => $product) {
            $aProduct[$key] = \App\Product::getProductById($product->product_id);
            // je veux la quantité pour chaque produit
            $aProduct[$key][0]->quantity = $listeObjProduit[$key]->quantity;

            $aInfosProduits = \App\Product::getProductById($product->product_id);
            $iCalorie = $aInfosProduits[0]->cal * $product->quantity;

            $iTotalCalorie += $iCalorie;
        }

        $oRecipe->total_calorie = $iTotalCalorie;


        return view('add_recipe', [
            'aUnit' => $aUnit,
            'oRecipe' => $oRecipe,
            'aProduct' => $aProduct,
            'aUnitSelect' => $aUnitSelect,
            'oProduct' => $listeObjProduit
        ]);

    }

    /**
     * Get the calorific value of a recipe when the user selects it
     * @param Request $request
     * @return false|string
     */
    public function getCalWithRecipeNameGet(Request $request) {
        $aCal = array();
        $input = $request->all();
        foreach ($input as $key => $oJour) {
            foreach ($oJour as $repas => $plat) {
                foreach ($plat as $moment => $valeur) {
                    $aCal[$moment] = $this::getTotalCalByRecipe($valeur);
                }
            }
        }
        return $aCal;
    }


    /**
     * Get total calorie from recipe with his name
     * @param $name
     * @return float|int
     */
    public function getTotalCalByRecipe($name) {

        $oRecipe = \App\Recipe::getRecipeIdByName($name);

        $oRecipeProduct = RecipeAssoc::getRecipeProducts($oRecipe[0]->id);
        $fTotalCal = 0;
        foreach ($oRecipeProduct as $key => $element) {
            $oProduct = \App\Product::getProductById($element->product_id);
            foreach ($oProduct as $product) {
                //var_dump($product->cal); // pour chaque produit voici sa valeur calorifique
                //var_dump($element->quantity);
                $fCal = $product->cal * $element->quantity;
                $fTotalCal += $fCal;
            }
        }
        return $fTotalCal;
    }

    /**
     * Update a recipe
     * @param Request $request
     * @return void
     * @throws \Exception
     */
    public function updateRecipePost(request $request) {

        $sRecipeName = Request('sRecipeName');
        $aProductName = Request('aProductName');
        $aQuantity = Request('aQuantity');
        $aUnit = Request('aUnit');
        $sCookingRecipe = Request('cooking_recipe');

        $aProductName = array_filter($aProductName);
        $aQuantity = array_filter($aQuantity);
        $aUnit = array_filter($aUnit);


        // id du nom de la recette
        $id = Request('id');
        $aData['id'] = $id;
        $aData['name'] = htmlspecialchars($sRecipeName);
        $aData['cooking_recipe'] = htmlspecialchars($sCookingRecipe);

        $sError = "";
        $iCptAddedProduct = 0;
        $iProduct = 0;

        //modification de la recette
        if (!empty($sRecipeName) && Validator::isValidStr($sRecipeName)) {

            Misc::setInitTransaction();

            $iRowUpdated = \App\Recipe::updateRecipeData($aData);
            if ($iRowUpdated > 0) {

                // si j'ai modifié, alors je supprime tous mes enregistrements where id recette = pouet
                $iRowDeleted = RecipeAssoc::deleteProductAssocTable($aData);

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

            // si AUCUN des elements de mon produit n'est vide (si TOUT est rempli)
            if (!empty($product) || !empty($aQuantity[$key]) || !empty($aUnit[$key])) {


                if (Validator::isValidStr($product) !== false) {

                    if (Validator::isValidInt($aQuantity[$key]) !== false) {

                        if (Validator::isValidInt($aUnit[$key]) !== false) {

                            $oProduct = \App\Product::getIdProductByName($product);


                            // si j'ai bien un produit
                            if (count($oProduct) === 1) {

                                $aDataProduct['id_recipe'] = (int)$id;
                                $aDataProduct['id_product'] = $oProduct[0]->id;
                                $aDataProduct['quantity'] = floatval($aQuantity[$key]);
                                $aDataProduct['id_unit'] = (int)$aUnit[$key];
                                // j'ai toutes les informations du produit dont l'ID je peux les add dans la table d'association

                                $iInsertedProduct = RecipeAssoc::addProductForRecipeTableAssoc($aDataProduct);

                                if ($iInsertedProduct === true) {
                                    $iCptAddedProduct++;
                                }

                            } else {
                                $sError = "Erreur sur la recupération du produit (requette 'getIdProductByName' erreur ou bien produit inconu en base ou bien doublon sur l'ID du produit?)";
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
                    dd($sError);
                }
            }
        }


        // compte le veritable nombre de produit modifiés
        foreach ($aProductName as $product) {
            if (!empty($product)) {
                $iProduct++;
            }
        }

        if ($iProduct === $iCptAddedProduct) {

            // tout vas bien j'init la transaction

            DB::commit();
            echo "Ajout de la recette OK";

        } else {
            DB::rollBack();
            echo "Ajout de la recette KO";

        }
        return redirect()->action('Recipe@recipeList');
    }

    /**
     * @return units
     */
    public function getUnitAjax() {
        $aUnit = Misc::getUnit();
        return json_encode($aUnit);
    }


    /**
     * @return units
     */
    public function getDislikedRecipe($iIdUser) {
        //return \App\Recipe::get
    }

}
