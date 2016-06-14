<?php declare(strict_types=1);

namespace MyPayments\Infrastructure\InMemory;

use MyPayments\Domain\Exception\Payment\PaymentNotFoundException;
use MyPayments\Domain\Payment;
use MyPayments\Domain\Payment\PaymentId;
use MyPayments\Domain\Payments;
use MyPayments\Domain\User\UserId;

/**
 * Class InMemoryPayments
 * @package MyPayments\Infrastructure\InMemory
 */
class InMemoryPayments implements Payments
{
    /**
     * @var Payment[]
     */
    private $payments = [];

    /**
     * @param Payment[] $payments
     */
    public function __construct(array $payments = [])
    {
        $this->payments = [];
        
        foreach ($payments as $payment) {
            $this->add($payment);
        }
    }
    
    /**
     * @param Payment $payment
     */
    public function add(Payment $payment)
    {
        $this->payments[(string) $payment->getPaymentId()] = $payment;
    }

    /**
     * @param UserId $userId
     *
     * @return Payment[]
     */
    public function getPaymentsByUserId(UserId $userId)
    {
        $payments = [];
        foreach ($this->payments as $payment) {
            if ($payment->getUserId()->sameValueAs($userId)) {
                $payments[(string) $payment->getPaymentId()] = $payment;
            }
        }

        return $payments;
    }

    /**
     * @param PaymentId $paymentId
     *
     * @throws PaymentNotFoundException
     * @return Payment
     */
    public function getPaymentByPaymentId(PaymentId $paymentId) : Payment
    {
        if (!array_key_exists((string) $paymentId, $this->payments)) {
            throw new PaymentNotFoundException();
        }

        return $this->payments[(string) $paymentId];
    }
}
