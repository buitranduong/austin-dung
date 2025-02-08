<?php

namespace App\Enums;

use App\Traits\EnumToArray;

enum PaymentType: string
{
    use EnumToArray;
    case COD = 'Cod';
    case BANK = 'Bank';
}
