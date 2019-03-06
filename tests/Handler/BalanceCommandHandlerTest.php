<?php

declare(strict_types=1);

namespace App\Tests\Handler;

use App\Entity\User;
use App\Factory\BalanceResponseModelFactoryInterface;
use App\Handler\BalanceCommandHandler;
use App\Handler\Command\BalanceCommand;
use PHPUnit\Framework\TestCase;

class BalanceCommandHandlerTest extends TestCase
{
    /**
     * @var BalanceCommandHandler
     */
    private $balanceCommandHandler;

    /**
     * @var \PHPUnit_Framework_MockObject_MockObject|BalanceResponseModelFactoryInterface
     */
    private $balanceResponseModelFactoryMock;

    /**
     * @var \PHPUnit_Framework_MockObject_MockObject|BalanceCommand
     */
    private $balanceCommandMock;

    /**
     * @var \PHPUnit_Framework_MockObject_MockObject|User
     */
    private $userMock;

    /**
     * {@inheritdoc}
     */
    protected function setUp()
    {
        $this->balanceCommandMock = $this->createMock(BalanceCommand::class);
        $this->userMock = $this->createMock(User::class);
        $this->balanceCommandMock->method('getUser')->willReturn($this->userMock);
        $this->balanceResponseModelFactoryMock = $this->createMock(BalanceResponseModelFactoryInterface::class);

        $this->balanceCommandHandler = new BalanceCommandHandler($this->balanceResponseModelFactoryMock);
    }

    public function testHandle()
    {
        $this->balanceResponseModelFactoryMock->expects($this->once())->method('create');

        $this->balanceCommandHandler->handle($this->balanceCommandMock);
    }
}
