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

//    public $additional_attributes = ['correct_answer'];

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

//    public function getCorrectAnswer()
//    {
//        return boolval($this->correctAnswer());
//    }

    public function addAnswer($title,$is_correct = false){
	    $answer = new Answer(['title'=>$title,'question_id'=>$this->id,'is_correct'=>($is_correct?1:0)]);
	    $answer->save();
	    if($answer->is_correct){
	        return $this->checkCorrectAnswer($answer->id);
        }
	    return $this->answers()->get();
    }
    public function removeAnswer($answerId){
	    foreach ($this->answers as $answer){
	        if($answer->id == $answerId){
	            $answer->delete();
            }
        }
	    return $this->answers()->get();
    }

    public function checkCorrectAnswer(int $id)
    {
        $this->answers()->whereNotIn('id',[$id])->update(['is_correct'=>0]);
        $this->answers()->where('id','=',$id)->update(['is_correct'=>1]);
        return $this->answers()->get();
    }


}
