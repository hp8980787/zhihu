@extends('layouts.app')

@section('content')

    <div class="container">

        <div class="row justify-content-center">
            @include('notifications._left')
            <div class="col-md-8">
                <ul class="liset-group-item">
                    @foreach($messages as $message)
                    <li class="list-group-item" style="background: #ccc">
                        <div class="card">
                            <div class="card-header">
                                <div class="float-left">
                                    <img  width="30px" src=" {{ $message->fromUser->avatar }}" alt="{{ $message->fromUser->name }}">
                                    <span>{{ $message->fromUser->name }}</span>
                                    {{ $message->hasred() }}
                                </div>

                            </div>
                            <div class="card-body"> <p> {!! $message->body !!}</p></div>
                        </div>

                    </li>
                    @endforeach
                </ul>
            </div>
        </div>
    </div>
    <!-- 实例化编辑器 -->

@endsection

