@extends('layouts.app')

@section('content')

    <div class="container">

        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">

                    <div class="card-header">
                        <div class="float-left" >
                                <h1>{{ $question->title }}</h1>
                        </div>


                        <div class="action float-right">
                            @if(Auth::check() && Auth::user()->owns($question))
                                <span class="edit"><button class="btn btn-info"><a
                                            href="{{ route('questions.edit',$question->id) }}">编辑</a></button></span>
                                <form action="{{ route('questions.destroy',$question->id) }}" method="POST">
                                    @csrf
                                    @method('delete')
                                    <button class="btn btn-warning" type="submit">删除</button>
                                </form>
                            @endif
                        </div>
                    </div>

                    <ul class="list-inline topics">
                        @foreach($question->topics as $topic)
                            <li class="list-inline-item"><a href="#">{{ $topic->name }}</a></li>
                        @endforeach
                    </ul>

                    <div class="card-body">

                        {!! $question->body !!}
                    </div>

                </div>
            </div>
        </div>
    </div>
    <!-- 实例化编辑器 -->

@endsection

