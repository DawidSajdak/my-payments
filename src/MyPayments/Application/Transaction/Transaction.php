<?php declare(strict_types=1);

namespace MyPayments\Application\Transaction;

/**
 * Class Transaction
 * @package MyPayments\Application\Transaction
 */
interface Transaction
{
    public function commit();
    public function rollback();
}
