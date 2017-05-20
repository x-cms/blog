@extends('base::layouts.master')

@section('content')
<div class="box box-info">
    <div class="box-header with-border">
        <div class="pull-left">
            <p>
                <a class="btn btn-success" href="{{ route('categories.index') }}">
                    <i class="fa fa-mail-reply"></i>&nbsp;&nbsp;返回分类列表
                </a>
            </p>
        </div>
    </div>
    <div class="box-body">
        <div class="dd" id="nestable">
            @if(!$categories->isEmpty())
                @include('blog::categories.partials.nestable', ['collection' => $categories])
            @endif
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script src="//cdn.bootcss.com/Nestable/2012-10-15/jquery.nestable.min.js"></script>
@endpush

@push('js')
<script>
    $('.dd').nestable().on('change',function () {
        let list = window.JSON.stringify($('#nestable').nestable('serialize'));
        $.ajax({
            url:'/admin/categories/reorder',
            data:{
                nestable:list,
                _token: '{{ csrf_token() }}'
            },
            type: 'post',
            dataType:'json',
            success:function (response) {
                if (response.status) {
                    alert(response.message);
                }
            }
        });
    });

    $('#collapse').on('click', function () {
        if ($(this).children().hasClass('fa-minus')) {
            $(this).children().removeClass('fa-minus').addClass('fa-plus');
            $('.dd').nestable('collapseAll');
        } else {
            $(this).children().removeClass('fa-plus').addClass('fa-minus');
            $('.dd').nestable('expandAll');
        }
    });

    function del(id) {
        let tpl = '您确定要删除该分类吗?'
        $.Confirm({
            url: '/admin/categories/' + id,
            method: 'DELETE',
            data: {
                Id: id
            },
            content: tpl
        });
    }

</script>
@endpush