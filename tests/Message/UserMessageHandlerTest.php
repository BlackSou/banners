<?php

namespace App\Tests\MessageHandler;

use App\Entity\User;
use App\Message\UserMessage;
use App\Message\Handler\UserMessageHandler;
use App\Repository\UserRepository;
use Doctrine\ORM\EntityManagerInterface;
use PHPUnit\Framework\TestCase;

class UserMessageHandlerTest extends TestCase
{
    public function testUserMessageHandler(): void
    {
        $message = new UserMessage('127.0.0.1', 'Test User Agent', 'test_identifier');

        $userRepository = $this->createMock(UserRepository::class);
        $userRepository->expects($this->once())
            ->method('hasSameIdentifier')
            ->with('test_identifier')
            ->willReturn(null);

        $entityManager = $this->createMock(EntityManagerInterface::class);
        $entityManager->expects($this->once())
            ->method('persist');
        $entityManager->expects($this->once())
            ->method('flush');

        $handler = new UserMessageHandler($userRepository, $entityManager);
        $handler($message);
    }

    public function testUserMessageHandlerUpdate(): void
    {
        $existingUser = new User();
        $existingUser->setIp('127.0.0.1');
        $existingUser->setUseragent('Old User Agent');
        $existingUser->setIdentifier('test_identifier');

        $message = new UserMessage('127.0.0.1', 'New User Agent', 'test_identifier');

        $userRepository = $this->createMock(UserRepository::class);
        $userRepository->expects($this->once())
            ->method('hasSameIdentifier')
            ->with('test_identifier')
            ->willReturn($existingUser);

        $entityManager = $this->createMock(EntityManagerInterface::class);
        $entityManager->expects($this->once())
            ->method('flush');

        $handler = new UserMessageHandler($userRepository, $entityManager);
        $handler($message);
    }
}
