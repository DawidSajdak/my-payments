<?php declare(strict_types=1);

namespace MyPayments\Domain\Payment;

use MyPayments\Domain\Payment\Installment\InstallmentId;
use SebastianBergmann\Money\Currency;
use SebastianBergmann\Money\Money;

/**
 * Class Installment
 * @package MyPayments\Domain\User
 */
class Installment
{
    /**
     * @var InstallmentId
     */
    protected $installmentId;

    /**
     * @var PaymentId
     */
    protected $paymentId;
    
    /**
     * @var \DateTimeImmutable
     */
    protected $installmentDate;
    
    /**
     * @var int
     */
    protected $installmentAmount;

    /**
     * @var Currency
     */
    protected $installmentCurrency;

    /**
     * @param PaymentId $paymentId
     * @param \DateTimeImmutable $installmentDate
     * @param Money $money
     */
    public function __construct(PaymentId $paymentId, \DateTimeImmutable $installmentDate, Money $money)
    {
        $this->installmentId = InstallmentId::generate();
        $this->paymentId = $paymentId;
        $this->installmentDate = $installmentDate;
        $this->installmentAmount = $money->getAmount();
        $this->installmentCurrency = $money->getCurrency();
    }

    /**
     * @return InstallmentId
     */
    public function getInstallmentId() : InstallmentId
    {
        return $this->installmentId;
    }

    /**
     * @return PaymentId
     */
    public function getPaymentId() : PaymentId
    {
        return $this->paymentId;
    }

    /**
     * @return \DateTimeImmutable
     */
    public function getInstallmentDate() : \DateTimeImmutable
    {
        return $this->installmentDate;
    }

    /**
     * @return int
     */
    public function getInstallmentAmount() : int
    {
        return $this->installmentAmount;
    }

    /**
     * @return Currency
     */
    public function getInstallmentCurrency() : Currency
    {
        return $this->installmentCurrency;
    }
}
