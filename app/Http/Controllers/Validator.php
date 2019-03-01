<?php
/**
 * Created by PhpStorm.
 * User: Fixe
 * Date: 28/02/2019
 * Time: 08:17
 */

namespace App\Http\Controllers;


/**
 * Format validator
 *
 * <pre>
 * False/True cheat sheet
 *
 * if ("false" == true) echo "true\n";
 * // => true
 *
 * if ("false" == false) echo "true\n";
 * // => false
 *
 * if ("false" == 0) echo "true\n";
 * // => true, wtf
 *
 * if (false == 0) echo "true\n";
 * // => true, as expected
 *
 * if ((string)"false" === (int)0) echo "true\n";
 * // => false
 *
 * if ("0" === 0) echo "true\n";
 * // => false
 *
 * if ("false" === false) echo "true\n";
 * // => false
 *
 * if ((int)"0" === 0) echo "true\n";
 * // => true, with type coercion
 * </pre>
 *
 */
class Validator {


    /**
     * Check date
     *
     * @author Marc Schuffenecker <mschuffenecker@nsi.admr.org>
     * @version 6.4
     * @since 5.0.0
     * @access public
     * @param array|string $mDate
     * @param boolean|string $sIndex
     * @return boolean
     */
    public static function isValidDate($mDate, $sIndex = false) {

        $bResult = false;

        if (is_array($mDate) && $sIndex !== false) {

            $sDate = isset($mDate[$sIndex]) ? $mDate[$sIndex] : false;
        } else {

            $sDate = $mDate;
        }

        if (isset($sDate) && !empty($sDate)) {

            $aDate = explode("-", $sDate);

            if (count($aDate) == 3) {

                list($yy, $mm, $dd) = $aDate;

                if (is_numeric($yy) && is_numeric($mm) && is_numeric($dd)) {

                    $bResult = checkdate($mm, $dd, $yy);
                }
            }
        }

        return $bResult;
    }

    /**
     * Check if value is a boolean. Value might be in an array['index'] = value
     *
     * @author Marc Schuffenecker <mschuffenecker@nsi.admr.org>
     * @version 6.4
     * @since 6.0.5
     * @access public
     * @param array|string $mData
     * @param boolean|string $sIndex
     * @return boolean
     */
    public static function isValidBool($mData, $sIndex = false) {

        $mVal = (is_array($mData) ? (isset($mData[$sIndex]) ? $mData[$sIndex] : null) : $mData);
        $bResult = (is_bool($mVal) ? true : false);

        return $bResult;
    }

    /**
     * Check dateTime
     *
     * @author Marc Schuffenecker <mschuffenecker@nsi.admr.org>
     * @version 6.4
     * @since 5.0.0
     * @access public
     * @param array|string $mDateTime
     * @param boolean|string $sIndex
     * @return boolean
     */
    public static function isValidDateTime($mDateTime, $sIndex = false) {

        if (is_array($mDateTime) && $sIndex !== false) {

            $sDateTime = isset($mDateTime[$sIndex]) ? $mDateTime[$sIndex] : false;
        } else {

            $sDateTime = $mDateTime;
        }

        return (\DateTime::createFromFormat('Y-m-d H:i:s', $sDateTime) !== false);
    }

    /**
     * Check if valid numeric
     *
     * @author Marc Schuffenecker <mschuffenecker@nsi.admr.org>
     * @version 6.4
     * @since 5.0.0
     * @access public
     * @param array|int $mData Value to test, may be an array
     * @param boolean $bNotZero If true, value has to be > 0
     * @param bool $sInd²ex Index of (array) $mData
     * @param mixed $mValue Value to compare with
     * @return boolean
     */
    public static function isValidInt($mData, $bNotZero = true, $sIndex = false, $mValue = false) {

        $bResult = false;

        // Value could not be zero
        if ($bNotZero === true) {

            $iNumeric = (is_array($mData) ? (isset($mData[$sIndex]) && !empty($mData[$sIndex]) ? $mData[$sIndex] : false) : $mData);

            // If value to test is numeric and > 0
            if (!empty($iNumeric) && is_numeric($iNumeric)) {

                // If value to compare with is function parameter
                if ($mValue !== false) {

                    // If value to test equals value to compare with
                    if ($mValue == $iNumeric) {

                        $bResult = true;
                    } else {
                    }
                } else {

                    $bResult = true;
                }
            }
        } else {
            $iNumeric = (is_array($mData) ? (isset($mData[$sIndex]) ? $mData[$sIndex] : false) : $mData);

            // If value to test is numeric
            if (is_numeric($iNumeric)) {

                // If value to compare with is function parameter
                if ($mValue !== false) {

                    // If value to test equals value to compare with
                    if ($mValue == $iNumeric) {

                        $bResult = true;
                    } else {
                    }
                } else {

                    $bResult = true;
                }
            } else {
            }
        }

        return $bResult;
    }

    /**
     * Check if valid string
     *
     * @author Marc Schuffenecker <mschuffenecker@nsi.admr.org>
     * @version 6.4
     * @since 5.0.0
     * @access public
     * @param string|array $mStr Value to test
     * @param boolean $bStrict If true, check type with, is_string()
     * @param string $sIndex Index of (array) $mStr
     * @return boolean
     */
    public static function isValidStr($mStr, $bStrict = false, $sIndex = false) {

        $bResult = false;
        $sStr = (is_array($mStr) ? (isset($mStr[$sIndex]) && !empty($mStr[$sIndex]) ? $mStr[$sIndex] : false) : $mStr);

        if (isset($sStr) && !empty($sStr)) {

            $bResult = $bStrict === true ? is_string($sStr) : true;
        }

        return $bResult;
    }

    /**
     * Check if a string contains valid integer for SQL querying
     *
     * @author Matthieu Leroy <mleroy@nsi.admr.org>
     * @author Marc Schuffenecker <mschuffenecker@nsi.admr.org>
     * @version 6.4
     * @since 6.0.0
     * @access public
     * @param array|string $mData Value to test
     * @param boolean $bNotZero If true, value has to be > 0
     * @param string|boolean $sIndex Index of (array) $mData
     * @return boolean
     */
    public static function isValidInStr($mData, $bNotZero = true, $sIndex = false) {

        $bResult = false;
        $bFlag = true;
        if (is_array($mData)) {
            if ($sIndex !== false && isset($mData[$sIndex]) && !empty($mData[$sIndex])) {
                $sString = $mData[$sIndex];
            } else {
                $bFlag = false;
            }
        } else {
            $sString = $mData;
        }

        if ($bFlag !== false) {
            $mStr = str_replace(' ', '', $sString);

            if (self::isValidInt($mStr, $bNotZero, $sIndex)) {
                $bResult = true;
            } elseif (strpos($mStr, ',') !== false) {

                // String contains at least one comma
                $bResult = true;

                // Explode string, supposedly integers separated by commas
                $aData = explode(',', $mStr);

                // Check each
                foreach ($aData as $mInteger) {
                    $bResult &= self::isValidInt($mInteger);
                }
            }
        }
        return $bResult;
    }

    /**
     * Check if a string is a valid json string
     *
     * @author Maxime Bergeon <mbergeon@nsi.admr.org>
     * @version 6.4
     * @since 6.0.0
     * @access public
     * @param mixed $mStr [array of] string to check against
     * @param mixed $sIndex Index of (array) $mStr if provided
     * @return boolean true if the strng is a valid json string, false otherwise
     */
    public static function isValidJSON($mStr, $sIndex = false) {
        $bFlag = true;
        $bResult = false;

        if (is_array($mStr)) {
            if ($sIndex !== false && isset($mStr[$sIndex]) && !empty($mStr[$sIndex])) {
                $sString = $mStr[$sIndex];
            } else {
                $bFlag = false;
            }
        } else {
            $sString = $mStr;
        }

        if ($bFlag !== false) {
            $bResult = is_string($sString) && is_array(json_decode($sString, true)) && (json_last_error() == JSON_ERROR_NONE);
        }

        return $bResult;
    }

    /**
     * Check if a string is a valid NNI
     *
     * @author Maxime Bergeon <mbergeon@nsi.admr.org>
     * @version 6.4
     * @since 6.0.0
     * @access public
     * @param mixed $mStr [array of] string to check against
     * @param mixed $sIndex Index of (array) $mStr if provided
     * @return boolean true if the string is a valid NNI string, false otherwise
     */
    public static function isValidNNI($mStr, $sIndex = false) {

        $bFlag = true;
        $bResult = false;

        if (is_array($mStr)) {
            if ($sIndex !== false && isset($mStr[$sIndex]) && !empty($mStr[$sIndex])) {
                $sString = $mStr[$sIndex];
            } else {
                $bFlag = false;
            }
        } else {
            $sString = $mStr;
        }

        if ($bFlag !== false) {
            $bResult = (preg_match("#^([1-3])[\s\.\-]?([0-9]{2})[\s\.\-]?(0[0-9]|[2-35-9][0-9]|[14][0-2])[\s\.\-]?(0[1-9]|[1-8][0-9]|9[0-57-9]|2[ab])[\s\.\-]?(00[1-9]|0[1-9][0-9]|[1-8][0-9]{2}|9[0-8][0-9]|990)[\s\.\-]?([0-9]{3})[\s\.\-]?([0-8][0-9]|9[0-7])$#i", $sString) == true);
        }

        return $bResult;
    }
}
