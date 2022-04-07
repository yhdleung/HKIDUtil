<?php
/**
 * Utility functions for Hong Kong Identity Card (HKID)
 */

class HKIDUtil
{
  /**
   * @param string $id AB987654
   *
   * @return char
   */
  public static function getCheckDigit($id)
  {
    // validate HKID format without the check digit
    if (!preg_match('/^([A-Z]{1,2})([0-9]{6})$/', $id, $matches)){
      return false;
    }
    // calculate check digit
    $starting_chars = str_split($matches[1]);
    $char_digits = array_map(function($x){
      return ord(strtoupper($x))-55;
    }, $starting_chars);
    if(count($starting_chars)==1){
      array_unshift($char_digits,3);
    }
    $digits = array_merge($char_digits, str_split($matches[2]));
    $sum = 0;
    $len = count($digits);
    for($i=0; $i<$len; $i++){
      $sum += $digits[$i] * ($len - $i + 1);
    }
    $remainder = $sum%11; 
    if($remainder === 0) return 0;
    if($remainder === 1) return 'A';
    return (11 - $remainder); 
  }

  /**
   * validate HKID format, with or without parentheses
   * 
   * @param string $id AB987654(3)
   *
   * @return bool
   */
  public static function validateHKID($id)
  {
    if(preg_match('/^([A-Z]{1,2}[0-9]{6})([0-9A]|\([0-9A]\))$/', strtoupper($id), $matches) === 0){
      return false;
    }
    return (self::getCheckDigit($matches[1]) == trim($matches[2], '()'));
  }

  /**
   * generate random HKID
   * 
   * @param bool $hasParentheses 
   *
   * @return string 
   */
  public static function randomHKID($hasParentheses=true)
  {
    $hkid = '';
    $charDigitCount = mt_rand(1,2); 
    for($i=0; $i<$charDigitCount; $i++){
      $hkid .= chr(64+mt_rand(1,26));
    }
    $hkid .= sprintf('%06d', mt_rand(0,999999));
    $checkDigit = self::getCheckDigit($hkid);
    $checkDigit = ($hasParentheses) ? "({$checkDigit})" : $checkDigit;
    return $hkid . $checkDigit;
  }

  /**
   * validate date in dd-mm-yyyy or dd/mm/yyyy
   * 
   * @param string $date 31-12-1969
   *
   * @return bool 
   */
  public static function validateDate($date)
  {
    if(preg_match('/^([0-9]{1,2})(\/|-)([0-9]{1,2})\2([0-9]{4})$/', $date, $m) === 0){
      return false;
    }
    return checkdate($m[3], $m[1], $m[4]);
  }
}