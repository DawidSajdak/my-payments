<?php declare(strict_types=1);

namespace MyPayments\Domain\Payment;

use MyPayments\Domain\Exception\InvalidArgumentException;

/**
 * Class PaymentPreferences
 * @package MyPayments\Domain\Payment
 */
final class PaymentPreferences
{
    /**
     * @var bool
     */
    private $cyclicalPayment;

    /**
     * @var bool
     */
    private $hirePurchase;

    /**
     * @var int
     */
    private $numberOfInstallments;

    /**
     * @param bool $cyclicalPayment
     * @param bool $hirePurchase
     * @param int $numberOfInstallments
     * @throws InvalidArgumentException
     */
    public function __construct(bool $cyclicalPayment, bool $hirePurchase, int $numberOfInstallments)
    {
        if ($cyclicalPayment && $hirePurchase) {
            throw new InvalidArgumentException('Payment can not be cyclical and hire payment at the same time.');
        }

        if ($hirePurchase && $numberOfInstallments <= 1) {
            throw new InvalidArgumentException('Number of installments must be greater than 1.');
        }

        $this->cyclicalPayment = $cyclicalPayment;
        $this->hirePurchase = $hirePurchase;
        $this->numberOfInstallments = $numberOfInstallments;
    }

    /**
     * @return bool
     */
    public function isCyclicalPayment() : bool
    {
        return $this->cyclicalPayment;
    }

    /**
     * @return bool
     */
    public function isHirePurchase() : bool
    {
        return $this->hirePurchase;
    }

    /**
     * @return int
     */
    public function getNumberOfInstallments() : int
    {
        return $this->numberOfInstallments;
    }
}
