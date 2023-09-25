<?php

declare(strict_types=1);

namespace App\Request;

use App\Entity\Question\Question;

final class QuestionRequest
{
    public function __construct(public readonly Question $question)
    {
    }
}
