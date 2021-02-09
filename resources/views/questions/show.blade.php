@extends('layouts.app')

@section('content')

    <div class="container">

        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">{{ $questions->title }}</div>

                    <div class="card-body">

                        {!! $questions->body !!}
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- 实例化编辑器 -->

@endsection

