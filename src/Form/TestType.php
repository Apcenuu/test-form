<?php

declare(strict_types=1);

namespace App\Form;

use App\Entity\TestSession\TestSession;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

final class TestType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('testQuestions', CollectionType::class, [
                'entry_type'    => TestQuestionType::class,
                'entry_options' => ['label' => false],
                'label'         => 'Test Question',
            ])
            ->add('submit', SubmitType::class)
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => TestSession::class,
        ]);
    }
}
