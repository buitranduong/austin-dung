<?php

namespace App\Supports\PhongThuy;

use Illuminate\Support\Str;

class TinhDiemSim
{
    public string $sim;
    public string $dungThanId;
    public array $hyThanId;
    public array $simSplit;

    /**
     * {@inheritdoc}
     * 0(Thủy) 8(Thổ) 3(Mộc) 3(Mộc) 6(Kim) 6(Kim) 9(Hỏa) 9(Hỏa) 9(Hỏa) 9(Hỏa)
     */
    public $nguHanhInfo = [
        1 => ['id' => 1, 'slug' => 'kim', 'text' => 'Kim', 'number' => [6, 7], 'cung_phe' => 5, 'sinh' => 2, 'bi_khac' => 4, 'khac' => 3],
        2 => ['id' => 2, 'slug' => 'thuy', 'text' => 'Thủy', 'number' => [0, 1], 'cung_phe' => 1, 'sinh' => 3, 'bi_khac' => 5, 'khac' => 4],
        3 => ['id' => 3, 'slug' => 'moc', 'text' => 'Mộc', 'number' => [3, 4], 'cung_phe' => 2, 'sinh' => 4, 'bi_khac' => 1, 'khac' => 5],
        4 => ['id' => 4, 'slug' => 'hoa', 'text' => 'Hỏa', 'number' => [9], 'cung_phe' => 3, 'sinh' => 5, 'bi_khac' => 2, 'khac' => 1],
        5 => ['id' => 5, 'slug' => 'tho', 'text' => 'Thổ', 'number' => [2, 5, 8], 'cung_phe' => 4, 'sinh' => 1, 'bi_khac' => 3, 'khac' => 2],
    ];

    public function __construct($sim, $dungThanId = null, $hyThanId = null) {
        $this->sim = $sim;
        $this->simSplit = str_split($this->sim);
        $this->dungThanId = $dungThanId;
        $this->hyThanId = $hyThanId;
    }

    function tinhamduong() {
        $am = $duong = 0;
        $arr = array();
        foreach ($this->simSplit as $num) {
            if ((int)$num % 2 == 0) {
                $am++;
                $arr['day_so'][] = ['number' => $num, 'text' => '-', 'color' => '#ffb7b7'];
            } else {
                $duong++;
                $arr['day_so'][] = ['number' => $num, 'text' => '+', 'color' => '#bfffd4'];
            }
        }
        $arr['am'] = $am;
        $arr['duong'] = $duong;
        $arr['menh'] = null;
        if (($am >= 7 && $am <= 9) || ($duong >= 7 && $duong <= 9)) {
            $arr['diem'] = 0.4;
            $arr['re'] = '-Số lượng số mang vận âm và dương chênh lệch nhiều.';
        } else if ($am == 6 || $duong == 6) {
            $arr['diem'] = 0.5;
            $arr['menh'] = $duong == 6 ? 1 : 0;
            $arr['re'] = '-Số lượng số mang vận âm dương chênh lệch không nhiều, số đạt được hoà hợp âm dương, tốt.';
        } else if (4 <= $am && $am <= 5) {
            $arr['diem'] = 1;
            $arr['re'] = '-Số lượng số mang vận âm dương hoàn toàn cân bằng, số đạt được hoà hợp âm dương, rất tốt.';
        } else {
            $arr['diem'] = 0;
            $arr['re'] = '-Số lượng số mang vận âm và dương chênh lệch nhiều.';
        }
        return $arr;
    }

    public function tinhquedich() {
        $thuong = substr($this->sim, 0, 5);
        $ha = substr($this->sim, 5, strlen($this->sim));
        $arrthuong = str_split($thuong) ?? [];
        $numericData = array_filter($arrthuong, fn($value) => is_numeric($value));
        $totalthuong = array_sum($numericData);
        $arrha = str_split($ha) ?? [];
        $numericData = array_filter($arrha, fn($value) => is_numeric($value));
        $totalha = array_sum($numericData);
        if ($totalthuong % 8 == 0) {
            $thuongque = 8;
        } else {
            $thuongque = $totalthuong % 8;
        }
        if ($totalha % 8 == 0) {
            $haque = 8;
        } else {
            $haque = $totalha % 8;
        }
        return Constant::$arrquedich[$haque][$thuongque];
    }

    public function tinhDuNien(): array
    {
        //
        $duNien = [
            'sinh_khi' => ['cap_so' => [67, 14, 82, 39, 41, 93, 28, 76], 'title' => 'Sinh Khí', 'luan_giai'=>'<p>- Sim này có chứa những cặp số thuộc năng lượng sinh khí, nên mệnh sim được Đắc Sinh Khí bảo trợ Sức khỏe, Thúc đẩy quan hệ hợp tác, gặp gỡ được Qúy nhân.</p>'],
            'thien_y' => ['cap_so' => [68, 13, 86, 31, 49, 94, 27, 72], 'title' => 'Thiên Y', 'luan_giai'=>'<p>- Số Sim này có chứa những cặp số thuộc năng lượng sinh khí, nên mệnh sim được Vượng Thiên Y kích Tài sinh Lộc, Củng cố Địa vị và gia tăng May mắn.</p>'],
            'dien_nien' => ['cap_so' => [62, 19, 87, 34, 43, 91, 26, 78], 'title' => 'Diên Niên', 'luan_giai'=>'<p>- Số Sim này có chứa những cặp số thuộc năng lượng sinh khí, nên mệnh sim được Tọa Phúc Đức Ân Duệ thúc đẩy Công danh để Thăng quan tiến chức, tinh thần thoải mái và gia đạo được êm ấm.</p>'],
            'phuc_vi' => ['cap_so' => [66, 11, 88, 33, 44, 99, 22, 77, 00, 15, 25, 35, 45, 55, 65, 75, 85, 95], 'title' => 'Phục Vị', 'luan_giai'=>'<p>- Số Sim này có chứa những cặp số thuộc năng lượng sinh khí, nên mệnh sim được Trợ Phục Vị Viên Mãn giúp Sự nghiệp, Tiền Bạc và Tình cảm được bền vững,Gia đình bình an, tính toán thuận lợi.</p>'],
            'sinh_thien_dien' => ['cap_so' => [1491, 3943, 4134, 9319, 2862, 6726, 7687, 2878], 'title' => 'Sinh Thiên Diên', 'luan_giai'=>'<p>- Số Sim này có chứa những cặp số thuộc Năng lượng Sinh Diên Niên, nên mệnh sim được Đắc đại cát, ngoài việc bổ trợ về kinh doanh phát đạt và có những mối quan hệ cát lành, thì năg lượng sinh diên niên còn hóa giải được những chủ sự phạm phải ngũ quỷ trong bát trạch, kết hôn, số CMTND số nhà, số xe bị phạm ngũ quỷ.</p>'],
            'sinh_dien' => ['cap_so' => [419, 391, 762, 826], 'title' => 'Sinh Diên', 'luan_giai'=>'<p>- Số Sim này có chứa những cặp số thuộc Năng lượng Sinh Diên, nên mệnh sim được Đắc đại cát, ngoài việc bổ trợ về kinh doanh phát đạt và có những mối quan hệ cát lành, thì năg lượng sinh diên còn hóa giải được, những chủ sự phạm phải họa hại (thị phi phiền toái) trong bát trạch, kết hôn, số CMTND số nhà, số xe bị phạm họa hại (thị phi phiền toái).</p>'],
            'sinh_phuc' => ['cap_so' => [415, 395, 765, 825], 'title' => 'Sinh Phục', 'luan_giai'=>'<p>- Số Sim này có chứa những cặp số thuộc Năng lượng Sinh Diên, nên mệnh sim được Đắc đại cát, ngoài việc bổ trợ về kinh doanh phát đạt và có những mối quan hệ cát lành, thì năg lượng sinh diên còn hóa giải được, những chủ sự phạm phải họa hại (thị phi phiền toái) trong bát trạch, kết hôn, số CMTND số nhà, số xe bị phạm họa hại (thị phi phiền toái).</p>'],
            'sinh_sinh' => ['cap_so' => [414, 393, 767, 828], 'title' => 'Sinh Sinh', 'luan_giai'=>'<p>- Số Sim này có chứa những cặp số thuộc Năng lượng Sinh Diên, nên mệnh sim được Đắc đại cát, ngoài việc bổ trợ về kinh doanh phát đạt và có những mối quan hệ cát lành, thì năg lượng sinh diên còn hóa giải được, những chủ sự phạm phải họa hại (thị phi phiền toái) trong bát trạch, kết hôn, số CMTND số nhà, số xe bị phạm họa hại (thị phi phiền toái).</p>'],
            'hung' => [69, 96, 12, 21, 37, 73, 48, 84, 29, 92, 16, 61, 83, 38, 47, 74, 36, 63, 79, 97, 24, 42, 18, 81, 89, 98, 23, 32, 17, 71, 46, 64],
        ];
        $results = [];
        $countHung = 0;

        for ($i = 0; $i < count($this->simSplit); $i++) {
            foreach ($duNien as $key => $val) {
                if (isset($this->simSplit[$i + 1])) {
                    $ss = $this->simSplit[$i] . $this->simSplit[$i + 1];
                    if ($key != 'hung' && in_array($ss, $val['cap_so'])) {
                        $results['cap_so'][strlen($ss)][] = $ss;
                        $results['cap_so2'][] = $ss;
                        $results['title'][] = $key;
                        $results['text'][] = $val['luan_giai'];
                    }
                    if ($key == 'hung' && in_array($ss, $val)) {
                        $countHung++;
                    }
                }
            }
        }
        $diem = $count2 = $count3 = $count4 = 0;
        if (!empty($results['cap_so'][2])) {
            $count2 = count($results['cap_so'][2]);
            if ($count2 >= 5) {
                $diem += 1;
            } else {
                $diem += $count2 * 0.1;
            }
        }
        if (!empty($results['cap_so'][3])) {
            $count3 = count($results['cap_so'][3]);
            if ($count3 >= 3) {
                $diem += 1;
            } else {
                $diem += $count3 * 0.2;
            }
        }
        if (!empty($results['cap_so'][4])) {
            $count4 = count($results['cap_so'][4]);
            if ($count4 >= 2) {
                $diem += 1;
            } else {
                $diem += 0.4;
            }
        }
        if ($countHung >=5) {
            $diem = 0;
        } else {
            $diem -= $countHung * 0.3;
        }

        return [
            'total' => $count2 + $count3 + $count4,
            'cap_so' => $results['cap_so2'] ?? [],
            'title' => !empty($results['title']) ? array_unique($results['title']) : [],
            'text' => !empty($results['text']) ? array_unique($results['text']) : [],
            'diem' => min($diem, 1),
        ];
    }

    function cmp($a, $b): int
    {
        if (count($a) == count($b)) {
            return 0;
        }
        return ($a < $b) ? 1 : -1;
    }

    function sinhkhac($s1, $s2) { // kim / moc/ thuy hoa tho
        $arr = array();
        switch ($s1) {
            case 'kim':
                if ($s2 == 'moc')
                    $arr['khac'] = 1;
                else if ($s2 == 'thuy')
                    $arr['sinh'] = 1;

                break;
            case 'moc':
                if ($s2 == 'tho')
                    $arr['khac'] = 1;
                else if ($s2 == 'hoa')
                    $arr['sinh'] = 1;
                break;
            case 'thuy':
                if ($s2 == 'hoa')
                    $arr['khac'] = 1;
                else if ($s2 == 'moc')
                    $arr['sinh'] = 1;
                break;
            case 'hoa':
                if ($s2 == 'kim')
                    $arr['khac'] = 1;
                else if ($s2 == 'tho')
                    $arr['sinh'] = 1;
                break;
            case 'tho':
                if ($s2 == 'thuy')
                    $arr['khac'] = 1;
                else if ($s2 == 'kim')
                    $arr['sinh'] = 1;
                break;
        }
        return $arr;
    }

    public function tinhDoVuongSim() {
        $result = [];
        $list = [];
        $nguHanhSim = 0;
        foreach ($this->simSplit as $index => $element) {
            foreach ($this->nguHanhInfo as $key => $val) {
                if (in_array($element, $val['number'])) { // Thủy
                    $result['ngu_hanh'][$key][] = $element;
                    $result['cung_phe'][$key][] = $element;
                    $result['cung_phe'][$val['sinh']][] = $element;
                    $list[] = [
                        'number' => $element,
                        'nguhanh' => $val['text'],
                        'slug' => $val['slug'],
                        'id' => $key,
                        'index' => $index
                    ];
                }
            }
        }
        $nguHanh = [];
        if ((isset($result['ngu_hanh'][1]) && count($result['ngu_hanh'][1]) >= 3 && ((isset($result['ngu_hanh'][5]) && count($result['ngu_hanh'][5]) >= 1) || (isset($result['ngu_hanh'][4]) && count($result['ngu_hanh'][4]) <= 1))) || (isset($result['ngu_hanh'][1]) && count($result['ngu_hanh'][1]) >= 4)) {
            $nguHanh[] = 1;
        }
        if ((isset($result['ngu_hanh'][2]) && count($result['ngu_hanh'][2]) >= 3 && ((isset($result['ngu_hanh'][1]) && count($result['ngu_hanh'][1]) >= 1) || (isset($result['ngu_hanh'][5]) && count($result['ngu_hanh'][5]) <= 1))) || (isset($result['ngu_hanh'][2]) && count($result['ngu_hanh'][2]) >= 4)) {
            $nguHanh[] = 2;
        }
        if ((isset($result['ngu_hanh'][3]) && count($result['ngu_hanh'][3]) >= 3 && ((isset($result['ngu_hanh'][2]) && count($result['ngu_hanh'][2]) >= 1) || (isset($result['ngu_hanh'][1]) && count($result['ngu_hanh'][1]) <= 1))) || (isset($result['ngu_hanh'][3]) && count($result['ngu_hanh'][3]) >= 4)) {
            $nguHanh[] = 3;
        }
        if ((isset($result['ngu_hanh'][4]) && count($result['ngu_hanh'][4]) >= 3 && ((isset($result['ngu_hanh'][3]) && count($result['ngu_hanh'][3]) >= 1) || (isset($result['ngu_hanh'][2]) && count($result['ngu_hanh'][2]) <= 1))) || (isset($result['ngu_hanh'][4]) && count($result['ngu_hanh'][4]) >= 4)) {
            $nguHanh[] = 4;
        }
        if ((isset($result['ngu_hanh'][5]) && count($result['ngu_hanh'][5]) >= 3 && ((isset($result['ngu_hanh'][4]) && count($result['ngu_hanh'][4]) >= 1) || (isset($result['ngu_hanh'][3]) && count($result['ngu_hanh'][3]) <= 1))) || (isset($result['ngu_hanh'][5]) && count($result['ngu_hanh'][5]) >= 4)) {
            $nguHanh[] = 5;
        }
        $countNguHanh = count($nguHanh);
        $nguHanhDuoisim = end($list)['id'];
        // Chỉ xét khi ngũ hành tối đa là 2 nếu > 2 coi như sim đó không phải sim phong thủy
        if ($countNguHanh == 2) {
            $nguHanh0 = $nguHanh[0];
            $nguHanh1 = $nguHanh[1];
            $cungPhe0 = isset($result['cung_phe'][$nguHanh0]) ? count($result['cung_phe'][$nguHanh0]) : 0;
            $cungPhe1 = isset($result['cung_phe'][$nguHanh1]) ? count($result['cung_phe'][$nguHanh1]) : 0;
            //echo $nguHanh[0] . ': ' . $cungPhe0 .'---'. $nguHanh[1] . ': ' . $cungPhe1 .'$nguHanhDuoisim:' . $nguHanhDuoisim. '<br>';
            // Đuôi số trùng lặp 3 số trở lên
            $pattern = "/(000|111|222|333|444|555|666|777|888|999)$/"; //Tam hoa
            if (preg_match($pattern, $this->sim)) {
                $pattern = "/(0000|1111|2222|3333|4444|5555|6666|7777|8888|9999)$/"; // Ngũ quy
                if (preg_match($pattern, $this->sim) && $cungPhe0 > 0 && $cungPhe1 > 0 && in_array($nguHanhDuoisim, $nguHanh)) {
                    $nguHanhSim = $nguHanhDuoisim;
                }
                // -- Xét nếu là tam hoa, ngũ hành đuôi nhỏ hơn 1 đơn vị thì xét theo ngũ hành sinh khắc
                elseif ($cungPhe0 > 0 && $cungPhe1 > 0 && (($nguHanh0 == $nguHanhDuoisim && ($cungPhe0 + 1) == $cungPhe1) ||
                        ($nguHanh1 == $nguHanhDuoisim && ($cungPhe1 + 1) == $cungPhe0))) {
                    $nguHanhSim = $this->tinhSinhTroKhacHao($nguHanh0, $nguHanh1);
                } elseif ($cungPhe0 > $cungPhe1) {
                    $nguHanhSim = $nguHanh0;
                } elseif ($cungPhe0 < $cungPhe1) {
                    $nguHanhSim = $nguHanh1;
                }
            } else {
                // Cân nhau xet đến đầu số
                if ($cungPhe0 == $cungPhe1) {
                    $nguHanhDauSo = $list[2];
                    if ($nguHanhDauSo == $this->nguHanhInfo[$nguHanh0]['cung_phe'] || $nguHanhDauSo == $this->nguHanhInfo[$nguHanh1]['khac']) {
                        $nguHanhSim = $nguHanh0;
                    } elseif ($nguHanhDauSo == $this->nguHanhInfo[$nguHanh1]['cung_phe'] || $nguHanhDauSo == $this->nguHanhInfo[$nguHanh0]['khac']) {
                        $nguHanhSim = $nguHanh1;
                    } else {
                        // Cân nhau xét theo hội
                        // -- Sinh lấy theo được sinh
                        // -- Khắc lấy đi khắc
                        $nguHanhSim = $this->tinhSinhTroKhacHao($nguHanh0, $nguHanh1);
                    }
                } elseif ($cungPhe0 > $cungPhe1) {
                    $nguHanhSim = $nguHanh0;
                } elseif ($cungPhe0 < $cungPhe1) {
                    $nguHanhSim = $nguHanh1;
                }
            }
        } elseif ($countNguHanh == 1) {
            $nguHanhSim = $nguHanh[0];
        }
        $pattern = "/(00000|11111|22222|33333|44444|55555|66666|77777|88888|99999)$/"; // Ngũ quy
        if (preg_match($pattern, $this->sim)) {
            $nguHanhSim = $nguHanhDuoisim;
        }
        if (empty($nguHanhSim)) {
            $nguHanhSim = $nguHanhDuoisim;
        }
        $thuanMenh = count($result['ngu_hanh']) <= 3 ? true : false;
        $diem = 0;
        if ($thuanMenh) {
            $diem = 2;
        } elseif (!$thuanMenh && !empty($nguHanh)) {
            $diem = 1;
        }
        return [
            'so_sim' => $this->sim,
            'ngu_hanh_sim' => isset($this->nguHanhInfo[$nguHanhSim]) ? $this->nguHanhInfo[$nguHanhSim] : NULL,
            'ngu_hanh' => $result['ngu_hanh'],
            'cung_phe' => $result['cung_phe'],
            'list' => $list,
            'thuan_menh' => $thuanMenh,
            'diem' => $diem
        ];
    }

    public function tinhSinhTroKhacHao($nguHanh0, $nguHanh1) {
        $nguHanhSim = 0;
        if ($nguHanh0 == $this->nguHanhInfo[$nguHanh1]['sinh'] || // được sinh
            $nguHanh0 == $this->nguHanhInfo[$nguHanh1]['cung_phe'] || // Cùng phe
            $nguHanh1 == $this->nguHanhInfo[$nguHanh0]['khac'] || // đi khắc
            $nguHanh1 == $this->nguHanhInfo[$nguHanh0]['bi_khac']) { // bị khắc
            $nguHanhSim = $nguHanh0;
        }
        if ($nguHanh1 == $this->nguHanhInfo[$nguHanh0]['sinh'] || // được sinh
            $nguHanh1 == $this->nguHanhInfo[$nguHanh0]['cung_phe'] || // Cùng phe
            $nguHanh0 == $this->nguHanhInfo[$nguHanh1]['khac'] || // đi khắc
            $nguHanh0 == $this->nguHanhInfo[$nguHanh1]['bi_khac']) {
            $nguHanhSim = $nguHanh1;
        }

        return $nguHanhSim;
    }

    public function demSinhKhac($doVuongSim): array
    {
        $arrs = [];
        $count = count($doVuongSim['list']);
        for ($i = 0; $i < $count; $i++) {
            if (isset($doVuongSim['list'][$i + 1]['slug']) && ($this->sinhkhac($doVuongSim['list'][$i]['slug'], $doVuongSim['list'][$i + 1]['slug']))){
                $arrs[] = ($this->sinhkhac($doVuongSim['list'][$i]['slug'], $doVuongSim['list'][$i + 1]['slug']));
            }
        }
        $demSinh = 0;
        $demKhac = 0;
        foreach ($arrs as $v) {
            if (isset($v['sinh'])) {
                $demSinh++;
            } elseif (isset($v['khac'])) {
                $demKhac++;
            }
        }
        $text[] = "<p>- Theo chiều từ trái qua phải(chiều thuận của sự phát triển) xảy ra : $demSinh quan hệ tương sinh, $demKhac quan hệ tương khắc</p>";
        if (($demSinh - $demKhac) <= -2) {
            $text[] = "<p>- Tỉ lệ tương sinh khắc quá cao, số này không tốt.</p>";
        }
        return [$demSinh, $demKhac, $text];
    }

    public function theoDungHyThan(int $menhAmDuong): int
    {
        $doVuongSim = $this->tinhDoVuongSim();
        $amDuong = $this->tinhamduong();
        $duNien = $this->tinhDuNien();
        $quedich = $this->tinhquedich();

        $diem = 0;
        if ($doVuongSim['ngu_hanh_sim']['id'] == $this->dungThanId) {
            $diem += 5;
        } elseif (in_array($doVuongSim['ngu_hanh_sim']['id'], $this->hyThanId)) {
            $diem += 5;
        }
        $diem += $duNien['diem'];
        $diem += $amDuong['diem'];
        if (is_numeric($amDuong['menh']) && $menhAmDuong == $amDuong['menh']) {
            $diem -= 1;
        }else{
            $diem += 1;
        }
        [$demSinh, $demKhac] = $this->demSinhKhac($doVuongSim);
        if ($demSinh > 0 && $demKhac == 0) {
            $diem += 1;
        } elseif ($demSinh > 0 && $demKhac > 0) {
            $diem += 0.5;
        }
        if (($demSinh - $demKhac) <= -2) {
            $diem -= 0.25;
        }
        $diem += $quedich['diem'];

        if($diem > 8){
            return 10;
        }elseif($diem < 5){
            return 5;
        }else{
            return ceil($diem);
        }
    }

    public function nguHanhSim() { // 0977778888
        // tính số xuất hiện nhiều nhất
        $arr = array_count_values($this->simSplit);
        $maxValue = max($arr);
        $maxIndex = array_search(max($arr), $arr);

        if ($maxValue >= 6) {
            $so = $maxIndex;
        } else {
            $so = substr(trim($this->sim), -1);
        }
        return Constant::$soNguHanh[$so] ?? '';
    }

    public function soSimNguHanh(): string
    {
        $text = '';
        foreach ($this->simSplit as $so){
            $hanh = Constant::$soNguHanh[$so] ?? ['color'=>'','ngu-hanh'=>''];
            $text .= Str::replaceArray('=?',[$so, $hanh['color'], $hanh['ngu-hanh']], Constant::$soSimNguHanhText);
        }
        return $text;
    }
}
