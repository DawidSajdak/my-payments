<?php declare(strict_types=1);

namespace MyPayments\Domain\Payment;

use MyPayments\Domain\Payment\PaymentDetails\AccountNumber;
use SebastianBergmann\Money\Currency;
use SebastianBergmann\Money\Money;

/**
 * Class PaymentDetails
 * @package MyPayments\Domain\Payment
 */
final class PaymentDetails
{
    /**
     * @var Money
     */
    private $money;

    /**
     * @var AccountNumber
     */
    private $accountNumber;

    /**
     * @param Money $money
     * @param AccountNumber $accountNumber
     */
    public function __construct(Money $money, AccountNumber $accountNumber)
    {
        $this->money = $money;
        $this->accountNumber = $accountNumber;
    }

    /**
     * @return int
     */
    public function getPaymentAmount() : int
    {
        return $this->money->getAmount();
    }

    /**
     * @return Currency
     */
    public function getPaymentCurrency() : Currency
    {
        return $this->money->getCurrency();
    }

    /**
     * @return AccountNumber
     */
    public function getAccountNumber() : AccountNumber
    {
        return $this->accountNumber;
    }
}
