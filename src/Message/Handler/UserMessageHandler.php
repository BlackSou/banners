<?php

namespace App\Message\Handler;

use App\Entity\User;
use App\Message\UserMessage;
use App\Repository\UserRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Messenger\Handler\MessageHandlerInterface;

class UserMessageHandler implements MessageHandlerInterface
{
    public function __construct(private readonly UserRepository $userRepository, private readonly EntityManagerInterface $em)
    {
    }

    public function __invoke(UserMessage $message)
    {
        $hit = $this->userRepository->hasSameIdentifier($message->getIdentifier());

        if ($hit) {
            $hit->setIp($message->getIp());
            $hit->setUseragent($message->getUserAgent());
            $hit->setUpdatedAt(new \DateTime());
        } else {
            $hit = new User();
            $hit->setIp($message->getIp());
            $hit->setUseragent($message->getUserAgent());
            $hit->setIdentifier($message->getIdentifier());
        }

        $this->em->persist($hit);
        $this->em->flush();
    }
}
