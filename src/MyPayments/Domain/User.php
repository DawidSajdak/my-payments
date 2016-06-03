<?php declare(strict_types=1);

namespace MyPayments\Domain;

use MyPayments\Domain\Payment;
use MyPayments\Domain\User\UserId;

/**
 * Class User
 * @package MyPayments\Domain
 */
class User
{
    /**
     * @var UserId
     */
    protected $userId;

    /**
     * User constructor.
     */
    public function __construct()
    {
        $this->userId = UserId::generate();
    }

    /**
     * @return UserId
     */
    public function getUserId()
    {
        return $this->userId;
    }
}
