<?php

namespace spec\MyPayments\Domain\Payment;

use MyPayments\Domain\Payment\PaymentDetails\AccountNumber;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;
use SebastianBergmann\Money\Currency;
use SebastianBergmann\Money\Money;

/**
 * Class PaymentDetailsSpec
 * @package spec\MyPayments\Domain\Payment
 */
class PaymentDetailsSpec extends ObjectBehavior
{
    function let()
    {
        $this->beConstructedWith(new Money(100, new Currency('PLN')), new AccountNumber('26105014451000002276470461'));
    }

    function it_should_has_payment_amount()
    {
        $this->getPaymentAmount()->shouldReturn(100);
    }

    function it_should_has_account_number()
    {
        $this->getAccountNumber()->__toString()->shouldReturn('26105014451000002276470461');
    }
}
