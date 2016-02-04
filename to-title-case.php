<?php
/**
 * PHP port of to-title-case ({@link https://github.com/gouch/to-title-case }) javascript function.
 *
 * @copyright 2016 Matthew Miller
 * @license MIT
 *
 * The MIT License (MIT)
 * Copyright (c) 2016 Matthew Miller
 *
 * Permission is hereby granted, free of charge, to any person obtaining a copy of this software and associated documentation files (the "Software"), to deal in the Software without restriction, including without limitation the rights to use, copy, modify, merge, publish, distribute, sublicense, and/or sell copies of the Software, and to permit persons to whom the Software is furnished to do so, subject to the following conditions:
 * The above copyright notice and this permission notice shall be included in all copies or substantial portions of the Software.
 * THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY, FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM, OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN THE SOFTWARE.
 */

/**
 * Convert to title-case.
 *
 * @param string $title The string title to convert.
 *
 * @return string
 */
function to_title_case( $title ) {
	/**
	 * These are words that generally should not be capitalized in the title.
	 */
	$smallWords = '/^(a|an|and|as|at|but|by|en|for|if|in|nor|of|on|or|per|the|to|vs?\.?|via)$/iu';

	return preg_replace_callback('/[A-Za-z0-9\xC0-\xFF]+[^\s-]*/u', function( $matches ) use ( $title, $smallWords ) {
		static $start_at = 0;

		// Find where the match starts in our $title.
		$offset = mb_strpos( $title, $matches[0], $start_at, 'UTF-8' );

		// Move the pointer for the next match.
		$start_at = $offset + mb_strlen( $matches[0],'UTF-8' );

		if ( $offset > 0 && $offset + mb_strlen( $matches[0], 'UTF-8' ) !== mb_strlen( $title, 'UTF-8' )
			&& preg_match( $smallWords, $matches[0] ) && ( $offset - 2 < 0 || mb_substr( $title, $offset - 2, 1 , 'UTF-8' ) !== ':' )
			&& ( mb_substr( $title, $offset + mb_strlen( $matches[0], 'UTF-8' ), 1 ) !== '-'
				|| $offset - 1 < 0 || mb_substr( $title, $offset - 1, 1, 'UTF-8' ) === '-' )
			&& ( $offset - 1 < 0 || ! preg_match( '/[^\s-]/', mb_substr( $title, $offset - 1, 1, 'UTF-8' ) ) ) ) {
			return mb_strtolower( $matches[0], 'UTF-8' );
		}

		if ( preg_match( '/[A-Z]|\../', mb_substr( $matches[0], 1, null, 'UTF-8' ) ) ) {
			return $matches[0];
		}

		return mb_strtoupper( mb_substr( $matches[0], 0, 1, 'UTF-8' ), 'UTF-8' ) . mb_substr( $matches[0], 1, null, 'UTF-8' );
	}, $title);
}
