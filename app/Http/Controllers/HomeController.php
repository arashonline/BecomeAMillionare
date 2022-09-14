<?php

namespace App\Http\Controllers;

use App\Models\Quiz;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class HomeController extends Controller
{
    public function index()
    {
        $data = DB::table('quizzes')->from('quizzes')->select(
            DB::raw('user_id, max( total_point ) AS t_point')
        )->where('status','=',Quiz::STATUS_DONE)->groupBy('user_id')->orderBy('t_point','DESC')
            ->take(10)
            ->get();

        $top_scores = [];
        foreach ($data as $top_score){
            $top_scores[]=[
                'user'=>User::query()->where('id','=',$top_score->user_id)->first(),
                'total_point'=>$top_score->t_point,
            ];
        }

        return view('home.index')->withTopScores($top_scores);
    }
}
