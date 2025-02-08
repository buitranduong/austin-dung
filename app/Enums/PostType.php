<?php

namespace App\Enums;

use App\Traits\EnumToArray;

enum PostType: string
{
    use EnumToArray;
    case Post = 'post';
    case Page = 'page';
}
