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

Route::middleware('api')->get('/topics', function (Request $request) {

    $topics = \App\Topic::query()->where('name','like',"%{$request->search}%")
        ->get(['id','name as text']);
    return ['results'=>$topics];
});

Route::post('/question/follower',function (Request $request){

   $follow = \App\Follow::query()->where('question_id', $request->question)
       ->where('user_id',$request->user)->count();

   if ($follow){
       return response()->json(['followed'=>true]);
   }
    return response()->json(['followed'=>false]);
})->middleware('api');

Route::post('/question/follow',function (Request $request){
    $follow = \App\Follow::query()->where('question_id',$request->question)
        ->where('user_id',$request->user)->first();

    if ($follow !== null){
        $follow->delete();
        return response()->json(['followed'=>false]);
    }
    \App\Follow::query()->create([
        'question_id'=>$request->question,
        'user_id'=>$request->user,
    ]);
    return response()->json(['followed'=>true]);
})->middleware('api');
