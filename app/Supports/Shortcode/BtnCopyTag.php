<?php

namespace App\Supports\Shortcode;

use App\Supports\Meta\InlineStyleTag;
use Butschster\Head\Contracts\MetaTags\MetaInterface;

class BtnCopyTag
{
    protected const CSS = <<<END
        .btn-copy{
            border: 1px solid;
            padding: 5px;
            margin-left: 10px;
        }
    END;

    public function __construct(protected MetaInterface $meta){}

    public function register($shortcode): string
    {
        $content = '';
        if ($shortcode && method_exists($shortcode, 'toArray')) {
            $attributes = $shortcode->toArray();
            if (empty($attributes['content'])) {
                return '';
            }
            $content = $attributes['content'];
        }
        $this->meta->addTag('custom-style', new InlineStyleTag(static::CSS));
        return view('components.theme.shortcodes.btn-copy', compact('content'))->render();
    }
}
