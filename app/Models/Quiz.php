<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

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
}
