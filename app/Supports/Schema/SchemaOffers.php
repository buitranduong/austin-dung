<?php

namespace App\Supports\Schema;

class SchemaOffers
{
    public float $minPrice = 0;
    public float $maxPrice = 0;

    public int $offerCount = 0;
    public function __construct(array $offers)
    {
        foreach ($offers as $key=>$value) {
            if(isset($this->$key)){
                $this->$key = $value;
            }
        }
    }
}
