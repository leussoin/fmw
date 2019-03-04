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


    public static function addRecipe($sName) {
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


    public static function addProductForRecipe($aData) {
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








}

