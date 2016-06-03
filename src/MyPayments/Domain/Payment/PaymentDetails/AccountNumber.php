<?php declare(strict_types=1);

namespace MyPayments\Domain\Payment\PaymentDetails;

use MyPayments\Domain\Exception\InvalidArgumentException;

/**
 * Class AccountNumber
 * @package MyPayments\Domain\Payment\PaymentDetails
 */
final class AccountNumber
{
    /**
     * @var string
     */
    private $accountNumber;

    /**
     * @param string $accountNumber
     * @throws InvalidArgumentException
     */
    public function __construct(string $accountNumber)
    {
        $accountNumber = str_replace(' ', '', $accountNumber);

        $nrb = $accountNumber;
        if (strlen($nrb) != 26) {
            throw new InvalidArgumentException('Account number must have exactly 26 digits.');
        }

        $digitWeight = [1, 10, 3, 30, 9, 90, 27, 76, 81, 34, 49, 5, 50, 15, 53, 45, 62, 38, 89, 17, 73, 51, 25, 56, 75, 71, 31, 19, 93, 57];

        $nrb .= '2521';
        $nrb = substr($nrb, 2).substr($nrb, 0, 2);

        $iSumaCyfr = 0;

        for ($i = 0; $i < 30; $i++) {
            $iSumaCyfr += $nrb[29 - $i] * $digitWeight[$i];
        }

        if ($iSumaCyfr % 97 != 1) {
            throw new InvalidArgumentException('Account number is incorrect.');
        }

        $this->accountNumber = $accountNumber;
    }

    /**
     * @return string
     */
    public function __toString() : string
    {
        return (string) $this->accountNumber;
    }
}
