<?php

namespace App\Http\Controllers\Api;

use App\Follow;
use App\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Notifications\NewUserFollowNotification;
class UserFollowController extends Controller
{
    public function __construct()
    {

    }

    public function isFollow(Request $request)
    {

        $followed_id = $request->followed_id;
        $followed_user = User::query()->findOrFail($followed_id);
        $followers_id = $followed_user->followers()->pluck('follower_id')->toArray();
        $user = Auth::guard('api')->user();
        if (in_array($user->id, $followers_id)) {
            return response(['is_followed' => true], 200);
        }
        return response(['is_followed' => false], 200);
    }

    public function follow(Request $request)
    {
        $followed_id = $request->followed_id;
        $userFollowed = User::query()->findOrFail($followed_id);
        $userFollower = Auth::guard('api')->user();
        $followed = $userFollowed->followers()->toggle($userFollower->id);

        if (sizeof($followed['detached']) > 0) {
            $userFollower->decrement('followings_count');
            $userFollowed->decrement('followers_count');

            return response(['is_followed' => false]);
        }
        $userFollowed->increment('followers_count');
        $userFollower->increment('followings_count');
        $userFollowed->notify(new NewUserFollowNotification($userFollower));
        return response(['is_followed' => true]);

    }
}
