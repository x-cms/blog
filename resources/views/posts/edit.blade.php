@extends('base::layouts.master')

@push('styles')
<link rel="stylesheet" href="{{ asset('vendor/core/plugins/editor/css/editormd.css') }}">
<link href="//cdn.bootcss.com/bootstrap-tagsinput/0.8.0/bootstrap-tagsinput.css" rel="stylesheet">
@endpush

@section('content')
    <form class="form-horizontal form-bordered" method="post" action="{{ route('posts.update', ['id' => $post->id]) }}">
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
                                    <textarea name="editormd-markdown-doc">{{ $post->content_markdown }}</textarea>
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
                        <h3 class="box-title">发布</h3>
                    </div>
                    <div class="box-footer">
                        <button type="submit" name="submit" class="btn btn-primary" value="1">保存草稿</button>
                        <button type="submit" name="submit" class="btn btn-primary" value="2">确认发布</button>
                    </div>
                </div>
            </div>
        </div>
    </form>
@endsection

@push('scripts')
<script src="{{ asset('vendor/core/plugins/editor/editormd.js') }}"></script>
<script src="//cdn.bootcss.com/typeahead.js/0.11.1/typeahead.bundle.min.js"></script>
<script src="//cdn.bootcss.com/bootstrap-tagsinput/0.8.0/bootstrap-tagsinput.min.js"></script>
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
</script>
@endpush