<?php



namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

/**
 * Class QuizQuestion
 *
 * @property int $id
 * @property int $question_id
 * @property int $quiz_id
 * @property int $selected_answer_id
 * @property int $got_answer
 * @property int $points
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 *
 * @property Question $question
 * @property Quiz $quiz
 * @property Answer $answer
 *
 * @package App\Models
 */
class QuizQuestion extends Model
{
	protected $table = 'quiz_questions';

	protected $casts = [
		'question_id' => 'int',
		'quiz_id' => 'int',
		'selected_answer_id' => 'int',
		'points' => 'int',
		'got_answer' => 'int',
	];

	protected $fillable = [
		'question_id',
		'quiz_id',
		'selected_answer_id',
		'points',
		'got_answer',
	];

	public function question()
	{
		return $this->belongsTo(Question::class);
	}

	public function quiz()
	{
		return $this->belongsTo(Quiz::class);
	}

	public function answer()
	{
		return $this->belongsTo(Answer::class, 'selected_answer_id');
	}

    public function updateAnswer($answer_id){
        $this->selected_answer_id = $answer_id;
        $this->save();
    }
    public function updatePoints(){
        $this->points = $this->question->points;
        $this->save();
    }
}
