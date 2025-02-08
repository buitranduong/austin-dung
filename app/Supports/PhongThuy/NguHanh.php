<?php

namespace App\Supports\PhongThuy;

class NguHanh
{
    public static array $sinhKhac = [
        'Mộc' => ['sinh' => 'Hỏa', 'khắc' => 'Thổ'],
        'Hỏa' => ['sinh' => 'Thổ', 'khắc' => 'Kim'],
        'Thổ' => ['sinh' => 'Kim', 'khắc' => 'Thủy'],
        'Kim' => ['sinh' => 'Thủy', 'khắc' => 'Mộc'],
        'Thủy' => ['sinh' => 'Mộc', 'khắc' => 'Hỏa']
    ];
    // Định nghĩa các Thiên Can và Ngũ Hành tương ứng
    public static array $thienCan = [
        'Giáp' => 'Mộc', 'Ất' => 'Mộc',
        'Bính' => 'Hỏa', 'Đinh' => 'Hỏa',
        'Mậu' => 'Thổ', 'Kỷ' => 'Thổ',
        'Canh' => 'Kim', 'Tân' => 'Kim',
        'Nhâm' => 'Thủy', 'Quý' => 'Thủy'
    ];

    // Định nghĩa các Địa Chi và Ngũ Hành tương ứng
    public static array $diaChi = [
        'Tý' => 'Thủy', 'Sửu' => 'Thổ', 'Dần' => 'Mộc', 'Mão' => 'Mộc',
        'Thìn' => 'Thổ', 'Tỵ' => 'Hỏa', 'Ngọ' => 'Hỏa', 'Mùi' => 'Thổ',
        'Thân' => 'Kim', 'Dậu' => 'Kim', 'Tuất' => 'Thổ', 'Hợi' => 'Thủy'
    ];

    // Hàm xác định quan hệ giữa Thiên Can và Địa Chi theo Ngũ Hành
    function tinhTuongSinhKhac(string $can, string $chi): string
    {
        $nguHanh = ['Mộc', 'Hỏa', 'Thổ', 'Kim', 'Thủy'];

        $hanhCan = static::$thienCan[$can];
        $hanhChi = static::$diaChi[$chi];

        $indexCan = array_search($hanhCan, $nguHanh);
        $indexChi = array_search($hanhChi, $nguHanh);

        if ($indexCan === $indexChi) {
            return 'Cùng Hành';
        } elseif (($indexCan + 1) % 5 === $indexChi) {
            return 'Can Sinh Chi';
        } elseif (($indexChi + 1) % 5 === $indexCan) {
            return 'Can Được Chi Sinh';
        } elseif (($indexCan + 2) % 5 === $indexChi) {
            return 'Can Bị Chi Khắc';
        } elseif (($indexChi + 2) % 5 === $indexCan) {
            return 'Can Khắc Chi';
        } else {
            return 'Không xác định';
        }
    }

    public static function kiemTraSinhKhac(string $hanh1, string $hanh2): string
    {
        if (static::$sinhKhac[$hanh1]['sinh'] == $hanh2) return 'sinh';
        if (static::$sinhKhac[$hanh1]['khắc'] == $hanh2) return 'khắc';
        return 'bình';
    }

    public static function tuongSinh(string $hanh): string
    {
        return static::$sinhKhac[$hanh]['sinh'];
    }
}
