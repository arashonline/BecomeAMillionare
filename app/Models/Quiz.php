<?php


namespace App\Models;

use App\Http\Resources\QuestionIndexResource;
use App\Http\Resources\QuestionShowResource;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

/**
 * Class Quiz
 *
 * @property int $id
 * @property int $user_id
 * @property int $total_point
 * @property string $status
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 *
 * @property User $user
 * @property Collection|Question[] $questions
 *
 * @package App\Models
 */
class Quiz extends Model
{
    protected $table = 'quizzes';

    const STATUS_PROCESSING = 'PROCESSING';
    const STATUS_FAILED = 'FAILED';
    const STATUS_DONE = 'DONE';

    public $correct_answer_text;

    protected $casts = [
        'user_id' => 'int',
        'total_point' => 'int'
    ];

    protected $fillable = [
        'user_id',
        'total_point',
        'status'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function questions()
    {
        return $this->belongsToMany(Question::class, 'quiz_questions')
            ->withPivot('id', 'selected_answer_id', 'points')
            ->withTimestamps();
    }
    public function availableQuestion()
    {
        return $this->questions()->whereNull('selected_answer_id')->limit(1)->first();
    }

    public function allocateQuestions()
    {
        $total_questions = $this->getTotalQuestions();
        $questions = Question::query()->inRandomOrder()->get()->random(5);
        $this->questions()->saveMany($questions);

    }

    private function getTotalQuestions(): int
    {
        return 5;
    }

    public function checkAnswer($question_id,$answer_id){
        $question = $this->questions()->where('questions.id','=',$question_id)->firstOrFail();
        $question_already_got_point = boolval($question->pivot->points);
        $question_already_answered_wrong = boolval($question->pivot->selected_answer_id===0);
        $question->pivot->selected_answer_id = $answer_id;
            $this->setCorrectAnswerText($question->correctAnswer->title);
        if($question->correctAnswer->id == $answer_id){

            if(!$question_already_got_point && !$question_already_answered_wrong){
                $this->updatePoints($question->points);
                $question->pivot->points = $question->points;
            }
            $question->pivot->save();
            return true;
        }

        $question->pivot->save();
        return false;
    }

    private function updatePoints(int $points)
    {
        $this->total_point += $points;
        $this->save();
    }

    public function statusDone(){
        $this->status = self::STATUS_DONE;
        $this->save();
    }

    private function setCorrectAnswerText( $title)
    {
        $this->correct_answer_text = $title;
    }
    public function getCorrectAnswerText( )
    {
        return $this->correct_answer_text;
    }
}
