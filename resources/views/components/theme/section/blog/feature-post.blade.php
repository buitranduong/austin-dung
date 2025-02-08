@props(['posts'=>''])
<div class="d-flex post-large-block mb-40">
    <div class="post-main-block">
        <x-theme.block.blog.post-item className="blogs-large" :post="$feature_post"/>
    </div>
    <div class="new-secondary-block">
        <div class="list-post">
            @if($posts)
                @foreach($posts as $post)
                    <x-theme.block.blog.post-item className="blogs-normal-item" :$post/>
                @endforeach
            @endif
        </div>
    </div>
</div>
