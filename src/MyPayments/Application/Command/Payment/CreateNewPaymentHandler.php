<?php declare(strict_types=1);

namespace MyPayments\Application\Command\Payment;

use MyPayments\Application\Payment\Factory;
use MyPayments\Domain\Exception\Payment\PaymentAlreadyExists;
use MyPayments\Domain\Exception\UserDoesNotExistsException;
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
     * @param Factory $paymentFactory
     * @param Users $users
     * @param Payments $payments
     */
    public function __construct(Factory $paymentFactory, Users $users, Payments $payments)
    {
        $this->paymentFactory = $paymentFactory;
        $this->users = $users;
        $this->payments = $payments;
    }

    /**
     * @param CreateNewPayment $command
     *
     * @throws PaymentAlreadyExists
     * @throws UserDoesNotExistsException
     */
    public function handle(CreateNewPayment $command)
    {
        $user = $this->users->getUserById(UserId::fromString($command->getUserId()));
        
        if (is_null($user)) {
            throw new UserDoesNotExistsException;
        }

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

        $this->payments->add($payment);
    }
}
