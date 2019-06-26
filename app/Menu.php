<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use DB;

class Menu extends Model {

    protected $table = 'menu';
    public $fillable = ['id_user', 'id_recipe', 'date', 'midi', 'convive'];

    public static function delMenu($date, $id_user, $bIsMidi) {

        $a = DB::delete('DELETE from menu where
                id_user = ' . $id_user . ' 
                and date = "' . $date . '"
                and midi = ' . $bIsMidi . '                    
                ');

        return $a;
    }


    /**
     * Add a product
     * @param $date
     * @param $id_recipe
     * @param $id_user
     * @param $bIsMidi
     * @param $convives
     * @return bool
     */
    public static function addMenu($date, $id_recipe, $id_user, $bIsMidi, $convives = null) {

        return DB::table('menu')->insertGetId([
            'date' => $date,
            'id_recipe' => $id_recipe,
            'id_user' => $id_user,
            'convives' => $convives,
            'created_at' => date('d-m-Y h:m'),

            'midi' => $bIsMidi
        ]);


    }


    /**
     * Get the 14 users recipe
     * @param $date
     * @param $id_user
     * @return array
     */
    public static function getMenu($date, $id_user) {

        return DB::select("SELECT * from menu where date = '" . $date . "' and id_user = '" . $id_user . "' ");

    }

}

