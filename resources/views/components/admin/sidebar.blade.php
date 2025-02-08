<div class="d-flex flex-column flex-shrink-0 p-2 bg-body-tertiary full-height w-sidebar">
    <ul class="nav nav-pills flex-column mb-auto">
        @if(!empty($sidebarMenuItems))
            @foreach($sidebarMenuItems as $item)
                <li class="nav-item border-bottom">
                    <a href="{{ $item->url }}" class="nav-link {{ $item->active ? 'active' : 'link-body-emphasis' }} {{ count($item->children) ? 'collapsed' :'' }}" @if(count($item->children)) data-bs-toggle="collapse" data-bs-target="#collapse{{ $item->id }}" aria-expanded="true" @endif aria-current="page">
                        @if($item->icon)
                            <i class="bi bi-{{ $item->icon }} fw-bold fs-5"></i>
                        @endif
                        {{ $item->name }}
                    </a>
                    @if(count($item->children))
                        <div class="collapse show ps-4" id="collapse{{ $item->id }}">
                            <ul class="btn-toggle-nav list-unstyled fw-normal pb-1">
                                @foreach($item->children as $children)
                                    <li class="py-1">
                                        <a href="{{ $children->url }}" class="{{ $children->active ? 'active' : 'link-body-emphasis' }} d-inline-flex text-decoration-none rounded gap-1">
                                            @if($children->icon)
                                                <i class="bi bi-{{ $children->icon }}"></i>
                                            @endif
                                            {{ $children->name }}
                                        </a>
                                    </li>
                                @endforeach
                            </ul>
                        </div>
                    @endif
                </li>
            @endforeach
        @endif
    </ul>
</div>
