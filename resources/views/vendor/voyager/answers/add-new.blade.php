<ul class="radio answer-options">
    @foreach($question->answers as $key => $answer)
        <li>
            <input type="radio" id="option-{{ $answer->id }}"
                   data-answer-id="{{ $answer->id }}"
                   name="answer"
                   value="{{ $key }}" @if($answer->is_correct) checked @endif>
            <label for="option-{{ $answer->id }}">{{ $answer->title }}</label>
            <div class="check"></div>
            @if(!$answer->is_correct)
                <div class="remove-answer" data-answer-id="{{ $answer->id }}">x</div>
            @endif

        </li>
    @endforeach
</ul>

<button class="btn btn-primary" id="add-answer-button">Add Answer</button>

<div class="page-content edit-add container-fluid hide" id="add-answer-section">
    <div class="row">
        <div class="col-md-12">
            <div class="panel panel-bordered">
                <!-- form start -->
                <form role="form"
                      class="form-edit-add"
                      action="#"
                      method="POST" enctype="multipart/form-data">
                    <div class="form-group">
                        <label class="control-label" for="answer-{{$dataTypeContent->getKey()}}">Answer</label>
                        <input type="text" id="answer-{{$dataTypeContent->getKey()}}" class="form-control"
                               name="answer-{{$dataTypeContent->getKey()}}">
                    </div>
                    <div class="form-group">
                        <label class="" for="is-correct-{{$dataTypeContent->getKey()}}">Is
                            Correct</label>
                        <input type="checkbox" id="is-correct-{{$dataTypeContent->getKey()}}" class="toggleswitch"
                               name="answer-{{$dataTypeContent->getKey()}}">
                    </div>
                    <div class="form-group">
                        <button type="submit" id="answer-submit" class="btn btn-primary save">Submit answer</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- End Delete File Modal -->



@section('javascript')
    <!-- DataTables -->

    <script>
        function addAnswerToList(answer) {
            $answerOptinos = $('.answer-options');
            var create = `<li>
            <input type="radio" id="option-` + answer.id + `"
                   name="answer"
                    ` + (answer.is_correct ? 'checked' : '') + `>
            <label for="option-` + answer.id + `">` + answer.title + `</label>
            <div class="check"></div>
        </li>`;
            console.log(answer.is_correct)
            $answerOptinos.append($(create));
        }

        function renewAnswerList(answers) {
            let answerOptions = $('.answer-options');
            answerOptions.empty();
            for (let i = 0; i < answers.length; i++) {
                let answer = answers[i];
                let isChecked = answer.is_correct ? '' : '<div class="remove-answer" data-answer-id="`+answer.id+`">x</div>';
                let create = `<li>
            <input type="radio" id="option-` + answer.id + `"
            data-answer-id="` + answer.id + `"
                   name="answer"
                    ` + (answer.is_correct ? 'checked' : '') + `>
            <label for="option-` + answer.id + `">` + answer.title + `</label>
            <div class="check"></div>
            ` + (answer.is_correct ? '' : '<div class="remove-answer" data-answer-id="'+answer.id+'">x</div>') + `
        </li>`;
                answerOptions.append($(create));
            }

            addRemoveAbility();
            onChangeAbility();

        }

        function  addRemoveAbility() {
            let removeAnswer = $('.remove-answer').click(function (event) {
                event.preventDefault();
                let $this = this;

                var params = {};
                var answerText = $('#answer-{{$dataTypeContent->getKey()}}');
                var isCorrect = $('#is-correct-{{$dataTypeContent->getKey()}}');
                params = {
                    id: $this.dataset.answerId,
                    question_id: '{{$dataTypeContent->getKey()}}',
                    _token: '{{ csrf_token() }}'
                }
                $.post('{{ route('admin/remove-answer') }}', params, function (response) {
                    if (response
                        && response.status
                        && response.status == 'success') {
                        if (response.data && response.data.answers) {
                            renewAnswerList(response.data.answers);
                            $('#add-answer-section').addClass('hide');
                        }
                    } else {
                        console.log('else');
                    }
                });

            })
        }

        function onChangeAbility(){
            $('input[type=radio][name=answer]').change(function(event) {
                event.preventDefault();
                let $this = this;

                var params = {};
                var answerText = $('#answer-{{$dataTypeContent->getKey()}}');
                params = {
                    id: $this.dataset.answerId,
                    question_id: '{{$dataTypeContent->getKey()}}',
                    _token: '{{ csrf_token() }}'
                }
                $.post('{{ route('admin/update-answer') }}', params, function (response) {
                    if (response
                        && response.status
                        && response.status == 'success') {
                        if (response.data && response.data.answers) {
                            renewAnswerList(response.data.answers);
                            $('#add-answer-section').addClass('hide');
                        }
                    } else {
                        console.log('else');
                    }
                });
            });
        }

        $(document).ready(function () {

            let addAnswerButton = $('#add-answer-button');
            addAnswerButton.click(function (event) {
                event.preventDefault();
                let addAnswerSection = $('#add-answer-section');
                addAnswerSection.removeClass('hide');

                let answerText = $('#answer-{{$dataTypeContent->getKey()}}');
                answerText.prop('required', true);
            });

            let submit = $('#answer-submit').click(function (event) {
                event.preventDefault();

                var params = {};
                var answerText = $('#answer-{{$dataTypeContent->getKey()}}');
                var isCorrect = $('#is-correct-{{$dataTypeContent->getKey()}}');
                params = {
                    id: '{{$dataTypeContent->getKey()}}',
                    answerText: answerText[0].value,
                    isCorrect: isCorrect[0].checked,
                    _token: '{{ csrf_token() }}'
                }
                if (params.answerText) {
                    $.post('{{ route('admin/submit-answer') }}', params, function (response) {
                        if (response
                            && response.status
                            && response.status == 'success') {
                            if (response.data && response.data.answers) {
                                renewAnswerList(response.data.answers);
                                $('#add-answer-section').addClass('hide');
                            }
                        } else {
                            console.log('else');
                        }
                    });
                } else {

                }

            })

            addRemoveAbility();
            onChangeAbility();
        })
    </script>

@stop
