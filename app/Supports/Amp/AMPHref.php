<?php

namespace App\Supports\Amp;

use Illuminate\Support\Str;
use magyarandras\AMPConverter\TagConverterInterface;

class AMPHref implements TagConverterInterface
{
    private array $necessary_scripts = [

    ];

    //Base URL of the images
    private string $base_url;

    public function __construct($base_url = '')
    {
        $this->base_url = $base_url;
    }

    public function convert(\DOMDocument $doc): \DOMDocument
    {
        $query = '//a';

        $xpath = new \DOMXPath($doc);

        $entries = $xpath->query($query);

        $allowed_attributes = ['href'];

        foreach ($entries as $tag) {
            if ($tag->hasAttribute('href')) {
                foreach ($allowed_attributes as $attribute) {
                    if ($tag->hasAttribute($attribute) && !Str::startsWith($tag->getAttribute($attribute), 'http')) {
                        $tag->setAttribute($attribute, $this->base_url.$tag->getAttribute($attribute));
                    }
                }
                $tag->parentNode->replaceChild($tag, $tag);
            } else {
                $tag->parentNode->removeChild($tag);
            }
        }

        return $doc;
    }

    public function getNecessaryScripts(): array
    {
        return $this->necessary_scripts;
    }
}
