@props([
    'position'=>'end',
    'scroll'=>'false',
    'backdrop'=>'true',
    'id'=>'',
    'title'=>'',
    'style'=>''
])
<div style="{{ $style }}" class="offcanvas offcanvas-{{ $position }}" data-bs-scroll="{{ $scroll }}" data-bs-backdrop="{{ $backdrop }}" tabindex="-1" id="{{ $id }}" aria-labelledby="{{ $id }}-title">
    <div class="offcanvas-header">
        <h5 class="offcanvas-title" id="{{ $id }}-title">{{ $title }}</h5>
        <button type="button" class="btn-close" data-bs-dismiss="offcanvas" aria-label="Close"></button>
    </div>
    <div class="offcanvas-body">
        {!! $slot !!}
    </div>
</div>
