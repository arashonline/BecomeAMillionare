@extends('layouts.app-master')

@section('content')
    <div class="bg-light p-5 rounded">

        <h1>Want to be a Millionaire</h1>
        @auth
            <div class="content">
                <h2 class="bg-success p-2 rounded-2">Answer is correct</h2>
                <a href="{{ route('quiz.index') }}" class="btn btn-primary mt-3">Next Question</a>
            </div>

        @endauth


    </div>
@endsection
