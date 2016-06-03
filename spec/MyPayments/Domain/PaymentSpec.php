<?php

namespace spec\MyPayments\Domain;

use MyPayments\Domain\Exception\Payment\DateOfPaymentException;
use MyPayments\Domain\Payment\Name;
use MyPayments\Domain\Payment\PaymentDate;
use MyPayments\Domain\Payment\PaymentDetails;
use MyPayments\Domain\Payment\PaymentPreferences;
use MyPayments\Domain\User\UserId;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;
use SebastianBergmann\Money\Currency;
use SebastianBergmann\Money\Money;

/**
 * Class PaymentSpec
 * @package spec\MyPayments\Domain\User
 */
class PaymentSpec extends ObjectBehavior
{
    function let()
    {
        $this->beConstructedWith(
            new Name('ZUS'),
            UserId::generate(),
            new PaymentDate('2015-09-11'),
            new PaymentDetails(
                new Money(100, new Currency('PLN')),
                new PaymentDetails\AccountNumber('26 1050 1445 1000 0022 7647 0461')
            ),
            new PaymentPreferences($cyclicalPayment = true, $hirePurchase = false, $numberOfInstallments = 0)
        );
    }

    function it_has_a_name()
    {
        $this->getPaymentName()->__toString()->shouldReturn('ZUS');
    }

    function it_has_a_payment_date()
    {
        $this->getPaymentDate()->format('Y-m-d')->shouldReturn('2015-09-11');
    }

    function it_has_a_payment_amount()
    {
        $this->getPaymentAmount()->shouldReturn(100);
    }

    function it_has_an_account_number()
    {
        $this->getAccountNumber()->__toString()->shouldReturn('26105014451000002276470461');
    }

    function it_should_be_mark_as_paid()
    {
        $this->isPaid()->shouldReturn(false);
        $this->markAsPaid(new \DateTimeImmutable('2015-12-10'));
        $this->isPaid()->shouldReturn(true);
    }

    function it_throw_exception_if_date_of_payment_is_in_the_future()
    {
        $this->shouldThrow(DateOfPaymentException::class)->during('markAsPaid', [(new \DateTimeImmutable('now'))->modify('+1 day')]);
    }

    function it_should_create_installment_when_payment_is_divided_into_installment()
    {
        $this->beConstructedWith(
            new Name('ZUS'),
            UserId::generate(),
            new PaymentDate('2015-09-11'),
            new PaymentDetails(
                new Money(1000, new Currency('PLN')),
                new PaymentDetails\AccountNumber('26 1050 1445 1000 0022 7647 0461')
            ),
            new PaymentPreferences($cyclicalPayment = false, $hirePurchase = true, $numberOfInstallments = 10)
        );

        $this->getInstallments()->shouldBeArray();
        $this->getInstallments()->shouldHaveCount(10);
    }
}
