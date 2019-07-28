<?php


namespace App\Http\Controllers;


use App\Misc;

class Shopping {

    public function shoppingListGet() {
        $oUser = session('oUser');
        $sCurrentDate = session('sDate');
        $aProductList = array();
        $oWelcome = new welcome();
        $aRecipeList = $oWelcome->getWeeklyRecipe($oUser, $sCurrentDate);
        $aListeDeProduit = array();
        $aUnit = array();

        $aRecipe = array_merge($aRecipeList['midi'], $aRecipeList['soir']);

        var_dump($aRecipe);

        // Tableau listant l'intégralitgé des produits et leur quantité
        foreach ($aRecipe as $key => $sRecipe) {
            $oRecipe = \App\Recipe::getRecipeIdByName($sRecipe);
            // pour chaque recette je veux la liste des produits
            $cAssocRecipe = \App\Product::getProductByIdRecipe($oRecipe->id);

            // pour chaque produit composant une recette...
            foreach ($cAssocRecipe as $k => $mValues) {

                // je veux la liste des produit
                $oProduct = \App\Product::getProductById($mValues->product_id);
                // index = produit => valeur = tableau de quantité
                $aProductList[$oProduct->name][] = $mValues->quantity;
            }
        }

        // somme des produits par ingrédient
        foreach ($aProductList as $product => $quantity) {


            $sUnit = Misc::getNameUnitById($mValues->id_unit);
            $aUnit[] = $sUnit->name;

            $fQuantity = 0;
            foreach ($quantity as $qte) {
                $fQuantity += $qte;
            }
            $aListeDeProduit[$product] = $fQuantity;
        }

        return view('shopping', ['aListeDeProduit' => $aListeDeProduit, 'aUnit' => $aUnit]);
    }
}