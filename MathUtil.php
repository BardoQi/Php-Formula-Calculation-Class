<?php

/**
 * This file is part of Bulo framework.
 *
 * Bulo -- Bulo library enterprise extension
 *
 * An open source  framework for PHP 5.4.0 or newer
 *
 *
 * @copyright  Copyright (c)  2010 Bardo QI
 * @author     Bardo QI
 * @link       http://www.Bulo.org
 * @license    http://www.Bulo.org/license.html
 * @version    1.0.1
 * @filesource
 */

namespace Bulo\Library\Std;


/**
 * MathUtil
 * 
 * @package        Bulo
 * @subpackage  Library 
 * @category    Std
 * @author        Bulo Dev Term: Bardo QI
 * @link
 */
class MathUtil
{
	/**
     * Keep the function names
     * @var array $funcName
     */
    private static $funcName=[];

    /**
     * MathUtil::getFuncName()
     *
     * @param $funcName
     * @param $code
     * @return bool
     */
    private static function getFuncName(& $funcName,$code){
        $key=md5($code);
        if (isset(self::$funcName[$key]) && (self::$funcName[$key]==$funcName))
            return true;
        if (function_exists($funcName))
            $funcName = $funcName .strval(count(self::$funcName));
        self::$funcName[$key]=$funcName;
        return false;
    }
    /**
     * MathUtil::parseExpression()
     * Expressions calculation function
     * @param String $expression
     * @param mixed $varibles 
     * @return number
     */
    public static function parseExpression( $expression, $varibles = array() ){
        if ( false === preg_match_all( '/(\w+)/', $expression, $result, PREG_PATTERN_ORDER ) ){
			throw New Exception("expression is not correct!");
            return false;
        }
        $keys = $result[0];
        if ( ! isset( $varibles['true'] ) )
            $varibles['true'] = 1;
        if ( ! isset( $varibles['false'] ) )
            $varibles['false'] = 0;
        $varArray = array();
        $pos = 0;
        foreach ( $keys as $value ){
            if ( ( is_numeric( $value ) ) || ( is_callable( $value ) ) ){
                continue;
            }
            if ( isset( $varibles[$value] ) ){
                $pos = strpos( $expression, $value, $pos );
                $expression = substr_replace( $expression, '$', $pos, 0 );
                $pos += strlen( $value ) + 1;
                $varArray[$value] = $varibles[$value];
            }else{
                return false;
            }
        }
        $cal = self::createRefFunction('evalExp','$varArray', 'extract($varArray); return ' . $expression .';' );
        $ret= @$cal( $varArray );
        if ((false==$ret)||(INF==$ret)){
        	throw new Exception('Division by zero.');
        }
		return $ret;
    }

    /**
     * MathUtil::create_ref_function()
     *
     * @param string $funcName
     * @param string $args
     * @param string $code
     * @param int $is_ref //if return refrence
     * @return string
     */
    public static function createRefFunction($funcName, $args, $code, $is_ref=0){
        if(true===self::getFuncName($funcName,$code))
            return $funcName;
        $ref=($is_ref==0)?'':'&';  //if return refrence
        $declaration = sprintf('function '.$ref.'%s(%s) {%s}',$funcName,$args,$code);
        eval($declaration);
        return $funcName;
    }
}
