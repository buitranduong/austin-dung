@props([
    'color' => 'success',
    'dismissible' => false,
])

<div {{ $attributes->class(['alert alert-' . $color . ' fade show mb-0','alert-dismissible' => $dismissible,]) }} role="alert">
    {{ $label ?? $slot }}
    @if($dismissible)
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    @endif
</div>
