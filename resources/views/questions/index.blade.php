@extends('layouts.app')

@section('content')

    <div class="container">
        <div class="row"></div>
        <div class="col-md-8 offset-md-2">
            <ul class="list-unstyled">
                @foreach($questions as $question)
                    <li class="media" style="margin: 30px 30px">
                        <a href="{{ route('questions.show',$question->id) }}">
                            <img src="{{ $question->user->avatar }}" width="50px" class="align-self-start mr-3"
                                 alt="{{ $question->user->name }}"></a>
                        <div class="media-body">
                            <h5 class="mt-0">
                                <a href="{{ route('questions.show',$question->id) }}">{{ $question->title }}</a></h5>
                            <ul class="list-inline topics">
                                @foreach($question->topics as $topic)
                                    <li class="list-inline-item"><a href="#">{{ $topic->name }}</a></li>
                                @endforeach
                            </ul>
                            <span>{{ $question->answers_count }}个回复</span>
                        </div>
                    </li>
                @endforeach

            </ul>
            {{ $questions->links() }}
        </div>

    </div>
    <!-- 实例化编辑器 -->

@endsection

