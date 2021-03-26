@extends('layouts.app')

@section('content')

    <div class="container">

        <div class="row justify-content-center">
            @include('notifications._left')
            <div class="col-md-8">
                <ul class="liset-group-item">
                    @foreach($user->unreadNotifications as $notification)
                        <li class="list-group-item">
                            <div class="card">
                                <div class="card-text btn-warning">
                                    {{ $notification->data['name'] }} 在{{ $notification->created_at }} 关注了你
                                    {{ $notification->markAsRead() }}
                                </div>

                            </div>
                        </li>
                    @endforeach
                    @foreach($user->notifications as $notification)
                        <li class="list-group-item">
                            <div class="card">
                                <div class="card-text">
                                    {{ $notification->data['name'] }} 在{{ $notification->created_at }} 关注了你
                                </div>

                            </div>
                        </li>
                    @endforeach
                </ul>
            </div>
        </div>
    </div>
    <!-- 实例化编辑器 -->

@endsection

