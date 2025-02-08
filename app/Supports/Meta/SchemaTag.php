<?php

namespace App\Supports\Meta;

use Butschster\Head\Contracts\MetaTags\Entities\TagInterface;

class SchemaTag implements TagInterface
{
    public function __construct(protected string $schema){}

    public function toArray(): array
    {
        return [
            'type'=>'schema_tags',
            'contents' => $this->schema,
        ];
    }

    public function toHtml(): string
    {
        return $this->schema;
    }

    public function getPlacement(): string
    {
        return 'head_script_after';
    }
}
