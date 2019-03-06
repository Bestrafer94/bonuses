<?php

declare(strict_types=1);

namespace App\Tests\Factory;

use App\Entity\User;
use App\Factory\WalletUpdatingPipelineFactory;
use App\Factory\WalletUpdatingPipelineFactoryInterface;
use App\Repository\WalletRepositoryInterface;
use League\Pipeline\PipelineInterface;
use PHPUnit\Framework\TestCase;

class WalletUpdatingPipelineFactoryTest extends TestCase
{
    /**
     * @var WalletUpdatingPipelineFactoryInterface
     */
    private $walletUpdatingPipelineFactory;

    /**
     * @var \PHPUnit_Framework_MockObject_MockObject|WalletRepositoryInterface
     */
    private $walletRepositoryMock;

    /**
     * @var \PHPUnit_Framework_MockObject_MockObject|User
     */
    private $userMock;

    /**
     * {@inheritdoc}
     */
    protected function setUp()
    {
        $this->walletRepositoryMock = $this->createMock(WalletRepositoryInterface::class);
        $this->userMock = $this->createMock(User::class);

        $this->walletUpdatingPipelineFactory = new WalletUpdatingPipelineFactory($this->walletRepositoryMock);
    }

    public function testCreate()
    {
        $pipeline = $this->walletUpdatingPipelineFactory->create($this->userMock, 500);
        $this->assertInstanceOf(PipelineInterface::class, $pipeline);
    }
}
