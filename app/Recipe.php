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

    /**
     * Set the name of new recipe
     * @param $sName
     * @return bool
     */
    public static function setRecipeName($sName) {


        $iInsertedRow = DB::table('recipe')->insert(
            ['name' => $sName,
                'status' => 1,
                'created_at' => date("Y-m-d H:i:s"),
                'modified_at' => date("Y-m-d H:i:s"),
                'owner' => 1
            ]
        );
        return $iInsertedRow;
    }


    /**
     * Get id recipe with his name
     * @param $sName
     * @return array
     */
    public static function getRecipeIdByName($sName) {
        $idRecipe = DB::select("SELECT id from recipe where name = '" . $sName . "' ");
        return $idRecipe;
    }

    /**
     * Soft delete a product
     * @param $id
     * @return int
     */
    public static function deleteRecipe($id) {
        $iModifiedRow = DB::update('UPDATE recipe set status = 0, modified_at = "' . date("Y-m-d H:i:s") . '" where id = ' . $id);
        return $iModifiedRow;
    }

    /**
     * Get recipe by ID
     * @param $id
     * @return Model|\Illuminate\Database\Query\Builder|object|null
     */
    public static function getRecipeByID($id) {
        return $aRecipe =  DB::table('recipe')->where('id', $id)->first();
    }

    /**
     * Update recipe
     * @param $aData
     * @return int
     */
    public static function updateRecipe($aData) {

        $iModifiedRow = DB::update('UPDATE recipe set name = "' .  $aData['name'] . '", modified_at = "' . date("Y-m-d H:i:s") . '"   where id = ' . $aData['id']);
        return $iModifiedRow;

    }


}

