<?php declare(strict_types=1);

namespace MyPayments\Domain\Payment;

use MyPayments\Domain\Exception\InvalidArgumentException;

/**
 * Class Name
 * @package MyPayments\Domain\Payment
 */
final class Name
{
    /**
     * @var string
     */
    private $name;

    /**
     * @param string $name
     * @throws InvalidArgumentException
     */
    public function __construct(string $name)
    {
        if (!is_string($name) || empty($name)) {
            throw new InvalidArgumentException("Name can't be created from non string or empty value.");
        }

        $this->name = $name;
    }

    /**
     * @return string
     */
    public function __toString() : string
    {
        return $this->name;
    }
}
