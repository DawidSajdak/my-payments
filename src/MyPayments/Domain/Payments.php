<?php

namespace MyPayments\Domain;

use MyPayments\Domain\Exception\Payment\PaymentNotFoundException;
use MyPayments\Domain\Payment\PaymentId;
use MyPayments\Domain\User\UserId;

/**
 * Interface Payments
 * @package MyPayments\Domain
 */
interface Payments
{
    /**
     * @param Payment $payment
     */
    public function add(Payment $payment);

    /**
     * @param UserId $userId
     *
     * @return Payment[]
     */
    public function getPaymentsByUserId(UserId $userId);

    /**
     * @param PaymentId $paymentId
     * @param UserId $userId
     *
     * @throws PaymentNotFoundException
     * @return Payment
     */
    public function getPaymentByPaymentIdAndUserId(PaymentId $paymentId, UserId $userId) : Payment;
}
