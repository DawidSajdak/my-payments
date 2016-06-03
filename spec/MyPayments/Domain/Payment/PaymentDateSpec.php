<?php

namespace spec\MyPayments\Domain\Payment;

use MyPayments\Domain\Exception\InvalidArgumentException;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

/**
 * Class PaymentDateSpec
 * @package spec\MyPayments\Domain\Payment
 */
class PaymentDateSpec extends ObjectBehavior
{
    function let()
    {
        $this->beConstructedWith('2015-12-10');
    }

    function it_should_has_a_date()
    {
        $this->getDate()->format('Y-m-d')->shouldReturn('2015-12-10');
    }

    function it_throw_exception_when_date_is_invalid()
    {
        $this->shouldThrow(InvalidArgumentException::class)->during('__construct', ['2015-13-10']);
    }
}
