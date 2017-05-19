@extends('base::layouts.master')

@push('styles')
<link rel="stylesheet" href="{{ asset('vendor/core/plugins/select2/select2.min.css') }}">
@endpush

@section('content')
    <div class="box box-primary">
        <div class="box-header with-border">
            <h3 class="box-title">基本信息</h3>
        </div>
        <form class="form-horizontal form-bordered" method="post" action="{{ route('categories.update', ['id' => $category->id]) }}">
            {{ csrf_field() }}
            <div class="box-body">
                <div class="form-group">
                    <label class="col-md-2 control-label">分类名称</label>
                    <div class="col-md-6">
                        <input class="form-control" name="title" title="title" value="{{ $category->title }}">
                        <p class="help-block">这将是它在站点上显示的名字。</p>
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-md-2 control-label">别名</label>
                    <div class="col-md-6">
                        <input class="form-control" name="slug" title="slug" value="{{ $category->slug }}">
                        <p class="help-block">“别名”是在URL中使用的别称，它可以令URL更美观。通常使用小写，只能包含字母，数字和连字符（-）。</p>
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-md-2 control-label">上级分类</label>
                    <div class="col-md-6">
                        <select name="parent_id" title="parent_id" class="form-control select2" data-placeholder="顶级分类">
                            @if(!$categories->isEmpty())
                                @include('blog::categories.partials.select', ['collection' => $categories])
                            @endif
                        </select>
                    </div>
                </div>
                <div class="form-group last">
                    <label class="col-md-2 control-label">排序</label>
                    <div class="col-md-6">
                        <input class="form-control" name="order" title="order" value="{{ $category->order }}">
                        <p class="help-block">数字范围为0~255，数字越小越靠前</p>
                    </div>
                </div>
            </div>
            <div class="box-footer">
                <div class="col-md-2"></div>
                <div class="col-md-6">
                    <a class="btn btn-primary" href="{{ route('categories.index') }}">返回列表</a>
                    <button type="submit" class="btn btn-primary">确认提交</button>
                </div>
            </div>
        </form>
    </div>
@endsection

@push('scripts')
<script src="//cdn.bootcss.com/select2/4.0.3/js/select2.min.js"></script>
<script src="//cdn.bootcss.com/select2/4.0.3/js/i18n/zh-CN.js"></script>
@endpush
@push('js')
<script>
    $('select').select2({
        language: "zh-CN"
    });
</script>
@endpush