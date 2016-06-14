<?php declare(strict_types=1);

namespace MyPayments\Application\Command\Payment;

/**
 * Class MarkInstallmentAsPaid
 * @package MyPayments\Application\Command\Payment
 */
final class MarkInstallmentAsPaid
{
    /**
     * @var string
     */
    private $paymentId;

    /**
     * @var string
     */
    private $installmentId;

    /**
     * @var \DateTimeImmutable
     */
    private $dateOfPaymentOf;

    /**
     * @param string $paymentId
     * @param string $installmentId
     * @param \DateTimeImmutable $dateOfPaymentOf
     */
    public function __construct($paymentId, $installmentId, $dateOfPaymentOf)
    {
        $this->paymentId = $paymentId;
        $this->installmentId = $installmentId;
        $this->dateOfPaymentOf = $dateOfPaymentOf;
    }

    /**
     * @return string
     */
    public function getPaymentId() : string
    {
        return $this->paymentId;
    }

    /**
     * @return string
     */
    public function getInstallmentId() : string
    {
        return $this->installmentId;
    }

    /**
     * @return \DateTimeImmutable
     */
    public function getDateOfPaymentOf() : \DateTimeImmutable
    {
        return $this->dateOfPaymentOf;
    }
}
