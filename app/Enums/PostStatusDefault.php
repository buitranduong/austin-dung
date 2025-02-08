<?php

namespace App\Enums;

use App\Traits\EnumToArray;

enum PostStatusDefault: string
{
    use EnumToArray;
    case Draft = 'draft';
    case Pending = 'pending';
}
