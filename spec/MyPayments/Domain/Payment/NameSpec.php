<?php

namespace spec\MyPayments\Domain\Payment;

use MyPayments\Domain\Exception\InvalidArgumentException;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

/**
 * Class NameSpec
 * @package spec\MyPayments\Domain\Payment
 */
class NameSpec extends ObjectBehavior
{
    function it_throws_exception_when_created_empty_string()
    {
        $this->shouldThrow(InvalidArgumentException::class)->during('__construct', ['']);
    }

    function it_can_be_caster_to_string()
    {
        $this->beConstructedWith('ZUS');
        $this->__toString()->shouldReturn('ZUS');
    }
}
