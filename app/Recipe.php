<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use DB;
use Illuminate\Database\Query\Builder;
use Illuminate\Support\Collection;

class Recipe extends Model {


    protected $fillable = [
        'aName',
        'aQuantity'
    ];

    /**
     * Select recipes
     * @param null $iPrice
     * @return array
     */
    public static function getAllRecipe($iPrice = null) {

        if (!empty($iPrice)) {
            if ($iPrice == 1) {
                $aRecipe = DB::select("SELECT * from recipe where price = 1 ");
            } elseif ($iPrice == 2) {
                $aRecipe = DB::select("SELECT * from recipe where price in (1,2)");
            } elseif ($iPrice == 3) {
                $aRecipe = DB::select("SELECT * from recipe where price in (1,2,3) ");
            }
        } else {
            $aRecipe = DB::select("SELECT * from recipe");
        }
        return $aRecipe;
    }

    /**
     * Set the name and cooking recipe of new recipe
     * @param $sName
     * @param $iPrice
     * @param $sCookingRecipe
     * @return bool
     */
    public static function setRecipeData($sName, $iPrice, $sCookingRecipe = null) {
        $iInsertedRow = DB::table('recipe')->insert(
            [
                'name' => $sName,
                'cooking_recipe' => $sCookingRecipe,
                'statuscode' => 1,
                'price' => $iPrice,
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
        return DB::table('recipe')->where('name', "=", $sName)->first();
        //$idRecipe = DB::select("SELECT id from recipe where name = '" . $sName . "' ");
    }

    /**
     * Soft delete a product
     * @param $id
     * @return int
     */
    public static function deleteRecipe($id) {
        $iModifiedRow = DB::update('UPDATE recipe set statuscode = 0, modified_at = "' . date("Y-m-d H:i:s") . '" where id = ' . $id);
        var_dump($iModifiedRow);
        return $iModifiedRow;
    }

    /**
     * Get recipe by ID
     * @param $id
     * @return Model|Builder|object|null
     */
    public static function getRecipeByID($id) {
        return $aRecipe = DB::table('recipe')->where('id', $id)->first();
    }

    /**
     * Update recipe name
     * @param $aData
     * @return int
     */
    public static function updateRecipeData($aData) {

        $iModifiedRow = DB::update('UPDATE recipe set 
            name = "' . $aData['name'] . '", 
            cooking_recipe = "' . $aData['cooking_recipe'] . '", 
            price = "'.$aData['iAveragePrice'].'",
            modified_at = "' . date("Y-m-d H:i:s") . '"   
            where id = ' . $aData['id']);
        return $iModifiedRow;
    }

    /**
     * Get full information about a product
     * @param $aData
     * @return Collection
     */
    public static function getRecipeAndProduct($aData) {

        $oRecipeProduct = DB::table('recipe')
            ->join('recipe_assoc', 'recipe_assoc.recipe_id', '=', 'recipe.id')
            ->join('product', 'recipe_assoc.product_id', '=', 'product.id')
            ->join('unit', 'recipe_assoc.product_id', '=', 'product.id')
            //->join('product', 'recipe_assoc.id_unit', '=', 'unit.id')
            ->join('user', 'recipe.owner', '=', 'user.id')
            ->where('recipe.id', '=', $aData)
            ->select(
                'product.name as ProductName',
                'cal',
                'product',
                'status as ProductStatus',
                'product.created_at as ProductCreateDate',
                'product.modified_at as ProductModifDate',
                'price,recipe.id as RecipeId',
                'recipe.name as RecipeName',
                'recipe.status as RecipeStatus',
                'recipe.created_at as ProductCreateDate',
                'recipe.modified_at as ProductModifDate',
                'quantity',
                'user.name as UserName')
            ->get();

        return $oRecipeProduct;

    }

    /**
     * Get recipe name for autocomplete
     * @param $name
     * @return Collection
     */
    public static function getRecipeByPartialName($name) {
        return DB::table('recipe')->select('name')->where('name', 'LIKE', "%{$name}%")->get();
    }

    /**
     * Get all recipe who contains one or secveral ID product
     * @param $sQuery
     * @return array
     */
    public static function getRecipeByProductId($sQuery) {
        return DB::select($sQuery);
    }

    /**
     * Get all recipe who contains juste one disliked product
     * @param $iIdProduct
     * @return Builder
     */
    public static function getRecipeByOnceProductId($iIdProduct) {
        return DB::table('recipe_assoc')->select('recipe_id')->where('product_id', '=', $iIdProduct)->get();
    }


}

