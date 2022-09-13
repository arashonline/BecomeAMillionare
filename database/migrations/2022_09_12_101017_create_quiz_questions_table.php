<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateQuizQuestionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('quiz_questions', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('question_id')->unsigned();
            $table->bigInteger('quiz_id')->unsigned();
            $table->bigInteger('selected_answer_id')->unsigned();
            $table->integer('points')->default(0);
            $table->timestamps();

            $table->foreign('question_id','quiz_questions_question_id')->references('id')->on('questions');
            $table->foreign('quiz_id','quiz_questions_quiz_id')->references('id')->on('quizzes');
            $table->foreign('selected_answer_id','quiz_questions_selected_answer_id')->references('id')->on('answers');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('quiz_questions');
    }
}
