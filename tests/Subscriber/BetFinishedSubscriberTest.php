<?php

declare(strict_types=1);

namespace App\Tests\Subscriber;

use App\Entity\User;
use App\Entity\Wallet;
use App\Event\BetFinishedEvent;
use App\Factory\WalletUpdatingPipelineFactoryInterface;
use App\Repository\WalletRepositoryInterface;
use App\Subscriber\BetFinishedSubscriber;
use Doctrine\ORM\EntityManagerInterface;
use League\Pipeline\Pipeline;
use PHPUnit\Framework\TestCase;

class BetFinishedSubscriberTest extends TestCase
{
    const NUMBER_OF_WALLETS = 3;

    /**
     * @var BetFinishedSubscriber
     */
    private $betFinishedSubscriber;

    /**
     * @var \PHPUnit_Framework_MockObject_MockObject|WalletRepositoryInterface
     */
    private $walletRepositoryMock;

    /**
     * @var \PHPUnit_Framework_MockObject_MockObject|EntityManagerInterface
     */
    private $entityManagerMock;

    /**
     * @var \PHPUnit_Framework_MockObject_MockObject|WalletUpdatingPipelineFactoryInterface
     */
    private $walletUpdatingPipelineFactoryMock;

    /**
     * @var \PHPUnit_Framework_MockObject_MockObject|BetFinishedEvent
     */
    private $betFinishedEventMock;

    /**
     * @var \PHPUnit_Framework_MockObject_MockObject|User
     */
    private $userMock;

    /**
     * @var \PHPUnit_Framework_MockObject_MockObject|Wallet
     */
    private $walletMock;

    /**
     * @var \PHPUnit_Framework_MockObject_MockObject|Pipeline
     */
    private $pipelineMock;

    /**
     * {@inheritdoc}
     */
    protected function setUp()
    {
        $this->walletRepositoryMock = $this->createMock(WalletRepositoryInterface::class);
        $this->entityManagerMock = $this->createMock(EntityManagerInterface::class);
        $this->walletUpdatingPipelineFactoryMock = $this->createMock(WalletUpdatingPipelineFactoryInterface::class);
        $this->betFinishedEventMock = $this->createMock(BetFinishedEvent::class);
        $this->walletMock = $this->createMock(Wallet::class);
        $this->pipelineMock = $this->createMock(Pipeline::class);
        $this->userMock = $this->createMock(User::class);

        for ($i = 0; $i < self::NUMBER_OF_WALLETS; ++$i) {
            $wallets[] = $this->createMock(Wallet::class);
        }

        $this->walletRepositoryMock->method('findBonusMoneyWalletsByUser')->willReturn($wallets);
        $this->walletUpdatingPipelineFactoryMock->method('create')->willReturn($this->pipelineMock);
        $this->pipelineMock->method('process')->willReturn($this->walletMock);

        $this->betFinishedSubscriber = new BetFinishedSubscriber(
            $this->walletRepositoryMock,
            $this->entityManagerMock,
            $this->walletUpdatingPipelineFactoryMock
        );
    }

    public function testOnBetFinished()
    {
        $this->entityManagerMock->expects($this->exactly(self::NUMBER_OF_WALLETS))->method('persist');
        $this->entityManagerMock->expects($this->once())->method('flush');

        $this->betFinishedSubscriber->onBetFinished($this->betFinishedEventMock);
    }
}
