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
 * @version    1.0
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
     * MathUtil::parseExpression()
     * Expressions calculation function
     * @param String $expression
     * @param mixed $varibles 
     * @return
     */
    public static function parseExpression( $expression, $varibles = array() )
    {
        if ( false === preg_match_all( '/(\w+)/', $expression, $result, PREG_PATTERN_ORDER ) )
        {
            trigger_error( "expression is not correct!", E_USER_ERROR );
            return false;
        }
        $keys = $result[0];
        if ( ! isset( $varibles['true'] ) )
            $varibles['true'] = 1;
        if ( ! isset( $varibles['false'] ) )
            $varibles['false'] = 0;
        $varArray = array();
        $pos = 0;
        foreach ( $keys as $value )
        {
            if ( ( is_numeric( $value ) ) || ( is_callable( $value ) ) )
            {
                continue;
            }
            if ( isset( $varibles[$value] ) )
            {
                $pos = strpos( $expression, $value, $i );
                $expression = substr_replace( $expression, '$', $pos, 0 );
                $pos += strlen( $value ) + 1;
                $varArray[$value] = $varibles[$value];
            }
        }
        $cal = create_function( '$varArray', 'extract($varArray); return ' . "$expression" .';' );
        return $cal( $varArray );
    }
}
