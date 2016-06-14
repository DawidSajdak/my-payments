<?php declare(strict_types=1);

namespace MyPayments\Application\Command\Payment;

use MyPayments\Application\Payment\Factory;
use MyPayments\Application\Transaction\Factory as TransactionFactory;
use MyPayments\Domain\Payment\PaymentDetails;
use MyPayments\Domain\Payments;
use MyPayments\Domain\User\UserId;
use MyPayments\Domain\Users;

/**
 * Class CreateNewPaymentHandler
 * @package MyPayments\Application\Command\Payment
 */
final class CreateNewPaymentHandler
{
    /**
     * @var Factory
     */
    private $paymentFactory;

    /**
     * @var Users
     */
    private $users;

    /**
     * @var Payments
     */
    private $payments;
    
    /**
     * @var TransactionFactory
     */
    private $transactionFactory;

    /**
     * @param Factory $paymentFactory
     * @param Users $users
     * @param Payments $payments
     * @param TransactionFactory $transactionFactory
     */
    public function __construct(Factory $paymentFactory, Users $users, Payments $payments, TransactionFactory $transactionFactory)
    {
        $this->paymentFactory = $paymentFactory;
        $this->users = $users;
        $this->payments = $payments;
        $this->transactionFactory = $transactionFactory;
    }

    /**
     * @param CreateNewPayment $command
     *
     * @throws \Exception
     */
    public function handle(CreateNewPayment $command)
    {
        $this->users->getUserById(UserId::fromString($command->getUserId()));

        $payment = $this->paymentFactory->createPayment(
            $command->getName(),
            $command->getUserId(),
            $command->getPaymentDate(),
            $command->getPaymentAmount(),
            $command->getAccountNumber(),
            $command->isCyclicalPayment(),
            $command->isHirePurchase(),
            $command->getNumberOfInstallments()
        );

        $transaction = $this->transactionFactory->open();

        try {
            $this->payments->add($payment);
            $transaction->commit();
        } catch (\Exception $e) {
            $transaction->rollback();
            throw $e;
        }
    }
}
