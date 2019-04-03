<?php

namespace Wiebenieuwenhuis;

Class IntEncoder {

	const codeset = "0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ";
	const readable_codeset = "23456789abcdefghijkmnopqrstuvwxyzABCDEFGHIJKLMNPQRSTUVWXYZ";

	/**
	 * @param int $number
	 * @param bool $numeric
	 *
	 * @return string
	 */
	public static function encode( $number, $readable = false ) {
		$set       = $readable ? self::readable_codeset : self::codeset;
		$base      = strlen( $set );
		$converted = '';

		while ( $number > 0 ) {
			$converted = substr( $set, bcmod( $number, $base ), 1 ) . $converted;
			$number    = self::bcFloor( bcdiv( $number, $base ) );
		}

		return $converted;
	}

	/**
	 * @param int $number
	 * @param bool $numeric
	 *
	 * @return string
	 */
	public static function decode( $number, $readable = false ) {
		$set  = $readable ? self::readable_codeset : self::codeset;
		$base = strlen( $set );

		$converted = '0';
		for ( $i = strlen( $number ); $i; $i -- ) {
			$converted = bcadd( $converted, bcmul( strpos( $set, substr( $number, ( - 1 * ( $i - strlen( $number ) ) ), 1 ) ), bcpow( $base, $i - 1 ) ) );
		}

		return bcmul( $converted, 1, 0 );
	}

	/**
	 * @param $x
	 *
	 * @return string
	 */
	static private function bcFloor( $x ) {
		return bcmul( $x, '1', 0 );
	}

}
