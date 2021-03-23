<?php

use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:api')->get('/user', function (Request $request) {
    echo $request->user();
});

Route::group([

    'prefix' => 'auth'

], function ($router) {

    Route::post('login', 'AuthController@login');
    Route::post('logout', 'AuthController@logout');
    Route::post('refresh', 'AuthController@refresh');
    Route::post('me', 'AuthController@me');

});

Route::middleware('api')->get('/topics', function (Request $request) {

    $topics = \App\Topic::query()->where('name', 'like', "%{$request->search}%")
        ->get(['id', 'name as text']);
    return ['results' => $topics];
});

Route::post('/question/follower', function (Request $request) {
    $user = Auth::guard('api')->user();
    $question = \App\Question::query()->findOrFail($request->question);
    $follow = $user->followed($question->id);
    if ($follow) {
        return response()->json(['followed' => true, 'followers_count' => $question->followers_count]);
    }
    return response()->json(['followed' => false, 'followers_count' => $question->followers_count]);
})->middleware('auth:api');

Route::post('/question/follow', function (Request $request) {
    $user = Auth::guard('api')->user();

    $question = \App\Question::query()->find($request->question);

    $follow = $user->followThis($question);

    if (sizeof($follow['detached']) > 0) {
        $question->decrement('followers_count');
        return response()->json(['followed' => false, 'followers_count' => $question->followers_count]);
    }

    $question->increment('followers_count');

    return response()->json(['followed' => true, 'followers_count' => $question->followers_count]);
})->middleware('auth:api');
Route::middleware('auth:api')->group(function () {
    Route::post('/user-isfollow', 'Api\UserFollowController@isFollow');
    Route::post('/user-follow', 'Api\UserFollowController@follow');
    Route::get('/answer-islike', 'Api\VotesController@isLike');
    Route::post('/answer-like', 'Api\VotesController@like');
    Route::post('/messages/store','Api\MessagesController@store');
});
Route::resource('/answers', 'Api\AnswersController');
