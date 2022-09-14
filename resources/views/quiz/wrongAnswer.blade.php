@extends('layouts.app-master')

@section('content')
    <div class="bg-light p-5 rounded">

        <h1>Want to be a Millionaire</h1>
        @auth
            <div class="content">
                <h2 class="bg-danger m-1 p-2 rounded">Answer is wrong</h2>
                <div class="card">
                    <div class="card-body">
                        The correct answer was: <strong>{{$quiz->getCorrectAnswerText()}}</strong>
                    </div>
                </div>
                <a href="{{ route('quiz.index') }}" class="btn btn-primary mt-3">Next Question</a>
            </div>

        @endauth


    </div>
@endsection
