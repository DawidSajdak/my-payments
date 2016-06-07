<?php

namespace Spec\MyPayments\Domain\Payment;

use MyPayments\Domain\Payment\PaymentId;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;
use SebastianBergmann\Money\Currency;
use SebastianBergmann\Money\Money;

/**
 * Class InstallmentSpec
 * @package Spec\MyPayments\Domain\Payment
 */
class InstallmentSpec extends ObjectBehavior
{
    function let()
    {
        $this->beConstructedWith(PaymentId::generate(), new \DateTimeImmutable('2015-12-10'), new Money(10, new Currency('PLN')));
    }

    function it_has_a_installment_date()
    {
        $this->getInstallmentDate()->format('Y-m-d')->shouldReturn('2015-12-10');
    }

    function it_has_a_installment_amount()
    {
        $this->getInstallmentAmount()->shouldReturn(10);
    }

    function it_has_a_currency()
    {
        $this->getInstallmentCurrency()->shouldBeAnInstanceOf(Currency::class);
        $this->getInstallmentCurrency()->getCurrencyCode()->shouldReturn('PLN');
    }
}
