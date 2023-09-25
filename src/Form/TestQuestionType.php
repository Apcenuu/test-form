<?php

declare(strict_types=1);

namespace App\Form;

use App\Request\TestQuestionRequest;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;
use Symfony\Component\OptionsResolver\OptionsResolver;

final class TestQuestionType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder->addEventListener(FormEvents::PRE_SET_DATA, function (FormEvent $event): void {
            $form = $event->getForm();
            if ($event->getData() instanceof TestQuestionRequest) {
                $form->add('concreteAnswers', CollectionType::class, [
                    'entry_type'    => ConcreteAnswerType::class,
                    'entry_options' => ['label' => false],
                    'label'         => $event->getData()->questionRequest->question->text,
                ]);
            }
        });
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => TestQuestionRequest::class,
        ]);
    }
}
