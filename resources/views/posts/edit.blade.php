@extends('base::layouts.master')

@push('styles')
<link rel="stylesheet" href="//cdn.bootcss.com/bootstrap-tagsinput/0.8.0/bootstrap-tagsinput.css">
<link rel="stylesheet" href="//cdn.bootcss.com/bootstrap-fileinput/4.3.8/css/fileinput.min.css">
<link rel="stylesheet" href="//cdn.bootcss.com/bootstrap-datetimepicker/4.17.47/css/bootstrap-datetimepicker.min.css">
<link rel="stylesheet" href="{{ asset('vendor/core/plugins/editor/css/editormd.css') }}">
@endpush

@push('css')
<link rel="stylesheet" href="{{ asset('vendor/core/media/css/storm.css') }}">
<link rel="stylesheet" href="{{ asset('vendor/core/media/css/october.css') }}">
<link rel="stylesheet" href="{{ asset('vendor/core/media/css/mediamanager.css') }}">
@endpush

@section('content')
    <form class="form-horizontal form-bordered" method="post" enctype="multipart/form-data" action="{{ route('posts.update', ['id' => $post->id]) }}">
        {{ csrf_field() }}
        <div class="row">
            <div class="col-md-9">
                <div class="box box-primary">
                    <div class="box-header with-border">
                        <h3 class="box-title">基本信息</h3>
                    </div>
                    <div class="box-body">
                        <div class="form-group">
                            <label class="col-md-2 control-label">文章标题</label>
                            <div class="col-md-6">
                                <input type="text"
                                       name="title"
                                       title="title"
                                       class="form-control"
                                       autocomplete="off"
                                       value="{{ $post->title }}"
                                >
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-md-2 control-label">别名</label>
                            <div class="col-md-6">
                                <input type="text"
                                       name="slug"
                                       title="slug"
                                       class="form-control"
                                       autocomplete="off"
                                       value="{{ $post->slug }}"
                                >
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-md-2 control-label">文章摘要</label>
                            <div class="col-md-6">
                                <textarea class="form-control" name="description"
                                          rows="5">{{ $post->description }}</textarea>
                            </div>
                        </div>
                        <div class="form-group last">
                            <label class="col-md-2 control-label">文章内容</label>
                            <div class="col-md-10">
                                <div id="editormd">
                                    <textarea name="editormd-markdown-doc">{{ $post->content }}</textarea>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="box box-primary">
                    <div class="box-header with-border">
                        <h3 class="box-title">文章分类</h3>
                    </div>
                    <div class="box-body">
                        {!! $categories !!}
                    </div>
                </div>
                <div class="box box-primary">
                    <div class="box-header with-border">
                        <h3 class="box-title">标签</h3>
                    </div>
                    <div class="box-body">
                        <select id="tags" name="tags[]" multiple data-role="tagsinput">
                            @foreach($post->tags as $tag)
                                <option value="{{ $tag->name }}">{{ $tag->name }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="box box-primary">
                    <div class="box-header with-border">
                        <h3 class="box-title">排序</h3>
                    </div>
                    <div class="box-body">
                        <input type="text" name="order" class="form-control" value="{{ $post->order }}"/>
                    </div>
                </div>
                <div class="box box-primary">
                    <div class="box-header with-border">
                        <h3 class="box-title">文章封面</h3>
                    </div>
                    <div class="box-body">
                        <input id="images" type="file" name="images[]" multiple data-show-upload="false"
                               data-allowed-file-extensions='["jpg", "png", "gif"]'>
                    </div>
                </div>
                <div class="box box-primary">
                    <div class="box-header with-border">
                        <h3 class="box-title">发布</h3>
                    </div>
                    <div class="box-body">
                        <div class="form-group">
                            <label class="coltrol-label">文章状态</label>
                            <select name="status" class="form-control">
                                <option value="0"  {{ $post->status == 0 ? 'selected' : '' }}>草稿</option>
                                <option value="1"  {{ $post->status == 1 ? 'selected' : '' }}>发布</option>
                            </select>
                        </div>
                        <div class="form-group m-t-15">
                            <label>发布时间</label>
                            <input name="published_at" type="text" class="form-control" id="datetimepicker"  value="{{ $post->published_at }}">
                        </div>
                    </div>
                    <div class="box-footer">
                        <a class="btn btn-primary" href="{{ route('posts.index') }}">返回列表</a>
                        <button type="submit" class="btn btn-primary">确认操作</button>
                    </div>
                </div>
            </div>
        </div>
    </form>
@endsection

@push('scripts')
<script src="//cdn.bootcss.com/typeahead.js/0.11.1/typeahead.bundle.min.js"></script>
<script src="//cdn.bootcss.com/bootstrap-tagsinput/0.8.0/bootstrap-tagsinput.min.js"></script>
<script src="//cdn.bootcss.com/moment.js/2.18.1/moment.min.js"></script>
<script src="//cdn.bootcss.com/moment.js/2.18.1/locale/zh-cn.js"></script>
<script src="//cdn.bootcss.com/bootstrap-datetimepicker/4.17.47/js/bootstrap-datetimepicker.min.js"></script>
<script src="//cdn.bootcss.com/bootstrap-fileinput/4.3.8/js/fileinput.min.js"></script>
<script src="//cdn.bootcss.com/bootstrap-fileinput/4.3.8/js/locales/zh.min.js"></script>
<script src="{{ asset('vendor/core/plugins/editor/editormd.js') }}"></script>
<script src="{{ asset('vendor/core/media/js/framework.js') }}"></script>
<script src="{{ asset('vendor/core/media/js/storm-min.js') }}"></script>
<script src="{{ asset('vendor/core/media/js/october-min.js') }}"></script>
<script src="{{ asset('vendor/core/media/js/mediamanager-browser-min.js') }}"></script>
@endpush

@push('js')
<script>
    let editor = editormd({
        id: "editormd",
        height: 640,
        toolbarAutoFixed: false,
        path: "/vendor/core/plugins/editor/lib/",
        saveHTMLToTextarea: true,
    });

    let tags = new Bloodhound({
        datumTokenizer: Bloodhound.tokenizers.obj.whitespace('name'),
        queryTokenizer: Bloodhound.tokenizers.whitespace,
        prefetch: {
            url: '{{ route('tags.json') }}',
            filter: function (list) {
                return $.map(list, function (tag) {
                    return {name: tag};
                });
            }
        }
    });

    tags.initialize();

    $('#tags').tagsinput({
        typeaheadjs: {
            name: 'tags',
            displayKey: 'name',
            valueKey: 'name',
            source: tags.ttAdapter()
        },
    });

    $("#images").fileinput({
        language: "zh",
        {{--uploadUrl: '{{ route('posts.upload') }}',--}}
        {{--uploadAsync: true--}}
    });

    $('#datetimepicker').datetimepicker({
        format: 'YYYY-MM-DD HH:mm:ss'
    });
</script>
@endpush