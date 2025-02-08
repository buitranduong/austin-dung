<?php

namespace App\Supports\Amp;

use magyarandras\AMPConverter\TagConverterInterface;

class AMPTable implements TagConverterInterface
{
    private array $necessary_scripts = [

    ];
    public function convert(\DOMDocument $doc): \DOMDocument
    {
        $query = '//table[@summary]';

        $xpath = new \DOMXPath($doc);

        $entries = $xpath->query($query);

        foreach ($entries as $tag) {
            $tag->removeAttribute("summary");
        }

        return $doc;
    }

    public function getNecessaryScripts(): array
    {
        return $this->necessary_scripts;
    }
}
