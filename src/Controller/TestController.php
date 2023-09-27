<?php

declare(strict_types=1);

namespace App\Controller;

use App\Entity\Question\Question;
use App\Entity\TestSession\TestSession;
use App\Form\TestType;
use App\Repository\QuestionRepository;
use App\Request\TestSession\TestSessionRequest;
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
        /** @var QuestionRepository $repository */
        $repository = $entityManager->getRepository(Question::class);
        $questions  = $repository->allInRandomOrder();

        $form = $this->createForm(TestType::class, TestSessionRequest::buildFromQuestions($questions));
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid() && $form->getData() instanceof TestSessionRequest) {
            $testSession = TestSession::fromRequest($form->getData());

            $entityManager->persist($testSession);
            $entityManager->flush();

            return $this->redirectToRoute('session', ['id' => $testSession->id]);
        }

        return $this->render('test_form.html.twig', [
            'form' => $form,
        ]);
    }
}
