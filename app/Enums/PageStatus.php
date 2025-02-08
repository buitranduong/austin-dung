<?php

namespace App\Enums;

use App\Traits\EnumToArray;

enum PageStatus: string
{
    use EnumToArray;
    case Published = 'published';
    case Hidden = 'hidden';
}
