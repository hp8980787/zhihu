<?php


namespace App\Repositories;

use App\Answer;
use App\Vote;

class AnswersRepository
{

    public function create(array $attribute)
    {
        return Answer::query()->create($attribute);
    }

    public function handleLike($question, $user)
    {
        $likes = [];
        $answers = Answer::query()->with('user')->where('question_id', $question)->published()
            ->get()->toArray();
        $answer_id = array_column($answers, 'id');
        if ($user) {
            $votes = Vote::query()->where('user_id', $user->id)->whereIn('answer_id', $answer_id)->get();
            if (sizeof($votes) > 0) {
                $likes = $votes->pluck('answer_id');
            }
        }
        return ['answers' => $answers, 'likes' => $likes];
    }
}
