<?php declare(strict_types=1);

namespace MyPayments\Application\Command\Payment;

use MyPayments\Application\Transaction\Factory;
use MyPayments\Domain\Payment\Installment\InstallmentId;
use MyPayments\Domain\Payment\PaymentId;
use MyPayments\Domain\Payments;

/**
 * Class MarkInstallmentAsPaidHandler
 * @package MyPayments\Application\Command\Payment
 */
final class MarkInstallmentAsPaidHandler
{
    /**
     * @var Payments
     */
    private $payments;

    /**
     * @var Factory
     */
    private $transactionFactory;

    /**
     * @param Payments $payments
     * @param Factory $transactionFactory
     */
    public function __construct(Payments $payments, Factory $transactionFactory)
    {
        $this->payments = $payments;
        $this->transactionFactory = $transactionFactory;
    }

    /**
     * @param MarkInstallmentAsPaid $command
     *
     * @throws \Exception
     */
    public function handle(MarkInstallmentAsPaid $command)
    {
        $payment = $this->payments->getPaymentByPaymentId(PaymentId::fromString($command->getPaymentId()));

        $transaction = $this->transactionFactory->open();

        try {
            $payment->markInstallmentAsPaid(InstallmentId::fromString($command->getInstallmentId()), $command->getDateOfPaymentOf());
            $transaction->commit();
        } catch (\Exception $e) {
            $transaction->rollback();
            throw $e;
        }
    }
}
