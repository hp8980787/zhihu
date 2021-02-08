@extends('layouts.app')

@section('content')
    @include('vendor.ueditor.assets')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">创建话题</div>

                    <div class="card-body">
                        <form action="{{ route('questions.store') }}" method="POST">
                            <div class="form-group">
                                <label for="title">标题</label>
                                <input type="text" name="title" class="form-control" value="" id="title" placeholder="标题">
                            </div>

                        <!-- 编辑器容器 -->
                        <script id="container" name="content" type="text/plain"></script>

                        <button class="btn btn-success right" type="submit">发布问题</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script type="text/javascript">
        var ue = UE.getEditor('container');
        ue.ready(function() {
            ue.execCommand('serverparam', '_token', '{{ csrf_token() }}'); // 设置 CSRF token.
        });
    </script>


@endsection
