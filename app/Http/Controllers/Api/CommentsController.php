<?php

namespace App\Http\Controllers\Api;

use App\Comment;
use App\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class CommentsController extends Controller
{
    public function index()
    {
    }

    public function store(Request $request, Comment $comment)
    {

        $user = Auth::guard('api')->user();
        if (intval($user->id) === intval($request->user_id)) {
            $request->validate([
               'body'=>'required|min:2|max:50'
            ]);
            $type = $this->transType($request->type);

            Comment::query()->create([
                'user_id' => $user->id,
                'body' => clean($request->body, 'question'),
                'commentable_id' => $request->model,
                'commentable_type' => $type,
            ]);
            $model = new $type;
            $model->increment('comments_count');
            return response(['message' => '回复成功'], 200);

        }
        return response(['message' => '回复失败'], 403);


    }

    public function answer($id)
    {
        $comments = Comment::query()->with('user')->where('commentable_id', $id)->published()->get();
        return response(['data' => $comments, 'message' => '成功'], '200');
    }

    protected function transType($type)
    {
        return $type == 'answer' ? 'App\Answer' : 'App\Question';
    }
}
