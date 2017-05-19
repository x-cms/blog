@foreach($collection as $k => $v)
    {{ $category->id }}
    {{ $category->parent_id }}
    @if($category->id != $v->id)
    <option value="{{ $v->id }}" {{ $category->parent_id == $v->id ? 'selected' : '' }}>
        @for($i=1; $i< $loop->depth; $i++)
            —
        @endfor
        {{ $v->name }}
    </option>
    @endif
    @if(isset($categories[$v->id]))
        @include('blog::category.partials.select', ['collection' => $categories[$v->id]])
    @endif
@endforeach