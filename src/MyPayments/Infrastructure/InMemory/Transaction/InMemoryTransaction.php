<?php declare(strict_types=1);

namespace MyPayments\Infrastructure\InMemory\Transaction;

use MyPayments\Application\Transaction\Transaction;

/**
 * Class InMemoryTransaction
 * @package MyPayments\Infrastructure\InMemory\Transaction
 */
final class InMemoryTransaction implements Transaction
{
    public function commit()
    {
        // do nothing, everything happens in memory
    }
    public function rollback()
    {
        throw new \RuntimeException('InMemoryTransaction does not supports rollbacks');
    }
}
