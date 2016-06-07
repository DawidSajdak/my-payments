<?php

namespace Spec\MyPayments\Domain\Payment\PaymentDetails;

use MyPayments\Domain\Exception\InvalidArgumentException;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

/**
 * Class AccountNumberSpec
 * @package Spec\MyPayments\Domain\Payment\PaymentDetails
 */
class AccountNumberSpec extends ObjectBehavior
{
    function let()
    {
        $this->beConstructedWith('26 1050 1445 1000 0022 7647 0461');
    }

    function it_should_has_an_account_number()
    {
        $this->__toString()->shouldReturn('26105014451000002276470461');
    }

    function it_throw_exception_when_account_number_has_more_than_26_digits()
    {
        $this->shouldThrow(InvalidArgumentException::class)->during('__construct', ['261050144510000022764704613']);
    }

    function it_throw_exception_when_account_number_is_incorrect()
    {
        $this->shouldThrow(InvalidArgumentException::class)->during('__construct', ['26105014451000002276470462']);
    }
}
