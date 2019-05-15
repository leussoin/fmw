<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use DB;

class RecipeAssoc extends Model {


    protected $fillable = [
        'aName',
        'aQuantity'
    ];

    protected $table = 'recipe_assoc';

    /**
     * Add id' informations into assoc table
     * @param $aProduct
     * @return bool
     */
    public static function addProductForRecipeTableAssoc($aProduct) {

        $idRecipe = $aProduct['id_recipe'];
        $iIdProduct = $aProduct['id_product'];
        $iQuantity = $aProduct['quantity'];
        $idUnit = $aProduct['id_unit'];

        $iInsertedRow = DB::table('recipe_assoc')->insert(
            [
                'id_unit' => $idUnit,
                'product_id' => $iIdProduct,
                'quantity' => $iQuantity,
                'recipe_id' => $idRecipe
            ]
        );
        return $iInsertedRow;
    }

    /**
     * Delete lines into assoc table
     * @param $aData
     * @return false|string
     */
    public static function deleteProductAssocTable($aData) {
        $iDeletedRow = RecipeAssoc::where('recipe_id', $aData['id'])->delete();
        return $iDeletedRow;
    }


    /**
     * Get all product with quantity from an ID recipe
     * @param $id
     * @return false|string
     */
    public static function getRecipeProducts($id) {
        $aProduct = DB::table('recipe_assoc')->where('recipe_id', $id)->get();
        return $aProduct;
    }

}

