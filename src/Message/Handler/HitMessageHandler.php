<?php

namespace App\Message\Handler;

use App\Message\HitMessage;
use App\Repository\HitRepository;
use Symfony\Component\Messenger\Attribute\AsMessageHandler;

#[AsMessageHandler]
class HitMessageHandler
{
    public function __construct(private readonly HitRepository $hitRepository)
    {
    }

    public function __invoke(HitMessage $message)
    {
        $hit = $this->hitRepository->hasSameIdentifier($message->getIdentifier());

        $data = [
            'ip' => $message->getIp(),
            'useragent' => $message->getUserAgent(),
            'identifier' => $message->getIdentifier(),
            'date' => (new \DateTimeImmutable())->format('Y-m-d H:i:s')
        ];

        if ($hit) {
            $this->hitRepository->upsert($data);
        } else {
            $this->hitRepository->insert($data);
        }
    }
}
