<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * Class Answer
 *
 * @property int $id
 * @property int $question_id
 * @property string $title
 * @property int $is_correct
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 *
 * @property Question $question
 * @property Collection|QuizQuestion[] $quiz_questions
 *
 * @package App\Models
 */
class Answer extends Model
{
    use HasFactory;
	protected $table = 'answers';

	protected $casts = [
		'question_id' => 'int',
		'is_correct' => 'int'
	];

	protected $fillable = [
		'question_id',
		'title',
		'is_correct'
	];

	public function question()
	{
		return $this->belongsTo(Question::class);
	}

	public function quiz_questions()
	{
		return $this->hasMany(QuizQuestion::class, 'selected_answer_id');
	}
}
