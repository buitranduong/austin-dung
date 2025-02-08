<?php

namespace App\Supports\Amp;

use magyarandras\AMPConverter\TagConverterInterface;

class AMPDiv implements TagConverterInterface
{
    private array $necessary_scripts = [

    ];
    public function convert(\DOMDocument $doc): \DOMDocument
    {
        $query = '//div[@width]';

        $xpath = new \DOMXPath($doc);

        $entries = $xpath->query($query);

        foreach ($entries as $tag) {
            $tag->removeAttribute("width");
        }

        return $doc;
    }

    public function getNecessaryScripts(): array
    {
        return $this->necessary_scripts;
    }
}
