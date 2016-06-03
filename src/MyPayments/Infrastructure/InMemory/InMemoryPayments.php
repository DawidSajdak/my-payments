<?php

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
     * @param UserId $userId
     *
     * @throws PaymentNotFoundException
     * @return Payment
     */
    public function getPaymentByPaymentIdAndUserId(PaymentId $paymentId, UserId $userId) : Payment
    {
        foreach ($this->payments as $payment) {
            if ($payment->getUserId()->sameValueAs($userId) && $payment->getPaymentId()->sameValueAs($paymentId)) {
                return $payment;
            }
        }

        throw new PaymentNotFoundException;
    }
}
