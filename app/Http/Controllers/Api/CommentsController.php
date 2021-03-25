<?php

namespace App\Http\Controllers\Api;

use App\Comment;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class CommentsController extends Controller
{
    public function store(Request $request)
    {
        $user = Auth::guard('api')->user();

        $this->authorize('create',$user);

        $type = $this->transType($request->type);
        dd($type);


    }

    protected function transType($type)
    {
        return $type == 'answer' ? 'App\Answer' : 'App\Question';
    }
}
