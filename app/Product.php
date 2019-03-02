<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use DB;

class Product extends Model {


    protected $fillable = [
        'aName',
        'aQuantity'
    ];

    /**
     * Get all active product
     * @return array
     */
    public static function getAllProduct() {
        $aProduit = DB::select("SELECT * from product where status = 1");
        return $aProduit;
    }

    public static function getProductById($id) {
        $aProduct = DB::select("SELECT * from product where id = " . $id);
        return $aProduct;
    }

    public static function addProduct($iCal, $iName, $iPrice) {

        $iInsertedRow = DB::insert('insert into product (cal, name, price, status, created_at, modified_at) values(?,?,?,?,?,?)',
            [$iCal, $iName, $iPrice, 1, date("Y-m-d H:i:s"), date("Y-m-d H:i:s")]);
        return $iInsertedRow;

    }

    public static function updateProduct($sName, $fPrice, $iCal, $id) {
        $iModifiedRow = DB::update('UPDATE product set name = "' . $sName . '", price =' . $fPrice . ', cal = ' . $iCal . ', modified_at = "' . date("Y-m-d H:i:s") . '"   where id = ' . $id);
        return $iModifiedRow;

    }

    public static function deleteProduct($id) {
        $iModifiedRow = DB::update('UPDATE product set status = 0, modified_at = "' . date("Y-m-d H:i:s") . '" where id = ' . $id);
        return $iModifiedRow;
    }

    public static function ajax_get_produit(Request $request) {
        $data = produit::select("nom_produit")
            ->where("nom_produit", "LIKE", "%{$request->input('query')}%")
            ->get();
        return response()->json($data);
    }


}

