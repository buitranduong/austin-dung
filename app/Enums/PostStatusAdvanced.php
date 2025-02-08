<?php

namespace App\Enums;

use App\Traits\EnumToArray;

enum PostStatusAdvanced: string
{
    use EnumToArray;

    case Published = 'published';
    case Archived = 'archived';
    case Rejected = 'rejected';
}
