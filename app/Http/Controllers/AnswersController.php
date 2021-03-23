<?php

namespace App\Http\Controllers;

use App\Http\Requests\AnswersRequest;
use Illuminate\Http\Request;
use App\Repositories\AnswersRepository;
use Illuminate\Support\Facades\Auth;

class AnswersController extends Controller
{
    protected $answers;

    public function __construct(AnswersRepository $answers)
    {
        $this->answers = $answers;
    }

    public function store(AnswersRequest $request, $question)
    {

       $answer = $this->answers->create([
           'user_id'=>Auth::id(),
           'question_id'=>$question,
           'body'=>clean(html_entity_decode($request->body),'question'),
       ]) ;

       $answer->question()->increment('answers_count');
       return back();
    }
}
