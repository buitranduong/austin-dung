@props([
    'title'=>'',
    'className'=>''
])
<div class="list-group">
    <h3>{{ $title }}</h3>
    <div class="{{ $className }}">
        {!! $slot !!}
    </div>
</div>
