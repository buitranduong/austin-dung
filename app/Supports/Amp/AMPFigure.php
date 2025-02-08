<?php

namespace App\Supports\Amp;

use magyarandras\AMPConverter\TagConverterInterface;

class AMPFigure implements TagConverterInterface
{
    private array $necessary_scripts = [

    ];
    public function convert(\DOMDocument $doc): \DOMDocument
    {
        $query = '//figure[@width]';

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
