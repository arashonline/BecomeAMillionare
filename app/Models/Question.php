<?php



namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * Class Question
 *
 * @property int $id
 * @property string $title
 * @property int $points
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 *
 * @property Collection|Answer[] $answers
 * @property Collection|Quiz[] $quizzes
 *
 * @package App\Models
 */
class Question extends Model
{
    use HasFactory;
	protected $table = 'questions';

	protected $casts = [
		'points' => 'int'
	];

	protected $fillable = [
		'title',
		'points'
	];

	public function answers()
	{
		return $this->hasMany(Answer::class);
	}
	public function correctAnswer()
	{
		return $this->hasOne(Answer::class)->where('is_correct','=','1');
	}

	public function quizzes()
	{
		return $this->belongsToMany(Quiz::class, 'quiz_questions')
					->withPivot('id', 'selected_answer_id', 'points')
					->withTimestamps();
	}

}
