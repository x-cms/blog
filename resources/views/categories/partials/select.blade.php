@foreach($collection as $k => $v)
    @if($category->id != array_get($v, 'id') && $category->id != array_get($v, 'parent_id'))
    <option value="{{ array_get($v, 'id') }}">
        @for($i=1; $i< $loop->depth; $i++)
            —
        @endfor
        {{ array_get($v, 'title') }}
    </option>
    @endif
    @if(array_get($v, 'child'))
        @include('blog::categories.partials.select', ['collection' => array_get($v, 'child')])
    @endif
@endforeach