<?php
/**
 * Created by PhpStorm.
 * User: oren
 * Date: 08-Feb-17
 * Time: 10:15 AM
 */


/**
 * This is a test function.
 * 
 * @param $param1
 * @param array $param2
 *
 * @return int
 */
function test( $param1, $param2 = array() ) {

	return (int)$param1;
}



/**
 * @param $one
 * @param int $two
 * @param string $three
 */
function foo( $one, $two = 0, $three = "String" ) {
}

