<?php

namespace App\Tests\MessageHandler;

use App\Entity\Hit;
use App\Message\HitMessage;
use App\Message\Handler\HitMessageHandler;
use App\Repository\HitRepository;
use Doctrine\ORM\EntityManagerInterface;
use PHPUnit\Framework\TestCase;

class HitMessageHandlerTest extends TestCase
{
    public function testUserMessageHandler(): void
    {
        $message = new HitMessage('127.0.0.1', 'Test User Agent', 'test_identifier');

        $hitRepository = $this->createMock(HitRepository::class);
        $hitRepository->expects($this->once())
            ->method('hasSameIdentifier')
            ->with('test_identifier')
            ->willReturn(null);

        $entityManager = $this->createMock(EntityManagerInterface::class);
        $entityManager->expects($this->once())
            ->method('persist');
        $entityManager->expects($this->once())
            ->method('flush');

        $handler = new HitMessageHandler($hitRepository, $entityManager);
        $handler($message);
    }

    public function testUserMessageHandlerUpdate(): void
    {
        $existingUser = new Hit();
        $existingUser->setIp('127.0.0.1');
        $existingUser->setUseragent('Old User Agent');
        $existingUser->setIdentifier('test_identifier');

        $message = new HitMessage('127.0.0.1', 'New User Agent', 'test_identifier');

        $hitRepository = $this->createMock(HitRepository::class);
        $hitRepository->expects($this->once())
            ->method('hasSameIdentifier')
            ->with('test_identifier')
            ->willReturn($existingUser);

        $entityManager = $this->createMock(EntityManagerInterface::class);
        $entityManager->expects($this->once())
            ->method('flush');

        $handler = new HitMessageHandler($hitRepository, $entityManager);
        $handler($message);
    }
}
