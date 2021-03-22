<?php

namespace App\Http\Controllers\Api;

use App\Answer;
use App\Vote;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class VotesController extends Controller
{


    public function like(Request $request)
    {
        $user = Auth::guard('api')->user();

        $answer = Answer::query()->where('id', $request->answer_id)->firstOrFail();

        $vote = $user->votes()->toggle($answer->id);

        if (sizeof($vote['attached']) > 0) {
            $answer->increment('votes_count');
            return response(['is_like' => true, 'like_counts' => $answer->vote_count]);
        }
        $answer->decrement('votes_count');
        return response(['is_like' => false, 'like_counts' => $answer->vote_count]);

    }
}
