<?php declare(strict_types=1);

namespace MyPayments\Application\Command\Payment;

/**
 * Class CreateNewPayment
 * @package MyPayments\Application\Command\Payment
 */
final class CreateNewPayment
{
    /**
     * @var string
     */
    private $name;

    /**
     * @var string
     */
    private $userId;

    /**
     * @var string
     */
    private $paymentDate;

    /**
     * @var int
     */
    private $paymentAmount;

    /**
     * @var string
     */
    private $accountNumber;

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
     * @param string $name
     * @param string $userId
     * @param string $paymentDate
     * @param int $paymentAmount
     * @param string $accountNumber
     * @param bool $cyclicalPayment
     * @param bool $hirePurchase
     * @param int $numberOfInstallments
     */
    public function __construct(
        string $name,
        string $userId,
        string $paymentDate,
        int $paymentAmount,
        string $accountNumber,
        bool $cyclicalPayment,
        bool $hirePurchase,
        int $numberOfInstallments
    ) {
        $this->name = $name;
        $this->userId = $userId;
        $this->paymentDate = $paymentDate;
        $this->paymentAmount = $paymentAmount;
        $this->accountNumber = $accountNumber;
        $this->numberOfInstallments = $numberOfInstallments;
        $this->cyclicalPayment = $cyclicalPayment;
        $this->hirePurchase = $hirePurchase;
    }

    /**
     * @return string
     */
    public function getName() : string
    {
        return $this->name;
    }

    /**
     * @return string
     */
    public function getUserId() : string
    {
        return $this->userId;
    }

    /**
     * @return string
     */
    public function getPaymentDate() : string
    {
        return $this->paymentDate;
    }

    /**
     * @return int
     */
    public function getPaymentAmount() : int
    {
        return $this->paymentAmount;
    }

    /**
     * @return string
     */
    public function getAccountNumber() : string
    {
        return $this->accountNumber;
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
