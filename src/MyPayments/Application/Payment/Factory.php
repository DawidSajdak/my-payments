<?php

namespace MyPayments\Application\Payment;

use MyPayments\Domain\Payment;

/**
 * Interface Factory
 * @package MyPayments\Application\Payment
 */
interface Factory
{
    /**
     * @param string $name
     * @param string $userId
     * @param string $paymentDate
     * @param int $paymentAmount
     * @param string $accountNumber
     * @param bool $cyclicalPayment
     * @param bool $hirePurchase
     * @param int $numberOfInstallments
     *
     * @return Payment
     */
    public function createPayment(
        string $name,
        string $userId,
        string $paymentDate,
        int $paymentAmount,
        string $accountNumber,
        bool $cyclicalPayment,
        bool $hirePurchase,
        int $numberOfInstallments
    );
}
