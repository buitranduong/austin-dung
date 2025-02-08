<?php

namespace App\Supports\Amp;

use DOMException;
use Illuminate\Support\Str;
use magyarandras\AMPConverter\TagConverterInterface;
use magyarandras\AMPConverter\Util\ImageSize;

class AMPImg implements TagConverterInterface
{
    private array $necessary_scripts = [

    ];

    //Base URL of the images
    private string $base_url;

    //Time limit for acquiring image dimensions in seconds
    private int $timeout;

    public function __construct($base_url = '', $timeout = 10)
    {
        $this->base_url = $base_url;
        $this->timeout = $timeout;
    }

    /**
     * @throws DOMException
     */
    public function convert(\DOMDocument $doc): \DOMDocument
    {
        $query = '//img';

        $xpath = new \DOMXPath($doc);

        $entries = $xpath->query($query);

        $allowed_attributes = ['src', 'width', 'height', 'alt', 'srcset', 'sizes'];

        foreach ($entries as $tag) {
            if ($tag->hasAttribute('src')) {
                $img = $doc->createElement('amp-img');

                if (!$tag->hasAttribute('width') || !$tag->hasAttribute('height')) {
                    $imageSize = ImageSize::getImageSize(
                        $this->base_url,
                        $tag->getAttribute('src'),
                        $this->timeout
                    );

                    if ($imageSize) {
                        $img->setAttribute('width', $imageSize['width']);
                        $img->setAttribute('height', $imageSize['height']);
                    } else {
                        $tag->parentNode->removeChild($tag);
                        continue;
                    }
                }

                foreach ($allowed_attributes as $attribute) {
                    if ($tag->hasAttribute($attribute)) {
                        if($attribute == 'src' && !Str::startsWith($tag->getAttribute($attribute), 'http')) {
                            $img->setAttribute($attribute, $this->base_url.$tag->getAttribute($attribute));
                        }else{
                            $img->setAttribute($attribute, $tag->getAttribute($attribute));
                        }
                    }
                }

                $img->setAttribute('layout', 'responsive');

                $tag->parentNode->replaceChild($img, $tag);
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
