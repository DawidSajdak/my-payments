<?php

namespace MyPayments\Test\Integration\Application\Command\Payment;

use MyPayments\Application\Command\Payment\CreateNewPayment;
use MyPayments\Application\Command\Payment\CreateNewPaymentHandler;
use MyPayments\Application\Payment\Factory\DomainFactory;
use MyPayments\Domain\User;
use MyPayments\Infrastructure\InMemory\InMemoryPayments;
use MyPayments\Infrastructure\InMemory\InMemoryUsers;
use MyPayments\Infrastructure\InMemory\Transaction\Factory;

class CreateNewPaymentHandlerTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var Factory
     */
    private $transactionFactory;

    public function setUp()
    {
        $this->transactionFactory = new Factory();
    }
    /**
     * @test
     */
    public function it_allows_to_add_new_payment()
    {
        $user = new User();
        $users = new InMemoryUsers();
        $users->add($user);
        $payments = new InMemoryPayments();

        $command = new CreateNewPayment(
            'ZUS',
            $user->getUserId(),
            '2015-12-10',
            436000,
            '26105014451000002276470461',
            $isCyclicalPayment = false,
            $isHirePurchase = false,
            $numberOfInstallments = 0
        );

        $handler = new CreateNewPaymentHandler(new DomainFactory(), $users, $payments, $this->transactionFactory);
        $handler->handle($command);

        $this->assertCount(1, $payments->getPaymentsByUserId($user->getUserId()));
    }

    /**
     * @test
     * @expectedException \MyPayments\Domain\Exception\User\UserNotFoundException
     */
    public function it_throw_exception_when_payment_exists_into_user()
    {
        $command = new CreateNewPayment(
            'ZUS',
            User\UserId::fromString('b6f48294-7f1b-427b-8f6b-c6cacdd509db'),
            '2015-12-10',
            436000,
            '26105014451000002276470461',
            $isCyclicalPayment = false,
            $isHirePurchase = false,
            $numberOfInstallments = 0
        );

        $handler = new CreateNewPaymentHandler(new DomainFactory(), new InMemoryUsers, new InMemoryPayments(), $this->transactionFactory);
        $handler->handle($command);
    }
}
