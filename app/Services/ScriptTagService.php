<?php

namespace App\Services;

use Butschster\Head\Contracts\MetaTags\Entities\TagInterface;

readonly class ScriptTagService implements TagInterface
{
    public function __construct(
        private ?string $script,
        private string  $placement)
    {

    }
    public function toArray(): array
    {
        return [
            'script' => $this->script,
            'placement' => $this->placement,
        ];
    }

    public function toHtml(): ?string
    {
        return $this->script;
    }

    public function getPlacement(): string
    {
        return $this->placement;
    }
}
