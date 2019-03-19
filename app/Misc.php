<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
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
        $idUnit = DB::select("SELECT id from unit where name = '".$sName."' ");
        return $idUnit;
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

