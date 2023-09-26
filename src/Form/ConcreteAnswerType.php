<?php

declare(strict_types=1);

namespace App\Form;

use App\Request\TestSession\ConcreteAnswerRequest;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;
use Symfony\Component\OptionsResolver\OptionsResolver;

final class ConcreteAnswerType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder->addEventListener(FormEvents::PRE_SET_DATA, function (FormEvent $event): void {
            $form = $event->getForm();
            if ($event->getData() instanceof ConcreteAnswerRequest) {
                $form->add('selected', CheckboxType::class, [
                    'label'    => $event->getData()->answerVariant->answerVariant->text,
                    'required' => false,
                ]);
            }
        });
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => ConcreteAnswerRequest::class,
        ]);
    }
}
