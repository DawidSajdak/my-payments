<?php declare(strict_types=1);

namespace MyPayments\Application\User;

use MyPayments\Application\Exception\User\Email\InvalidEmailException;

/**
 * Class Email
 * @package MyPayments\Application\User
 */
final class Email
{
    /**
     * @var string
     */
    private $email;

    /**
     * @param string $email
     * @throws InvalidEmailException
     */
    public function __construct(string $email)
    {
        if (false === filter_var($email, FILTER_VALIDATE_EMAIL)) {
            throw new InvalidEmailException;
        }
        $this->email = $email;
    }

    /**
     * @return string
     */
    public function __toString() : string
    {
        return $this->email;
    }

    /**
     * @param Email $email
     * @return bool
     */
    public function isEqual(Email $email) : bool
    {
        return strtolower($this->email) === strtolower((string) $email);
    }
}
