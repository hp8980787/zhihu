<?php

namespace App\Http\Controllers\Api;

use App\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class UserFollowController extends Controller
{
    public function __construct()
    {

    }

    public function isFollow(Request $request)
    {
        $followed_id = $request->followed_id;
        $user = Auth::guard('api')->user();
        $is_followed = !!$user->followers()->where('followed_id', $followed_id)->count();

        return response(compact('is_followed'), 200);
    }

    public function follow(Request $request)
    {
        $followed_id = $request->followed_id;
        $userFollowed = User::query()->findOrFail($followed_id);
        $userFollower = Auth::guard('api')->user();
        $followed = $userFollower->followers()->toggle($followed_id);

        if (sizeof($followed['detached']) > 0) {
            $userFollower->decrement('followings_count');
            $userFollowed->decrement('followers_count');
            return response(['is_followed' => false]);
        }
        $userFollowed->increment('followers_count');
        $userFollower->increment('followings_count');
        return response(['is_followed' => true]);

    }
}
