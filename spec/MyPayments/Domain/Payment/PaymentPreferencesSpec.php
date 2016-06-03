<?php

namespace spec\MyPayments\Domain\Payment;

use MyPayments\Domain\Exception\InvalidArgumentException;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

/**
 * Class PaymentPreferencesSpec
 * @package spec\MyPayments\Domain\Payment
 */
class PaymentPreferencesSpec extends ObjectBehavior
{
    function it_is_cyclical_payment()
    {
        $this->beConstructedWith($cyclicalPayment = true, $hirePurchase = false, 0);
        $this->isCyclicalPayment()->shouldReturn(true);
    }

    function it_is_hire_purchase()
    {
        $this->beConstructedWith($cyclicalPayment = false, $hirePurchase = true, 10);
        $this->isHirePurchase()->shouldReturn(true);
    }

    function it_has_installments()
    {
        $this->beConstructedWith($cyclicalPayment = false, $hirePurchase = true, 10);
        $this->getNumberOfInstallments()->shouldReturn(10);
    }

    function it_throw_exception_when_payment_is_cyclical_and_hire_purchase()
    {
        $this->shouldThrow(new InvalidArgumentException('Payment can not be cyclical and hire payment at the same time.'))
            ->during('__construct', [$cyclicalPayment = true, $hirePurchase = true, 10]);
    }

    function it_throw_exception_when_payment_is_hire_purchase_and_number_of_installments_are_less_than_2()
    {
        $this->shouldThrow(new InvalidArgumentException('Number of installments must be greater than 1.'))
            ->during('__construct', [$cyclicalPayment = false, $hirePurchase = true, 1]);
    }
}
