<?php
namespace spec\Mi11er\Library\Security;

use Mi11er\Library\Security\PasswordGenerator;
use Mi11er\Library\Exception\Security\InvalidSymbolListException;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class PasswordGeneratorSpec extends ObjectBehavior
{
    public function it_is_initializable()
    {
        $this->shouldHaveType(PasswordGenerator::class);
    }

    public function it_generates_a_password()
    {
        $this->generate()->shouldBeString();
    }

    public function it_generates_multiple_password()
    {
        $firstResult = $this->generate();
        $this->generate()->shouldNotbe($firstResult);
    }
    
    public function it_must_use_a_symbol_list_of_the_correct_size()
    {
        $this->shouldThrow('Mi11er\Library\Exception\Security\InvalidSymbolListException')
             ->during('setSymbolList', [[]]);
        $this->shouldThrow('Mi11er\Library\Exception\Security\InvalidSymbolListException')
             ->during('setSymbolList', [['1', '2', '3']]);
    }
    
    public function it_tells_us_the_password_entropy()
    {
        $this->entropy()->shouldBeLike(91);
    }
}
