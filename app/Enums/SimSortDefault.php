<?php

namespace App\Enums;

use App\Traits\EnumToArray;

enum SimSortDefault: string
{
    use EnumToArray;
    case Random = '0';
    case Asc = '-1';
    case Desc = '1';
}
