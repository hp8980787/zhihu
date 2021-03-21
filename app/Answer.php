<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Answer extends Model
{
    protected $fillable = ['user_id', 'question_id', 'body'];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }

    public function question()
    {
        return $this->belongsTo(Question::class, 'question_id', 'id');
    }

    public function scopePublished($query)
    {
        return $query->where('is_hidden', 'F');
    }

    public function votes()
    {
        return $this->belongsToMany(User::class, 'votes', 'user_id', 'answer_id');
    }

    public function hasVote($user_id)
    {
        return !! $this->votes()->where('user_id',$user_id)->count();
    }


}
