<?php

declare(strict_types=1);

namespace App\Controller;

use App\Entity\Question\Question;
use App\Entity\TestSession\ConcreteAnswer;
use App\Entity\TestSession\TestQuestion;
use App\Entity\TestSession\TestSession;
use App\Form\TestType;
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
        $testQuestions = [];
        foreach ($entityManager->getRepository(Question::class)->findAll() as $question) {
            $testQuestion    = new TestQuestion($question);
            $concreteAnswers = [];
            foreach ($question->answerVariants as $answerVariant) {
                $concreteAnswers[] = new ConcreteAnswer(false, $testQuestion, $answerVariant);
            }
            $testQuestion->setConcreteAnswers($concreteAnswers);
            $testQuestions[] = $testQuestion;
        }

        $form = $this->createForm(TestType::class, new TestSession($testQuestions));
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->getData() instanceof TestSession) {
            $testSession = $form->getData();

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
