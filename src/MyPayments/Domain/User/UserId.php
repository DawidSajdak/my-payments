<?php declare(strict_types=1);

namespace MyPayments\Domain\User;

use Ramsey\Uuid\Uuid;
use Ramsey\Uuid\UuidInterface;

/**
 * Class UserId
 * @package MyPayments\Domain\User
 */
final class UserId
{
    /**
     * @var UuidInterface
     */
    private $uuid;

    /**
     * @param UuidInterface $aUuid
     */
    public function __construct(UuidInterface $aUuid)
    {
        $this->uuid = $aUuid;
    }

    /**
     * @return UserId
     */
    public static function generate() : UserId
    {
        return new self(Uuid::uuid4());
    }

    /**
     * @param string $userId
     * @return UserId
     */
    public static function fromString(string $userId) : UserId
    {
        return new self(Uuid::fromString($userId));
    }

    /**
     * @return string
     */
    public function __toString() : string
    {
        return (string) $this->uuid;
    }

    /**
     * @param UserId $userId
     * @return bool
     */
    public function sameValueAs(UserId $userId) : bool
    {
        return (string) $this->uuid === (string) $userId;
    }
}
