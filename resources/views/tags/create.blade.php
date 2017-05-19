@extends('base::layouts.master')

@section('content')
    <div class="box box-primary">
        <div class="box-header with-border">
            <h3 class="box-title">基本信息</h3>
        </div>
        <form class="form-horizontal form-bordered" method="post" action="{{ route('tags.store') }}">
            {{ csrf_field() }}
            <div class="box-body">
                <div class="form-group">
                    <label class="col-md-2 control-label">标签名称</label>
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
                    <label class="col-md-2 control-label">排序</label>
                    <div class="col-md-6">
                        <input type="text"
                               name="order"
                               title="order"
                               class="form-control"
                               autocomplete="off"
                               value="0"
                        >
                    </div>
                </div>
            </div>
            <div class="box-footer">
                <div class="col-md-2"></div>
                <div class="col-md-6">
                    <a class="btn btn-primary" href="{{ route('tags.index') }}">返回列表</a>
                    <button type="submit" class="btn btn-primary">确认提交</button>
                </div>
            </div>
        </form>
    </div>
@endsection