<?php

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
     * @return User
     * @throws UserNotFoundException
     */
    public function getUserById(UserId $userId) : User
    {
        foreach ($this->users as $user) {
            if ($user->getUserId()->sameValueAs($userId)) {
                return $user;
            }
        }
        
        throw new UserNotFoundException;
    }
}
