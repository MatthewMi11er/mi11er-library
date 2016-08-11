<?php

namespace spec\Mi11er\Library\Exception\DateTime;

use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class InvalidFormatExceptionSpec extends ObjectBehavior
{
    public function it_is_initializable()
    {
        $this->shouldHaveType('Mi11er\Library\Exception\DateTime\InvalidFormatException');
    }
}
