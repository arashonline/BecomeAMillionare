@extends('layouts.app-master')

@section('content')
    <div class="bg-light p-5 rounded">

        <h1>Want to be a Millionaire</h1>
        @auth

            <div class="content">
                <h2 class="bg-success p-2 rounded-2">Congratulation</h2>
                <br>
                <li> You got total points of {{$quiz->total_point}}</li>
                <br>
                <a href="{{ route('quiz.index') }}" class="btn btn-primary me-2">Want to play again?</a>
            </div>

        @endauth


    </div>
@endsection
