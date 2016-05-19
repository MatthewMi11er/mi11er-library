<?php

namespace spec\Mi11er\Library\DateTime;

use PhpSpec\ObjectBehavior;
use Prophecy\Argument;
use Mi11er\Library\DateTime\Formatters\DateTimeFormatterInterface;

class DateTimeSpec extends ObjectBehavior
{
    public function it_is_initializable()
    {
        $this->shouldHaveType('Mi11er\Library\DateTime\DateTime');
        $this->shouldBeAnInstanceOf('\DateTime');
        $this->shouldImplement('\DateTimeInterface');
    }
    
    public function it_can_format_itself_with_a_php_format_string()
    {
        $this->beConstructedWith('2008-10-08');
        $this->format('Y-m-d')->shouldReturn('2008-10-08');
    }

    public function it_can_format_itself_with_a_custom_formatter(DateTimeFormatterInterface $formatter)
    {
        $this->beConstructedWith('12:00');
        $formatter->format($this)->willReturn('noon');
        $this->format($formatter)->shouldReturn('noon');
    }
    
    public function it_can_format_itself_with_a_custom_formatter2(DateTimeFormatterInterface $formatter)
    {
        $this->beConstructedWith('12:00', null, $formatter);
        $formatter->format($this)->willReturn('noon');
        $this->format(0)->shouldReturn('noon');
    }
    public function it_can_format_itself_with_a_custom_formatter3(
        DateTimeFormatterInterface $formatter,
        DateTimeFormatterInterface $formatter2
    ) {
        $this->beConstructedWith('12:00', null, [$formatter,$formatter2]);
        $formatter->format($this)->willReturn('noon');
        $this->format(0)->shouldReturn('noon');
        $formatter2->format($this)->willReturn('midnight');
        $this->format(1)->shouldReturn('midnight');
        $this->format(2)->shouldReturn('2');
    }
}
