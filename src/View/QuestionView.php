<?php

declare(strict_types=1);

namespace App\View;

final readonly class QuestionView
{
    public string $text;

    public function __construct(string $text)
    {
        $this->text = $text;
    }
}
