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

namespace Mi11er\Library\DateTime;

use DateTime as PhpDateTime;
use DateTimeInterface as PhpDateTimeInterface;
use Mi11er\Library\DateTime\Formatters\DateTimeFormatterInterface;

/**
 * Extends the builtin DateTime class with addtional features
 *
 * Features:
 * - AP Style formating
 *   {@see https://owl.english.purdue.edu/owl/resource/735/02/ }
 */
class DateTime extends PhpDateTime
{
    /**
     * Returns the formated Date and/or Time.
     *
     * @param string|DateTimeFormatterInterface $format The formatter we want to use, or a php date format string.
     * @return string
     */
    public function format($format)
    {
        if ($format instanceof DateTimeFormatterInterface) {
            return $format->format($this);
        }
        return parent::format($format);
    }
}
