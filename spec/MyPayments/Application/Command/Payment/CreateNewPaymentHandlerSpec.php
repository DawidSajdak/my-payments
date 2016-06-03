<?php

namespace spec\MyPayments\Application\Handler\Payment;

use MyPayments\Application\Command\Payment\CreateNewPayment;
use MyPayments\Application\Payment\Factory;
use MyPayments\Domain\Exception\PaymentAlreadyExists;
use MyPayments\Domain\Exception\UserDoesNotExistsException;
use MyPayments\Domain\Payment;
use MyPayments\Domain\Payments;
use MyPayments\Domain\User;
use MyPayments\Domain\Users;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;
use SebastianBergmann\Money\Currency;
use SebastianBergmann\Money\Money;

/**
 * Class CreateNewPaymentHandlerSpec
 * @package spec\MyPayments\Application\Handler\Payment
 */
class CreateNewPaymentHandlerSpec extends ObjectBehavior
{
    function let(Factory $paymentFactory, Users $users, Payments $payments)
    {
        $userId = User\UserId::fromString('b6f48294-7f1b-427b-8f6b-c6cacdd509db');
        $paymentFactory->createPayment(
            'ZUS',
            $userId,
            '2015-12-10',
            436000,
            '26105014451000002276470461',
            $isCyclicalPayment = false,
            $isHirePurchase = false,
            $numberOfInstallments = 0
        )->willReturn(
            new Payment(
                new Payment\Name('ZUS'),
                $userId,
                new Payment\PaymentDate('2016-01-10'),
                new Payment\PaymentDetails(
                    new Money(460000, new Currency('PLN')),
                    new Payment\PaymentDetails\AccountNumber('26105014451000002276470461')
                ),
                new Payment\PaymentPreferences(
                    $isCyclicalPayment = false,
                    $isHirePurchase = false,
                    $numberOfInstallments = 0
                )
            )
        );
        $this->beConstructedWith($paymentFactory, $users, $payments);
    }

    function it_adds_new_payment(Users $users, Payments $payments)
    {
        $users->getUserById(Argument::type(User\UserId::class))->willReturn(new User());
        $payments->add(Argument::type(Payment::class))->shouldBeCalled();
        $payments->getPaymentByPaymentIdAndUserId(
            Argument::type(Payment\PaymentId::class),
            Argument::type(User\UserId::class)
        )->willReturn(null);

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

        $this->handle($command);
    }

    function it_throw_exception_when_payment_exists_into_user(Users $users, Payments $payments)
    {
        $users->getUserById(Argument::type(User\UserId::class))->willReturn(new User());
        $payments->getPaymentByPaymentIdAndUserId(
            Argument::type(Payment\PaymentId::class),
            Argument::type(User\UserId::class)
        )->willReturn(Payment::class);

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

        $this->shouldThrow(PaymentAlreadyExists::class)->during('handle', [$command]);
    }

    function it_throw_exception_when_user_does_not_exists(Users $users)
    {
        $users->getUserById(Argument::type(User\UserId::class))->willReturn(null);

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

        $this->shouldThrow(UserDoesNotExistsException::class)->during('handle', [$command]);
    }
}
