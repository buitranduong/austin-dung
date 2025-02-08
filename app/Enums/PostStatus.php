<?php

namespace App\Enums;

use App\Traits\EnumToArray;

enum PostStatus: string
{
    use EnumToArray;
    case Draft = 'draft';
    case Published = 'published';
    case Archived = 'archived';
    case Pending = 'pending';
    case Rejected = 'rejected';
}
