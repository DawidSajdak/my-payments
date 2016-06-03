<?php declare(strict_types=1);

namespace MyPayments\Domain\Payment;

use MyPayments\Domain\Exception\InvalidArgumentException;

/**
 * Class PaymentDate
 * @package MyPayments\Domain\Payment
 */
final class PaymentDate
{
    /**
     * @var \DateTimeImmutable
     */
    private $date;

    /**
     * @param string $date
     * @throws InvalidArgumentException
     */
    public function __construct(string $date)
    {
        if (!preg_match('/^\d{4}-(0[1-9]|1[0-2])-(0[1-9]|[1-2]\d|3[0-1])$/', $date)) {
            throw new InvalidArgumentException('Date format is invalid, valid format: YYYY-MM-DD.');
        }
        $this->date = new \DateTimeImmutable($date);
    }

    /**
     * @return \DateTimeImmutable
     */
    public function getDate() : \DateTimeImmutable
    {
        return $this->date;
    }
}
