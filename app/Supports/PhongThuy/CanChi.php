<?php

namespace App\Supports\PhongThuy;

class CanChi
{
    public static array $thienCanNam = [
        'Canh', // 0
        'Tân',  // 1
        'Nhâm', // 2
        'Quý',  // 3
        'Giáp', // 4
        'Ất',   // 5
        'Bính', // 6
        'Đinh', // 7
        'Mậu',  // 8
        'Kỷ'    // 9
    ];

    public static array $diaChiNam = [
        'Tý',   // 0
        'Sửu',  // 1
        'Dần',  // 2
        'Mão',  // 3
        'Thìn', // 4
        'Tỵ',   // 5
        'Ngọ',  // 6
        'Mùi',  // 7
        'Thân', // 8
        'Dậu',  // 9
        'Tuất', // 10
        'Hợi'   // 11
    ];

    public static array $thienCanThang = [
        'Giáp'=>[
            1=>'Bính',
            2=>'Đinh',
            3=>'Mậu',
            4=>'Kỷ',
            5=>'Canh',
            6=>'Tân',
            7=>'Nhâm',
            8=>'Quý',
            9=>'Giáp',
            10=>'Ất',
            11=>'Bính',
            12=>'Đinh'
        ],
        'Kỷ'=>[
            1=>'Bính',
            2=>'Đinh',
            3=>'Mậu',
            4=>'Kỷ',
            5=>'Canh',
            6=>'Tân',
            7=>'Nhâm',
            8=>'Quý',
            9=>'Giáp',
            10=>'Ất',
            11=>'Bính',
            12=>'Đinh'
        ],
        'Ất'=>[
            1=>'Mậu',
            2=>'Kỷ',
            3=>'Canh',
            4=>'Tân',
            5=>'Nhâm',
            6=>'Quý',
            7=>'Giáp',
            8=>'Ất',
            9=>'Bính',
            10=>'Đinh',
            11=>'Mậu',
            12=>'Kỷ'
        ],
        'Canh'=>[
            1=>'Mậu',
            2=>'Kỷ',
            3=>'Canh',
            4=>'Tân',
            5=>'Nhâm',
            6=>'Quý',
            7=>'Giáp',
            8=>'Ất',
            9=>'Bính',
            10=>'Đinh',
            11=>'Mậu',
            12=>'Kỷ'
        ],
        'Bính'=>[
            1=>'Canh',
            2=>'Tân',
            3=>'Nhâm',
            4=>'Quý',
            5=>'Giáp',
            6=>'Ất',
            7=>'Bính',
            8=>'Đinh',
            9=>'Mậu',
            10=>'Kỷ',
            11=>'Canh',
            12=>'Tân'
        ],
        'Tân'=>[
            1=>'Canh',
            2=>'Tân',
            3=>'Nhâm',
            4=>'Quý',
            5=>'Giáp',
            6=>'Ất',
            7=>'Bính',
            8=>'Đinh',
            9=>'Mậu',
            10=>'Kỷ',
            11=>'Canh',
            12=>'Tân'
        ],
        'Đinh'=>[
            1=>'Nhâm',
            2=>'Quý',
            3=>'Giáp',
            4=>'Ất',
            5=>'Bính',
            6=>'Đinh',
            7=>'Mậu',
            8=>'Kỷ',
            9=>'Canh',
            10=>'Tân',
            11=>'Nhâm',
            12=>'Quý'
        ],
        'Nhâm'=>[
            1=>'Nhâm',
            2=>'Quý',
            3=>'Giáp',
            4=>'Ất',
            5=>'Bính',
            6=>'Đinh',
            7=>'Mậu',
            8=>'Kỷ',
            9=>'Canh',
            10=>'Tân',
            11=>'Nhâm',
            12=>'Quý'
        ],
        'Mậu'=>[
            1=>'Giáp',
            2=>'Ất',
            3=>'Bính',
            4=>'Đinh',
            5=>'Mậu',
            6=>'Kỷ',
            7=>'Canh',
            8=>'Tân',
            9=>'Nhâm',
            10=>'Quý',
            11=>'Giáp',
            12=>'Ất'
        ],
        'Quý'=>[
            1=>'Giáp',
            2=>'Ất',
            3=>'Bính',
            4=>'Đinh',
            5=>'Mậu',
            6=>'Kỷ',
            7=>'Canh',
            8=>'Tân',
            9=>'Nhâm',
            10=>'Quý',
            11=>'Giáp',
            12=>'Ất'
        ]
    ];

    public static array $diaChiThang = [
        1=>'Dần',
        2=>'Mão',
        3=>'Thìn',
        4=>'Tỵ',
        5=>'Ngọ',
        6=>'Mùi',
        7=>'Thân',
        8=>'Dậu',
        9=>'Tuất',
        10=>'Hợi',
        11=>'Tý',
        12=>'Sửu'
    ];

    public static array $amDuong = [
        'Giáp' => 'Dương', 'Ất' => 'Âm',
        'Bính' => 'Dương', 'Đinh' => 'Âm',
        'Mậu' => 'Dương', 'Kỷ' => 'Âm',
        'Canh' => 'Dương', 'Tân' => 'Âm',
        'Nhâm' => 'Dương', 'Quý' => 'Âm'
    ];

    public array $data = [];

    public function __construct(protected int $ngayAL, protected int $thangAL, protected int $namAL)
    {

    }

    public function tinhCanChiNam(): array
    {
        $this->data['can-chi-nam'] = [
            'can'=>static::$thienCanNam[$this->namAL % 10],
            'chi'=>static::$diaChiNam[($this->namAL - 4) % 12],
        ];
        return $this->data['can-chi-nam'];
    }

    public function tinhCanChiThang(string $thienCanNam): array
    {
        $this->data['can-chi-thang'] = [
            'can'=>static::$thienCanThang[$thienCanNam][$this->thangAL],
            'chi'=>static::$diaChiThang[$this->thangAL]
        ];
        return $this->data['can-chi-thang'];
    }

    /**
     * @param LichVanNien::jdFromDate $jd
     * @return string
     */
    public static function tinhCanChiNgay($jd): array
    {
        $can = array("Giáp", "Ất", "Bính", "Đinh", "Mậu", "Kỷ", "Canh", "Tân", "Nhâm", "Quý");
        $chi = array("Tý", "Sửu", "Dần", "Mão", "Thìn", "Tỵ", "Ngọ", "Mùi", "Thân", "Dậu", "Tuất", "Hợi");

        $canNgay = $can[($jd + 9) % 10];
        $chiNgay = $chi[($jd + 1) % 12];

        return ['can'=>$canNgay,'chi'=>$chiNgay];
    }
    /**
     * @param LichVanNien::jdFromDate $jd
     * @param $gio
     * @return array
     */
    public static function tinhCanChiGio($jd, $gio): array
    {
        // Tính chỉ số Can của ngày
        $canNgayIndex = ($jd + 9) % 10;

        $can = array("Giáp", "Ất", "Bính", "Đinh", "Mậu", "Kỷ", "Canh", "Tân", "Nhâm", "Quý");
        $chi = array("Tý", "Sửu", "Dần", "Mão", "Thìn", "Tỵ", "Ngọ", "Mùi", "Thân", "Dậu", "Tuất", "Hợi");

        // Tính chỉ số Địa Chi của giờ
        $index = intval(($gio + 1) / 2) % 12;
        $chiGio = $chi[$index];

        // Tính chỉ số Can của giờ dựa trên Can của ngày và Địa Chi của giờ
        $canGioIndex = ($canNgayIndex * 2 + $index) % 10;
        $canGio = $can[$canGioIndex];

        return ['can'=>$canGio,'chi'=>$chiGio];
    }

    public static function tinhAmDuong(string $thienCanNam): string
    {
        return static::$amDuong[$thienCanNam];
    }
}
