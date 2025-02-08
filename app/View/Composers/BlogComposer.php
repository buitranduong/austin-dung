<?php

namespace App\View\Composers;

use App\Services\CacheModelService;

class BlogComposer
{
    public function compose($view): void
    {
        $categories = CacheModelService::getBlogCategories();
        $tags = CacheModelService::getBlogTags();
        $view->with(compact('categories', 'tags'));
    }
}
