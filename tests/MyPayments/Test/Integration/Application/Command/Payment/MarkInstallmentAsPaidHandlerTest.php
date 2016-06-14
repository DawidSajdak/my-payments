<?php

namespace MyPayments\Test\Integration\Application\Command\Payment;

use MyPayments\Application\Command\Payment\MarkInstallmentAsPaid;
use MyPayments\Application\Command\Payment\MarkInstallmentAsPaidHandler;
use MyPayments\Application\Payment\Factory\DomainFactory;
use MyPayments\Domain\Payment;
use MyPayments\Domain\User\UserId;
use MyPayments\Infrastructure\InMemory\InMemoryPayments;
use MyPayments\Infrastructure\InMemory\Transaction\Factory;

/**
 * Class MarkInstallmentAsPaidHandlerTest
 * @package MyPayments\Test\Integration\Application\Command\Payment
 */
class MarkInstallmentAsPaidHandlerTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @test
     */
    public function it_allows_to_mark_installment_as_paid()
    {
        $payment = (new DomainFactory())->createPayment(
            'ZUS',
            UserId::fromString('b6f48294-7f1b-427b-8f6b-c6cacdd509db'),
            '2015-12-10',
            436000,
            '26105014451000002276470461',
            $isCyclicalPayment = false,
            $isHirePurchase = true,
            $numberOfInstallments = 2
        );

        $command = new MarkInstallmentAsPaid(
            (string) $payment->getPaymentId(),
            (string) current($payment->getInstallments())->getInstallmentId(),
            new \DateTimeImmutable()
        );

        $handler = new MarkInstallmentAsPaidHandler(new InMemoryPayments([$payment]), new Factory());

        $this->assertFalse(current($payment->getInstallments())->isPaid());
        $handler->handle($command);
        $this->assertTrue(current($payment->getInstallments())->isPaid());
    }
}
