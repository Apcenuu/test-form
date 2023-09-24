<?php

declare(strict_types=1);

namespace App\Controller;

use App\Entity\TestSession\TestSession;
use Doctrine\ORM\EntityManagerInterface as EntityManager;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

final class SessionController extends AbstractController
{
    #[Route(path: '/sessions', name: 'sessions')]
    public function sessions(EntityManager $entityManager): Response
    {
        $sessions = $entityManager->getRepository(TestSession::class)->findAll();

        return $this->render('sessions.html.twig', [
            'sessions' => $sessions,
        ]);
    }

    #[Route(path: '/sessions/{id}', name: 'session')]
    public function session(TestSession $session): Response
    {
        return $this->render('session.html.twig', [
            'session' => $session,
        ]);
    }
}
