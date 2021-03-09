@extends('layouts.app')


@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">创建话题</div>

                    <div class="card-body">

                        <form action="{{ route('questions.store') }}" method="POST">
                            @csrf
                            <div class="form-group">
                                <label for="title">标题</label>
                                <input type="text" name="title" class="form-control" value="{{ old('title') }}"
                                       id="title"
                                       placeholder="标题">
                                @if($errors->has('title'))
                                    <span class="help-block " style="color: #00a2d4">
                                        <strong>{{ $errors->first('title') }}</strong>
                                    </span>
                                @endif
                            </div>
                            <div class="form-group" >
                                <select  name="topics[]" class="js-example-placeholder-multiple form-control"
                                        multiple="multiple"></select>
                            </div>
                            <div class="form-group questions-editor">

                                <!-- 编辑器容器 -->
                                <div  id="editor" >
                                    <p>Hello World!</p>
                                    <p>Some initial <strong>bold</strong> text</p>
                                    <p><br></p>
                                </div>
                                <textarea hidden name="body" id="text1" style="width:100%; height:200px;"></textarea>
                            @if($errors->has('body'))
                                    <span class="help-block">
                                    <strong>{{ $errors->first('body') }}</strong>
                                </span>
                                @endif
                            </div>

                            <button style="float: right" class="btn btn-success pull-right" type="submit">发布问题</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>


@endsection
@section('footer-js')
    <script src="/js/select2/select2.js"></script>
    <!-- 配置文件 -->
    <script src="/js/ckeditor/ckeditor.js"></script>


    <script type="text/javascript">

        // In your Javascript (external .js resource or <script> tag)
        $(document).ready(function () {

            $(".js-example-placeholder-multiple").select2({
                tags: true,
                placeholder: '选择相关话题',
                ajax: {
                    url: '/api/topics',
                    data: function (params) {
                        var query = {
                            search: params.term,
                        }

                        // Query parameters will be ?search=[term]&page=[page]
                        return query;
                    }
                }
            });

        });
    </script>

@endsection
