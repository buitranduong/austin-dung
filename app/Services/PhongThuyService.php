<?php

namespace App\Services;

use App\Settings\WarehouseSetting;
use App\Supports\PhongThuy\CanChi;
use App\Supports\PhongThuy\Constant;
use App\Supports\PhongThuy\LaSoTutru;
use App\Supports\PhongThuy\LichVanNien;
use App\Supports\PhongThuy\MenhNien;
use App\Supports\PhongThuy\NguHanh;
use App\Supports\PhongThuy\TinhDiemSim;
use App\Utils\Helper;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Str;

class PhongThuyService
{
    public static function searchSim(array $params): array
    {
        if(!$params) return [];
        $api_sim_url = config('constant.api_sim_url');
        $api_path = "phong-thuy/search-sim";
        $queryString = http_build_query($params);
        $api_sim_url = "$api_sim_url/$api_path?$queryString";
        $response = Http::get($api_sim_url);
        if ($response->successful()) {
            $json = $response->json();
            return $json['data'];
        }
        return [];
    }

    public static function boiSim(array $params): array
    {
        if(!$params) return [];
        $api_sim_url = config('constant.api_sim_url');
        $api_path = "phong-thuy/boi-sim";
        $queryString = http_build_query($params);
        $api_sim_url = "$api_sim_url/$api_path?$queryString";
        $response = Http::get($api_sim_url);
        if ($response->successful()) {
            $json = $response->json();
            return $json['data'];
        }
        return [];
    }

    public static function laSoBatTu(Request $request, SimService $simService, WarehouseSetting $warehouseSetting): array
    {
        $gioSinh = $request->get('gs');
        $ngaySinh = $request->get('ns');
        $thangSinh = $request->get('ts');
        $namSinh = $request->get('ls');
        $gioiTinh = $request->get('gt');

        $gioiTinh = $gioiTinh == 'nam' ? 'Nam' : 'Nữ';
        $laSoTuTru = new LaSoTutru("$ngaySinh-$thangSinh-$namSinh", $gioSinh, 30, $gioiTinh == 'Nam' ? 1 : 0, 7, 'Vô danh khách');
        [$ngayAm, $thangAm, $namAm, $namNhuan] = $laSoTuTru->ngaythangAm;
        $lichDuong = Carbon::parse("$namSinh-$thangSinh-$ngaySinh")->format('d/m/Y');
        $lichAm = Carbon::parse("$namAm-$thangAm-$ngayAm")->format('d/m/Y');
        $namNhuan = 'âm lịch';
        $canChi = new CanChi($ngayAm, $thangAm, $namAm);
        $jd = LichVanNien::jdFromDate($ngaySinh, $thangSinh, $namSinh);
        $canChiNam = $canChi->tinhCanChiNam();
        //$canChithang = $canChi->tinhCanChiThang($canChiNam['can']);
        $canChiNgay = $canChi->tinhCanChiNgay($jd);
        $canChiGio = $canChi->tinhCanChiGio($jd, $gioSinh);
        $menhNien = MenhNien::tinhMenhNien(Str::of(implode(' ', $canChiNam))->lower()->slug());
        $menhQuai = MenhNien::tinhMenhQuai($namAm, $gioiTinh);
        $amDuong = $canChi::tinhAmDuong($canChiNam['can']);
        $doVuong = $laSoTuTru->tinhDoVuong();
        $doVuongSuy = $laSoTuTru->tinhDoVuongSuy($doVuong);
        $total = array_sum($doVuongSuy['total']);
        $soNguHanh = floor($total * 0.4);
        if ($doVuongSuy['cung_phe'] >= $soNguHanh && $doVuongSuy['cung_phe'] >= 50) {
            $banMenhText = 'Vượng';
        } else {
            $banMenhText = 'Nhược';
        }
        $dungThan = $doVuongSuy['ban_menh']['dung_than'];
        $dungThanId = array_search($dungThan, Constant::$nguHanhId);

        $hyThan = $doVuongSuy['ban_menh']['hy_than'];
        $hyThanId = array_map(function ($item) {
            return array_search($item, Constant::$nguHanhId);
        }, $hyThan);

        $hyThan = array_map(function ($item) {
            return Constant::$nguHanh[$item];
        }, $hyThan);
        $dungHyThan = Constant::$dungHyThan[Constant::$nguHanh[$dungThan]];
        $nguHanhKhongDau = array_search(Constant::$nguHanh[$dungThan], Constant::$nguHanh);

        $menhChu = [
            'con_giap'=> Constant::$iconConGiap[$canChiNam['chi']],
            'than_chu'=>Str::replaceArray('=?',[$gioiTinh, $amDuong, $lichDuong, $lichAm, $namNhuan], "=? (=?) sinh ngày: =? (tức ngày =? =?)"),
            'nam_can_chi'=>$menhNien['can-chi'],
            'menh_nien'=>"Mệnh {$menhNien['ngu-hanh']} - {$menhNien['menh-nien']} ({$menhNien['giai-nghia']})",
            'menh_quai'=>"Cung {$menhQuai['menh-quai']} {$menhQuai['ngu-hanh']} - {$menhQuai['tu-menh']}",
            'cung_menh'=>"{$menhNien['van-so']} ({$menhNien['luan-giai']})",
            'bat_tu'=>Str::replaceArray(
                '=?',
                [
                    implode(' ', $canChiNam),
                    implode(' ', [$laSoTuTru->canThangText, $laSoTuTru->chiThangText]),
                    implode(' ', $canChiNgay),
                    implode(' ', $canChiGio),
                    $laSoTuTru->tietKhiBySex['name'],
                    "$banMenhText {$doVuongSuy['ban_menh']['title']}",
                    Constant::$nguHanh[$dungThan],
                    implode(', ',$hyThan)
                ],
                'Năm =?, tháng =?, ngày =?, giờ =? - Tiết khí: =?<br/>Mệnh <strong>=?</strong>, Dụng thần: <strong>=?</strong>, Hỷ thần: <strong>=?</strong>'
            ),
        ];

        if($sim = $request->get('sim')){
            $sim_data = $simService->getSimDetail($sim, $warehouseSetting);
            if($sim_data){
                $sim_data['detail']['highlight'] = preg_replace('/<i>(.*?)<\/i>/', '$1', $sim_data['detail']['highlight']);;
            }
            $tinhDiemSim = new TinhDiemSim($sim, $dungThanId, $hyThanId);
            $doVuongSim = $tinhDiemSim->tinhDoVuongSim();
            $duNien = $tinhDiemSim->tinhDuNien();
            $soAmDuong = $tinhDiemSim->tinhamduong();
            $demSinhKhac = $tinhDiemSim->demSinhKhac($doVuongSim);
            $nguHanhSim = $tinhDiemSim->nguHanhSim();
            $xungKhac = NguHanh::kiemTraSinhKhac($nguHanhSim['ngu-hanh'], $menhNien['ngu-hanh']);
            if($xungKhac == 'sinh'){
                $xungKhacText = "{$nguHanhSim['ngu-hanh']} hợp {$menhNien['ngu-hanh']}";
            }elseif ($xungKhac == 'khắc'){
                $xungKhacText = "{$nguHanhSim['ngu-hanh']} không hợp {$menhNien['ngu-hanh']}";
            }else{
                $xungKhacText = "{$nguHanhSim['ngu-hanh']} bình hòa {$menhNien['ngu-hanh']}";
            }
            $queDich = $tinhDiemSim->tinhquedich();

            return [
                'menh_chu'=> $menhChu,
                'luan_giai'=>[
                    'title'=>'Kết quả phong thủy sim '.($sim_data['detail']['highlight'] ?? $sim),
                    'top'=>[
                        Constant::$gioiThieuChung
                    ],
                    'menh_chu'=>[
                        'title'=>'1. MỆNH CHỦ',
                        'text'=>[
                            Constant::$menhChuTextVuong[$doVuongSuy['ban_menh']['title']]
                        ]
                    ],
                    'sinh_khi'=>[
                        'title'=>'2. SINH KHÍ THIÊN MỆNH',
                        'text'=>[
                            '<p>Bên cạnh cách tính con số hợp mệnh theo trường phái mệnh Niên và mệnh Quái, trường phái Số sinh cũng là một trong những trường phái được kiểm nghiệm mang tính chính xác cao. Nghiên cứu này dựa vào dữ liệu đầu vào là ngày tháng năm sinh (theo lịch dương) để tính ra “CON SỐ MAY MẮN” của mỗi người. Con số may mắn sẽ nói lên tính cách của gia chủ, xác suất chính xác lên đến 90%.</p>',
                            '<p>- Trước khi nói về mệnh sim chúng ta bàn luận một chút về mệnh sim và mệnh chủ sự, khi một sim số có ngũ hành thuần mệnh và mệnh sim đó thuộc dụng hỷ thần của chân mệnh quý vị, thì sẽ giúp mệnh chủ thêm nguồn năng lượng để cân bằng lại ngũ hành trong mệnh cục, khi mệnh cục có được sự cân bằng thì chân mệnh đó sẽ phát triển và phát huy được hết những khả năng tiềm ẩn trong bản thân. Trong trời đất vận vật đều cần có sự cân bằng để phát triển, cái gì vượng quá hay suy quá đều không tốt, vd như quý vị thường biết thủy sinh mộc là tốt, cây cần có nước để phát triển nhưng nếu cây có quá nhiều nước mà không phải thủy sinh thì cây sẽ bị ủng mà chết, hoặc ví như bị nhập nước (úng) thì cây cũng không sống được. Chính vì vậy lên vạn vật đều cần có sự cân bằng mới phát triển tốt nhất.</p>',
                            Str::replaceArray('=?',[$sim], Constant::$nguHanhSim[$doVuongSim['ngu_hanh_sim']['text']]),
                            '<p>SIM SỐ sim phong thủy như 1 ID của mỗi chúng ta, giúp chúng ta kết nới với lục thân, đối tác, vv... tại sao lại gọi là ID ví sim số thay mặt chủ sử để tiếp cận gián tiếp với người mình cần gặp và người muốn gặp mình, thông qua những năng lượng và tần sóng - số - nếu năng lượng tốt, hợp mệnh cục của chủ sự, thì vạn sự hanh thông trôi chảy, đạt được ước muốn hoan hỷ thịnh cầu. Ngược lại gặp năng lượng xấu gặp chuyện gần được lại mất, ức chế tiền mất tật mạng, vướng vào thì phi phiền toái</p>',
                            '<p>Nhưng quý vị cũng lên lưu ý:</p>
                                <ul>
                                    <li>Sim phong thủy không thể giúp chủ sự tự nhiên mà giầu có</li>
                                    <li>Sim phong thủy không thể giúp chủ sự không làm mà cũng có ăn</li>
                                    <li>Sim phong thủy không thể giúp chủ sự làm ắc gặp thiện</li>
                                </ul>',
                            '<p>- Sim phong thủy có nguồn năng lượng tốt hỗ trợ gia chủ khỏe mạnh, may mắn, trí tuệ thông, gặp ông có đức gặp bà có nhân, gặp người gặp duyên. Việc gặp với cả việc thành là khác nhau xin quý vị lưu ý. – phúc lộc tại nhân – thành sự tại trí- tâm an trí vững ắt vận thông, sim phong thủy hay tất cả nhưng vật phẩm phong thủy trợ mệnh chỉ giúp quý vị được 25% - còn 20% là do phong thủy chỗ quý vị ở. Quý vị làm việc, ngành nghề quý vị làm và kinh doanh. Và 55% còn lại là do chính bản thân của quý vị biết điểm yếu điểm mạnh, của bản thân, biết sai thiêu sót phải sửa. Biết điểm mạnh để phát huy. Thành công chỉ đếm khi quý phát huy được điểm mạnh, niềm đam mê, sự nỗ lực phấn đấu, Và cần kiệm liêm chính, trông cây nào thì hái quả đó, và nắm được thời thể vượng suy lên đầu tư hay thủ thân. Tất cả là do bản thân mỗi chúng ta. Các vật phẩm phong thủy hay các thuật toán chỉ trợ mệnh hỗ trợ quý vị mà thôi.</p>'
                        ]
                    ],
                    'du_nien'=>[
                        'title'=>'3. DU NIÊN',
                        'text'=>[
                            '<p>Vạn vật xung quanh chúng ta đều có cái hồn của riêng nó, có những cái chúng ta nắm bắt được và cũng có những cái không nắm bắt được, nhưng cũng có những thứ ẩn khuất và vô hình, hung hiểm, lành dữ khó mà phân định, chúng ta ko nhìn nhận được, nhưng nó lại tác động đến chúng ta một cách bất ngờ mà bí ẩn. Năng lượng tốt khí chúng ta biết kết hợp những nguồn năng lượng tốt. Vận thông khi số sóng thông, sóng thông khi số tọa được Thiên Y, Sinh Khí, Phúc Đức và Phục vị Viên Mãn.</p>',
                            Str::replaceArray('=?',[$duNien['total'], implode(', ', $duNien['cap_so'])], Constant::$duNienText),
                            ...$duNien['text']
                        ]
                    ],
                    'am_duong'=>[
                        'title'=>'4. ÂM DƯƠNG TƯƠNG PHỐI',
                        'top'=>[
                            '<p>Âm dương (chữ Hán 陰陽) là hai khái niệm để chỉ hai thực thể đối lập ban đầu tạo nên toàn bộ vũ trụ. Trong mỗi vật thể, sự việc đều luôn tồn tại hai trạng thái Âm và Dương, mà nếu thiên lệch về trạng thái nào quá cũng đều không tốt.</p>',
                            '<p>Âm dương là hai khái niệm để chỉ hai thực thể đối lập ban đầu tạo nên toàn bộ vũ trụ. Ý niệm âm dương đã ăn sâu trong tâm thức người Việt từ ngàn xưa và được phản chiếu rất rõ nét trong ngôn ngữ nói chung và các con số nói riêng. Người xưa quan niệm rằng các số chẵn mang vận âm, các số lẻ mang vận dương.</p>',
                        ],
                        'text'=>[
                            Str::replaceArray('=?',[$soAmDuong['am'], $soAmDuong['duong']], Constant::$simAmDuongText),
                        ],
                        ...$soAmDuong
                    ],
                    'ngu_hanh'=>[
                        'title'=>'5. NGŨ HÀNH TƯƠNG PHỐI',
                        'text'=>[
                            Str::replaceArray('=?',[$menhNien['ngu-hanh'], $menhNien['can-chi'], $nguHanhSim['ngu-hanh'], $xungKhacText], Constant::$nguHanhText),
                            $tinhDiemSim->soSimNguHanh(),
                            ...$demSinhKhac[2],
                        ]
                    ],
                    'que_dich'=>[
                        'title'=>'6. PHỐI QUẺ DỊCH BÁT QUÁI',
                        'text'=>[
                            '<p>Bát quái là khái niệm trong Dịch Học, bao gồm tám đơn quái Càn, Khảm, Cấn, Chấn, Tốn, Ly, Khôn, Đoài. Từ Bát Quái, ta có được 64 quẻ trùng quái (quẻ kép) gọi là Lục Thập Tứ Quái. Trong 64 quẻ này, có quẻ cát, quẻ bình và quẻ hung. Nếu số đang xét rơi vào quẻ cát thì là tốt.</p>',
                            //'<p>Dựa theo ngày tháng năm và giờ sinh:</p>',
                            Str::replaceArray('=?',[$sim], '<p>Tiến hành tách số <strong style="color:#ff0045">=?</strong> thành quẻ Thượng và quẻ Hạ rồi phối quẻ theo nguyên tắc của Dịch Học ta được quẻ kép:</p>'),
                            "<p>Quẻ dịch: {$queDich['tengoi']}</p>",
                            Str::replaceArray('=?',[$queDich['name']], '<p><span class="img"><img alt="" src="/static/theme/images/phongthuy/=?.png" width="50" height="50"></span></p>'),
                            "<p>Quẻ này mang ý nghĩa: {$queDich['ynghia']}</p>",
                            "<p>Quẻ này là một quẻ: <strong>{$queDich['status']}</strong></p>"
                        ]
                    ],
                    'bat_tu'=>[
                        'title'=>'7. LÁ SỐ BÁT TỰ (TỨ TRỤ) LUẬN VẬN MỆNH',
                        'image'=> $laSoTuTru->drawImage()
                    ]
                ],
                'sim'=>[
                    'diem'=>$tinhDiemSim->theoDungHyThan($laSoTuTru->menhAmDuong),
                    'highlight'=>($sim_data['detail']['highlight'] ?? $sim),
                    'sold'=>!isset($sim_data['detail']['highlight'])
                ]
            ];
        }else{
            $path = "/sim-hop-menh-$nguHanhKhongDau";
            $filter = Helper::getRequestParams($path, [], $request, $warehouseSetting);
            //$filter['all']['sortBy'] = 'pt';
            //$filter['all']['limit'] = 100;
            $sim_data = $simService->getSims($filter['all'], $request, '', $warehouseSetting);
            $sim_data->getCollection()->transform(function ($item) use($laSoTuTru, $dungThanId, $hyThanId) {
                $tinhDiemSim = new TinhDiemSim($item['id'], $dungThanId, $hyThanId);
                $item['pt'] = $tinhDiemSim->theoDungHyThan($laSoTuTru->menhAmDuong);
                return $item;
            });
            //$new_data = $sim_data->getCollection()->reject(function ($item){
            //    return $item['pt'] < 7;
            //});
            //$sim_data->setCollection($new_data);
            return [
                'menh_chu'=> $menhChu,
                'tong_quan'=>Str::replaceArray('=?',[$banMenhText, $doVuongSuy['ban_menh']['title'], Constant::$nguHanh[$dungThan], implode(', ',$hyThan)], Constant::$textDungThanVuongNhuoc),
                'luan_giai'=>[
                    Constant::$thienCanLuanGiai[$canChiNam['can']]['luan-giai'],
                    Constant::$diaChiLuanGiai[$canChiNam['chi']]['luan-giai'],
                    Constant::$napAmLuanGiai[$menhNien['ngu-hanh']],
                    Constant::$cungMenhLuanGiai[$canChiNam['chi']]
                ],
                'sim_cai_menh'=>[
                    'ban_menh'=>"$banMenhText {$doVuongSuy['ban_menh']['title']}",
                    'dang_so'=>Str::replaceArray('=?', [Constant::$nguHanh[$dungThan], $dungHyThan['so-vi-du']], Constant::$dangSoText),
                    'sim_ngu_hanh'=>Str::replaceArray('=?',[Constant::$nguHanh[$dungThan], $dungHyThan['so-tong-quan']], Constant::$simSoText),
                    'y_nghia_hop_menh'=>Str::replaceArray('=?',[$dungHyThan['y-nghia']], Constant::$hopMenhText)
                ],
                'lists'=>$sim_data
            ];
        }
    }
}
