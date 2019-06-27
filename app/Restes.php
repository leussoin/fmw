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
class Restes extends Controller
{

    /**
     * Get 'restes' view
     *
     * @return Response
     */
    public function welcomeGet()
    {
        return view('restes');
    }

    /**
     * Manage 'restes' treatement
     *
     * @param Request $request
     * @return Response
     */
    public function welcomePost(Request $request)
    {
        $sInput = $request->all();
        $bError = false;
        $aNameRecipeList = array();
        $aProduct = explode(",", $sInput['products']);

        // supprimer quand j'aaurai remplacé par la div
        foreach ($aProduct as $sProduct) {
            if (Validator::isValidStr($sProduct) == false) {
                echo "Il y à des caractéres spéciaux";
                $bError = true;
            }
        }



        // supprimer la condition quand j'aurai remplacé par la div
        if ($bError == false) {
            $sQuery = 'SELECT * from recipe_assoc where product_id in (';

            foreach ($aProduct as $sProduct) {
                $iIdproduct = \App\Product::getIdProductByName($sProduct);
                if ($iIdproduct) {
                    $sQuery .= $iIdproduct[0]->id . ',';
                }
            }
            $sQuery = rtrim($sQuery,',');
            $sQuery .= ')';

            $aListIdRecipe = \App\Recipe::getRecipeByProductId($sQuery);
        }

        if ($aListIdRecipe) {
            foreach ($aListIdRecipe as $iIdRecipe) {
                $aListRecipe[] = \App\Recipe::getRecipeByID($iIdRecipe->recipe_id);
            }
        }

        foreach ($aListRecipe as $oRecipe) {
            $aNameRecipeList[$oRecipe->id] = $oRecipe->name;
        }

        var_dump($aNameRecipeList);


        return view('restes', ['aNameRecipeList' => $aNameRecipeList, ]);
    }


}