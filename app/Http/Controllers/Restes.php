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
 * @package App\Http\Controfllers
 */
class Restes extends Controller {

    /**
     * Get 'restes' view
     *
     * @return Response
     */
    public function welcomeGet() {
        return view('restes');
    }

    /**
     * Manage 'restes' treatement
     *
     * @param Request $request
     * @return Response
     */
    public function welcomePost(Request $request) {
        $sInput = $request->all();
        $aNameRecipeList = array();
        $aProduct = explode(";", $sInput['products']);
        $aRecipe = array();

        $sQuery = 'SELECT * from recipe_assoc where product_id in (';

        foreach ($aProduct as $sProduct) {

            $iIdproduct = \App\Product::getIdProductByName($sProduct);

            if (!empty($iIdproduct[0]->id)) {
                $sQuery .= $iIdproduct[0]->id . ',';
            }
        }
        $sQuery = rtrim($sQuery, ',');
        $sQuery .= ')';

        // 49 = le nombre de de caractéres requete vide
        if (strlen($sQuery) > 49) {
            $aListIdRecipe = \App\Recipe::getRecipeByProductId($sQuery);
        }

        if (!empty($aListIdRecipe)) {

            foreach ($aListIdRecipe as $iIdRecipe) {
                $aListRecipe[] = \App\Recipe::getRecipeByID($iIdRecipe->recipe_id);
            }

            foreach ($aListRecipe as $oRecipe) {
                $aRecipe[$oRecipe->id] = $oRecipe->name;
            }
        }

        return view('restes', ['aRecipe' => $aRecipe,]);
    }


}