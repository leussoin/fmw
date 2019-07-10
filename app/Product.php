<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use DB;
use Illuminate\Database\Query\Builder;
use Illuminate\Support\Collection;

class Product extends Model {

    protected $fillable = [
        'aName',
        'aQuantity'
    ];

    protected $table = 'product';
    public $timestamps = false;


    /**
     * Get all active product
     * @return Collection
     */
    public static function getAllProduct() {
        return DB::table('product')->where('status', '=', 1)->get();
    }

    /**
     * Get a single product by his id
     * @param $id
     * @return Model|Builder|object|null
     */
    public static function getProductById($id) {
        return DB::table('product')->where('id', '=', $id)->first();
    }

    /**
     * Add a product
     * @param $iCal
     * @param $iName
     * @param $iPrice
     * @return bool
     */
    public static function addProduct($iCal, $iName, $iPrice) {

        //$iInsertedRow = DB::insert('insert into product (cal, name, price, status, created_at, modified_at) values(?,?,?,?,?,?)', [$iCal, $iName, $iPrice, 1, date("Y-m-d H:i:s"), date("Y-m-d H:i:s")]);
        $IdInsertedRow = DB::table('product')->insertGetId([
            'cal' => $iCal,
            'name' => $iName,
            'price' => $iPrice,
            'status' => 1,
            'created_at' => date("Y-m-d H:i:s"),
            'modified_at' => date("Y-m-d H:i:s")
        ]);
        return $IdInsertedRow;
    }


    /**
     * update a product
     * @param $sName
     * @param $fPrice
     * @param $iCal
     * @param $id
     * @return bool
     */
    public static function updateProduct($sName, $fPrice, $iCal, $id) {
        return DB::table('product')->where('id', '=', $id)->update(['cal' => $iCal, 'name'=>$sName, 'price'=>$fPrice, 'modified_at' => date("Y-m-d H:i:s"), 'status' => 1 ]);
    }


    /**
     * Soft delete a product
     * @param $id
     * @return bool
     */
    public static function deleteProduct($id) {
        return DB::table('product')->where('id', '=', $id)->update(['status' => 0]);

    }


    /**
     * Get product with partial name
     * @param $term
     * @return Collection
     */
    public static function getProductByPartialNameAjax($term) {
        return DB::table('product')->where('name', 'like', '%'.$term.'%')->get();
    }


    /**
     * Get id product with his name
     * @param $sProduct
     * @return Collection
     */
    public static function getIdProductByName($sProduct) {
        return DB::table('product')->where('name', "=", $sProduct)->get();

    }

    /**
     * Get product by ID recipe
     * @param $id
     * @return Collection
     */
    public static function getProductByIdRecipe($id) {
        return DB::Table('recipe_assoc')->select('*')->where('recipe_id', $id)->get();
    }

}

