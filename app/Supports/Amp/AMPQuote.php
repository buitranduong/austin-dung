<?php

namespace App\Supports\Amp;

use magyarandras\AMPConverter\TagConverterInterface;

class AMPQuote implements TagConverterInterface
{
    private array $necessary_scripts = [

    ];
    private array $prohibited_attributes = [
        'alt' => '*',
        'title' => '*',
    ];
    public function convert(\DOMDocument $doc): \DOMDocument
    {
        $xpath = new \DOMXPath($doc);

        foreach ($this->prohibited_attributes as $attribute=>$tags) {
            $entries = $xpath->query('//' . $tags . '[@'.$attribute.']');

            foreach ($entries as $entry) {
                $entry->setAttribute($attribute, htmlspecialchars(
                    $entry->getAttribute($attribute), ENT_QUOTES, 'UTF-8')
                );
                $entry->parentNode->replaceChild($entry, $entry);
            }
        }

        return $doc;
    }

    public function getNecessaryScripts(): array
    {
        return $this->necessary_scripts;
    }
}
