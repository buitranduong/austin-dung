<?php

namespace App\Enums;

use App\Traits\EnumToArray;

enum SimProviders: string
{
    use EnumToArray;
    case Viettel = 'viettel';
    case Vinaphone = 'vinaphone';
    case Mobifone = 'mobifone';
    case Itelecom = 'itel';
    case Vietnamobile = 'vietnamobile';
    case Gmobile = 'gmobile';
    case Wintel = 'wintel';
    case Mayban = 'mayban';

    public function brand(): string
    {
        return match ($this) {
            self::Viettel => 'icon_viettel.svg',
            self::Vinaphone => 'icon_vinaphone.svg',
            self::Mobifone => 'icon_mobiphone.svg',
            self::Itelecom => 'icon_itel.svg',
            self::Vietnamobile => 'icon_vietnamobile.svg',
            self::Gmobile => 'icon_mobile.svg',
            self::Wintel => 'icon_wintel.svg',
            self::Mayban => 'icon_phone.svg',
        };
    }
}
