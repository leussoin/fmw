<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use DB;

class Product extends Model {


    protected $fillable = [
        'aName',
        'aQuantity'
    ];

    protected $table = 'product';


    /**
     * Get all active product
     * @return array
     */
    public static function getAllProduct() {
        $aProduit = DB::select("SELECT * from product where status = 1");
        return $aProduit;
    }

    /**
     * Get a single product by his id
     * @param $id
     * @return array
     */
    public static function getProductById($id) {
        $aProduct = DB::select("SELECT * from product where id = " . $id);
        return $aProduct;
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
        $iModifiedRow = DB::update('UPDATE product set name = "' . $sName . '", price =' . $fPrice . ', cal = ' . $iCal . ', modified_at = "' . date("Y-m-d H:i:s") . '"   where id = ' . $id);
        return $iModifiedRow;
    }


    /**
     * Soft delete a product
     * @param $id
     * @return bool
     */
    public static function deleteProduct($id) {
        $iModifiedRow = DB::update('UPDATE product set status = 0, modified_at = "' . date("Y-m-d H:i:s") . '" where id = ' . $id);
        return $iModifiedRow;
    }


    /**
     * Get product with partial name
     * @param Request $request
     * @return bool
     */
    public static function getProductByPartialNameAjax(Request $request) {
        $data = DB::select("nom_produit")
            ->where("nom_produit", "LIKE", "%{$request->input('query')}%")
            ->get();
        return response()->json($data);
    }


    /**
     * Get id product with his name
     * @param $sProduct
     * @return \Illuminate\Support\Collection
     */
    public static function getIdProductByName($sProduct) {
        $aProduct = DB::table('product')->where('name', "=", $sProduct)->get();
        return $aProduct;
    }

    /**
     * Get product by ID recipe
     * @param $id
     * @return \Illuminate\Support\Collection
     */
    public static function getProductByIdRecipe($id) {

        return DB::Table('recipe_assoc')->select('*')->where('recipe_id', $id)->get();
    }


}

