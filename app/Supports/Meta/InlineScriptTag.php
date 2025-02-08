<?php

namespace App\Supports\Meta;

use Butschster\Head\Contracts\MetaTags\Entities\TagInterface;

class InlineScriptTag implements TagInterface
{
    public function __construct(protected string $js){}

    public function toArray(): array
    {
        return [
            'type'=>'inline_js_tag',
            'contents' => $this->js,
        ];
    }

    public function toHtml(): string
    {
        return '<script>'.$this->js.'</script>';
    }

    public function getPlacement(): string
    {
        return 'head_script_after';
    }
}
