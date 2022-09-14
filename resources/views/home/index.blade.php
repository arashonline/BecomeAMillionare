@extends('layouts.app-master')

@section('content')
    <div class="bg-light p-5 rounded">

        <h1>Want to be a Millionaire</h1>
        @auth
            <p class="lead">What are you waiting for? Start Playing</p>
            <a href="{{ route('quiz.index') }}" class="btn btn-primary  mt-3 mb-3">Play to win</a>
        @endauth

        @guest

            <a href="{{ route('login') }}" class="btn btn-primary mt-3 mb-3">Please Login</a>
        @endguest
        <div class="content">
            <h2>Top scores</h2>
            <table class="table">
                <thead>
                <tr>
                    <th scope="col">#</th>
                    <th scope="col">Name</th>
                    <th scope="col">Score</th>
                </tr>
                </thead>
                <tbody>
                @foreach($topScores as $key=> $topScore)
                    <tr>
                        <th scope="row">{{$key+1}}</th>
                        <td>{{$topScore['user']->fullname()}}</td>
                        <td>{{$topScore['total_point']}}</td>
                    </tr>
                @endforeach
                </tbody>
            </table>

        </div>
    </div>
@endsection
