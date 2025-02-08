<?php

namespace App\Enums;

class PhongThuyMenu
{
    public const MENU_TOP = [
        [
            "title" => "Tìm sim phong thủy",
            "link" => "/sim-phong-thuy",
        ],
        [
            "title" => "Xem bói phong thủy sim",
            "link" => "/xem-phong-thuy-sim",
        ],
    ];
    public const MENU_SIM_HOP_MENH = [
        [
            "title" => "Sim hợp mệnh Kim",
            "link" => "/sim-hop-menh-kim",
        ],
        [
            "title" => "Sim hợp mệnh Mộc",
            "link" => "/sim-hop-menh-moc",
        ],
        [
            "title" => "Sim hợp mệnh Thủy",
            "link" => "/sim-hop-menh-thuy",
        ],
        [
            "title" => "Sim hợp mệnh Hỏa",
            "link" => "/sim-hop-menh-hoa",
        ],
        [
            "title" => "Sim hợp mệnh Thổ",
            "link" => "/sim-hop-menh-tho",
        ],
    ];
    public const MENU_SIM_HOP_TUOI = [
        [
            "title" => "Sim hợp tuổi Tý",
            "link" => "/sim-hop-tuoi-ty",
        ],
        [
            "title" => "Sim hợp tuổi Sửu",
            "link" => "/sim-hop-tuoi-suu",
        ],
        [
            "title" => "Sim hợp tuổi Dần",
            "link" => "/sim-hop-tuoi-dan",
        ],
        [
            "title" => "Sim hợp tuổi Mão",
            "link" => "/sim-hop-tuoi-mao",
        ],
        [
            "title" => "Sim hợp tuổi Thìn",
            "link" => "/sim-hop-tuoi-thin",
        ],
        [
            "title" => "Sim hợp tuổi Tị",
            "link" => "/sim-hop-tuoi-ti",
        ],
        [
            "title" => "Sim hợp tuổi Ngọ",
            "link" => "/sim-hop-tuoi-ngo",
        ],
        [
            "title" => "Sim hợp tuổi Mùi",
            "link" => "/sim-hop-tuoi-mui",
        ],
        [
            "title" => "Sim hợp tuổi Thân",
            "link" => "/sim-hop-tuoi-than",
        ],
        [
            "title" => "Sim hợp tuổi Dậu",
            "link" => "/sim-hop-tuoi-dau",
        ],
        [
            "title" => "Sim hợp tuổi Tuất",
            "link" => "/sim-hop-tuoi-tuat",
        ],
        [
            "title" => "Sim hợp tuổi Hợi",
            "link" => "/sim-hop-tuoi-hoi",
        ],
    ];

    public const OPTION_GIO_SINH = [
        1=> 'Tý (23-12h)',
        99=>'Tý (12-01h)',
        2=>'Sửu (1h-3h)',
        3=>'Dần (3h-5h)',
        4=>'Mão (5h-7h)',
        5=>'Thìn (7h-9h)',
        6=>'Tỵ (9h-11h)',
        7=>'Ngọ (11h-13h)',
        8=>'Mùi (13h-15h)',
        9=>'Thân (15h-17h)',
        10=>'Dậu (17h-19h)',
        11=>'Tuất (19h-21h)',
        12=>'Hợi (21h-23h)'
    ];

    public const OPTION_NGAY_SINH = [
        '01',
        '02',
        '03',
        '04',
        '05',
        '06',
        '07',
        '08',
        '09',
        '10',
        '11',
        '12',
        '13',
        '14',
        '15',
        '16',
        '17',
        '18',
        '19',
        '20',
        '21',
        '22',
        '23',
        '24',
        '25',
        '26',
        '27',
        '28',
        '29',
        '30',
        '31',
    ];

    public const OPTION_THANG_SINH = [
        '01',
        '02',
        '03',
        '04',
        '05',
        '06',
        '07',
        '08',
        '09',
        '10',
        '11',
        '12',
    ];
}
