<?php declare(strict_types=1);

namespace MyPayments\Domain;

use MyPayments\Domain\User\UserId;

/**
 * Interface Users
 * @package MyPayments\Domain
 */
interface Users
{
    /**
     * @param User $user
     */
    public function add(User $user);

    /**
     * @param UserId $userId
     *
     * @return User
     */
    public function getUserById(UserId $userId) : User;
}
