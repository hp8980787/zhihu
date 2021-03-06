@extends('layouts.app')
@section('header_css')

    <link rel="stylesheet" href="{{ asset('css/tiny/tinymce.css') }}">
@stop
@section('content')

    <div class="container">
        <div class="row">
            <div class="col-md-8 offset-1">
                <div class="row justify-content-center">
                    <div class="col-md-12">
                        <div class="card">
                            <div class="card-header">
                                <div class="float-left">
                                    <h1>{{ $question->title }}</h1>
                                </div>
                                <div class="action float-right">
                                    @if(Auth::check() && Auth::user()->owns($question))
                                        <span class="edit"><button class="btn btn-info"><a
                                                    href="{{ route('questions.edit',$question->id) }}">编辑</a></button></span>
                                        <form action="{{ route('questions.destroy',$question->id) }}" method="POST">
                                            @csrf
                                            @method('delete')
                                            <button class="btn btn-danger" type="submit">删除</button>
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

                    <div class="col-md-12">

                        <question-answer question="{{ $question->id }}" user="{{ Auth::user() }}"></question-answer>

                        <div>
                            @if(Auth::check())
                                <form action="{{ route('answers.store',$question->id) }}" method="POST">
                                    @csrf
                                    <div class="form-group questions-editor">

                                        <!-- 编辑器容器 -->
                                        <textarea name="body" id="mytextarea">Hello, World!</textarea>

                                        @if($errors->has('body'))
                                            <span class="help-block">
                                    <strong>{{ $errors->first('body') }}</strong>
                                </span>
                                        @endif
                                    </div>
                                    <div class="text-right">
                                        <button class="btn btn-success" type="submit">提交</button>
                                    </div>
                                </form>
                            @else

                                <a href="{{ route('login') }}" class="btn btn-info btn-block">登录后评论</a>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                @if(Auth::check()&&Auth::id()!=$question->user_id)
                    <question-follow-button question="{{ $question->id }}"></question-follow-button>
                @elseif(Auth::check()&&Auth::id()==$question->user_id)
                    <div class="card">
                        <div class="card-header" style="text-align: center">
                            <h4>{{ $question->followers_count }}</h4>
                            <span>关注者</span>
                        </div>
                        <div class="card-body">
                            <a class="btn btn-success" href="javascript:;">已关注该问题</a>
                            <a href="#">撰写答案</a>
                        </div>
                    </div>
                @else
                    <div class="card">
                        <div class="card-header" style="text-align: center">
                            <h4>{{ $question->followers_count }}</h4>
                            <span>关注者</span>
                        </div>
                        <div class="card-body">
                            <a href="{{ route('login') }}">关注该问题</a>
                            <a href="{{ route('login') }}">撰写答案</a>
                        </div>
                    </div>
                @endif
                <div class="cart about-author">
                    <span>关于作者</span>
                    <div class="cart-header clearfix">
                        <div class="float-left"><img src="{{ $question->user->avatar }}"
                                                     alt="{{ $question->user->name }}"></div>
                        <div class="float-right">
                            <h4>{{ $question->user->name }}</h4>
                            <span>这是我的测试测试测....</span>
                        </div>
                    </div>
                    <div class="cart-body author-item clearfix">
                        <div class="float-left">
                            <div>回答</div>
                            <strong>1</strong>
                        </div>
                        <div class="float-left">
                            <div>文章</div>
                            <strong>1</strong>

                        </div>
                        <div class="float-left">
                            <div>关注者</div>
                            <strong>{{ $question->user->followers_count }}</strong>
                        </div>
                    </div>

                    <message-user questionuser="{{ $question->user->name }}" user="{{ auth()->user() }}"
                                  followed_id="{{ $question->user->id }}"></message-user>
                </div>

            </div>
        </div>

    </div>
    <!-- 实例化编辑器 -->

@endsection
@section('footer-js')
    <script src="{{ asset('js/tiny/tiny.js') }}"></script>
@endsection
