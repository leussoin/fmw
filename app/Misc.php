<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\RedirectResponse;
use DB;
use Illuminate\Support\Collection;

class Misc extends Model {
    /**
     * Get all informations about units
     * @return array
     */
    public static function getUnit() {
        $oUnit = DB::table('unit')->get();
        foreach ($oUnit as $key => $unit) {
            $aUnit[$key]['id'] = $unit->id;
            $aUnit[$key]['name'] = $unit->name;
        }
        return $aUnit;
    }


    /**
     * Get id unit with name
     * @param $sName
     * @return array $idUnit
     */
    public static function getIdUnitByName($sName) {
        $idUnit = DB::table('unit')->where('name', '=', $sName)->get();
        //$idUnit = DB::select("SELECT id from unit where name = '" . $sName . "' ");
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
     * @return void $user
     */
    public static function isAuth() {

        $user = session('oUser');
        if ($user == null) {
            header('Location: /');
            exit;
        }
    }

    /**
     * Get all seasons
     * @return Collection
     */
    public static function getSeasons() {
        return DB::table('saisonalite')->get();
    }

    /**
     * Get months for a product
     * @param $id
     * @return array
     */
    public static function getProductMonth($id) {
        return DB::select('SELECT * FROM assoc_saison WHERE id_produit = '. $id);
    }

    /**
     * Set one season for a product
     * @param $id_produit
     * @param $id_season
     * @return bool
     */
    public static function setProductSeason($id_produit, $id_season) {
        return DB::table('assoc_saison')->insert(['id_produit' => $id_produit, 'id_season' => $id_season]);
    }

    /**
     * Delete all months from product
     * @param $id_produit
     * @return int
     */
    public static function deleteProductSeason($id_produit) {
        return DB::delete('DELETE from assoc_saison where id_produit = ' . $id_produit . ' ');
        //return DB::table('assoc_saison')->insert(['id_produit' => $id_produit, 'id_season' => $id_season]);
    }

    /**
     * Log de l'application
     * @param $sMessage
     * @return void
     */
    public static function fmwLogSystem($sMessage) {
        $log  = $sMessage.PHP_EOL;
        file_put_contents('../fmw_log/'.date("d-m-Y").'.log', $log, FILE_APPEND);
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

