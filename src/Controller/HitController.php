<?php

namespace App\Controller;

use App\Message\UserMessage;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Messenger\MessageBusInterface;
use Symfony\Component\Routing\Annotation\Route;
use OpenApi\Attributes as OA;

class HitController extends AbstractController
{

    public function __construct(private readonly MessageBusInterface $messageBus)
    {
    }

    #[Route('/api/v1/collect', name: 'create collect', methods: ['POST'])]
    #[OA\Tag(name: 'Collect API')]
    public function collect (Request $request): Response
    {
        $ip = $request->getClientIp();
        $useragent = $request->headers->get('User-Agent');

        if (empty($ip) || empty($useragent)) {
            return new Response('', Response::HTTP_OK);
        }

        $identifier = md5($ip . "_" . $useragent);

        try {
        $this->messageBus->dispatch(new UserMessage($ip, $useragent, $identifier));
        } catch (\Exception $e) {
            return new Response('', Response::HTTP_BAD_REQUEST);
        }

        return new Response('', Response::HTTP_OK);
    }
}
