<?php declare(strict_types=1);

namespace MyPayments\Infrastructure\InMemory;

use MyPayments\Domain\Exception\User\UserNotFoundException;
use MyPayments\Domain\User;
use MyPayments\Domain\User\UserId;
use MyPayments\Domain\Users;

/**
 * Class InMemoryUsers
 * @package MyPayments\Infrastructure\InMemory
 */
class InMemoryUsers implements Users
{
    /**
     * @var User[]
     */
    private $users = [];
    
    /**
     * @param User $user
     */
    public function add(User $user)
    {
        $this->users[(string) $user->getUserId()] = $user;
    }

    /**
     * @param UserId $userId
     *
     * @return User
     * @throws UserNotFoundException
     */
    public function getUserById(UserId $userId) : User
    {
        if (!array_key_exists((string) $userId, $this->users)) {
            throw new UserNotFoundException();
        }
        
        return $this->users[(string) $userId];
    }
}
