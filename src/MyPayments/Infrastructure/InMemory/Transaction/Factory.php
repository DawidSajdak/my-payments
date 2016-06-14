<?php declare(strict_types=1);

namespace MyPayments\Infrastructure\InMemory\Transaction;

use MyPayments\Application\Transaction\Factory as BaseFactory;
use MyPayments\Application\Transaction\Transaction;

/**
 * Class Factory
 * @package MyPayments\Infrastructure\InMemory\Transaction
 */
final class Factory implements BaseFactory
{
    /**
     * @return Transaction
     */
    public function open() : Transaction
    {
        return new InMemoryTransaction();
    }
}
