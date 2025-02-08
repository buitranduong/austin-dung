<?php

namespace App\Enums;

use App\Traits\EnumToArray;

enum CategoryType: string
{
    use EnumToArray;
    case Tags = 'tags';
    case Category = 'category';
}
