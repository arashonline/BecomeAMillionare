<?php

namespace App\Http\Controllers;

use App\Models\Quiz;
use App\Models\User;
use Illuminate\Http\Request;

class QuizController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
            /**
             * check if user is logged in
             * check if user has active quiz
             * generate a quiz
             *
            */

            /**
             * @var $user User
            */
            $user = auth()->user();
            if($user->activeQuiz){
                if($available_question = $user->activeQuiz->availableQuestion()){
                    $available_question->pivot->got_answer = 1;
                    $available_question->pivot->save();
                    return view('quiz.perform')->with(['quiz'=>$user->activeQuiz]);
                }
                $user->activeQuiz->statusDone();
                return view('quiz.result')->with(['quiz'=>$user->activeQuiz]);
            }else{
                $quiz = $user->generateQuiz();
                return view('quiz.perform')->with(['quiz'=>$quiz]);
            }
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function validation(){
        /**
         * @var $user User
         */
        $user = auth()->user();
        $answer_id = \request('answer');
        $quiz_id = \request('quiz_id');
        $question_id = \request('question_id');
        $quiz = Quiz::query()->where('id','=',$quiz_id)->where('user_id','=',$user->id)->firstOrFail();

        if($quiz->checkAnswer($question_id,$answer_id)){
            $view = 'quiz.correctAnswer';
        }else{
            $view = 'quiz.wrongAnswer';
        }
        return view($view)->withQuiz($quiz);
    }


}
