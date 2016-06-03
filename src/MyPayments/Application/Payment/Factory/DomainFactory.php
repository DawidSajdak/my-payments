<?php

namespace MyPayments\Application\Payment\Factory;

use MyPayments\Application\Payment\Factory;
use MyPayments\Domain\Payment;
use MyPayments\Domain\User\UserId;
use SebastianBergmann\Money\Currency;
use SebastianBergmann\Money\Money;

class DomainFactory implements Factory
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
    ) {
        return new Payment(
            new Payment\Name($name),
            UserId::fromString($userId),
            new Payment\PaymentDate($paymentDate),
            new Payment\PaymentDetails(
                new Money($paymentAmount, new Currency('PLN')),
                new Payment\PaymentDetails\AccountNumber($accountNumber)
            ),
            new Payment\PaymentPreferences(
                $isCyclicalPayment = $cyclicalPayment,
                $isHirePurchase = $hirePurchase,
                $numberOfInstallments
            )
        );
    }
}
