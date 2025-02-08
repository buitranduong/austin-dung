<?php

namespace App\Supports\Meta;

use Butschster\Head\Contracts\MetaTags\Entities\TagInterface;

class InlineStyleTag implements TagInterface
{
    public function __construct(protected string $css){}

    public function toArray(): array
    {
        return [
            'type'=>'inline_css_tag',
            'contents' => $this->css,
        ];
    }

    public function toHtml(): string
    {
        return '<style>'.$this->css.'</style>';
    }

    public function getPlacement(): string
    {
        return 'head_script_after';
    }
}
