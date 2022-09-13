<?php

namespace Database\Seeders;

use App\Models\Answer;
use App\Models\Question;
use Database\Factories\AnswerFactory;
use Database\Factories\QuestionFactory;
use Illuminate\Database\Seeder;

class QuestionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $questions = Question::factory()->count(50)->has(Answer::factory(['is_correct'=>false])->count(4),'answers')->create();
       $questions->each(function ($thread){
           Answer::factory(['is_correct'=>true])->count(1)->create(['question_id'=>$thread->id]);
       });

    }
}
