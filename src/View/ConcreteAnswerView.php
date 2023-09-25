<?php

declare(strict_types=1);

namespace App\View;

final  class ConcreteAnswerView
{
    public bool $selected;

    public readonly AnswerVariantView $answerVariant;

    public function __construct(bool $selected, AnswerVariantView $answerVariant)
    {
        $this->selected = $selected;
        $this->answerVariant = $answerVariant;
    }
}
