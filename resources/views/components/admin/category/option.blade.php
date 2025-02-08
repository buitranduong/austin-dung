@props([
    'category'=>'',
    'tag'=>'',
    'selected'=>''
])
@if(!empty($category))
    <option value="{{ $category->id }}" @if(!empty($selected) && $selected == $category->id) selected @endif>
        @if($category->parent_id)
            --
        @endif
        {{ $category->name }}
    </option>
    @foreach($category->children as $category)
        <x-admin.category.option :category="$category" :selected="$selected"/>
    @endforeach
@endif

@if(!empty($tag))
    <option value="{{ $tag->id }}" @if(!empty($selected) && in_array($tag->id, $selected)) selected @endif>{{ $tag->name }}</option>
    @foreach($tag->children as $tag)
        <x-admin.category.option :tag="$tag" :selected="$selected"/>
    @endforeach
@endif
