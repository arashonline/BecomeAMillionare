@extends('layouts.app-master')

@section('content')
    <div class="bg-light p-5 rounded">

        <h1>Want to be a Millionaire</h1>
        @auth
            <button type="button" class="btn btn-primary mb-3 mt-3">
                Total points: <span class="badge badge-light">{{$quiz->total_point}}</span>
            </button>
            <form method="POST" action="{{route('quiz.validate')}}">
                {{csrf_field()}}

                <fieldset>
                    <legend><h3 class="center title"><strong>{{ $quiz->availableQuestion()->title }}</strong></h3>
                    </legend>

                </fieldset>
                <div class="checkboxes-wrapper" class="center">
                    @foreach($quiz->availableQuestion()->answers as $answer)
                        <div>
                            <input type="radio" id="{{$answer->id}}" name="answer" value="{{$answer->id}}">
                            <label for="{{$answer->id}}">{{$answer->title}}</label>
                        </div>

                    @endforeach
                </div>
                <input hidden type="text" name="quiz_id" value="{{$quiz->id}}">
                <input hidden type="text" name="question_id" value="{{$quiz->availableQuestion()->id}}">
                <button type="submit" class="btn btn-primary mt-3">Submit your answer</button>


            </form>
        @endauth


    </div>
@endsection
