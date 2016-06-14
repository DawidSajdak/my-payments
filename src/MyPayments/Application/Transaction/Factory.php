<?php declare(strict_types=1);

namespace MyPayments\Application\Transaction;

/**
 * Interface Factory
 * @package MyPayments\Application\Transaction
 */
interface Factory
{
    /**
     * @return Transaction
     */
    public function open() : Transaction;
}
