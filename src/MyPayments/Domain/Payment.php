<?php declare(strict_types=1);

namespace MyPayments\Domain;

use MyPayments\Domain\Exception\Payment\DateOfPaymentException;
use MyPayments\Domain\Payment\Installment;
use MyPayments\Domain\Payment\Name;
use MyPayments\Domain\Payment\PaymentDate;
use MyPayments\Domain\Payment\PaymentDetails;
use MyPayments\Domain\Payment\PaymentId;
use MyPayments\Domain\Payment\PaymentPreferences;
use MyPayments\Domain\User\UserId;
use SebastianBergmann\Money\Currency;
use SebastianBergmann\Money\Money;

/**
 * Class Payment
 * @package MyPayments\Domain\User
 */
class Payment
{
    /**
     * @var UserId
     */
    protected $userId;

    /**
     * @var Name
     */
    protected $paymentName;

    /**
     * @var PaymentId
     */
    protected $paymentId;

    /**
     * @var \DateTimeImmutable
     */
    protected $paymentDate;

    /**
     * @var int
     */
    protected $paymentAmount;

    /**
     * @var Currency
     */
    protected $paymentCurrency;

    /**
     * @var string
     */
    protected $accountNumber;

    /**
     * @var bool
     */
    protected $cyclicalPayment;

    /**
     * @var bool
     */
    protected $hirePurchase;

    /**
     * @var \DateTimeImmutable
     */
    protected $dateOfPaymentOf;

    /**
     * @var Installment[]
     */
    protected $installments = [];

    /**
     * @param Name $paymentName
     * @param UserId $userId
     * @param PaymentDate $paymentDate
     * @param PaymentDetails $paymentDetails
     * @param PaymentPreferences $paymentPreferences
     */
    public function __construct(
        Name $paymentName,
        UserId $userId,
        PaymentDate $paymentDate,
        PaymentDetails $paymentDetails,
        PaymentPreferences $paymentPreferences
    ) {
        $this->paymentId = PaymentId::generate();

        $this->paymentName = $paymentName;
        $this->userId = $userId;
        $this->paymentDate = $paymentDate->getDate();

        if ($paymentPreferences->isHirePurchase()) {
            $installmentAmount = $paymentDetails->getPaymentAmount() / $paymentPreferences->getNumberOfInstallments();
            $installmentDate = $paymentDate->getDate();
            for ($numberOfInstallment = 0; $numberOfInstallment < $paymentPreferences->getNumberOfInstallments(); $numberOfInstallment++) {
                $this->addInstallment($installmentDate->modify('+1 month'), new Money($installmentAmount, $paymentDetails->getPaymentCurrency()));
            }
        }

        $this->setPaymentDetails($paymentDetails);
        $this->setPaymentPreferences($paymentPreferences);
    }

    /**
     * @return Name
     */
    public function getPaymentName() : Name
    {
        return $this->paymentName;
    }

    /**
     * @return UserId
     */
    public function getUserId() : UserId
    {
        return $this->userId;
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
    public function getPaymentDate() : \DateTimeImmutable
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
     * @return Currency
     */
    public function getPaymentCurrency() : Currency
    {
        return $this->paymentCurrency;
    }

    /**
     * @return PaymentDetails\AccountNumber
     */
    public function getAccountNumber() : PaymentDetails\AccountNumber
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
     * @param \DateTimeImmutable $dateOfPaymentOf
     * @throws DateOfPaymentException
     */
    public function markAsPaid(\DateTimeImmutable $dateOfPaymentOf)
    {
        if ($dateOfPaymentOf->getTimestamp() > (new \DateTimeImmutable('now'))->getTimestamp()) {
            throw new DateOfPaymentException('Date of payment can not be in the future!');
        }
        $this->dateOfPaymentOf = $dateOfPaymentOf;
    }

    /**
     * @return bool
     */
    public function isPaid() : bool
    {
        return !is_null($this->dateOfPaymentOf);
    }

    /**
     * @return \DateTimeImmutable
     */
    public function getDateOfPaymentOf() : \DateTimeImmutable
    {
        return $this->dateOfPaymentOf;
    }

    /**
     * @return Payment\Installment[]
     */
    public function getInstallments() : array
    {
        return $this->installments;
    }

    /**
     * @param \DateTimeImmutable $installmentDate
     * @param Money $installmentAmount
     */
    private function addInstallment(\DateTimeImmutable $installmentDate, Money $installmentAmount)
    {
        $this->installments[] = new Installment($this->paymentId, $installmentDate, $installmentAmount);
    }

    /**
     * @param PaymentDetails $paymentDetails
     */
    private function setPaymentDetails(PaymentDetails $paymentDetails)
    {
        $this->accountNumber = $paymentDetails->getAccountNumber();
        $this->paymentAmount = $paymentDetails->getPaymentAmount();
        $this->paymentCurrency = $paymentDetails->getPaymentCurrency();
    }

    /**
     * @param PaymentPreferences $paymentPreferences
     */
    private function setPaymentPreferences(PaymentPreferences $paymentPreferences)
    {
        $this->cyclicalPayment = $paymentPreferences->isCyclicalPayment();
        $this->hirePurchase = $paymentPreferences->isHirePurchase();
    }
}
