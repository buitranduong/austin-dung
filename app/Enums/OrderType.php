<?php

namespace App\Enums;

use App\Traits\EnumToArray;

enum OrderType: string
{
    use EnumToArray;
    case COMMON = 'Common';
    case INSTALLMENT = 'Installment';
    case REQUEST = 'Request';
}
