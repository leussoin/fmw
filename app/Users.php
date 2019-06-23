<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use DB;

class Users extends Model
{

    protected $table = 'user_preferences';

    public static function getPreferences($iIdUser) {
        return DB::table('user_preferences')->where('id_user', $iIdUser)->get();
    }


    public static function deleteUserData($iIdUser) {
        return Users::where('id_user', $iIdUser)->delete();

    }

    public static function addUserData($iIdUser, $iIdProduct) {
        //return DB::table('user_preferences')->where('id_user', $iIdUser)->get();

        return DB::table('user_preferences')->insert(
            [
                'product_disliked' => $iIdProduct,
                'id_user' => $iIdUser
            ]
        );
    }

    public static function getAssocProduct($iIdUser, $iIdProduct) {
        return DB::table('user_preferences')->where('id_user', $iIdUser)->where('product_liked', $iIdProduct)->get();
    }

    public static function updatePassword($iIdUser, $sPassword) {
        return DB::update('UPDATE user set passwd = "' . $sPassword . '"  where id = ' . $iIdUser);
    }

    public static function updateUserGenre($iIdUser, $sgenre) {
        return DB::update('UPDATE user set genre = "' . $sgenre . '"  where id = ' . $iIdUser);
    }

    public static function updateUserWill($iIdUser, $iIdWill) {
        return DB::update('UPDATE user set will = ' . $iIdWill . '  where id =  "' . $iIdUser . '" ');
    }

}

