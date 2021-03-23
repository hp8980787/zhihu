<?php

namespace App\Http\Controllers\Api;

use App\Answer;
use App\Vote;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Repositories\AnswersRepository;

class VotesController extends Controller
{
    protected $answers;

    public function __construct(AnswersRepository $answersRepository)
    {
        $this->answers = $answersRepository;
    }


    public function like(Request $request)
    {
        $user = Auth::guard('api')->user();

        $answer = Answer::query()->where('id', $request->answer_id)->firstOrFail();

        $vote = $user->votes()->toggle($answer->id);

        $answers = $this->answers->handleLike($request->question, $user);

        if (sizeof($vote['attached']) > 0) {
            $answer->increment('votes_count');
            $answers = $this->answers->handleLike($request->question, $user);
            return response($answers);
        }
        $answer->decrement('votes_count');
        $answers = $this->answers->handleLike($request->question, $user);
        return response($answers);

    }
}
