<?php

declare(strict_types=1);

namespace App\View;

final readonly class AnswerVariantView
{
    public string $text;

    public bool $correct;


    public function __construct(string $text, bool $correct)
    {
        $this->text = $text;
        $this->correct = $correct;
    }
}
