@extends('layouts.app')

@section('content')

    <div class="container">

        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">消息通知</div>

                    <div class="card-body">
                        @foreach($user->notifications as $notification)
                            @include('notifications.'.strtolower(class_basename($notification->type)))
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- 实例化编辑器 -->

@endsection

