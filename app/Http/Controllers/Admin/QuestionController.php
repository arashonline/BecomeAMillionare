<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Question;
use App\Providers\ApiResponseServiceProvider;
use Illuminate\Http\Request;

class QuestionController extends Controller
{
    public function submitAnswer(Request $request)
    {

        $request->validate(
            [
                'id' => 'required|int',
                'answerText' => 'required',
            ]
        );
        $data = $request->post();
        if ($question = Question::query()->where('id', '=', $data['id'])->first()) {
            /**
             * @var $question Question
             */
            $answers = $question->addAnswer($data['answerText'], boolval($data['isCorrect'] === 'true'));

            return response()->api(['answers' => $answers]);
        }
        return response()->api($question, ApiResponseServiceProvider::STATUS_FAILED, 'Question not found', 400);
    }
    public function removeAnswer(Request $request)
    {

        $request->validate(
            [
                'id' => 'required|int',
                'question_id' => 'required|int',
            ]
        );
        $data = $request->post();
        if ($question = Question::query()->where('id', '=', $data['question_id'])->first()) {
            /**
             * @var $question Question
             */
            $answers = $question->removeAnswer($data['id']);

            return response()->api(['answers' => $answers]);
        }
        return response()->api($question, ApiResponseServiceProvider::STATUS_FAILED, 'Question not found', 400);
    }
    public function updateAnswer(Request $request)
    {

        $request->validate(
            [
                'id' => 'required|int',
                'question_id' => 'required|int',
            ]
        );
        $data = $request->post();
        if ($question = Question::query()->where('id', '=', $data['question_id'])->first()) {
            /**
             * @var $question Question
             */
            $answers = $question->checkCorrectAnswer($data['id']);

            return response()->api(['answers' => $answers]);
        }
        return response()->api($question, ApiResponseServiceProvider::STATUS_FAILED, 'Question not found', 400);
    }
}
