<ol class="dd-list">
    @foreach($collection as $category)
        <li class="dd-item dd3-item" data-id="{{ array_get($category, 'id') }}">
            <div class="dd-handle dd3-handle"></div>
            <div class="dd3-content">
                <span>{{ array_get($category, 'name') }}</span>
                {{--<div class="pull-right">--}}
                    {{--<a href="{{ route('categories.edit', array_get($category, 'id')) }}"><i class="fa fa-edit"></i></a>--}}
                    {{--<a href="javascript:;" onclick="del({{ array_get($category, 'id') }})"><i class="fa fa-trash"></i></a>--}}
                {{--</div>--}}
            </div>
            @if(array_get($category, 'child'))
                @include('blog::categories.partials.nestable', ['collection' => array_get($category, 'child')])
            @endif
        </li>
    @endforeach
</ol>
