<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class QuestionsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $topics_id = \App\Topic::query()->get()->pluck('id')->toArray();
        factory(\App\Question::class, 20)->create()->each(function ($u) use ($topics_id) {
            $ids = array_rand($topics_id, rand(1, sizeof($topics_id)));

            if (!is_array($ids)) {
                DB::table('question_topic')->insert([
                    'question_id' => $u->id,
                    'topic_id' => $ids,
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);
            } else {
                foreach ($ids as $id) {
                    DB::table('question_topic')->insert([
                        'question_id' => $u->id,
                        'topic_id' => $id,
                        'created_at' => now(),
                        'updated_at' => now(),
                    ]);
                }

            }

        });
    }
}
