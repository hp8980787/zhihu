<?php


namespace App\Repositories;

use App\Answer;

class AnswersRepository
{

    public function create(array $attribute)
    {
        return Answer::query()->create($attribute);
    }
}
