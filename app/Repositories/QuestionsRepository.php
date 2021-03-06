<?php


namespace App\Repositories;

use App\Question;
use App\Topic;

class QuestionsRepository
{
    public function byId($id)
    {
        return Question::query()->findOrFail($id);
    }

    public function byIdWithTopics($id)
    {
        return Question::query()->with('topics')->findOrFail($id);
    }

    public function create(array $attributes)
    {
        return Question::query()->create($attributes);
    }

    public function normalizeTopic(array $topics)
    {
        return collect($topics)->map(function ($topic) {
            if (is_numeric($topic)) {
                Topic::query()->find($topic)->increment('questions_count');
                return (int)$topic;
            }
            $newTopic = Topic::query()->create(['name' => $topic, 'questions_count' => 1]);
            return $newTopic->id;
        })->toArray();
    }

    public function destroy($id)
    {
        return Question::query()->where('id',$id)->delete();

    }
}
