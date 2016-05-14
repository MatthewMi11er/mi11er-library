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

namespace Mi11er\Library\DateTime\Formatters;

use DateTimeInterface as PhpDateTimeInterface;
use Mi11er\Library\Exception\DateTime\InvalidFormatException;

/**
 * Extends the builtin DateTime class with addtional features
 *
 * Features:
 * - AP Style formating
 *   {@see https://owl.english.purdue.edu/owl/resource/735/02/ }
 */
class ApStyleFormatter implements DateTimeFormatterInterface
{
    const DATE      = 'AP_DATE';
    const TIME      = 'AP_TIME';
    const DATE_TIME = 'AP_DATE_TIME';
    
    private $format;
    private $compareDateTime;
    private $date;
    
    /**
     * The Constructor
     *
     * @param string                  $format       One of the preset formats this formater returns.
     * @param PhpDateTimeInterface    $compare_date A date to compare to for relative output.
     */
    public function __construct($format, PhpDateTimeInterface $compareDateTime)
    {
        $this->format = $format;
        $this->compareDateTime = $compareDateTime;
    }
    
    /**
     * Returns the formated Date and/or Time.
     *
     * @param PhpDateTimeInterface $date The date to format.
     * @return string
     */
    public function format(PhpDateTimeInterface $date)
    {
        $this->date = $date;
        if (self::DATE === $this->format) {
            return $this->apDate();
        }
        if (self::TIME === $this->format) {
            return $this->apTime();
        }
        if (self::DATE_TIME === $this->format) {
            return $this->apDate() . ' at ' . $this->apTime();
        }
        throw new InvalidFormatException();
    }
  

    /**
     * Returns the ap formated date
     *
     * @return string
     */
    private function apDate()
    {

            /**
             * The AP Style only allows
             * abreviation of some months
             * and those that can must be abreaviated a
             * certain way.
             */
            $apMonths = [
                '01' => 'Jan.',
                '02' => 'Feb.',
                '03' => 'March',
                '04' => 'April',
                '05' => 'May',
                '06' => 'June',
                '07' => 'July',
                '08' => 'Aug.',
                '09' => 'Sept.',
                '10' => 'Oct.',
                '11' => 'Nov.',
                '12' => 'Dec.',
            ];
            if ($this->date->diff($this->compareDateTime)->days === 0) {
                return 'today';
            }
            if ($this->date->diff($this->compareDateTime, true)->days < 7) {
                return $this->date->format('l');
            }

                $formatedDate = $apMonths[ $this->date->format('m') ] . ' '. $this->date->format('j');

            if ($this->date->format('Y') === $this->compareDateTime->format('Y')) {
                return $formatedDate;
            }

                return $formatedDate . ', ' . $this->date->format('Y');
    }

        /**
         * Returns the ap formated time
         *
         * @return string
         */
    private function apTime()
    {
        $hour = $this->date->format('g');
        $minute = $this->date->format('i');
        $meridian = 'am' === $this->date->format('a') ? 'a.m.' : 'p.m.';
        if ('00' === $minute) {
            if ('12' === $hour) {
                return 'a.m.' === ( $meridian ) ? 'midnight' : 'noon';
            }
            return $hour . ' ' . $meridian;
        }
        return $hour . ':' . $minute . ' ' . $meridian;
    }
}
