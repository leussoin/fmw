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
        $aUnit = DB::select("SELECT * from unit");
        return $aUnit;
    }

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

