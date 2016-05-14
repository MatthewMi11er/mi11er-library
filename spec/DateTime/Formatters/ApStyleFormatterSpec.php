<?php

namespace spec\Mi11er\Library\DateTime\Formatters;

use PhpSpec\ObjectBehavior;
use Prophecy\Argument;
use DateTime as PhpDateTime;
use Mi11er\Library\DateTime\Formatters\ApStyleFormatter;

class ApStyleFormatterSpec extends ObjectBehavior
{
    public function it_is_initializable(PhpDateTime $compareDate)
    {
        $this->beConstructedWith(ApStyleFormatter::DATE, $compareDate);
        $this->shouldHaveType('Mi11er\Library\DateTime\Formatters\ApStyleFormatter');
        $this->shouldImplement('Mi11er\Library\DateTime\Formatters\DateTimeFormatterInterface');
    }
    
    /**
     *  @dataProvider dateTimeExamples
     */
    public function it_converts_text_to_title_case($inputValue, $expectedValue)
    {
        $compareDateTime = new PhpDateTime('2008-10-07 18:11:31');
        $this->beConstructedWith($inputValue[0], $compareDateTime);
        $this->format($inputValue[1])->shouldReturn($expectedValue);
    }
    public function it_throws_and_exception_on_an_invalid_format()
    {
        $this->beConstructedWith('INVALID', new PhpDateTime());
        $this->shouldThrow('Mi11er\Library\Exception\DateTime\InvalidFormatException')->duringformat(new PhpDateTime());
    }

    /**
     * Example test cases for the toTitleCcase method
     */
    public function dateTimeExamples()
    {
        return [
            [[ApStyleFormatter::DATE,      new PhpDateTime('2008-10-07')],          'today'],
            [[ApStyleFormatter::DATE,      new PhpDateTime('2008-10-09')],          'Thursday'],
            [[ApStyleFormatter::DATE,      new PhpDateTime('2008-10-05')],          'Sunday'],
            [[ApStyleFormatter::DATE,      new PhpDateTime('2008-09-07')],          'Sept. 7'],
            [[ApStyleFormatter::DATE,      new PhpDateTime('2007-10-07')],          'Oct. 7, 2007'],
            [[ApStyleFormatter::TIME,      new PhpDateTime('12:00')],               'noon'],
            [[ApStyleFormatter::TIME,      new PhpDateTime('3:00')],                '3 a.m.'],
            [[ApStyleFormatter::TIME,      new PhpDateTime('18:11')],               '6:11 p.m.'],
            [[ApStyleFormatter::DATE_TIME, new PhpDateTime('2005-08-07 18:11:31')], 'Aug. 7, 2005 at 6:11 p.m.'],
        ];
    }
}
