<?php

namespace spec\Mi11er\Library\Exception\Security;

use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class InvalidSymbolListExceptionSpec extends ObjectBehavior
{
    public function it_is_initializable()
    {
        $this->shouldHaveType('Mi11er\Library\Exception\Security\InvalidSymbolListException');
    }
}
