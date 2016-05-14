<?php
/**
 * The Mi11er Library
 *
 * @package    Mi11er\Library
 * @copyright 2016 Matthew Miller
 * @license MIT
 *
 * The MIT License (MIT)
 * Copyright (c) 2016 Matthew Miller
 *
 * Permission is hereby granted, free of charge, to any person obtaining a
 * copy of this software and associated documentation files (the "Software"),
 * to deal in the Software without restriction, including without limitation
 * the rights to use, copy, modify, merge, publish, distribute, sublicense,
 * and/or sell copies of the Software, and to permit persons to whom the
 * Software is furnished to do so, subject to the following conditions:
 * The above copyright notice and this permission notice shall be included
 * in all copies or substantial portions of the Software.
 *
 * THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR
 * IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY,
 * FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE
 * AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER
 * LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING
 * FROM, OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER
 * DEALINGS IN THE SOFTWARE.
 */

namespace Mi11er\Library\Text\Formatters;

/**
 * PHP port of to-title-case ({@link https://github.com/gouch/to-title-case }) javascript function.
 * See also:{@link http://camendesign.com/code/title-case}
 */
class TitleCaseFormatter
{
    /**
     * These are words that generally should not be capitalized in the title.
     */
    private $smallWords = '/^(a|an|and|as|at|but|by|en|for|if|in|nor|of|on|or|per|the|to|vs?\.?|via)$/iu';
    
    /**
     * Regex to remove basic HTML from the $title string
     */
    private $elements   = '/<(code|var)[^>]*>.*?<\/\1>|<[^>]+>|&\S+;/';
    
    /**
     * Holds the working title string
     */
    private $title;
    
    /**
     * Holds the html we stripped from the $title
     */
    private $foundElements;
    
    /**
     * Track where we are in the $title string
     */
    private $offset;

    /**
     * Convert to title-case.
     *
     * @param string $title The string title to convert.
     *
     * @return string
     */
    public function format($title)
    {
        $this->reset();

        $this->title = $title;

        $this->removeHtml();

        $this->title = preg_replace_callback('/[A-Za-z0-9\xC0-\xFF]+[^\s-]*/u', [$this,'callback'], $this->title);

        $this->restoreHtml();

        return $this->title;
    }

    /**
     * Private Helper Functions
     */

    /**
     * Clears the working vars
     */
    private function reset()
    {
        $this->foundElements = [];
        $this->offset        = 0;
    }
    
    /**
     * Remove HTML like tags and entities
     */
    private function removeHtml()
    {
        preg_match_all($this->elements, $this->title, $this->foundElements, PREG_OFFSET_CAPTURE);
        $this->title = preg_replace($this->elements, '', $this->title);
    }
    
    /**
     * Try to put the HTML tags and entities back where they belong
     */
    private function restoreHtml()
    {
        foreach ($this->foundElements[0] as $element) {
            $this->title = substr_replace($this->title, $element[0], $element[1], 0);
        }
    }

    /**
     * Find and return the current offset then advance the
     * offset for next itteration.
     */
    private function getNextOffset($match)
    {
        // Find where the match starts in our $title.
        $offset = mb_strpos($this->title, $match, $this->offset, 'UTF-8');

        // Move the pointer for the next match.
        $this->offset = $offset + mb_strlen($match, 'UTF-8');
        return $offset;
    }

    /**
     * Get the char from the $title string
     * at the specified index. Empty if $charIndex
     * less than zero.
     *
     * @param int $charIndex Which char to return.
     * @return string
     */
    private function getChar($charIndex)
    {
        if ($charIndex<0) {
            return '';
        }
        return mb_substr($this->title, $charIndex, 1, 'UTF-8');
    }
    
    /**
     * Handler for the preg_replace_callback.
     *
     * Determines if each word should be capitalized
     * or not and returns the word with the correct
     * Capitalization.
     *
     * @SuppressWarnings(PHPMD.UnusedPrivateMethod)
     * @param array $matches The matches from preg_replace_callback.
     * @return string
     */
    private function callback($matches)
    {
        $offset      = $this->getNextOffset($matches[0]);
        $matchEnd    = $offset + mb_strlen($matches[0], 'UTF-8');

        /**
         * Determine Lower Case Words
         */
        if ($offset > 0                                         && // We're not at the start.
            $matchEnd !== mb_strlen($this->title, 'UTF-8')      && // A single word title is not lower case.
            preg_match($this->smallWords, $matches[0])          && // Small words are lower case.
            $this->getChar($offset - 2) !== ':'                 && // Words after a colon are not lower case.
          ! preg_match('/[^\s-]/', $this->getChar($offset - 1)) &&
            (
               $this->getChar($matchEnd)   !== '-' ||
               $this->getChar($offset - 1) === '-'
            )
        ) {
            return mb_strtolower($matches[0], 'UTF-8');
        }

        /**
         * It's already capitalized.
         */
        if (preg_match('/[A-Z]|\../', mb_substr($matches[0], 1, null, 'UTF-8'))) {
            return $matches[0];
        }
        
        /**
         * Capitalize it
         */
        return mb_strtoupper(mb_substr($matches[0], 0, 1, 'UTF-8'), 'UTF-8') . mb_substr($matches[0], 1, null, 'UTF-8');
    }
}
