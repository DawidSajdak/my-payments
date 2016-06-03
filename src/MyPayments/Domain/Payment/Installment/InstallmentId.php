<?php declare(strict_types=1);

namespace MyPayments\Domain\Payment\Installment;

use Ramsey\Uuid\Uuid;
use Ramsey\Uuid\UuidInterface;

/**
 * Class InstallmentId
 * @package MyPayments\Domain\Payment\Installment
 */
final class InstallmentId
{
    /**
     * @var UuidInterface
     */
    private $uuid;

    /**
     * @param UuidInterface $uuid
     */
    public function __construct(UuidInterface $uuid)
    {
        $this->uuid = $uuid;
    }

    /**
     * @return InstallmentId
     */
    public static function generate() : InstallmentId
    {
        return new self(Uuid::uuid4());
    }

    /**
     * @param string $installmentId
     * @return InstallmentId
     */
    public static function fromString(string $installmentId) : InstallmentId
    {
        return new self(Uuid::fromString($installmentId));
    }

    /**
     * @return string
     */
    public function __toString() : string
    {
        return (string) $this->uuid;
    }

    /**
     * @param InstallmentId $installmentId
     * @return bool
     */
    public function sameValueAs(InstallmentId $installmentId) : bool
    {
        return (string) $this->uuid === (string) $installmentId;
    }
}
