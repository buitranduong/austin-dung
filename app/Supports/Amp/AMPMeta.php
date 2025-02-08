<?php

namespace App\Supports\Amp;

use DOMException;
use magyarandras\AMPConverter\TagConverterInterface;

class AMPMeta implements TagConverterInterface
{
    private array $necessary_scripts = [

    ];

    public function __construct(){}

    /**
     * @throws DOMException
     */
    public function convert(\DOMDocument $doc): \DOMDocument
    {
        $query = '//meta';

        $xpath = new \DOMXPath($doc);

        $entries = $xpath->query($query);

        foreach ($entries as $tag) {
            $tag->parentNode->removeChild($tag);
        }

        return $doc;
    }

    public function getNecessaryScripts(): array
    {
        return $this->necessary_scripts;
    }
}
