<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\RedirectResponse;
use DB;

class Misc extends Model {
    /**
     * Get all informations about units
     * @return array
     */
    public static function getUnit() {
        $oUnit = DB::select("SELECT * from unit");
        $aUnit = array();
        foreach ($oUnit as $key => $unit) {
            $aUnit[$key]['id'] = $unit->id;
            $aUnit[$key]['name'] = $unit->name;
        }
        return $aUnit;
    }


    /**
     * Get all informations about units to recreate dynamics inputs
     * @return array
     */
    /*public static function getUnitAjax() {
        $oUnit = DB::select("SELECT * from unit");
        $aUnit = array();
        foreach ($oUnit as $key => $unit) {
            $aUnit[$key]['id'] = $unit->id;
            $aUnit[$key]['name'] = $unit->name;
        }
        return json_encode($aUnit);
    }*/

    /**
     * Get id unit with name
     * @param $sName
     * @return array $idUnit
     */
    public static function getIdUnitByName($sName) {
        $idUnit = DB::select("SELECT id from unit where name = '" . $sName . "' ");
        return $idUnit;
    }

    /**
     * Get user by name and password input
     * @param $aData
     * @return array $user
     */
    public static function getUserByNameAndPass($aData) {
        return DB::select("SELECT * from user where name = '" . $aData['name'] . "' and passwd = '" . $aData['password'] . "' ");

    }

    /**
     * Check if user is authenticated
     * @return array $user
     */
    public static function isAuth() {

        $user = session('oUser');
        if ($user == null) {
            header('Location: /');
        }
    }


    /**
     * This function is called to init query transaction
     */
    public static function setInitTransaction() {
        DB::beginTransaction();
    }

    /**
     * This function is called to finalize transaction
     */
    public static function setCommitTransaction() {
        DB::commit();
    }

    /**
     * This function is called to cancel transaction
     */
    public static function setRollbackTransaction() {
        DB::rollBack();
    }

}

