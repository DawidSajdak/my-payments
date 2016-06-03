<?php declare(strict_types=1);

namespace MyPayments\Domain\Payment;

use Ramsey\Uuid\Uuid;
use Ramsey\Uuid\UuidInterface;

/**
 * Class PaymentId
 * @package MyPayments\Domain\Payment
 */
final class PaymentId
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
     * @return PaymentId
     */
    public static function generate() : PaymentId
    {
        return new self(Uuid::uuid4());
    }

    /**
     * @param string $paymentId
     * @return PaymentId
     */
    public static function fromString(string $paymentId) : PaymentId
    {
        return new self(Uuid::fromString($paymentId));
    }

    /**
     * @return string
     */
    public function __toString() : string
    {
        return (string) $this->uuid;
    }

    /**
     * @param PaymentId $paymentId
     * @return bool
     */
    public function sameValueAs(PaymentId $paymentId) : bool
    {
        return (string) $this->uuid === (string) $paymentId;
    }
}
