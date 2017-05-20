@extends('base::layouts.master')

@push('styles')
<link rel="stylesheet" href="{{ asset('vendor/core/plugins/editor/css/editormd.css') }}">
@endpush

@section('content')
    <form class="form-horizontal form-bordered" method="post" action="{{ route('posts.store') }}">
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
                                >
                            </div>
                        </div>
                        <div class="form-group last">
                            <label class="col-md-2 control-label">文章内容</label>
                            <div class="col-md-10">
                                <div id="editormd">
                                            <textarea class="editormd-markdown-textarea"
                                                      name="content_markdown"></textarea>
                                    <textarea class="editormd-html-textarea" name="content_html"></textarea>
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
                        <select name="category_id" id="category_id"
                                class="form-control select2">
                            <option value="0">请选择文章分类</option>
                        </select>
                    </div>
                </div>
                <div class="box box-primary">
                    <div class="box-header with-border">
                        <h3 class="box-title">标签</h3>
                    </div>
                    <div class="box-body">
                        <input type="text" id="tags" name="tags" class="form-control" data-role="tagsinput"/>
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
</script>
@endpush