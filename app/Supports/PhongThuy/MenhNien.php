<?php

namespace App\Supports\PhongThuy;

class MenhNien
{
    // Bảng Du Niên (kết hợp giữa các cung)
    public static array $duNien = [
        'Khảm' => [
            'Khảm' => 'Phục Vị',
            'Ly' => 'Diên Niên',
            'Cấn' => 'Ngũ Quỷ',
            'Đoài' => 'Họa Hại',
            'Càn' => 'Lục Sát',
            'Khôn' => 'Tuyệt Mệnh',
            'Chấn' => 'Thiên Y',
            'Tốn' => 'Sinh Khí'
        ],
        'Ly' => [
            'Khảm' => 'Diên Niên',
            'Ly' => 'Phục Vị',
            'Cấn' => 'Họa Hại',
            'Đoài' => 'Ngũ Quỷ',
            'Càn' => 'Tuyệt Mệnh',
            'Khôn' => 'Lục Sát',
            'Chấn' => 'Sinh Khí',
            'Tốn' => 'Thiên Y'
        ],
        'Cấn' => [
            'Khảm' => 'Ngũ Quỷ',
            'Ly' => 'Họa Hại',
            'Cấn' => 'Phục Vị',
            'Đoài' => 'Diên Niên',
            'Càn' => 'Thiên Y',
            'Khôn' => 'Sinh Khí',
            'Chấn' => 'Ngũ Quỷ',
            'Tốn' => 'Tuyệt Mệnh'
        ],
        'Đoài' => [
            'Khảm' => 'Họa Hại',
            'Ly' => 'Ngũ Quỷ',
            'Cấn' => 'Diên Niên',
            'Đoài' => 'Phục Vị',
            'Càn' => 'Sinh Khí',
            'Khôn' => 'Thiên Y',
            'Chấn' => 'Tuyệt Mệnh',
            'Tốn' => 'Lục Sát'
        ],
        'Càn' => [
            'Khảm' => 'Lục Sát',
            'Ly' => 'Tuyệt Mệnh',
            'Cấn' => 'Thiên Y',
            'Đoài' => 'Sinh Khí',
            'Càn' => 'Phục Vị',
            'Khôn' => 'Diên Niên',
            'Chấn' => 'Ngũ Quỷ',
            'Tốn' => 'Họa Hại'
        ],
        'Khôn' => [
            'Khảm' => 'Tuyệt Mệnh',
            'Ly' => 'Lục Sát',
            'Cấn' => 'Sinh Khí',
            'Đoài' => 'Thiên Y',
            'Càn' => 'Diên Niên',
            'Khôn' => 'Phục Vị',
            'Chấn' => 'Họa Hại',
            'Tốn' => 'Ngũ Quỷ'
        ],
        'Chấn' => [
            'Khảm' => 'Thiên Y',
            'Ly' => 'Sinh Khí',
            'Cấn' => 'Lục Sát',
            'Đoài' => 'Tuyệt Mệnh',
            'Càn' => 'Ngũ Quỷ',
            'Khôn' => 'Họa Hại',
            'Chấn' => 'Phục Vị',
            'Tốn' => 'Diên Niên'
        ],
        'Tốn' => [
            'Khảm' => 'Sinh Khí',
            'Ly' => 'Thiên Y',
            'Cấn' => 'Tuyệt Mệnh',
            'Đoài' => 'Lục Sát',
            'Càn' => 'Họa Hại',
            'Khôn' => 'Ngũ Quỷ',
            'Chấn' => 'Diên Niên',
            'Tốn' => 'Phục Vị'
        ]
    ];
    public static function simTheoMenh(string $nguHanh): ?string
    {
        $idSim = [
            '110' => 'Thuỷ',
            '111' => 'Hoả',
            '112' => 'Mộc',
            '113' => 'Thổ',
            '114' => 'Kim',
        ];

        return array_search($nguHanh, $idSim);
    }
    /**
     * @param string $canChi
     * @return array|null
     */
    public static function tinhMenhNien(string $canChi): array|null
    {
        $menhNienData = array(
            'giap-ty' => [
                'can-chi' => 'Giáp Tý',
                'menh-nien' => 'Hải Trung Kim',
                'giai-nghia' => 'Kim Đáy Biển',
                'ngu-hanh' => 'Kim',
                'van-so' => 'Ốc Thượng Chi Thử',
                'luan-giai' => 'Chuột ở nóc nhà'
            ],
            'at-suu' => [
                'can-chi' => 'Ất Sửu',
                'menh-nien' => 'Hải Trung Kim',
                'giai-nghia' => 'Kim Đáy Biển',
                'ngu-hanh' => 'Kim',
                'van-so' => 'Hải Nội Chi Ngưu',
                'luan-giai' => 'Trâu trong biển'
            ],
            'binh-dan' => [
                'can-chi' => 'Bính Dần',
                'menh-nien' => 'Lư Trung Hỏa',
                'giai-nghia' => 'Lửa Trong Lò',
                'ngu-hanh' => 'Hỏa',
                'van-so' => 'Sơn Lâm Chi Hổ',
                'luan-giai' => 'Hổ trong rừng'
            ],
            'dinh-mao' => [
                'can-chi' => 'Đinh Mão',
                'menh-nien' => 'Lư Trung Hỏa',
                'giai-nghia' => 'Lửa Trong Lò',
                'ngu-hanh' => 'Hỏa',
                'van-so' => 'Vọng Nguyệt Chi Thố',
                'luan-giai' => 'Thỏ ngắm trăng'
            ],
            'mau-thin' => [
                'can-chi' => 'Mậu Thìn',
                'menh-nien' => 'Đại Lâm Mộc',
                'giai-nghia' => 'Gỗ Rừng Già',
                'ngu-hanh' => 'Mộc',
                'van-so' => 'Thanh Ôn Chi Long',
                'luan-giai' => 'Rồng trong sạch, ôn hoà'
            ],
            'ky-ty' => [
                'can-chi' => 'Kỷ Tỵ',
                'menh-nien' => 'Đại Lâm Mộc',
                'giai-nghia' => 'Gỗ Rừng Già',
                'ngu-hanh' => 'Mộc',
                'van-so' => 'Phúc Khí Chi Xà',
                'luan-giai' => 'Rắn có phúc'
            ],
            'canh-ngo' => [
                'can-chi' => 'Canh Ngọ',
                'menh-nien' => 'Lộ Bàng Thổ',
                'giai-nghia' => 'Đất Bên Đường',
                'ngu-hanh' => 'Thổ',
                'van-so' => 'Thất Lý Chi Mã',
                'luan-giai' => 'Ngựa trong nhà'
            ],
            'tan-mui' => [
                'can-chi' => 'Tân Mùi',
                'menh-nien' => 'Lộ Bàng Thổ',
                'giai-nghia' => 'Đất Bên Đường',
                'ngu-hanh' => 'Thổ',
                'van-so' => 'Đắc Lộc Chi Dương',
                'luan-giai' => 'Dê có lộc'
            ],
            'nham-than' => [
                'can-chi' => 'Nhâm Thân',
                'menh-nien' => 'Kiếm Phong Kim',
                'giai-nghia' => 'Kim Mũi Kiếm',
                'ngu-hanh' => 'Kim',
                'van-so' => 'Thanh Tú Chi Hầu',
                'luan-giai' => 'Khỉ thanh tú'
            ],
            'quy-dau' => [
                'can-chi' => 'Quý Dậu',
                'menh-nien' => 'Kiếm Phong Kim',
                'giai-nghia' => 'Kim Mũi Kiếm',
                'ngu-hanh' => 'Kim',
                'van-so' => 'Lâu Túc Kê',
                'luan-giai' => 'Gà nhà gác'
            ],
            'giap-tuat' => [
                'can-chi' => 'Giáp Tuất',
                'menh-nien' => 'Sơn Đầu Hỏa',
                'giai-nghia' => 'Lửa Đầu Núi',
                'ngu-hanh' => 'Hỏa',
                'van-so' => 'Thủ Thân Chi Cẩu',
                'luan-giai' => 'Chó giữ mình'
            ],
            'at-hoi' => [
                'can-chi' => 'Ất Hợi',
                'menh-nien' => 'Sơn Đầu Hỏa',
                'giai-nghia' => 'Lửa Đầu Núi',
                'ngu-hanh' => 'Hỏa',
                'van-so' => 'Quá Vãng Chi Trư',
                'luan-giai' => 'Lợn hay đi'
            ],
            'binh-ty' => [
                'can-chi' => 'Bính Tý',
                'menh-nien' => 'Giản Hạ Thủy',
                'giai-nghia' => 'Nước Dưới Khe',
                'ngu-hanh' => 'Thủy',
                'van-so' => 'Điền Nội Chi Thử',
                'luan-giai' => 'Chuột trong ruộng'
            ],
            'dinh-suu' => [
                'can-chi' => 'Đinh Sửu',
                'menh-nien' => 'Giản Hạ Thủy',
                'giai-nghia' => 'Nước Dưới Khe',
                'ngu-hanh' => 'Thủy',
                'van-so' => 'Hồ Nội Chi Ngưu',
                'luan-giai' => 'Trâu trong hồ nước'
            ],
            'mau-dan' => [
                'can-chi' => 'Mậu Dần',
                'menh-nien' => 'Thành Đầu Thổ',
                'giai-nghia' => 'Đất Trên Thành',
                'ngu-hanh' => 'Thổ',
                'van-so' => 'Quá Sơn Chi Hổ',
                'luan-giai' => 'Hổ qua rừng'
            ],
            'ky-mao' => [
                'can-chi' => 'Kỷ Mão',
                'menh-nien' => 'Thành Đầu Thổ',
                'giai-nghia' => 'Đất Trên Thành',
                'ngu-hanh' => 'Thổ',
                'van-so' => 'Sơn Lâm Chi Thố',
                'luan-giai' => 'Thỏ ở rừng'
            ],
            'canh-thin' => [
                'can-chi' => 'Canh Thìn',
                'menh-nien' => 'Bạch Lạp Kim',
                'giai-nghia' => 'Vàng Trong Nến',
                'ngu-hanh' => 'Kim',
                'van-so' => 'Thứ Tính Chi Long',
                'luan-giai' => 'Rồng khoan dung'
            ],
            'tan-ty' => [
                'can-chi' => 'Tân Tỵ',
                'menh-nien' => 'Bạch Lạp Kim',
                'giai-nghia' => 'Vàng Trong Nến',
                'ngu-hanh' => 'Kim',
                'van-so' => 'Đông Tàng Chi Xà',
                'luan-giai' => 'Rắn ngủ đông'
            ],
            'nham-ngo' => [
                'can-chi' => 'Nhâm Ngọ',
                'menh-nien' => 'Dương Liễu Mộc',
                'giai-nghia' => 'Gỗ Cây Dương Liễu',
                'ngu-hanh' => 'Mộc',
                'van-so' => 'Quân Trung Chi Mã',
                'luan-giai' => 'Ngựa chiến'
            ],
            'quy-mui' => [
                'can-chi' => 'Quý Mùi',
                'menh-nien' => 'Dương Liễu Mộc',
                'giai-nghia' => 'Gỗ Cây Dương Liễu',
                'ngu-hanh' => 'Mộc',
                'van-so' => 'Quần Nội Chi Dương',
                'luan-giai' => 'Dê trong đàn'
            ],
            'giap-than' => [
                'can-chi' => 'Giáp Thân',
                'menh-nien' => 'Tuyền Trung Thủy',
                'giai-nghia' => 'Nước Trong Suối',
                'ngu-hanh' => 'Thủy',
                'van-so' => 'Quá Thụ Chi Hầu',
                'luan-giai' => 'Khỉ leo cây'
            ],
            'at-dau' => [
                'can-chi' => 'Ất Dậu',
                'menh-nien' => 'Tuyền Trung Thủy',
                'giai-nghia' => 'Nước Trong Suối',
                'ngu-hanh' => 'Thủy',
                'van-so' => 'Xướng Ngọ Chi Kê',
                'luan-giai' => 'Gà gáy trưa'
            ],
            'binh-tuat' => [
                'can-chi' => 'Bính Tuất',
                'menh-nien' => 'Ốc Thượng Thổ',
                'giai-nghia' => 'Đất Trên Mái',
                'ngu-hanh' => 'Thổ',
                'van-so' => 'Tự Miên Chi Cẩu',
                'luan-giai' => 'Chó đang ngủ'
            ],
            'dinh-hoi' => [
                'can-chi' => 'Đinh Hợi',
                'menh-nien' => 'Ốc Thượng Thổ',
                'giai-nghia' => 'Đất Trên Mái',
                'ngu-hanh' => 'Thổ',
                'van-so' => 'Quá Sơn Chi Trư',
                'luan-giai' => 'Lợn qua núi'
            ],
            'mau-ty' => [
                'can-chi' => 'Mậu Tý',
                'menh-nien' => 'Tích Lịch Hỏa',
                'giai-nghia' => 'Lửa Sấm Sét',
                'ngu-hanh' => 'Hỏa',
                'van-so' => 'Thương Nội Chi Thư',
                'luan-giai' => 'Chuột trong kho'
            ],
            'ky-suu' => [
                'can-chi' => 'Kỷ Sửu',
                'menh-nien' => 'Tích Lịch Hỏa',
                'giai-nghia' => 'Lửa Sấm Sét',
                'ngu-hanh' => 'Hỏa',
                'van-so' => 'Lâm Nội Chi Ngưu',
                'luan-giai' => 'Trâu trong chuồng'
            ],
            'canh-dan' => [
                'can-chi' => 'Canh Dần',
                'menh-nien' => 'Tùng Bách Mộc',
                'giai-nghia' => 'Gỗ Cây Tùng Bách',
                'ngu-hanh' => 'Mộc',
                'van-so' => 'Xuất Sơn Chi Hổ',
                'luan-giai' => 'Hổ xuống núi'
            ],
            'tan-mao' => [
                'can-chi' => 'Tân Mão',
                'menh-nien' => 'Tùng Bách Mộc',
                'giai-nghia' => 'Gỗ Cây Tùng Bách',
                'ngu-hanh' => 'Mộc',
                'van-so' => 'Ẩn Huyệt Chi Thố',
                'luan-giai' => 'Thỏ trong hang'
            ],
            'nham-thin' => [
                'can-chi' => 'Nhâm Thìn',
                'menh-nien' => 'Trường Lưu Thủy',
                'giai-nghia' => 'Nước Sông Dài',
                'ngu-hanh' => 'Thủy',
                'van-so' => 'Hành Vũ Chi Long',
                'luan-giai' => 'Rồng phun mưa'
            ],
            'quy-ty' => [
                'can-chi' => 'Quý Tỵ',
                'menh-nien' => 'Trường Lưu Thủy',
                'giai-nghia' => 'Nước Sông Dài',
                'ngu-hanh' => 'Thủy',
                'van-so' => 'Thảo Trung Chi Xà',
                'luan-giai' => 'Rắn trong cỏ'
            ],
            'giap-ngo' => [
                'can-chi' => 'Giáp Ngọ',
                'menh-nien' => 'Sa Trung Kim',
                'giai-nghia' => 'Vàng Trong Cát',
                'ngu-hanh' => 'Kim',
                'van-so' => 'Vân Trung Chi Mã',
                'luan-giai' => 'Ngựa trong mây'
            ],
            'at-mui' => [
                'can-chi' => 'Ất Mùi',
                'menh-nien' => 'Sa Trung Kim',
                'giai-nghia' => 'Vàng Trong Cát',
                'ngu-hanh' => 'Kim',
                'van-so' => 'Kính Trọng Chi Dương',
                'luan-giai' => 'Dê được quý mến'
            ],
            'binh-than' => [
                'can-chi' => 'Bính Thân',
                'menh-nien' => 'Sơn Hạ Hỏa',
                'giai-nghia' => 'Lửa Dưới Núi',
                'ngu-hanh' => 'Hỏa',
                'van-so' => 'Sơn Thượng Chi Hầu',
                'luan-giai' => 'Khỉ trên núi'
            ],
            'dinh-dau' => [
                'can-chi' => 'Đinh Dậu',
                'menh-nien' => 'Sơn Hạ Hỏa',
                'giai-nghia' => 'Lửa Dưới Núi',
                'ngu-hanh' => 'Hỏa',
                'van-so' => 'Độc Lập Chi Kê',
                'luan-giai' => 'Gà độc thân'
            ],
            'mau-tuat' => [
                'can-chi' => 'Mậu Tuất',
                'menh-nien' => 'Bình Địa Mộc',
                'giai-nghia' => 'Cây Đồng Bằng',
                'ngu-hanh' => 'Mộc',
                'van-so' => 'Tiến Sơn Chi Cẩu',
                'luan-giai' => 'Chó vào núi'
            ],
            'ky-hoi' => [
                'can-chi' => 'Kỷ Hợi',
                'menh-nien' => 'Bình Địa Mộc',
                'giai-nghia' => 'Cây Đồng Bằng',
                'ngu-hanh' => 'Mộc',
                'van-so' => 'Đạo Viện Chi Trư',
                'luan-giai' => 'Lợn trong tu viện'
            ],
            'canh-ty' => [
                'can-chi' => 'Canh Tý',
                'menh-nien' => 'Bích Thượng Thổ',
                'giai-nghia' => 'Đất Trên Vách',
                'ngu-hanh' => 'Thổ',
                'van-so' => 'Lương Thượng Chi Thử',
                'luan-giai' => 'Chuột trên xà'
            ],
            'tan-suu' => [
                'can-chi' => 'Tân Sửu',
                'menh-nien' => 'Bích Thượng Thổ',
                'giai-nghia' => 'Đất Trên Vách',
                'ngu-hanh' => 'Thổ',
                'van-so' => 'Lộ Đồ Chi Ngưu',
                'luan-giai' => 'Trâu trên đường'
            ],
            'nham-dan' => [
                'can-chi' => 'Nhâm Dần',
                'menh-nien' => 'Kim Bạch Kim',
                'giai-nghia' => 'Kim Dát Vàng',
                'ngu-hanh' => 'Kim',
                'van-so' => 'Quá Lâm Chi Hổ',
                'luan-giai' => 'Hổ qua rừng'
            ],
            'quy-mao' => [
                'can-chi' => 'Quý Mão',
                'menh-nien' => 'Kim Bạch Kim',
                'giai-nghia' => 'Kim Dát Vàng',
                'ngu-hanh' => 'Kim',
                'van-so' => 'Quá Lâm Chi Thố',
                'luan-giai' => 'Thỏ qua rừng'
            ],
            'giap-thin' => [
                'can-chi' => 'Giáp Thìn',
                'menh-nien' => 'Phúc Đăng Hỏa',
                'giai-nghia' => 'Lửa Đèn To',
                'ngu-hanh' => 'Hỏa',
                'van-so' => 'Phục Đầm Chi Lâm',
                'luan-giai' => 'Rồng ẩn ở đầm'
            ],
            'at-ty' => [
                'can-chi' => 'Ất Tỵ',
                'menh-nien' => 'Phúc Đăng Hỏa',
                'giai-nghia' => 'Lửa Đèn To',
                'ngu-hanh' => 'Hỏa',
                'van-so' => 'Xuất Huyệt Chi Xà',
                'luan-giai' => 'Rắn rời hang'
            ],
            'binh-ngo' => [
                'can-chi' => 'Bính Ngọ',
                'menh-nien' => 'Thiên Hà Thủy',
                'giai-nghia' => 'Nước Trên Trời',
                'ngu-hanh' => 'Thủy',
                'van-so' => 'Hành Lộ Chi Mã',
                'luan-giai' => 'Ngựa chạy trên đường'
            ],
            'dinh-mui' => [
                'can-chi' => 'Đinh Mùi',
                'menh-nien' => 'Thiên Hà Thủy',
                'giai-nghia' => 'Nước Trên Trời',
                'ngu-hanh' => 'Thủy',
                'van-so' => 'Thất Quần Chi Dương',
                'luan-giai' => 'Dê lạc đàn'
            ],
            'mau-than' => [
                'can-chi' => 'Mậu Thân',
                'menh-nien' => 'Đại Dịch Thổ',
                'giai-nghia' => 'Đất Nhà Lớn',
                'ngu-hanh' => 'Thổ',
                'van-so' => 'Độc Lập Chi Hầu',
                'luan-giai' => 'Khỉ độc thân'
            ],
            'ky-dau' => [
                'can-chi' => 'Kỷ Dậu',
                'menh-nien' => 'Đại Dịch Thổ',
                'giai-nghia' => 'Đất Nhà Lớn',
                'ngu-hanh' => 'Thổ',
                'van-so' => 'Báo Hiệu Chi Kê',
                'luan-giai' => 'Gà gáy'
            ],
            'canh-tuat' => [
                'can-chi' => 'Canh Tuất',
                'menh-nien' => 'Thoa Xuyến Kim',
                'giai-nghia' => 'Kim Trâm Vòng',
                'ngu-hanh' => 'Kim',
                'van-so' => 'Tự Quan Chi Cẩu',
                'luan-giai' => 'Chó nhà chùa'
            ],
            'tan-hoi' => [
                'can-chi' => 'Tân Hợi',
                'menh-nien' => 'Thoa Xuyến Kim',
                'giai-nghia' => 'Kim Trâm Vòng',
                'ngu-hanh' => 'Kim',
                'van-so' => 'Khuyên Dưỡng Chi Trư',
                'luan-giai' => 'Lợn nuôi nhốt'
            ],
            'nham-ty' => [
                'can-chi' => 'Nhâm Tý',
                'menh-nien' => 'Tang Đố Mộc',
                'giai-nghia' => 'Gỗ Cây Dâu',
                'ngu-hanh' => 'Mộc',
                'van-so' => 'Sơn Thượng Chi Thử',
                'luan-giai' => 'Chuột trên núi'
            ],
            'quy-suu' => [
                'can-chi' => 'Quý Sửu',
                'menh-nien' => 'Tang Đố Mộc',
                'giai-nghia' => 'Gỗ Cây Dâu',
                'ngu-hanh' => 'Mộc',
                'van-so' => 'Lan Ngoại Chi Ngưu',
                'luan-giai' => 'Trâu ngoài chuồng'
            ],
            'giap-dan' => [
                'can-chi' => 'Giáp Dần',
                'menh-nien' => 'Đại Khê Thủy',
                'giai-nghia' => 'Nước Suối Lớn',
                'ngu-hanh' => 'Thủy',
                'van-so' => 'Lập Định Chi Hổ',
                'luan-giai' => 'Hổ tự lập'
            ],
            'at-mao' => [
                'can-chi' => 'Ất Mão',
                'menh-nien' => 'Đại Khê Thủy',
                'giai-nghia' => 'Nước Suối Lớn',
                'ngu-hanh' => 'Thủy',
                'van-so' => 'Đắc Đạo Chi Thố',
                'luan-giai' => 'Thỏ đắc đạo'
            ],
            'binh-thin' => [
                'can-chi' => 'Bính Thìn',
                'menh-nien' => 'Sa Trung Thổ',
                'giai-nghia' => 'Đất Trong Cát',
                'ngu-hanh' => 'Thổ',
                'van-so' => 'Thiên Thượng Chi Long',
                'luan-giai' => 'Rồng trên trời'
            ],
            'dinh-ty' => [
                'can-chi' => 'Đinh Tỵ',
                'menh-nien' => 'Sa Trung Thổ',
                'giai-nghia' => 'Đất Trong Cát',
                'ngu-hanh' => 'Thổ',
                'van-so' => 'Đầm Nội Chi Xà',
                'luan-giai' => 'Rắn trong đầm'
            ],
            'mau-ngo' => [
                'can-chi' => 'Mậu Ngọ',
                'menh-nien' => 'Thiên Thượng Hỏa',
                'giai-nghia' => 'Lửa Trên Trời',
                'ngu-hanh' => 'Hỏa',
                'van-so' => 'Cứu Nội Chi Mã',
                'luan-giai' => 'Ngựa trong chuồng'
            ],
            'ky-mui' => [
                'can-chi' => 'Kỷ Mùi',
                'menh-nien' => 'Thiên Thượng Hỏa',
                'giai-nghia' => 'Lửa Trên Trời',
                'ngu-hanh' => 'Hỏa',
                'van-so' => 'Thảo Dã Chi Dương',
                'luan-giai' => 'Dê đồng cỏ'
            ],
            'canh-than' => [
                'can-chi' => 'Canh Thân',
                'menh-nien' => 'Thạch Lựu Mộc',
                'giai-nghia' => 'Gỗ Cây Lựu',
                'ngu-hanh' => 'Mộc',
                'van-so' => 'Thực Quả Chi Hầu',
                'luan-giai' => 'Khỉ ăn hoa quả'
            ],
            'tan-dau' => [
                'can-chi' => 'Tân Dậu',
                'menh-nien' => 'Thạch Lựu Mộc',
                'giai-nghia' => 'Gỗ Cây Lựu',
                'ngu-hanh' => 'Mộc',
                'van-so' => 'Long Tàng Chi Kê',
                'luan-giai' => 'Gà trong lồng'
            ],
            'nham-tuat' => [
                'can-chi' => 'Nhâm Tuất',
                'menh-nien' => 'Đại Hải Thủy',
                'giai-nghia' => 'Nước Biển Lớn',
                'ngu-hanh' => 'Thủy',
                'van-so' => 'Cố Gia Chi Khuyển',
                'luan-giai' => 'Chó về nhà'
            ],
            'quy-hoi' => [
                'can-chi' => 'Quý Hợi',
                'menh-nien' => 'Đại Hải Thủy',
                'giai-nghia' => 'Nước Biển Lớn',
                'ngu-hanh' => 'Thủy',
                'van-so' => 'Lâm Hạ Chi Trư',
                'luan-giai' => 'Lợn trong rừng'
            ],
        );
        return $menhNienData[$canChi] ?? null;
    }

    /**
     * @param int $year 1990
     * @param string $gender Nam
     * @return array|null
     */
    public static function tinhMenhQuai(int $year, string $gender): array|null
    {
        // Tra bảng để tính Mệnh Quái dựa trên năm sinh và giới tính
        $menhQuaiTable = [
            1 => ['Nam' => 'Khảm', 'Nữ' => 'Cấn'],
            2 => ['Nam' => 'Ly', 'Nữ' => 'Càn'],
            3 => ['Nam' => 'Cấn', 'Nữ' => 'Đoài'],
            4 => ['Nam' => 'Đoài', 'Nữ' => 'Cấn'],
            5 => ['Nam' => 'Càn', 'Nữ' => 'Ly'],
            6 => ['Nam' => 'Khôn', 'Nữ' => 'Khảm'],
            7 => ['Nam' => 'Tốn', 'Nữ' => 'Khôn'],
            8 => ['Nam' => 'Chấn', 'Nữ' => 'Chấn'],
            9 => ['Nam' => 'Khôn', 'Nữ' => 'Tốn'],
        ];

        $menhNguHanh = [
            'Khảm' => 'Thủy',
            'Ly' => 'Hỏa',
            'Cấn' => 'Thổ',
            'Đoài' => 'Kim',
            'Càn' => 'Kim',
            'Khôn' => 'Thổ',
            'Tốn' => 'Mộc',
            'Chấn' => 'Mộc',
        ];

        // Cộng tất cả các chữ số trong năm sinh
        $total = array_sum(str_split($year))%9;
        $total = $total == 0 ? 9 : $total;
        // Xác định Mệnh Quái và Ngũ Hành dựa trên tổng và giới tính
        if (isset($menhQuaiTable[$total])) {
            $menhQuai = $menhQuaiTable[$total][$gender];
            $nguHanh = $menhNguHanh[$menhQuai];

            // Xác định Đông Tứ Mệnh và Tây Tứ Mệnh dựa trên Mệnh Quái
            $dongTuMenh = ['Khảm', 'Ly', 'Chấn', 'Tốn'];
            $tayTuMenh = ['Càn', 'Khôn', 'Cấn', 'Đoài'];
            if (in_array($menhQuai, $dongTuMenh)) {
                $tuMenh = 'Đông Tứ Mệnh';
            } elseif (in_array($menhQuai, $tayTuMenh)) {
                $tuMenh = 'Tây Tứ Mệnh';
            }else{
                $tuMenh = '';
            }
            return ['menh-quai' => $menhQuai, 'ngu-hanh' => $nguHanh, 'tu-menh' => $tuMenh];
        }

        return null;
    }

    public function tinhDuNien(string $cungPhiBanMenh, string $cungPhiHuong): ?string
    {
        return static::$duNien[$cungPhiBanMenh][$cungPhiHuong] ?? null;
    }

}
