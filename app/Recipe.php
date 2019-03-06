<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use DB;

class Recipe extends Model {


    protected $fillable = [
        'aName',
        'aQuantity'
    ];

    public static function getAllRecipe() {
        $aRecipe = DB::select("SELECT * from recipe");
        return $aRecipe;
    }


    public static function setRecipeName($sName) {

        $iInsertedRow = DB::table('recipe')->insert(
            ['name' => $sName,
                'statuscode' => 1,
                'created_at' => date("Y-m-d H:i:s"),
                'modified_at' => date("Y-m-d H:i:s"),
                'owner' => 1
            ]
        );
        return $iInsertedRow;
    }

    /**
     *
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

    public static function getRecipeIdByName($sName) {
        $idRecipe = DB::select("SELECT id from recipe where name = '" . $sName . "' ");
        return $idRecipe;
    }


    public static function deleteRecipe($id) {
        $iModifiedRow = DB::update('UPDATE recipe set status = 0, modified_at = "' . date("Y-m-d H:i:s") . '" where id = ' . $id);
        return $iModifiedRow;
    }
}

