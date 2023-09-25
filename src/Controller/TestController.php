<?php

declare(strict_types=1);

namespace App\Controller;

use App\Entity\Question\Question;
use App\Entity\TestSession\TestSession;
use App\Form\TestType;
use App\Request\TestSessionRequest;
use Doctrine\ORM\EntityManagerInterface as EntityManager;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

final class TestController extends AbstractController
{
    #[Route(path: '/test', name: 'test')]
    public function test(Request $request, EntityManager $entityManager): Response
    {
        $questions = $entityManager->getRepository(Question::class)->findAll();

        $form = $this->createForm(TestType::class, TestSessionRequest::buildFromQuestions($questions));
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->getData() instanceof TestSessionRequest) {

            $testSession = TestSession::fromRequest($form->getData());

            $entityManager->persist($testSession);
            $entityManager->flush();

            return $this->render('test_form.html.twig', [
                'form'    => $form,
                'session' => $testSession,
            ]);
        }

        return $this->render('test_form.html.twig', [
            'form' => $form,
        ]);
    }
}
