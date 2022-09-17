@if(isset($options->model) && isset($options->type))

    @if(class_exists($options->model))

        @php
            $model = $options->model;
            $table = $options->table;

            $question = \App\Models\Question::where('id','=',$dataTypeContent->getKey())->first();
        @endphp




        @include('vendor.voyager.answers.add-new')
    @else

        cannot make relationship because {{ $options->model }} does not exist.

    @endif

@endif
