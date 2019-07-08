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

        return DB::table('recipe_assoc')->insert(
            [
                'id_unit' => $aProduct['id_unit'],
                'product_id' => $aProduct['id_product'],
                'quantity' => $aProduct['quantity'],
                'recipe_id' => $aProduct['id_recipe']
            ]
        );
    }

    /**
     * Delete lines into assoc table
     * @param $aData
     * @return false|string
     */
    public static function deleteProductAssocTable($aData) {
        return RecipeAssoc::where('recipe_id', $aData['id'])->delete();
    }


    /**
     * Get all product with quantity from an ID recipe
     * @param $id
     * @return false|string
     */
    public static function getRecipeProducts($id) {
        return DB::table('recipe_assoc')->where('recipe_id', $id)->get();
    }

}

