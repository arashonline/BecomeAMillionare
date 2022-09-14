<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

/**
 * Class User
 *
 * @property int $id
 * @property string $name
 * @property string $surname
 * @property string $username
 * @property string $email
 * @property Carbon|null $email_verified_at
 * @property string $password
 * @property string|null $remember_token
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 *
 * @property Collection|Quiz[] $quizzes
 *
 * @package App\Models
 */
class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

protected $table = 'users';

	protected $dates = [
		'email_verified_at'
	];

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'surname',
        'username',
        'email',
        'password',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    /**
     * Always encrypt the password when it is updated.
     *
     * @param $value
     * @return string
     */
    public function setPasswordAttribute($value)
    {
        $this->attributes['password'] = bcrypt($value);
    }

   public function quizzes()
   	{
   		return $this->hasMany(Quiz::class);
   	}

   public function activeQuiz()
   	{
   		return $this->hasOne(Quiz::class)->where('status','=',Quiz::STATUS_PROCESSING);
   	}

    public function generateQuiz()
    {
        $quiz = new Quiz(['user_id'=>$this->id,'status'=>Quiz::STATUS_PROCESSING,'total_point'=>0]);
        $quiz->save();
        $quiz->allocateQuestions();
        return $quiz;
    }

    public function fullname(){
        return $this->name.' '.$this->surname;
    }
}
