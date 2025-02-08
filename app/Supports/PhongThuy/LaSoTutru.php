<?php

namespace App\Supports\PhongThuy;

use Carbon\Carbon;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\File;

class LaSoTutru
{
    const KIM = 1;
    const THUY = 2;
    const MOC = 3;
    const HOA = 4;
    const THO = 5;

    public $can;
    public $chi;
    public $canArr;
    public $chiArr;
    public $chiThang;
    public $arrayMonths;
    public $giosinhArr;
    public $vongTrangSinh;
    public $canTang;
    public $thapthan;
    public $namInfoAl;
    public $saoDepArr;
    public $saoArr;
    public $sao2Arr;
    public $bangKhongVong;
    public $bangMenhQuai;
    public $bangMenhQuaiNu;
    public $cungMenhArr2;
    public $cungMenhTamHop;
    public $cungMenhArr;
    public $diaChiXung;
    public $diaChiHinh;
    public $ngayDuongLich;
    public $ngayAmLich;
    public $gioSinh;
    public $phutSinh;
    public $gioPhutSinh;
    public $ngayDuong, $thangDuong, $namDuong;
    public $ngayAm, $thangAm, $namAm;
    public $gioID;
    public $canNgayId, $chiNgayId;
    public $canGio, $chiGio;
    public $ngaythangNamAm; // ID
    public $ngaythangAm; // ngay am lich
    public $canThangId, $chiThangId;
    public $sex;
    public $thangAmlich;
    public $canNamText, $chiNamText;
    public $canThangText, $chiThangText;
    public $canNgayText, $chiNgayText;
    public $canGioText, $chiGioText;
    public $genderString;
    public $menhQuaiArr;
    public $namAmlich;
    public $ngaySinhFull;
    public $menhAmDuong;
    public $hoTen;
    public $tamtai = '';
    public $canNamSlug, $chiNamSlug, $canThangSlug, $chiThangSlug, $canNgaySlug, $chiNgaySlug, $canGioSlug, $chiGioSlug;
    public $chiInfo = [];
    public $canInfo = [];
    public $tietKhiHienTai;
    public $tietKhiBySex;
    public $diaChiPha = [
        'ti' => 'dau',
        'dau' => 'ti',
        'ngo' => 'mao',
        'mao' => 'ngo',
        'than' => 'ty',
        'ty' => 'than',
        'dan' => 'hoi',
        'hoi' => 'dan',
        'thin' => 'suu',
        'suu' => 'thin',
        'tuat' => 'mui',
        'mui' => 'tuat'
    ];
    public $diaChiHai = [
        'ti' => 'mui',
        'mui' => 'ti',
        'suu' => 'ngo',
        'ngo' => 'suu',
        'dan' => 'ty',
        'ty' => 'dan',
        'mao' => 'thin',
        'thin' => 'mao',
        'than' => 'hoi',
        'hoi' => 'than',
        'dau' => 'tuat',
        'tuat' => 'dau',
    ];
    public $thienCanXung = [
        'canh' => 'giap',
        'tan' => 'at',
        'nham' => 'binh',
        'quy' => 'dinh',
        'giap' => 'mau',
        'at' => 'ky',
        'binh' => 'canh',
        'dinh' => 'tan',
        'mau' => 'nham',
        'ky' => 'quy'
    ];
    public $canAmDuong = [
        'canh' => [
            'name' => 'kim',
            'title' => 'Kim',
            'do' => 36,
            'sex' => 1,
            'id' => 1,
        ],
        'tan' => [
            'name' => 'kim',
            'title' => 'Kim',
            'do' => 36,
            'sex' => 0,
            'id' => 1
        ],
        'nham' => [
            'name' => 'thuy',
            'title' => 'Thủy',
            'do' => 36,
            'sex' => 1,
            'id' => 2
        ],
        'quy' => [
            'name' => 'thuy',
            'title' => 'Thủy',
            'do' => 36,
            'sex' => 0,
            'id' => 2
        ],
        'giap' => [
            'name' => 'moc',
            'title' => 'Mộc',
            'do' => 36,
            'sex' => 1,
            'id' => 3
        ],
        'at' => [
            'name' => 'moc',
            'title' => 'Mộc',
            'do' => 36,
            'sex' => 0,
            'id' => 3
        ],
        'binh' => [
            'name' => 'hoa',
            'title' => 'Hỏa',
            'do' => 36,
            'sex' => 1,
            'id' => 4
        ],
        'dinh' => [
            'name' => 'hoa',
            'title' => 'Hỏa',
            'do' => 36,
            'sex' => 0,
            'id' => 4
        ],
        'mau' => [
            'name' => 'tho',
            'title' => 'Thổ',
            'do' => 36,
            'sex' => 1,
            'id' => 5
        ],
        'ky' => [
            'name' => 'tho',
            'title' => 'Thổ',
            'do' => 36,
            'sex' => 0,
            'id' => 5
        ],
    ];
    public $chiAmDuong = [
        'ti' => [
            'name' => 'thuy',
            'title' => 'Thủy',
            'h' => 'Tý (23h-00:59p)',
            'sex' => 1,
            'id' => 2,
            'do_vuong' => [['quy', 'thuy', 'Thủy', 'do' => 30]]
        ],
        'suu' => [
            'name' => 'tho',
            'title' => 'Thổ',
            'h' => 'Sửu (1h-2:59p)',
            'sex' => 0,
            'id' => 5,
            'do_vuong' => [
                ['ky', 'tho', 'Thổ', 'do' => 18],
                ['quy', 'thuy', 'Thủy', 'do' => 9],
                ['tan', 'kim', 'Kim', 'do' => 3]
            ]
        ],
        'dan' => [
            'name' => 'moc',
            'title' => 'Mộc',
            'h' => 'Dần (3h-4:59p)',
            'sex' => 1,
            'id' => 3,
            'do_vuong' => [
                ['giap', 'moc', 'Mộc', 'do' => 18],
                ['binh', 'hoa', 'Hỏa', 'do' => 9],
                ['mau', 'tho', 'Thổ', 'do' => 3]
            ]
        ],
        'mao' => [
            'name' => 'moc',
            'title' => 'Mộc',
            'h' => 'Mão (5h-6:59p)',
            'sex' => 0,
            'id' => 3,
            'do_vuong' => [
                ['at', 'moc', 'Mộc', 'do' => 30],
            ]
        ],
        'thin' => [
            'name' => 'tho',
            'title' => 'Thổ',
            'h' => 'Thìn (7h-8:59p)',
            'sex' => 1,
            'id' => 5,
            'do_vuong' => [
                ['mau', 'tho', 'Thổ', 'do' => 18],
                ['at', 'moc', 'Mộc', 'do' => 9],
                ['quy', 'thuy', 'Thủy', 'do' => 3]
            ]
        ],
        'ty' => [
            'name' => 'hoa',
            'title' => 'Hỏa',
            'h' => 'Tỵ (9h-10:59p)',
            'sex' => 0,
            'id' => 4,
            'do_vuong' => [
                ['binh', 'hoa', 'Hỏa', 'do' => 18],
                ['canh', 'kim', 'Kim', 'do' => 9],
                ['mau', 'mau', 'Mậu', 'do' => 3]
            ]
        ],
        'ngo' => [
            'name' => 'hoa',
            'title' => 'Hỏa',
            'h' => 'Ngọ (11h-12:59p)',
            'sex' => 1,
            'id' => 4,
            'do_vuong' => [
                ['dinh', 'hoa', 'Hỏa', 'do' => 21],
                ['ky', 'tho', 'Thổ', 'do' => 9],
            ]
        ],
        'mui' => [
            'name' => 'tho',
            'title' => 'Thổ',
            'h' => 'Mùi (13h-14:59p)',
            'sex' => 0,
            'id' => 5,
            'do_vuong' => [
                ['ky', 'tho', 'Thổ', 'do' => 18],
                ['dinh', 'hoa', 'Hỏa', 'do' => 9],
                ['at', 'moc', 'Mộc', 'do' => 3]
            ]
        ],
        'than' => [
            'name' => 'kim',
            'title' => 'Kim',
            'h' => 'Thân (15h-16:59p)',
            'id' => 1,
            'sex' => 1,
            'do_vuong' => [
                ['canh', 'kim', 'Kim', 'do' => 18],
                ['mau', 'tho', 'Thổ', 'do' => 9],
                ['nham', 'thuy', 'Thủy', 'do' => 3]
            ]
        ],
        'dau' => [
            'name' => 'kim',
            'title' => 'Kim',
            'h' => 'Dậu (17h-18:59p)',
            'id' => 1,
            'sex' => 0,
            'do_vuong' => [
                ['tan', 'kim', 'Kim', 'do' => 30],
            ]
        ],
        'tuat' => [
            'name' => 'tho',
            'title' => 'Thổ',
            'h' => 'Tuất (19h-20:59p)',
            'id' => 5,
            'sex' => 1,
            'do_vuong' => [
                ['mau', 'tho', 'Thổ', 'do' => 18],
                ['tan', 'kim', 'Kim', 'do' => 9],
                ['dinh', 'hoa', 'Hỏa', 'do' => 3]
            ]
        ],
        'hoi' => [
            'name' => 'thuy',
            'title' => 'Thủy',
            'h' => 'Hợi (21h-22:59p)',
            'sex' => 0,
            'id' => 2,
            'do_vuong' => [
                ['nham', 'thuy', 'Thủy', 'do' => 21],
                ['giap', 'moc', 'Mộc', 'do' => 9],
            ]
        ],
    ];

    public function setTamTai() {
        if (in_array($this->chiNamSlug, ['than', 'ti', 'thin'])) {
            $this->tamtai = 'Thìn, Mão, Dần';
        } elseif (in_array($this->chiNamSlug, ['ty', 'dau', 'suu'])) {
            $this->tamtai = 'Sửu, Tý, Hợi';
        } elseif (in_array($this->chiNamSlug, ['hoi', 'mao', 'mui'])) {
            $this->tamtai = 'Mùi, Ngọ, Tỵ';
        } elseif (in_array($this->chiNamSlug, ['dan', 'ngo', 'tuat'])) {
            $this->tamtai = 'Tuất, Dậu, Thân';
        }

        return $this;
    }
    public $thapthanLuanGiai = [
        'quan' => [
            'luan_giai' => '<b class="red">Chính quan</b> cho quan chức tốt, chức vụ, học vị, danh dự. Dễ làm sếp nhưng cũng dễ lao lý, những năm có vận Quan nên đề phòng hung cát đan sen, cũng có thể là cơ hội thăng tiến, cũng có thể đua bản thân vào bế tắc, trì trệ, nhưng có thể cát nhiều hơn hung.',
            'vuong' => [
                '- Sức khỏe: Ổn định nếu có ốm thì ốm qua loa, tai nạn nhẹ, dễ gặp hạn',
                '- Gia đạo: Gia đạo bình thường, chỉ dễ hao hụt số tiền nhỏ nhưng lấy lại được.',
                '- Công việc: Nếu đã đi làm thì công việc gặp nhiều sự thăng tiến, thêm cơ hội.',
                '- Tài lộc: tài lộc có thể tăng tiến.',
                '- Học hành thi cử có nhiều sự may mắn hanh thông, nếu có kinh doanh sẽ có nhiều khởi sắc.'
            ],
            'nhuoc' => [
                '- Sức khỏe: Dễ bị ốm đau hoặc ngã, tai nạn.',
                '- Gia đạo: Gia đạo bình thường, chỉ dễ hao hụt số tiền nhỏ do lạm phát. ',
                '- Công việc: Nếu có đi làm thêm thì công việc gặp nhiều thiệt thòi, dễ mất tiền và danh tiếng. ',
                '- Tài lộc: tài lộc chưa có, dễ bị sa sút.',
                '- Học hành thi cử dễ có nhiều trở ngại, nếu có kinh doanh sẽ có nhiều sự thua thiệt.',
            ]
        ],
        'sat' => [
            'luan_giai' => 'Dễ làm ăn đầu tư dễ thua lỗ, tán gia bại sản. Trong chuyện tình cảm, gia đình thì lao đao, không hạnh phúc dễ gặp chuyện không như mong. Có thể dễ hao tài sản, tốn của, gia đình lâm nguy, dễ bị kích động, thậm chí dễ trở thành người ngang ngược, trụy lạc… cần có sự chuẩn bị, cẩn trọng thì mọi việc mói có thể háo hung thành cát.',
            'vuong' => [
                '- Sức khỏe: Chú ý bản thân dễ đau đầu, mệt mỏi, tâm trí bất an. ',
                '- Gia đạo: Dễ có sự xáo trộn, bất đồng, mất lòng.',
                '- Công việc: Dễ có sự mất mất tiền của, được mất đan xen, có người giúp có kẻ hại nhưng vẫn có thể đi lên và làm ăn khá. ',
                '- Tài lộc: Tài lộc vẫn có nhưng chú ý dễ bị chơi xấu, có kẻ chọc gậy bánh xe.',
                '- Học hành thi cử có nhiều sự may mắn hanh thông, nếu có kinh doanh sẽ có nhiều khởi sắc.',
            ],
            'nhuoc' => [
                '- Sức khỏe: Dễ bị ốm đau, bệnh tật, xô sát, tai nạn.',
                '- Gia đạo: Gia đạo dễ bất hòa hoặc xa cách, ly tán. ',
                '- Công việc: Có thể phải thay đổi, đi xa hoặc mất việc, dễ mất tiền và danh tiếng. ',
                '- Tài lộc: Có thể dễ bị sa sút.',
                '- Học hành thi cử dễ có nhiều trở ngại, nếu có kinh doanh sẽ có nhiều sự mất mát dễ đi vào con đường lao lý.',
            ],
        ],
        'an' => [
            'luan_giai' => 'Sau Những năm hạn nhẹ thì đại vận này còn làm kinh doanh vẫn có cơ hội giầu bình thường, có sự sinh trợ giúp đỡ, nhưng không nên phóng túng thì sẽ phát, có thể giúp con cái phát trong thời gian này.',
            'vuong' => [
                '- Sức khỏe: Bình thường, cần chú ý những bệnh phù nề, thừa chất.',
                '- Gia đạo: 5 năm đầu dễ có nhiều biến động nhưng sau đó mọi chuyện sẽ đâu vào đó. Không nên vì người ngoài mà mất tình cảm với người thân. ',
                '- Công việc: Những năm đầu đại vận công việc dễ gặp trắc trở nhưng về sau làm ăn thuận có quý nhân phù trợ. Không nên mơ mộng, mông lung khẻo mất nhiều hơn được. ',
                '- Tài lộc: Tài lộc sẽ nên dần, may mắn hanh thông nhưng không được thái quá kẻo mất hết.',
                '- Học hành thi cử có nhiều sự may mắn, nhưng dễ bị xa đọa ham chơi cần chú ý.',
            ],
            'nhuoc' => [
                '- Sức khỏe: Bình thường, nếu có bệnh tật ắt sẽ có nhiều sự cải thiện.',
                '- Gia đạo: Có nhiều sự chưa thuận nhưng có quý nhân phù trợ, bản thân biết nhìn nhận thấu đáo ắt trong ấm ngoài êm. ',
                '- Công việc: Lúc đầu dễ gặp trắc trở nhưng do gặp vận vượng nên có người giúp đỡ nếu bản thân cần kiệm liêm chính ắt vận mệnh hanh thông. ',
                '- Tài lộc: Tài lộc sẽ nên dần, quyết chí ắt hữu lộc lộc tồn.',
                '- Học hành thi cử có nhiều sự may mắn, nếu chăm chỉ cần cù học ắt có thành tựu.',
            ],
        ],

        'kieu' => [
            'luan_giai' => 'Cơ bản vè hậu vận được an nhàn thảnh thơi, con cái đề hều, nhưng chú ý dễ có sự tranh chấp chiếm đoạt, hãy nên làm mọi sự rõ ràng để tránh hung tinh. Chú ý con cai dẽ có sự tranh chấp về tiền bạc, tài sản nên có thể bất đồng.',
            'vuong' => [
                '- Sức khỏe: Bình thường. ',
                '- Gia đạo: Có nhiều may mắn hanh thông nhưng đan xen sự chiếm đoạt, ắp đặt, vui buồn tại tâm. ',
                '- Công việc: Công việc khi gặp khó khăn ắt có quý nhân trợ giúp, chú ý dễ bị lợi dụng, chèn áp, chơi xấu. ',
                '- Tài lộc: Tài lộc may mắn hanh thông nhưng nên đề phòng, cẩn thân với người xum quanh kẻo thiệt thòi.',
                '- Học hành thi cử có nhiều thay đổi, có thế lực quấy phá nhưng vẫn có thể vươn lên nếu bản thân nỗ lực.',
            ],
            'nhuoc' => [
                '- Sức khỏe: Bình thường. ',
                '- Gia đạo: Có nhiều may mắn hanh thông nhưng cũng cần sự thấu đáo, sẻ chia, đặt mình vào họ thì mọi sự mới cát lành. ',
                '- Công việc: Công việc dễ có sự thay đổi nhưng có quý nhân phù trợ cần kiệm liêm chính ắt vạn sự hanh thông. ',
                '- Tài lộc: Tài lộc may mắn hanh thông nhưng nên đề phòng có kẻ ghen ăn tức ở và chơi xấu.',
                '- Học hành thi cử có nhiều thay đổi, khó khăn nhưng có quý nhân phù trợ. ',
            ],
        ],
        'ty' => [
            'luan_giai' => '10 năm này đại diện cho tay chân cấp dưới, bạn bè, đồng nghiệp cùng phe đồng lòng cũng vượt qua khó khăn, làm ăn có người trợ giúp, không nên nhu nhược, thao túng, chủ quan, kiêu ngạo nếu vậy cát sẽ thành hung.',
            'vuong' => [
                '- Sức khỏe: Bình thường.',
                '- Gia đạo: Có sự đồng lòng, có tin vui từ nữ, bạn bè, đồng nghiệp mang lại nhưng dễ bị chi phối tác động từ bên ngoài.',
                '- Công việc: Có người trợ giúp, thêm những mối quan hệ từ bên ngoài, dễ gặp chuyện những năm tam tai',
                '- Tài lộc: Có thêm tài lộc từ bạn bè, đối tác, đồng nghiệp chú ý dễ hao tiền tài.',
                '- Học hành thi cử có bạn bè giúp đỡ nhưng cũng có một số bạn xấu dụ dỗ cần chú ý thêm.',
            ],
            'nhuoc' => [
                '- Sức khỏe: Dễ ốm đau, tai nạn.',
                '- Gia đạo: Có sự đồng lòng, có tin vui từ nữ, bạn bè, đồng nghiệp mang lại cần có thêm sự thấu hiểu, đồng lòng để gia đình hanh thông viên mãn.',
                '- Công việc: Có bạn bè, anh em trợ giúp, thêm những mối quan hệ từ bên ngoài, dễ gặp chuyện những năm tam tai',
                '- Tài lộc: Có thêm tài lộc từ bạn bè, đối tác, đồng nghiệp, nghề phụ, chú ý không nhu nhược vì sẽ bị thất thoát tài sản vô ịch.',
                '- Học hành thi cử có bạn bè giúp đỡ nhưng cũng chú ý không nên nhu nhược quá sẽ dễ mất chính kiến về sau.',
            ],
        ],
        'kiep' => [
            'luan_giai' => 'Những năm này dễ được anh em, bạn bè, đồng nghiệp giúp đỡ, nhưng làm ăn dễ chỗ nay đập chỗ kía, chú ý trong bạn bè, đồng nghiệp có kẻ nói xấu, chơi đểu hoặc hãm hại. Khi kết giao cũng càn chú trọng kẻo mang rắn và cắn gà nhà. ',
            'vuong' => [
                '- Sức khỏe: Bình thường. ',
                '- Gia đạo: Có sự đồng lòng, có tin vui từ nam, bạn bè, đồng nghiệp mang lại nhưng dễ bị chi phối tác động từ bên ngoài.',
                '- Công việc: Có người trợ giúp, thêm những mối quan hệ từ bên ngoài, dễ gặp chuyện, bị lợi dụng, lừa những năm (lấy theo tam tai của địa chi năm sinh).',
                '- Tài lộc: Có thêm tài lộc từ bạn bè, đối tác, đồng nghiệp chú ý không chủ quan, kiêu ngạo dễ hao tiền tài.',
                '- Học hành thi cử có bạn bè giúp đỡ nhưng cũng có một số bạn xấu dụ dỗ cần chú ý thêm. ',
            ],
            'nhuoc' => [
                '- Sức khỏe: Dễ ốm đau, tai nạn.',
                '- Gia đạo: Có sự đồng lòng, có tin vui từ nam, bạn bè, đồng nghiệp mang lại nhưng trong cát có hung cần có thêm sự thấu đáo, đồng lòng để gia đình hanh thông viên mãn.',
                '- Công việc: Có bạn bè, anh em trợ giúp nhưng cũng có sự hãm hại, chơi xấu dễ gặp chuyện những ',
                '- Tài lộc: Có thêm tài lộc từ bạn bè, đối tác, đồng nghiệp, nghề phụ, chú ý có kẻ lợi dụng, lừa tiền.',
                '- Học hành thi cử có bạn bè giúp đỡ nhưng cũng chú ý không nên chính kiến, nhụt chí sẽ dễ bị mất cơ hội và tiền bác.',
            ],
        ],
        'thuc' => [
            'luan_giai' => 'Những năm này tính tình ôn hòa, rộng rãi với mọi người, hiền lành, thậm chí nhút nhát, đôi khi hơi giả tạo. Dễ người béo, có lộc cuộc sống bình thường, chú ý dễ ốm đau hoặc tai nạn. ',
            'vuong' => [
                '- Sức khỏe: Bình thường, chú ý ốm đau nhẹ. ',
                '- Gia đạo: Gia đạo bình thường, dễ có thêm thanh viên. ',
                '- Công việc: Nếu có đi làm, làm thêm thì công việc gặp nhiều thiệt thòi nhưng vẫn hữu lộc, lộc tồn. ',
                '- Tài lộc: Tài lộc chưa có nhiều.',
                '- Học hành thi cử có nhiều sự may mắn hanh thông, có thể sinh tiền tài.',
            ],
            'nhuoc' => [
                '- Sức khỏe: Dễ bị ốm đau hoặc ngã, tai nạn nhẹ, chú ý dễ gặp hạn hao tiền.',
                '- Gia đạo: Gia đạo dễ có sự bất đồng, dễ hao hụt số tiền nhỏ. ',
                '- Công việc: Dễ gặp nhiều thiệt thòi. Nếu không có sự thay đổi, nỗ lực thì tiền tài có thể đi xuống. ',
                '- Tài lộc:  Tài lộc chưa có.',
                '- Học hành thi cử bình thường, chú ý sức khỏe có thể ốm, yếu.',
            ]
        ],
        'thuong' => [
            'luan_giai' => 'Dễ đụng độ, tranh chấp, hãm hại, thị phi, thôi việc, mất quyền, mất ngôi, do hiếu thắng, tùy tiện nên dễ hao tổn về tiền và tài, tuy là xâu nhưng giảm sát sẽ không gặp hung hại lớn, nếu bản thân không nỗ lực thì cuộc sống khó khăn bế tắc. Bản thân và gia đình dễ ốm đau.',
            'vuong' => [
                '- Sức khỏe: Bình thường, chú ý ốm đau nhẹ. ',
                '- Gia đạo: Gia đạo bình thường, dễ có thêm thanh viên, có sự đố kỵ nhỏ. ',
                '- Công việc: Nếu có đi làm, làm thêm thì công việc sẽ hữu lộc, lộc tồn nhưng chú ý dễ có sự tranh chấp, chiếm đoạt. ',
                '- Tài lộc: Tài lộc bình thường.',
                '- Học hành thi cử có nhiều sự may mắn hanh thông, có thể sinh tiền tài',
            ],
            'nhuoc' => [
                '- Sức khỏe: Dễ bị ốm đau hoặc ngã, tai nạn nhẹ, chú ý dễ gặp hạn hao tiền.',
                '- Gia đạo: Gia đạo dễ có sự bất đồng, dễ hao hụt số tiền nhỏ.',
                '- Công việc: Dễ gặp nhiều thiệt thòi. Nếu không có sự thay đổi, nỗ lực thì tiền tài có thể đi xuống. ',
                '- Tài lộc: Tài lộc chưa có.',
                '- Học hành thi cử bình thường, chú ý sức khỏe có thể ốm, yếu',
            ],
        ],
        'ctai' => [
            'luan_giai' => 'Đại diện cho tài lộc, sản nghiệp, tài vận, tiền lương, cần cù, tiết kiệm, chắc chắn, thật thà, nhưng dễ nhu nhược, vẫn sinh tài bình thường nhưng chưa thuận như mong, đủ ăn đủ tiêu. Có lúc lên nhưng chưa thịnh được.',
            'vuong' => [
                '- Sức khỏe: Sức khỏe bình thường.',
                '- Gia đạo: Dễ gặp chuyện thị phi ảnh hưởng tới bản thân.',
                '- Công việc: Có nhiều khởi sắc.',
                '- Tài lộc: Có cơ hội thăng tiến và phát triển, phát tài, dễ hữu lộc lộc tồn',
                '- Học hành thi cử bình thường, nếu có kinh doanh sẽ có nhiều khởi sắc.',
            ],
            'nhuoc' => [
                '- Sức khỏe: Dễ ốm đau, bệnh tật, sức khỏe yếu.',
                '- Gia đạo: Dễ gặp chuyện thị, bất đồng, tranh chấp, đố kỵ.',
                '- Công việc: Dễ có nhiều thăng trầm.',
                '- Tài lộc: Dễ bị hao hụt, hao tốn tiền của.',
                '- Học hành thi cử dễ sa sút, nếu có kinh doanh sẽ gặp nhiều trắc trở.',
            ]
        ],
        'ttai' => [
            'luan_giai' => 'Đại diện cho của riêng, trúng thưởng, phát tài nhanh, tình cảm với Cha dễ va chạm. Trọng tình cảm, thông minh, lạc quan, phóng khoáng, về tiền tài nếu không biết cách trợ mệnh thì dễ kiếm được rồi lại đi, dễ nợ lần niên miên.',
            'vuong' => [
                '- Sức khỏe: Bình thường. ',
                '- Gia đạo: Dễ trước bất đồng sau hòa thuận. ',
                '- Công việc: Có nhiều khởi sắc dễ sinh tài lộc.',
                '- Tài lộc: Có cơ hội thăng tiến và phát triển, phát tài, dễ hữu lộc lộc tồn',
                '- Học hành thi cử bình thường, nếu có kinh doanh sẽ có nhiều may mắn.',
            ],
            'nhuoc' => [
                '- Sức khỏe: Dễ ốm đau nhẹ, sức khỏe yếu',
                '- Gia đạo: Dễ có sự bất đồng, cái vã, hiểu lầm. ',
                '- Công việc: Dễ có nhiều thăng trầm, thay đổi công việc hoặc chỗ làm.',
                '- Tài lộc: Dễ bị hao hụt tiền của, bỏ ra nhiều thu lại được ít, thất thoạt, lạm phát.',
                '- Học hành thi cử dễ sa sút, nếu có kinh doanh sẽ gặp nhiều trắc trở',
            ],
        ]];

    /**
     * @param $thanNhuoc - Than vuong nhuoc
     * @param $canNam - ngũ hành can nam tiểu vận đó
     *
     */

    public $tieuVanThapthanLuanGiai = [
        'quan' => [
            'luan_giai' => '<b>Chính quan</b> Dễ có chức vụ và sinh tài, nhưng đồng thời cũng hao thân, thân mà vượng thì làm ăn tấn tới, còn suy thì dễ thua lỗ mất chức nợ nần, nhưng cát nhiều hơn hung. Khi làm ăn nên có sự cân nhắc.',
            'kim' => [
                'vuong' => [
                    '- Sức khỏe: bình thường, cần chú ý những bệnh liên quan tới phổi, đường hô hấp. ',
                    '- Gia đạo: dễ có sự đố kị, bất đồng.',
                    '- Công việc: có nhiều sự thay đổi theo hướng tốt, có thể tăng quan tiến chức, nhưng cũng nên cẩn trọng từng bước đi. ',
                    '- Tài lộc: bình thường dễ thăng quan, thăng chức có hữu lộc nhưng vẫn nhiều vất vả.',
                ],
                'nhuoc' => [
                    '- Sức khỏe: dễ ốm đau nhẹ, cần chú ý những bệnh liên quan tới phổi, đường hô hấp. ',
                    '- Gia đạo: dễ có sự xáo trộn, dễ bị hiểu lầm. ',
                    '- Công việc: có nhiều sự thay đổi do thân nhược Kim gặp năm khắc, nên cần chú ý dễ trong cát có hung. ',
                    '- Tài lộc: bình thường dễ thăng chức những khó khăn trồng chất.',
                ],
            ],
            'thuy' => [
                'vuong' => [
                    '- Sức khỏe: bình thường, cần chú ý những bệnh liên quan thận, bàng quang, lá lách và dạ dày (đường ruột)',
                    '- Gia đạo: bình thường.',
                    '- Công việc: có nhiều sự thay đổi theo hướng tốt, nếu giảm bớt sự mộng mơ, cao xa ắt mọi sự thành. ',
                    '- Tài lộc: dễ thăng quan, thăng chức có lộc từ nghành thủy, kim, hỏa.',
                ],
                'nhuoc' => [
                    '- Sức khỏe: dễ ốm đau nhẹ, cần chú ý những bệnh liên quan tới Thận, bàng quang. ',
                    '- Gia đạo: dễ có sự xáo trộn, các thành viên trong gia đình hay bất đồng quan điểm. ',
                    '- Công việc: dễ có nhiều sự thay đổi (đi xuống) có thể do sự chậm chạp kỹ lưỡng mà thành. ',
                    '- Tài lộc: bình thường dễ hao tài thất thoát tiền của.',
                ],
            ],
            'moc' => [
                'vuong' => [
                    '- Sức khỏe: bình thường, cần chú ý những bệnh liên quan tới gan. ',
                    '- Gia đạo: bình thường chú ý một chút trong nhà có người gian trá. ',
                    '- Công việc: có quý nhân phù trợ, cấp trên nâng đỡ, dễ thăng chức, làm ăn hữu lộc. ',
                    '- Tài lộc: tăng tiến nên cần kiệm liêm chính để lộc tồn.',
                ],
                'nhuoc' => [
                    '- Sức khỏe: dễ ốm vặt, cần chú ý những bệnh liên quan tới gan, mật, mắt. ',
                    '- Gia đạo: dễ có sự cãi cọ, tranh giành, đố kỵ. ',
                    '- Công việc: dễ có nhiều sự trì trệ, (đi xuống) có thể do bản thân ý chí kém, vội vàng và buông xuôi nên vậy. ',
                    '- Tài lộc: dễ hao tài tốn của, tiền mất tật mang. ',
                ],
            ],
            'hoa' => [
                'vuong' => [
                    '- Sức khỏe: bình thường, cần chú ý những bệnh liên quan tới mắt và đường máu. ',
                    '- Gia đạo: bình thường. ',
                    '- Công việc: có quý nhân phù trợ tại phương nam, cấp trên nâng đỡ công việc hanh thông, chú ý có sự đố kỵ và hãm hại. ',
                    '- Tài lộc: tăng tiến, thăng quan tiến chức, chú ý có thể bị lợi dụng.',
                ],
                'nhuoc' => [
                    '- Sức khỏe: dễ suy nhược ốm đau, cần chú ý những bệnh liên quan tới mắt, đường máu, đường ruột. ',
                    '- Gia đạo: dễ có sự bất hòa do chưa có tiếng nói chung. ',
                    '- Công việc: dễ đi xuống có thể do bản thân Thiếu sự quyết đoán, trần trừ, nhút nhát, chậm chạp nên vậy. ',
                    '- Tài lộc: hơi kém, dễ hao tài tốn của, nên tránh nơi có nước hoặc liên quan tới thủy. ',
                ],
            ],
            'tho' => [
                'vuong' => [
                    '- Sức khỏe: bình thường, cần chú ý những bệnh liên quan tới mắt và dạ dày. ',
                    '- Gia đạo: bình thường, có thể sinh ra người tài. ',
                    '- Công việc: bình thường, tại hướng tây nam, đông bắc có quý nhân phù trợ công việc hanh thông. ',
                    '- Tài lộc: dễ có thành quả tại những công việc thuộc ngũ hành thổ, thủy.',
                ],
                'nhuoc' => [
                    '- Sức khỏe: dễ suy nhược ốm đau, cần chú ý những bệnh liên quan tới mắt, đường máu, dạ dày',
                    '- Gia đạo: dễ có sự bất hòa do chưa có tiếng nói chung. ',
                    '- Công việc: dễ đi xuống có thể do bản thân Thiếu sự quyết đoán, trần trừ, nhút nhát, chậm chạp nên vậy. ',
                    '- Tài lộc: hơi kém, dễ hao tài tốn của, nên tránh nơi có mộc hoặc liên quan tới mộc.',
                ],
            ]
        ],
        'sat' => [
            'luan_giai' => '<b>Thất sát</b> Dễ có chức vụ và sinh tài, nhưng đồng thời cũng hao thân, thân mà vượng thì làm ăn tấn tới, còn suy thì dễ thua lỗ mất chức nợ nần, nhưng cát nhiều hơn hung. Khi làm ăn nên có sự cân nhắc.',
            'kim' => [
                'vuong' => [
                    '- Sức khỏe: bình thường, cần chú ý những bệnh liên quan tới phổi. ',
                    '- Gia đạo: dễ có sự tranh giành, đấu đá.',
                    '- Công việc: có nhiều sự thay đổi nên cẩn trọng từng bước đi, dễ có sự mưu đồ xấu với mình, nhưng vẫn có sự khởi sắc. ',
                    '- Tài lộc: bình thường có hữu lộc nhưng vẫn nhiều vất vả.',
                ],
                'nhuoc' => [
                    '- Sức khỏe: dễ ốm đau, bệnh tật, tai nạn, cần chú ý những bệnh liên quan tới phổi, đường hô hấp. ',
                    '- Gia đạo: dễ có sự bất hòa về tình cảm và tiền nong. ',
                    '- Công việc: chú ý dễ bị chiếm đoạt, lợi dụng dẫn tới nợ nần có thể lao lý, do thân nhược Kim gặp năm khắc, nên cần chú ý và cẩn trọng. ',
                    '- Tài lộc: xấu dễ hao tài tốn của.',
                ],
            ],
            'thuy' => [
                'vuong' => [
                    '- Sức khỏe: bình thường, cần chú ý những bệnh liên quan thận, xương tủy. ',
                    '- Gia đạo: bình thường.',
                    '- Công việc: có nhiều sự thay đổi nếu giảm bớt sự mộng mơ, đứng núi này trông núi kia ắt mọi sự thành. ',
                    '- Tài lộc: có thể thăng quan, thăng chức nhưng chú ý dễ là con tốt cho họ.',
                ],
                'nhuoc' => [
                    '- Sức khỏe: dễ ốm đau bệnh tật, cần chú ý những bệnh liên quan tới Thận, bàng quang, vùng bụng, tai nạn về tay chân. ',
                    '- Gia đạo: dễ có sự đụng độ, bất hòa. ',
                    '- Công việc: dễ đi xuống có thể do trí nhớ kém, thiếu sự cận thận hay qua loa và buông xuôi mà thành. ',
                    '- Tài lộc: dễ hao tài thất thoát tiền của.',
                ],
            ],
            'moc' => [
                'vuong' => [
                    '- Sức khỏe: bình thường, cần chú ý những bệnh liên quan tới gan, mật. ',
                    '- Gia đạo: bình thường.',
                    '- Công việc: có quý nhân phù trợ, cấp trên nâng đỡ, làm ăn hữu lộc đồng thời cũng có kẻ tiểu nhân tìm cách hãm hại, cần chú ý. ',
                    '- Tài lộc: có sự phát triển, có kẻ đang tìm cách chiếm đoạt.',
                ],
                'nhuoc' => [
                    '- Sức khỏe: dễ đau ốm, bệnh tật, cần chú ý những bệnh liên quan tới gan và mắt. ',
                    '- Gia đạo: dễ có sự bất đồng, tranh chấp. ',
                    '- Công việc: dễ có nhiều sự trì trệ, (đi xuống) có thể do bản thân ý chí kém, vội vàng và buông xuôi nên vậy. ',
                    '- Tài lộc: dễ hao tài tốn của, tiền mất tật mang. ',
                ],
            ],
            'hoa' => [
                'vuong' => [
                    '- Sức khỏe: bình thường, cần chú ý những bệnh liên quan tới mắt và đường máu. ',
                    '- Gia đạo: bình thường. ',
                    '- Công việc: có quý nhân phù trợ tại phương nam, cấp trên nâng đỡ công việc hanh thông, chú ý có sự đố kỵ và hãm hại. ',
                    '- Tài lộc: tăng tiến, thăng quan tiến chức, chú ý có thể bị lợi dụng.',
                ],
                'nhuoc' => [
                    '- Sức khỏe: dễ suy nhược ốm đau, cần chú ý những bệnh liên quan tới tim, mắt, đường máu. ',
                    '- Gia đạo: dễ có sự bất hòa. ',
                    '- Công việc: dễ đi xuống có thể do bản thân Thiếu sự quyết đoán, trần trừ, nhút nhát, chậm chạp nên vậy. ',
                    '- Tài lộc: hơi kém, dễ hao tài tốn của, nên tránh nơi có nước hoặc liên quan tới thủy. ',
                ],
            ],
            'tho' => [
                'vuong' => [
                    '- Sức khỏe: bình thường, cần chú ý những bệnh liên quan tới đại tràng và dạ dày. ',
                    '- Gia đạo: bình thường. không nên quá báo thủ, cố chấp ắt vạn sự như mong. ',
                    '- Công việc: bình thường, tại hướng tây nam, đông bắc có quý nhân phù trợ công việc hanh thông. ',
                    '- Tài lộc: dễ có thành quả tại những công việc thuộc ngũ hành thổ, thủy.',
                ],
                'nhuoc' => [
                    '- Sức khỏe: dễ suy nhược, đau nhức, cần chú ý những bệnh liên quan tới dạ dày, lá lách, đường ruột. ',
                    '- Gia đạo: dễ có sự bất hòa do chưa có tiếng nói chung có thể do nhu nhược, trì trệ mà ra. ',
                    '- Công việc: dễ đi xuống có thể do bản thân dễ lay động, không có sự quyết đoán do dự và tự ti, bảo thủ, nhu nhược, thiếu chứng kiếm, nửa vời cả thèm chóng chán, không có lập trường. ',
                    '- Tài lộc: hơi kém, dễ hao tài tốn của, nên tránh nơi có nước hoặc liên quan tới ngũ hành Mộc. ',
                ],
            ],

        ],
        'an' => [
            'luan_giai' => '<b>Chính ấn</b> Ấn vượng thân cường, trong cuộc sống và công việc dễ gặp vận may, nếu làm ăn sẽ có cơ hội phát triển, nhưng liều lĩnh làm lớn lại có thể gặp bất trắc, cân sự thấu đáo mới có thể đạt được như mong.',
            'kim' => [
                'vuong' => [
                    '- Sức khỏe: bình thường. Nếu có bệnh tật ắt có khởi sắc, lưu ý dễ thừa chất sinh bệnh.',
                    '- Gia đạo: có sự thuận hòa, cảm thông và chia sẻ, chú ý không nên kiêu ngạo sẽ dễ đố kỵ và mất lòng về sau.',
                    '- Công việc: có nhiều khởi sắc hỷ thần tại hướng tây, bắc.',
                    '- Tài lộc: có nhiều khởi sắc, chú ý không nên qua loa, vội vàng kẻo tiền mất tật mang.',
                ],
                'nhuoc' => [
                    '- Sức khỏe: bình thường, có nhiều khởi sắc. ',
                    '- Gia đạo: có sự thuận hòa, nên cảm thông và chia sẻ ắt hạnh phúc viên mãn.',
                    '- Công việc: có nhiều khởi sắc hỷ thần tại hướng tây, tây bắc, đông bắc.',
                    '- Tài lộc: có nhiều khởi sắc, nên cần kiệm liêm chính để sinh tài nhận lộc.',
                ],
            ],
            'thuy' => [
                'vuong' => [
                    '- Sức khỏe: bình thường, lưu ý dễ thừa chất sinh bệnh. (lưu ý bệnh về thận, bàng quang)',
                    '- Gia đạo: có sự thuận hòa, chú ý dễ có sự hão huyền ảo tưởng của cá nhân mà làm mất đi hòa khí.',
                    '- Công việc: có nhiều khởi sắc, nhưng cần chú ý dễ bị lợi dụng, hay qua loa mà cát thành hung.',
                    '- Tài lộc: hữu lộc có nhưng chưa chắc đã giữ được do làm phát phung phí.',
                ],
                'nhuoc' => [
                    '- Sức khỏe: có nhiều khởi sắc, tràn đầy năng lương. Chú ý thêm về những bệnh liên quan tới thận, bàng quang.',
                    '- Gia đạo: có sự thuận hòa, có quý nhân phù trợ, nâng đỡ.',
                    '- Công việc: có nhiều sự thay đổi, phát triển theo hướng tốt.',
                    '- Tài lộc: có nhiều khởi sắc, nên cần kiệm liêm chính để sinh tài nhận lộc.',
                ],
            ],
            'moc' => [
                'vuong' => [
                    '- Sức khỏe: bình thường, lưu ý dễ thừa chất sinh bệnh. (lưu ý bệnh về gan, mật)',
                    '- Gia đạo: bình thường, chú ý dễ vì cố chấp, bảo thủ, nóng giận vội vàng, nói xong mới nghĩ mà bị mất lòng với mọi người.',
                    '- Công việc: chú ý dễ bị lợi dụng, không nên đứng núi nọ trông núi kia mà cuối cùng về không.',
                    '- Tài lộc: bình thường có thể bị hao hụt tiền của do lạm phát.',
                ],
                'nhuoc' => [
                    '- Sức khỏe: có nhiều khởi sắc. Chú ý thêm về những bệnh liên quan tới gan, mật.',
                    '- Gia đạo: có quý nhân phù trợ, nâng đỡ nên hòa khí sẽ tốt dần lên nếu trước đó chưa như mong.',
                    '- Công việc: thêm sự cần kiệm liêm chính, cần thêm nghị lực, gắp khó khăn không lùi bước, ý chí mạnh mẽ ắt mọi sự như mong.',
                    '- Tài lộc: có nhiều khởi sắc, nên cần kiệm liêm chính để sinh tài nhận lộc.',
                ],
            ],
            'hoa' => [
                'vuong' => [
                    '- Sức khỏe: cần có sự chú ý nhiều hơn, vì có thể sẽ đi xuống. (lưu ý bệnh về Tim Mạch, và đường ruột)',
                    '- Gia đạo: có thể do nóng giận, gia trưởng, cố chấp mà bị mất lòng với mọi người dẫn tới sự bất đồng.',
                    '- Công việc: dễ không thuận do thất thời, sai ngành nghề nên dễ có sự thay đổi. ',
                    '- Tài lộc: có thể bị hao hụt tiền của.',
                ],
                'nhuoc' => [
                    '- Sức khỏe: có nhiều khởi sắc. Chú ý thêm về những bệnh liên quan tới Tim Mạch, và đường ruột',
                    '- Gia đạo: nếu gia đình có sự bất đồng ắt những năm này sẽ có sự hòa thuận trở lại, cần có sự thấu đáo, thấu hiểu đệ mọi sự như mong.',
                    '- Công việc: nếu gắp khó khăn không lùi bước, thêm sự quyết đoán, không trần trừ, nhút nhát ắt công việc hanh thông. ',
                    '- Tài lộc: có nhiều khởi sắc. ',
                ],
            ],
            'tho' => [
                'vuong' => [
                    '- Sức khỏe: cần có sự chú ý nhiều hơn về sức khỏe. (lưu ý bệnh về dạ dày và vùng lưng)',
                    '- Gia đạo: có thể do sự gia trưởng, cố chấp, bảo thủ mà gia đình có sự chưa hòa thuận.',
                    '- Công việc: dễ không thuận có thể do tư duy, suy nghĩ và thời vận. ',
                    '- Tài lộc: có thể bị hao hụt tiền của.',
                ],
                'nhuoc' => [
                    '- Sức khỏe: có nhiều khởi sắc. Chú ý thêm về những bệnh liên quan tới dạ dày và vùng thắt lưng',
                    '- Gia đạo: có sự hòa thuận, cần có sự thấu đáo, thấu hiểu đệ mọi sự như mong.',
                    '- Công việc: nếu gắp khó khăn không lùi bước, không dễ lay động, quyết đoán không do dự và tự ti, bảo thủ, nhu nhược ắt công việc hanh thông. ',
                    '- Tài lộc: có nhiều khởi sắc. ',
                ],
            ],

        ],
        'kieu' => [
            'luan_giai' => '<b>Kiêu - Thiên ấn</b> Những năm này làm nghề dịch vụ dễ ăn nên làm ra, nhưng cũng có sự tranh chấp chiếm đoạt, cần phải cẩn trong không là vạ oan, chú chú sức khỏe bản thân và vợ con.',
            'kim' => [
                'vuong' => [
                    '- Sức khỏe: bình thường. (lưu ý đường hô hấp)',
                    '- Gia đạo: cần có sự cảm thông, thấu đáo và chia sẻ mới vạn sự như mong, tránh lời qua tiếng lại kẻo bất hòa.',
                    '- Công việc: dễ có nhiều sự thay đổi, chú ý có thể bị chiếm đoạt, tranh chấp, không nên quá cứng nhắc.',
                    '- Tài lộc: bình thường, dễ có sự hao tốn.',
                ],
                'nhuoc' => [
                    '- Sức khỏe: bình thường, có nhiều khởi sắc nếu có những bệnh liên quan tới phổi và đường hô hấp.',
                    '- Gia đạo: có sự thuận hòa, nếu có sự cảm thông, đồng lòng ắt hạnh phúc về sau.',
                    '- Công việc: có nhiều khởi sắc, có quý nhân trợ giúp thêm sự linh động giảm sự dụt dè ắt sẽ tốt về sau.',
                    '- Tài lộc: có nhiều khởi sắc, nên cần kiệm liêm chính để sinh tài nhận lộc.',
                ],
            ],
            'thuy' => [
                'vuong' => [
                    '- Sức khỏe: bình thường, lưu ý dễ thừa chất sinh bệnh. (lưu ý bệnh về thận, bàng quang)',
                    '- Gia đạo: bình thường, bản thân cần giảm sự toan tính, chi ly của bản thân đê đỡ làm mất đi hòa khí.',
                    '- Công việc: có khởi sắc, nhưng cần chú ý dễ bị lợi dụng, lừa gạt, hay qua loa mà cát thành hung. ',
                    '- Tài lộc: không nên lạm phát phung phí để giữ lại được tiền của.',
                ],
                'nhuoc' => [
                    '- Sức khỏe: có nhiều khởi sắc, tràn đầy năng lương. Chú ý thêm về những bệnh liên quan tới thận, bàng quang.',
                    '- Gia đạo: có sự thuận hòa, có quý nhân phù trợ, nâng đỡ khi gặp trục trặc ắt được giải nguy.',
                    '- Công việc: có nhiều sự thay đổi, phát triển theo hướng tốt, chú ý có kẻ muốn lừa gạt, chiếm đoạt. ',
                    '- Tài lộc: có nhiều khởi sắc, cần cù, nỗ lực ắt có thành quả như mong. ',
                ],
            ],
            'moc' => [
                'vuong' => [
                    '- Sức khỏe: bình thường, lưu ý về gan, mật nên đi khám và kiểm tra định kỳ.',
                    '- Gia đạo: bình thường, chú ý dễ vì cố chấp, bảo thủ, nóng giận, tranh giành mà ảnh hưởng tới hòa khí.',
                    '- Công việc: chú ý dễ bị lợi dụng, nếu bản thân bảo thủ, cứng rắn quá sẽ dễ mất đi đồng đội từ đó công việc có nhiều sự xáo trộn.',
                    '- Tài lộc: bình thường có thể bị hao hụt tiền của.',
                ],
                'nhuoc' => [
                    '- Sức khỏe: có nhiều sự khởi sắc. Chú ý thêm về những bệnh liên quan tới gan, mật. sức khỏe có thể kém',
                    '- Gia đạo: có sự thay đổi theo chiều hướng tốt lên trong năm này.',
                    '- Công việc: nếu có thêm nghị lực, gắp khó khăn không lùi bước, ý chí mạnh mẽ ắt sẽ vượt qua được khó khăn.',
                    '- Tài lộc: có thêm tài lộc từ ngũ hành thủy (từ phương bắc, nghành nghề thuộc thủy).',
                ],
            ],
            'hoa' => [
                'vuong' => [
                    '- Sức khỏe: cần có sự chú ý nhiều hơn, (lưu ý bệnh về Tim Mạch, và đường ruột, nóng trong)',
                    '- Gia đạo: có thể do nóng giận, gia trưởng, cố chấp mà bị mất lòng với mọi người dẫn tới sự bất đồng.',
                    '- Công việc: dễ không thuận do thất thời, sai ngành nghề, nóng giận, hơn thua nên dễ có sự thay đổi.',
                    '- Tài lộc: có thể bị hao hụt tiền của.',
                ],
                'nhuoc' => [
                    '- Sức khỏe: có nhiều khởi sắc. Chú ý thêm về những bệnh liên quan tới Tim Mạch, và đường ruột',
                    '- Gia đạo: cần có sự thấu đáo, thấu hiểu, mạnh mẽ để mọi sự như mong.',
                    '- Công việc: nếu gắp khó khăn không lùi bước, nhút nhát thêm phần mạnh ắt công việc hanh thông. Lưu ý có kẻ muốn chiếm đoạt, tranh giành.',
                    '- Tài lộc: có nhiều khởi sắc, chú ý có kẻ muốn lợi dụng và chiếm đoạt.',
                ],
            ],
            'tho' => [
                'vuong' => [
                    '- Sức khỏe: tuy được sinh trợ là tốt nhưng hung cát đan xen, cần có sự chú ý về sức khỏe. (lưu ý bệnh về dạ dày và vùng lưng)',
                    '- Gia đạo: có thể do sự cố chấp, bảo thủ mà gia đình có sự chưa hòa thuận cần có thêm sự thấu đáo, lăng nghe sau mới thuận.',
                    '- Công việc: dễ không thuận có thể do tư duy, suy nghĩ và thời vận, chú ý có kẻ muốn lợi dụng và chiếm đoạt. ',
                    '- Tài lộc: có thể bị hao hụt tiền của.',
                ],
                'nhuoc' => [
                    '- Sức khỏe: thân nhược lại được trợ nên có nhiều khởi sắc. Chú ý thêm về những bệnh liên quan tới dạ dày và vùng thắt lưng',
                    '- Gia đạo: có sẽ sự hòa thuận, nhưng cần có sự thấu đáo, thấu hiểu, giảm nhu nhược để mọi sự như mong.',
                    '- Công việc: nếu gắp khó khăn không lùi bước, không dễ lay động, quyết đoán không do dự, tự ti, bảo thủ, nhu nhược ắt công việc hanh thông.',
                    '- Tài lộc: có nhiều khởi sắc. ',
                ],
            ],

        ],
        'ty' => [
            'luan_giai' => '<b>Tỷ Kiên</b> - Đại diện cho tay chân cấp dưới, bạn bè, đồng nghiệp cùng phe đồng lòng cũng vượt qua khó khăn, làm ăn có người trợ giúp, không nên nhu nhược, thao túng, chủ quan, kiêu ngạo nếu vậy cát sẽ thành hung. ',
            'kim' => [
                'vuong' => [
                    '- Sức khỏe: bình thường. (chú ý dễ ốm vặt hoặc khởi phát bệnh)',
                    '- Gia đạo: có thể dễ bất đồng do người bên ngoài tác động vào. ',
                    '- Công việc: dễ có nhiều sự thay đổi có bản thân quá cứng nhắc và có tác động xấu từ người ngoài vào. ',
                    '- Tài lộc: bình thường, dễ có sự lạm phát, mất nhiều hơn được.',
                ],
                'nhuoc' => [
                    '- Sức khỏe: có nhiều khởi sắc nếu có những bệnh liên quan tới thực quản, xoang, tuyến giáp, phổi, phế quản. ',
                    '- Gia đạo: thêm sự quyết đoán, mạnh mẽ ắt gia đạo thuận hòa.',
                    '- Công việc: có bạn bè, đồng nghiệp giúp đỡ, bản thân thêm sự linh động, chính kiến giảm sự dụt dè ắt công việc sẽ hanh thông. ',
                    '- Tài lộc: có nhiều khởi sắc, nên cần kiệm liêm chính để sinh tài nhận lộc.',
                ],
            ],
            'thuy' => [
                'vuong' => [
                    '- Sức khỏe: bình thường, lưu ý về những bệnh thận, bàng quang, xương tủy. ',
                    '- Gia đạo: bình thường, chú ý không nghe lời xui bẩy, nghe một phía mà dễ làm ảnh hưởng tới tình cảm gia đình.',
                    '- Công việc: công việc có nhiều sự thuận lợi tới từ anh em, bạn bè, đồng nghiệp nhưng cũng từ đó mà sinh ra thị phi phiền toái, gia chủ cần chú ý. ',
                    '- Tài lộc: dễ lạm phát phung phí mà tiền mất tật mang.',
                ],
                'nhuoc' => [
                    '- Sức khỏe: bình thường, chú ý những bệnh liên quan tới thận, bàng quang có thể khởi phát. ',
                    '- Gia đạo: có sự thuận hòa, có nhiều tin vui từ anh em bạn bè trợ giúp.',
                    '- Công việc: có nhiều sự thay đổi, phát triển theo hướng tốt, có anh em, bạn bè, đồng nghiệp trợ giúp, hỷ thần tại hướng bắc. ',
                    '- Tài lộc: có nhiều khởi sắc, cần cù, nỗ lực ắt có kết quả cát lành.',
                ],
            ],
            'moc' => [
                'vuong' => [
                    '- Sức khỏe: bình thường, lưu ý về bệnh cơ, gân, mắt và dễ nóng giận. ',
                    '- Gia đạo: bình thường, chú ý dễ bị mất hòa khí do tác động từ bên ngoài và bản thân khá cố chấp, bảo thủ.',
                    '- Công việc: bình thường, nhưng cần chú ý khi kết giao hoặc đầu tư kẻo tiền mất tật mang. ',
                    '- Tài lộc: bình thường có thể mất tiền oan. ',
                ],
                'nhuoc' => [
                    '- Sức khỏe: bình thường. Chú ý thêm về những bệnh liên quan tới gan, mật, mắt. ',
                    '- Gia đạo: bình thường, nếu có khó khăn ắt có người trợ giúp, nên thấu tình đạt lý, tu tâm để bền phúc.',
                    '- Công việc: có sự thuận lợi, có mọi người giúp đỡ, nếu làm công việc thuộc ngũ hành mộc sẽ có nhiều sự thuận lợi. ',
                    '- Tài lộc: bình thường dễ hữu lộc vào đầu năm và cuối năm.  ',
                ],
            ],
            'hoa' => [
                'vuong' => [
                    '- Sức khỏe: cần có sự chú ý nhiều hơn, (lưu ý dễ trúng gió, khoặc cấm khẩu, méo miệng.vv…)',
                    '- Gia đạo: nên giảm nóng giận, gia trưởng, cố chấp để gia đình hạnh phúc viên mãn hơn.',
                    '- Công việc: có thể do tư duy, tính nết cách ứng xử mà công việc có chiều hướng được ít mất nhiều, gia chủ nên cân nhắc. ',
                    '- Tài lộc: có thể bị hao hụt tiền của vào mùa xuân và hạ.',
                ],
                'nhuoc' => [
                    '- Sức khỏe: bình thường. Chú ý thêm về những bệnh liên quan tới mắt, đường máu, tim mạch. ',
                    '- Gia đạo: có sự hòa thuận trở lại, cần mạnh mẽ, ý chí để duy trì lâu dài.',
                    '- Công việc: nếu chọn công việc thuộc ngũ hành Hỏa công thêm bản thân mạnh mẽ, quyết đoán, bền bỉ ắt công việc hanh thông.',
                    '- Tài lộc: có nhiều khởi sắc, may mắn.',
                ],
            ],
            'tho' => [
                'vuong' => [
                    '- Sức khỏe: có thể kém đi nếu sinh hoạt thái quá dễ mắc bệnh về dạ dày và vùng lưng.',
                    '- Gia đạo: nếu cố chấp, gia trưởng, không lắng nghe gia đình dễ lục đục.',
                    '- Công việc: Chú ý có kẻ muốn lợi dụng, đố kỵ có thể sẽ ảnh hưởng xấu tới công việc, có thể chọn công việc thuộc ngũ hành kim hoặc thủy.',
                    '- Tài lộc: có thể bị hao hụt tiền của.',
                ],
                'nhuoc' => [
                    '- Sức khỏe: dễ ốm vặt nhất nhưng năm Giáp, Ất, Nhâm Quý',
                    '- Gia đạo: dễ có nhiều sự thay đổi, nếu bản thân nhu nhược, ắt không có tiếng nói trong gia đình.',
                    '- Công việc: có nhiều khởi sắc do có quý nhân trợ giúp hỷ thần tại phương tây nam, đông bắc, nghề hợp thuộc ngũ hành thổ. ',
                    '- Tài lộc: có nhiều khởi sắc. ',
                ],
            ],

        ],
        'kiep' => [
            'luan_giai' => '<b>Kiếp tài</b> Những năm này dễ được anh em, bạn bè, đồng nghiệp giúp đỡ, nhưng làm ăn dễ chỗ nay đập chỗ kía, chú ý trong bạn bè, đồng nghiệp có kẻ nói xấu, chơi đểu hoặc hãm hại. Khi kết giao cũng càn chú trọng kẻo mang rắn và cắn gà nhà.',
            'kim' => [
                'vuong' => [
                    '- Sức khỏe: bình thường. (chú ý không nên chơi bời, nhậu thái quá sẽ ảnh hưởng tới sức khỏe về sau)',
                    '- Gia đạo: có thể dễ bất đồng do bản thiên về người ngoài hơn gia đình. ',
                    '- Công việc: dễ có nhiều sự thay đổi vì trong bạn bè có người tốt kẻ xấu nếu không thấu đáo, cẩn trọng ắt cát thành hung. ',
                    '-
                      Tài lộc: bình thường, dễ có sự lạm phát, mất nhiều hơn được.',
                ],
                'nhuoc' => [
                    '- Sức khỏe: có nhiều khởi sắc nếu có những bệnh liên quan tới thực quản, xoang, tuyến giáp. ',
                    '- Gia đạo: có sự thuận hòa, có anh em bạn bè giúp đỡ, thêm sự quyết đoán, mạnh mẽ ắt mọi sự như mong.',
                    '- Công việc: có nhiều khởi sắc, có bạn bè, đồng nghiệp trợ giúp, bản thân thêm sự linh động, chính kiến giảm sự dụt dè ắt sẽ tốt về sau. ',
                    '- Tài lộc: có nhiều khởi sắc, nên cần kiệm liêm chính để sinh tài nhận lộc.',
                ],
            ],
            'thuy' => [
                'vuong' => [
                    '- Sức khỏe: bình thường, lưu ý dễ buông thả sinh bệnh. ',
                    '- Gia đạo: bình thường, bản thân cần lắng nghe thấu đáo, không nghe bên ngoài để giữ gia đình trong ấm, ngoài êm.',
                    '- Công việc: có khởi sắc, nhưng cần chú ý dễ bị lợi dụng, chơi xấu, hãm hại mà cát thành hung. ',
                    '- Tài lộc: không nên lạm phát phung phí kẻo tiền mất tật mang.',
                ],
                'nhuoc' => [
                    '- Sức khỏe: bình thường, có nhiều khởi sắc nếu đang có bệnh liên quan tới thận, bàng quang. ',
                    '- Gia đạo: có sự thuận hòa, có nhiều tin vui từ anh em bạn bè.',
                    '- Công việc: có nhiều sự thay đổi, phát triển theo hướng tốt, có anh em, bạn bè, đồng nghiệp trợ giúp, bản thân nên nỗ lực thêm ắt đổi vận. ',
                    '- Tài lộc: có nhiều khởi sắc, cần cù, nỗ lực ắt có kết quả cát lành.',
                ],
            ],
            'moc' => [
                'vuong' => [
                    '- Sức khỏe: bình thường, lưu ý về bệnh cơ, gân, mắt và dễ nóng giận. ',
                    '- Gia đạo: bình thường, chú ý đừng vì người khác mà làm mất hòa khí với gia đình.',
                    '- Công việc: chú ý dễ bị lợi dụng, xui khiến, nghe một tai, hùa theo mà công việc dễ bị xáo trộn, thay đổi và đi xuống. ',
                    '- Tài lộc: bình thường có thể bị hao hụt tiền của.',
                ],
                'nhuoc' => [
                    '- Sức khỏe: bình thường. Chú ý thêm về những bệnh liên quan tới gan, mật. ',
                    '- Gia đạo: bình thường, những năm này có nhiều niềm vui trong gia trung.',
                    '- Công việc: có nhiều thuận lợi, có anh em bạn bè, đồng nghiệp trợ giúp, làm những công việc thuộc ngũ hành mộc ắt có thành quả. ',
                    '- Tài lộc: có thêm tài lộc từ ngũ hành mộc ',
                ],
            ],
            'hoa' => [
                'vuong' => [
                    '- Sức khỏe: cần có sự chú ý nhiều hơn, (lưu ý dễ trúng gió, khoặc cấm khẩu, méo miệng.vv…)',
                    '- Gia đạo: nên giảm nóng giận, gia trưởng, cố chấp ắt gia đình hòa thuận, đồng lòng.',
                    '- Công việc: dễ không thuận do tư duy, suy nghĩ, cách làm, tính cách hiện tại gây ra, cần chú ý anh em, bạn bè, đồng nghiệp chơi xấu. ',
                    '- Tài lộc: có thể bị hao hụt tiền của.',
                ],
                'nhuoc' => [
                    '- Sức khỏe: bình thường. Chú ý thêm về những bệnh liên quan tới mắt, đường máu, tim mạch. ',
                    '- Gia đạo: có sự hòa thuận chở lại, cần mạnh mẽ, ý chí để duy trì lâu dài.',
                    '- Công việc: nếu gắp khó khăn không lùi bước, mạnh mẽ, quyết đoán, bền bỉ ắt công việc hanh thông.',
                    '- Tài lộc: có nhiều khởi sắc, chú ý có kẻ muốn lợi dụng, chơi xấu.',
                ],
            ],
            'tho' => [
                'vuong' => [
                    '- Sức khỏe: bình thường nhưng cần lưu ý: nếu sinh hoạt thái quá thì dễ mắc bệnh về dạ dày và vùng lưng.',
                    '- Gia đạo: có thể do sự cố chấp, gia trưởng, trì trệ mà gia đình có sự chưa hòa thuận, cần chú ý thêm.',
                    '- Công việc: có thể do tư duy, suy nghĩ và thời vận, nghành nghề mà công việc hung cát đan xen. Chú ý có kẻ muốn lợi dụng, tranh giành.',
                    '- Tài lộc: có thể bị hao hụt tiền của.',
                ],
                'nhuoc' => [
                    '- Sức khỏe: bình thường, nếu có bệnh sẽ khởi sắc. Chú ý thêm về những bệnh liên quan tới dạ dày và vùng thắt lưng',
                    '- Gia đạo: bình thường, dễ có nhiều sự thay đổi, bản thân nên có ý chí kiên cường hơn để mọi sự như mong.',
                    '- Công việc: nếu bản thân không dễ lay động, quyết đoán không do dự, bảo thủ, ắt có bạn bè, đồng nghiệp giúp đỡ công việc sẽ hanh thông. ',
                    '- Tài lộc: có nhiều khởi sắc. ',
                ],
            ],

        ],
        'thuong' => [
            'luan_giai' => '<b>Thương quan</b> Dễ mất chức, thôi việc, mất quyền, mất ngôi, do hiếu thắng, tùy tiện nên dễ hao tổn về tiền và tài, tuy là xâu nhưng giảm sát sẽ không gặp hung hại lớn, nếu bản thân không nỗ lực thì cuộc sống khó khăn bế tắc. Bản thân và vợ con dể ốm đau.',
            'kim' => [
                'vuong' => [
                    '- Sức khỏe: chú ý về sức khỏe dễ ốm đau, sức khỏe có tình trạng mệt mỏi, trì trệ.',
                    '- Gia đạo: dễ có sự bất hòa chưa thấu hiểu nhau, có thể có thêm thành viên mới.',
                    '- Công việc: dễ có nhiều sự thay đổi, có sự hao tốn và thiệt thòi, nhưng có sự phát triển về sau.',
                    '- Tài lộc: dễ bị hao tốn tiền của, nhưng vẫn sinh tài có lộc vào những tháng đầu năm.',
                ],
                'nhuoc' => [
                    '- Sức khỏe: chú ý về sức khỏe thân nhược lại gặp năm hao, dễ ốm vặt.',
                    '- Gia đạo: dễ có sự lục đục một phần do công việc và tiền bạc kém.',
                    '- Công việc: dễ có nhiều sự thay đổi.',
                    '- Tài lộc: dễ bị hao tài tốn của. Cần bổ sung thêm ngũ hành kim, tháng tốt 7 -8 âm lịch có nhiều sự may mắn',
                ],
            ],
            'thuy' => [
                'vuong' => [
                    '- Sức khỏe: bình thường.',
                    '- Gia đạo: có nhiều sự thay đổi dễ cso thành viên mới vào tháng đầu năm (mùa xuân).',
                    '- Công việc: có thể sinh tài lộc vào những tháng cuối của 4 mùa (3-6-9-12) và tháng 4-5 mùa hạ.',
                    '- Tài lộc: tài lộc dễ phát nếu làm nghành nghề thuộc ngũ hành hỏa, mộc (cụ thể xem phần nghành nghề).',
                ],
                'nhuoc' => [
                    '- Sức khỏe: chú ý về sức khỏe dễ ốm vặt.',
                    '- Gia đạo: bản thân có đôi chút miu mô, dễ buông xuôi nên gia đạo dễ có sự bất hòa.',
                    '- Công việc: dễ có nhiều sự thay đổi. Nên làm những ngành nghề thuộc ngũ hành Thủy, Kim để có nhiều may mắn hơn. ',
                    '- Tài lộc: dễ bị hao tài tốn của. Cần bổ sung thêm ngũ hành Thủy, tháng tốt 10 -11 âm lịch có nhiều sự may mắn',
                ],
            ],
            'moc' => [
                'vuong' => [
                    '- Sức khỏe: bình thường.',
                    '- Gia đạo: dễ có sự bất hòa vào những tháng 1-2- 10 – 11 âm lịch.',
                    '- Công việc: dễ có nhiều sự thay đổi, có thể chọn công việc thuộc ngũ hành Thổ, Thủy để giảm sát.',
                    '- Tài lộc: dễ bị hao mòn.',
                ],
                'nhuoc' => [
                    '- Sức khỏe: chú ý về sức khỏe dễ ốm vặt có thể liên quan tới gan, mật.',
                    '- Gia đạo: có sự chưa hòa thuận cần bổ sung thêm ngũ hành Mộc để mọi sự may mắn hơn.',
                    '- Công việc: dễ có nhiều sự thay đổi. Dễ làm nhiều mà không có dư giả. ',
                    '- Tài lộc: ít. Cần bổ sung thêm ngũ hành Mộc, Thủy, tháng tốt 1 -2- 10 - 11 âm lịch có nhiều sự may mắn',
                ],
            ],
            'hoa' => [
                'vuong' => [
                    '- Sức khỏe: bình thường.',
                    '- Gia đạo: bình thường, không nên quá khái tính và quy tắc để gia đình hạnh phúc viên mãn hơn.',
                    '- Công việc: bình thường, dễ sinh tài lộc vào những tháng 6-7 và cuối các mùa trong năm.',
                    '- Tài lộc: bình thường, có khả năng thăng tiến và thêm tiền của.',
                ],
                'nhuoc' => [
                    '- Sức khỏe: dễ ốm vặt chú ý những bệnh về mắt, tim, ruột non và lưỡi.',
                    '- Gia đạo: dễ chưa thuận hòa, một phần do bản thân Thiếu sự quyết đoán, trần trừ, nhút nhát.',
                    '- Công việc: dễ gặp thị phi, làm nhiều được ít, kiếm được mà không dư, cần bổ sung ngũ hành hỏa để thêm may mắn.',
                    '- Tài lộc: dễ bị hao tài tốn của. Cần bổ sung thêm ngũ hành Mộc, Hỏa, tháng tốt 1-2-4-5 âm lịch có nhiều sự may mắn',
                ],
            ],
            'tho' => [
                'vuong' => [
                    '- Sức khỏe: chú ý về sức khỏe dễ ốm đau nhẹ.',
                    '- Gia đạo: dễ có sự hao tốn tiền của, nhưng lại là tin vui cho đi để nhận về.',
                    '- Công việc: dễ có nhiều sự thay đổi nếu bản thân hiếu thắng, tuy có chút hao mòn nhưng vẫn có thể ăn nên làm ra. ',
                    '- Tài lộc: dễ bị hao tốn tiền của, nhưng vẫn sinh tài có lộc vào những tháng cuối năm.',
                ],
                'nhuoc' => [
                    '- Sức khỏe: tuy những năm này thuộc hệ tương sinh là tốt nhưng vẫn chú ý về sức khỏe dễ ốm vặt.',
                    '- Gia đạo: có thêm sự mất hòa thuận, cần bổ sung thêm ngũ hành thổ và không dễ bị lay động, thêm sự quyết đoán thì mọi sự sẽ như mong.',
                    '- Công việc: có thể do sức khỏe yếu cộng thêm năm hao tiền tài nên công việc dễ có nhiều sự thay đổi. ',
                    '- Tài lộc: dễ bị hao tài tốn của. Cần bổ sung thêm ngũ hành thổ, tháng tốt 3- 6-9-12 âm lịch có nhiều sự may mắn',
                ],
            ],

        ],
        'thuc' => [
            'luan_giai' => '<b>Thực thần</b> Những năm này dễ nhận phúc thọ, có lộc, dễ sinh tình, sinh con. Làm ăn dễ sinh tài lộc, lộc tài tại phương vị và nghành nghề thuộc ngũ hành theo dụng thần, nhưng trong cát có hung chú ý dễ hao tiền, nên cần chú trọng.',
            'kim' => [
                'vuong' => [
                    '- Sức khỏe: bình thường.',
                    '- Gia đạo: dễ có thêm thành viên mới, nếu có những sự bất đồng sẽ được hóa giải.',
                    '- Công việc: dễ có nhiều sự thay đổi theo chiều hướng tốt, những công việc thuộc ngũ hành mộc, nghề tự do sẽ sinh nhiều tài lộc.',
                    '- Tài lộc: tăng tiến, có thêm nhiều tiền của nhất là từ ngũ hành mộc.',
                ],
                'nhuoc' => [
                    '- Sức khỏe: bình thường có thể ốm đau nhẹ.',
                    '- Gia đạo: bình thường tuy có chút hao tiền tài nhưng cũng có niềm vui theo kèm như kiểu mất để được.',
                    '- Công việc: dễ có nhiều sự thay đổi theo chiều hướng đi xuống, có cát lợi cho nghề tự do, nên làm công việc thuộc ngũ hành Kim để có tài lộc. ',
                    '- Tài lộc: chưa có. Cần bổ sung thêm ngũ hành kim, tháng tốt 7 -8 âm lịch có nhiều sự may mắn.',
                ],
            ],
            'thuy' => [
                'vuong' => [
                    '- Sức khỏe: bình thường.',
                    '- Gia đạo: không nên giả tạo và nhút nhát thì gia đình ắt yên vui, có thể thêm thành viên mới trong gia đình. ',
                    '- Công việc: có thể sinh tài lộc vào những tháng cuối của 4 mùa (3-6-9-12) và tháng 4-5 mùa hạ.',
                    '- Tài lộc: tài lộc dễ phát nếu làm nghành nghề thuộc ngũ hành hỏa, thổ (cụ thể xem phần nghành nghề). ',
                ],
                'nhuoc' => [
                    '- Sức khỏe: chú ý về sức khỏe dễ ốm vặt hoặc khởi phát bệnh tật về thận.',
                    '- Gia đạo: dễ có sự bất hòa, nên có sự đồng lòng, chú ý những tháng cuối mùa gia đình dễ có va chạm.',
                    '- Công việc: dễ có nhiều sự thay đổi theo hướng xấu, những ngành nghề thuộc ngũ hành Thủy, Kim để có nhiều may mắn hơn. ',
                    '- Tài lộc: dễ bị hao tài tốn của. Cần bổ sung thêm ngũ hành Thủy, tháng tốt 6-7- 10 -11 âm lịch dễ có lộc. ',
                ],
            ],
            'moc' => [
                'vuong' => [
                    '- Sức khỏe: bình thường. ',
                    '- Gia đạo: bình thường có sự bất đồng nhỏ, có thể hao hụt tiền của nhưng vào công việc tốt.',
                    '- Công việc: dễ sinh tài lộc, nếu làm công việc thuộc ngũ hành Thổ, hỏa.',
                    '- Tài lộc: bình thường, có thể tăng tiến.',
                ],
                'nhuoc' => [
                    '- Sức khỏe: dễ ốm vặt có thể liên quan về mắt.',
                    '- Gia đạo: dễ có sự đấu đá, chia rẽ, bản thân có thể bất hòa với gia đình.',
                    '- Công việc: dễ có nhiều sự thay đổi, không có dư giả nên chọn công việc thuộc ngũ hành Mộc để tốt dần lên. ',
                    '- Tài lộc: ít. Cần bổ sung thêm ngũ hành Mộc, Thủy, tháng tốt 1 -2- 10 - 11 âm lịch có nhiều sự may mắn.',
                ],
            ],
            'hoa' => [
                'vuong' => [
                    '- Sức khỏe: bình thường.',
                    '- Gia đạo: bình thường, có thể gia đình có thành viên mới.',
                    '- Công việc: bình thường, dễ sinh tài lộc vào những tháng 6-7 và cuối các mùa trong năm.',
                    '- Tài lộc: bình thường, có khả năng thăng tiến và thêm tiền của.',
                ],
                'nhuoc' => [
                    '- Sức khỏe: dễ ốm vặt.',
                    '- Gia đạo: dễ chưa thuận hòa, bản thân Thiếu sự quyết đoán, trần trừ, nhút nhát. Có thể thêm thành viên mới.',
                    '- Công việc: dễ gặp thị phi, nên chọn công việc thuộc ngũ hành hỏa để may mắn.',
                    '- Tài lộc: dễ bị hao tài tốn của. Cần bổ sung thêm ngũ hành Mộc, Hỏa, tháng tốt 1-2-4-5 âm lịch có nhiều sự may mắn',
                ],
            ],
            'tho' => [
                'vuong' => [
                    '- Sức khỏe: bình thường.',
                    '- Gia đạo: dễ nhận được thêm người và của.',
                    '- Công việc: nếu bản thân không quá bảo thủ, trì trệ quá trong khi làm công việc thuộc ngũ hành mộc, kim, thủy ắt có thành tựu về sau. ',
                    '- Tài lộc: dễ bị hao tốn tiền của, nhưng vẫn sinh tài có lộc vào những tháng 1-2-6-7-10-11 âm lịch.',
                ],
                'nhuoc' => [
                    '- Sức khỏe: dễ ốm vặt, va chạm cần chú ý.',
                    '- Gia đạo: dễ có sự bất hòa, cần bổ sung thêm ngũ hành thổ và thêm sự quyết đoán mọi sự sẽ tốt dần lên.',
                    '- Công việc: công việc dễ không thuận, thu nhập có thể chưa dư. ',
                    '- Tài lộc: dễ bị hao tài tốn của. Cần bổ sung thêm ngũ hành thổ, tháng tốt 3-4-5- 6-9-12 âm lịch có nhiều sự may mắn',
                ],
            ],

        ],
        'ctai' => [
            'luan_giai' => '<b>Chính tài</b> Những năm này dễ tài lộc tăng tiến, sản nghiệp vững chắc, tài vận được mở nếu đầu tư làm những nghành nghề thuộc ngũ hành mộc tại hướng Đông ắt sinh tài lộc, nhưng chú ý tới sức khẻo của bản thân, me, vợ và con trai.',
            'kim' => [
                'vuong' => [
                    '- Sức khỏe: bình thường. ',
                    '- Gia đạo: bình thường, có thêm niềm vui từ tài lộc nhận tiền của, nhưng cũng cần có sự hài hòa kẻo dễ gây ra xích mích với nhau.',
                    '- Công việc: có nhiều sự thuận lợi, sinh tài lộc, nhưng cũng nên cẩn trọng từng bước đi. ',
                    '- Tài lộc: có thể hữu lộc.',
                ],
                'nhuoc' => [
                    '- Sức khỏe: dễ ốm đau, bệnh tật, va chạm, tai nạn. lưu ý bệnh về phổi, đường hô hấp, mắt, gan. ',
                    '- Gia đạo: dễ có sự xáo trộn, sa sut, cần thêm sự mạnh mẽ, nỗ lực thấu đáo để giảm sát, phương vị cát là Tây (ngũ hành Kim). ',
                    '- Công việc: có nhiều sự thay đổi theo chiều hướng xấu, cần trợ mệnh cải vận để tốt hơn. ',
                    '- Tài lộc: dễ sa sút do sức khỏe và công việc chưa tốt.',
                ],
            ],
            'thuy' => [
                'vuong' => [
                    '- Sức khỏe: bình thường.',
                    '- Gia đạo: bình thường có thể nhận thêm tài lộc từ ngũ hành Thủy, Hỏa.',
                    '- Công việc: nếu làm đúng những công việc thuộc ngũ hành Hỏa, Thổ, Mộc ắt tiền tài tăng tiến. ',
                    '- Tài lộc: có thể phát tài khi làm công việc thuộc ngũ hành Hỏa. ',
                ],
                'nhuoc' => [
                    '- Sức khỏe: dễ ốm đau, cần chú ý những bệnh liên quan tới Thận, bàng quang, tim mạch. ',
                    '- Gia đạo: dễ có sự xáo trộn, bất đồng quan điểm, bản thân nên bổ sung thêm ngũ hành thủy để trợ mệnh. ',
                    '- Công việc: dễ có nhiều sự thay đổi (đi xuống) có thể do sự chậm chạp, tranh giành, buông xuôi tạo ra. ',
                    '- Tài lộc: dễ sa sút, cần bổ sung thêm ngũ hành Thủy, Kim để trợ mệnh cải vận.',
                ],
            ],
            'moc' => [
                'vuong' => [
                    '- Sức khỏe: bình thường. ',
                    '- Gia đạo: bình thường, có thêm tài lộc từ ngũ hành Thổ. ',
                    '- Công việc: có quý nhân phù trợ, gặp thời phát tài nếu làm đúng nghề thuộc ngũ hành Kim, Thổ. ',
                    '- Tài lộc: tăng tiến nên cần kiệm liêm chính để lộc tồn.',
                ],
                'nhuoc' => [
                    '- Sức khỏe: dễ đau ốm, cần chú ý những bệnh liên quan tới gan, mật, mắt, đường hô hấp. ',
                    '- Gia đạo: dễ có sự cãi cọ, tranh giành, đố kỵ. ',
                    '- Công việc: dễ có nhiều sự trì trệ, (đi xuống) có thể do bản thân ý chí kém, vội vàng và buông xuôi, mệnh nhược Mộc nên vậy. ',
                    '- Tài lộc: dễ hao tài tốn của, tiền mất tật mang. ',
                ],
            ],
            'hoa' => [
                'vuong' => [
                    '- Sức khỏe: bình thường. ',
                    '- Gia đạo: bình thường chú ý không nên quá cá nhân mà ảnh hưởng tới tình cảm gia đình. ',
                    '- Công việc: có quý nhân phù trợ có thể phát tài, nếu công việc thuộc ngũ hành Kim, Thủy, Thổ. ',
                    '- Tài lộc: tăng tiến, hữu lộc lộc tồn.',
                ],
                'nhuoc' => [
                    '- Sức khỏe: dễ suy nhược ốm đau, bệnh tật cần chú ý những bệnh liên quan tới mắt, đường máu, đường ruột, tim mạnh. ',
                    '- Gia đạo: dễ có sự bất hòa do chưa có tiếng nói chung. ',
                    '- Công việc: dễ đi xuống có thể do bản thân Thiếu sự quyết đoán, trần trừ, công việc có thể bấp bênh. ',
                    '- Tài lộc: hơi kém, dễ hao tài tốn của, cần bổ sung thêm ngũ hành Hỏa, Mộc để trợ mệnh. ',
                ],
            ],
            'tho' => [
                'vuong' => [
                    '- Sức khỏe: bình thường. ',
                    '- Gia đạo: bình thường, trong gia đình có người phát tài. ',
                    '- Công việc: có sự phát triển, phát tài tại phương vị bắc, (tài phát từ thủy). ',
                    '- Tài lộc: có thành quả tại những công việc thuộc ngũ hành Thủy, dễ phát tài vào những năm này.',
                ],
                'nhuoc' => [
                    '- Sức khỏe: sức khỏe dễ yếu, và những bệnh liên quan tới phổi, đường hô hấp, đường ruột, thận. ',
                    '- Gia đạo: dễ có nhiều sự bất đồng, bản thân nên quyết đoán, có lập trường để gia đình thêm an vui. ',
                    '- Công việc: dễ đi xuống có thể do bản thân trần trừ, nhút nhát, chậm chạp. Nên chọn nghành nghề thuộc ngũ hành Thổ, Hỏa để hanh thông.',
                    '- Tài lộc: hơi kém. ',
                ],
            ],

        ],
        'ttai' => [
            'luan_giai' => '<b>Thiên tài</b> Dễ phát tài kiểu nhanh đầu cơ ăn sổi, tài lộc có đủ, hữu lộc lộc tồn. Nhưng dễ khắc Cha, tại phương vị tây nghành kinh doanh thuộc mộc dễ phát tài, chú ý dễ bệnh tật.',
            'kim' => [
                'vuong' => [
                    '- Sức khỏe: bình thường, dễ có tình trạng tốt thành xấu, hoặc không kiểm soát được ăn uống mà sinh bệnh. ',
                    '- Gia đạo: có niềm vui do có thêm tiền của, nhưng cũng chú ý nên có sự liêm chính để lộc tồn. ',
                    '- Công việc: có nhiều sự thuận lợi, sinh tài lộc, cần giữ đức để có phúc lộc lâu bền. ',
                    '- Tài lộc: có thể phát. Chú ý dễ được nhanh, mất cũng nhanh',
                ],
                'nhuoc' => [
                    '- Sức khỏe: dễ ốm đau, tai nạn. lưu ý bệnh về phổi, đường hô hấp, mắt, gan. ',
                    '- Gia đạo: dễ có sự xáo trộn, sa sut về tiền và sức khỏe. ',
                    '- Công việc: dễ sa sút, tháng xấu trong năm 1-2-4-5. Thân nên bổ sung thêm ngũ hành Kim để mệnh vận hanh thông hơn. ',
                    '- Tài lộc: dễ sa sút. Phương vị Tây là Hỷ Thần.',
                ],
            ],
            'thuy' => [
                'vuong' => [
                    '- Sức khỏe: bình thường.',
                    '- Gia đạo: bình thường có thể nhận thêm tài lộc từ ngũ hành Mộc, Hỏa.',
                    '- Công việc: có sự tăng tiến, thuận lợi, công việc thuộc ngũ hành Hỏa, Mộc sẽ có nhiều thăng tiến. ',
                    '- Tài lộc: có thể phát tài tại phương vị nam, nghề thuộc Hỏa. Chú ý dễ được nhanh, mất cũng nhanh',
                ],
                'nhuoc' => [
                    '- Sức khỏe: có thể yếu kém, ôm vặt, chú ý những bệnh liên quan tới Thận, bàng quang, tim mạch. ',
                    '- Gia đạo: chưa thuận một phần do bản thân yếu kém, cần bổ sung thêm ngũ hành Thủy để mọi thứ tốt dần lên. ',
                    '- Công việc: dễ có nhiều sự thay đổi (đi xuống) do vận tài mà thân nhược, nên bổ sung thêm ngũ hành Thủy để công việc hanh thông hơn. ',
                    '- Tài lộc: dễ sa sút, cần bổ sung thêm ngũ hành Thủy, Kim để trợ mệnh cải vận.',
                ],
            ],
            'moc' => [
                'vuong' => [
                    '- Sức khỏe: bình thường. ',
                    '- Gia đạo: bình thường có thêm tài lộc, gia đình cần thêm sự đồng lòng, tu tập để hạnh phúc dài lâu. ',
                    '- Công việc: thuận lợi, có sự thăng tiến và phát tài, cần thêm sự nỗ lực, cần kiệm liêm chính ắt cát lành. ',
                    '- Tài lộc: tăng tiến nên tạo thêm, tâm thiện lành để lộc tồn. Chú ý dễ được nhanh, mất cũng nhanh',
                ],
                'nhuoc' => [
                    '- Sức khỏe: dễ đau ốm, cần chú ý những bệnh liên quan tới gan, mật, mắt, đường hô hấp. ',
                    '- Gia đạo: dễ có sự bất đồng, tranh giành, đố kỵ do mất phương hướng, cần bổ sung thêm ngũ hành Mộc để tốt dần lên. ',
                    '- Công việc: dễ có sự vội vàng và buông xuôi, lùi bước, (đi xuống) nghề thuộc ngũ hành Mộc có thể giúp gia chủ công việc ổn định hơn. ',
                    '- Tài lộc: dễ hao tài tốn của, tiền mất tật mang. ',
                ],
            ],
            'hoa' => [
                'vuong' => [
                    '- Sức khỏe: bình thường, chú ý chút về tim gan, dạ dày. ',
                    '- Gia đạo: bình thường có tin vui về tài chính, nếu thêm được chữ tâm thiện thì càng quý. ',
                    '- Công việc: có quý nhân phù trợ có thể phát tài. Tuy vận thế lên nhưng cũng cần chú ý nếu chủ quan, vội vàng lại thành hung. ',
                    '- Tài lộc: tăng tiến, hữu lộc lộc tồn. Chú ý dễ được nhanh, mất cũng nhanh',
                ],
                'nhuoc' => [
                    '- Sức khỏe: dễ suy cơ thể, ốm đau, bệnh tật cần chú ý những bệnh liên quan tới mắt, đường máu, đường ruột, tim mạnh. ',
                    '- Gia đạo: dễ có sự bất hòa do chưa có tiếng nói chung. ',
                    '- Công việc: dễ đi xuống do thân thiếu ngũ hành Hỏa. Hãy chọn công việc thuộc ngũ hành Hỏa để có thêm sự may mắn hanh thông hơn. ',
                    '- Tài lộc: hơi kém, dễ hao tài tốn của, cần bổ sung thêm ngũ hành Hỏa, Mộc để trợ mệnh. ',
                ],
            ],
            'tho' => [
                'vuong' => [
                    '- Sức khỏe: bình thường, chú ý một chút về đau đầu mệt mỏi. ',
                    '- Gia đạo: bình thường, trong gia đình có người phát tài, nhưng cũng dễ từ đó mà sa đọa. ',
                    '- Công việc: có sự phát triển, phát tài tại phương vị bắc, nên biết điểm dừng kẻo hối không kịp.  ',
                    '- Tài lộc: có thành quả tại những công việc thuộc ngũ hành Thủy, dễ phát tài vào những năm này. Chú ý dễ được nhanh, mất cũng nhanh',
                ],
                'nhuoc' => [
                    '- Sức khỏe: có thể ốm yếu, chú ý tới phổi, đường hô hấp, đường ruột, thận. ',
                    '- Gia đạo: dễ có nhiều sự bất đồng, bản thân nên quyết đoán, có lập trường để gia đình thêm an vui. ',
                    '- Công việc: dễ đi xuống. Nên chọn nghành nghề thuộc ngũ hành Thổ, Hỏa để hanh thông.',
                    '- Tài lộc: hơi kém. Cần bổ sung thêm ngũ hành Thổ để lộc tồn nhiều hơn. ',
                ],
            ],

        ],
    ];

    public $thanSatLuanGiai = [
        'thien-at' => '- Thiên Ất là trong 4 trụ (năm, tháng, ngày, giờ sinh) gặp quý nhân. Thiên ất là cát tinh, là sao cứu trợ là thần quý nhất - vị thần cát lợi nhất trong mệnh. Trong Tứ trụ có quý nhân nghĩa là gặp tai ách sẽ có người trợ giúp, khiến cho hung sát hóa thành cát. Trong sách “Tam mệnh thông hội” viết rằng: Thiên Ất chính là thần trên trời, ở ngoài cửa cổng trời đóng lại, cùng ngang hàng với Thái Ất, làm việc cho Thượng đế, địa vị kém hơn ba thần (tên gọi chung của Nhật, Nguyệt và Tinh tú), nơi ở Kỷ Sửu, chỗ trọ là sao Đẩu Ngưu, xuất ra ở Kỷ Mùi chỗ ở là sao Tỉnh Quỷ, nắm cái cân ngọc để tính toán thời gian sự việc, danh gọi là ở Ất vậy. Là thần tôn quý nhất, chỗ đến thi hành, tất cả Hung Sát đều phải ẩn tránh. Sách “ Chúc thần kinh” còn viết: Thiên ất quý nhân gặp sinh vượng thì diện mạo hiên ngang, tính tình nhanh nhẹn, lý lẽ phân minh, không thích mẹo vặt, thẳng thắn, người ôn hòa đức độ, được mọi người yêu mến, khâm phục. Nếu gặp được Thiên ất quý nhân thì vinh hiển, công danh sớm đạt, dễ thăng quan tiến chức. Nếu mệnh thừa vượng khí thì có thể đạt đến chức vị cao trong công việc. Đại, tiểu vận hành đến năm đó thì nhất định sẽ gặp được nhiều điều may mắn, thuận lợi, đường quan lộ hanh thông, tất cả mọi việc đều là điềm tốt. Nếu Thiên ất quý nhân lại gặp được Thiên đức, Nguyệt đức thì quý vô cùng, người đó thông minh, trí tuệ. Quý nhân toạ vào can ngày thì suốt đời thanh cao.<br>Tóm lại, trong Tứ trụ có Thiên ất quý nhân thì đa số là người thông minh tháo vát, gặp hung hóa cát. Là người hào phóng, tâm tư hiền lành hay vui vẻ giúp người, giao thiệp rộng rãi được mọi người ủng hộ, yêu mến và phù trợ rất nhiều. Thiên ất quý nhân tốt nhất là được sinh vượng, được cát tinh trợ giúp, thì phúc đức tăng gấp đối, cuộc sống khỏe mạnh, giàu sang phú quý. Thiên ất kỵ nhất là gặp hình, xung, khắc, hại hoặc đất không, vong, tử, tuyệt, người gặp thế là họa, nguồn phúc giảm đi, suốt đời vất vả.',

        'van-xuong' => '- Văn Xương tức thực thần kiến lộc là văn thần - 1 trong các thần may mắn trong Tứ trụ. Khi gặp được Văn xương thì thông minh hơn người, có thể giúp hóa giải các khó khăn, trở ngại trong cuộc sống, gặp hung hóa cát. Tác dụng của nó tương tự như Thiên đức, Nguyệt đức, Thiên ất quý nhân. Nếu mệnh gặp Văn xương thì khí chất thanh tao, nho nhã, ham học hỏi, yêu thích văn chương, thơ ca. Có thể trở thành nhà thơ, nhà văn, nhà nghệ thuật, học giả nổi tiếng hoặc giáo sư tiến sĩ… sự nghiệp văn chương xán lạn. Nam thuộc Văn xương thì thường có nội tâm phong phú, thông minh nhanh nhạy, hiếu học, thăng quan tiến chức nhanh chóng. Nữ thì đoan trang, ham học hỏi muốn vươn lên, con đường tiến chức thuận lợi, không giao thiệp với kẻ tầm thường.<br>Trong thực tiễn, người có Văn xương quý nhân sinh vượng thường đỗ đạt các trường chuyên khoa, đại học về văn học, ngôn ngữ. Nhìn chung người có Văn xương trong mệnh sẽ có tư chất tốt, tính tình nho nhã dễ gần, hiếu học, có công danh rộng mở. Chính vì vậy nên thời xa xưa cha mẹ thường khấn vái, cầu mong cho con mình sinh ra được học giỏi, thành đạt hơn người.',

        'loc-than' => '- Lộc thần là một trong các sao tốt, nếu gặp chúng trong tứ trụ thì phúc lộc dồi dào, công danh sự nghiệp rộng mở, mọi việc đều hanh thông.<br>Giáp lộc ở Dần: Gặp Bính Dần là lộc phúc tinh, gặp Mậu Dần là lộc phục mã, cả hai đều tốt cả. Gặp Canh Dần là lộc phá, nửa tốt nửa xấu, gặp Nhâm Dần là chính lộc, có kèm với tuần không, vong thì có nhiều khả năng người mệnh này đi theo đạo. Gặp Giáp Dần gọi là lộc trường sinh, đại cát.<br>Ất lộc ở Mão: Gặp Mão gọi là lộc hỷ thần vượng, mọi việc đều may mắn, cát lành. Gặp Đinh Mão là cắt ngang đường, chủ về hung. Gặp Kỷ Mão là lộc tiến thần, gặp Tân Mão là lộc phá hay còn gọi là lộc giao, tức nửa tốt nửa xấu. Gặp Quý Mão có kèm theo Thiên ất là lộc chết, trong cái tốt lại có cái xấu.<br>Bính lộc ở Tỵ: Gặp Kỷ Tỵ là lộc kho trời, chủ mệnh làm mọi việc đều cát lành. Gặp Tân Tỵ là đứt đường, coi như bị tuần không vong. Gặp Quý Tỵ là lộc phục quý thần, nửa tốt nửa xấu, gặp Ất Tỵ là lộc mã, gặp Đinh Tỵ là lộc khố, đều tốt.<br>Đinh lộc ở Ngọ: Gặp Canh Ngọ là đứt đường, giống như không vong nên rất xấu. Gặp Nhâm Ngọ là lộc đức hợp, gặp Giáp Ngọ là lộc tiến thần, đều tốt. Gặp Bính Ngọ là tốt. Gặp Lộc thần, gặp Kình dương thì nửa tốt nửa xấu. Gặp Mậu Ngọ phần nhiều là xấu.<br>Mậu lộc ở Tỵ: Gặp Kỷ Tỵ là lộc kho trời, tức là tốt. Gặp Tân Tỵ là đứt đường hoặc tuần không vong. Gặp Quý Tỵ là gặp quý thần, hoá hợp với Mậu Quý là được chức quan quan trọng. Gặp Ất Tỵ, trạch mã là lộc đồng hương, nhận được sự trợ giúp từ những người cùng quê. Gặp Đinh Tỵ vượng là lộc kho, đều tốt.<br>Kỷ lộc ở Ngọ: Gặp Canh Ngọ là đứt đường hoặc tuần không vong. Gặp Nhâm Ngọ là lộc tử quý, đều xấu. Gặp Giáp Ngọ là lộc hợp tiến thần, là làm nên công danh, sự nghiệp, có địa vị xã hội cao. Bính Ngọ gặp lộc thần là tốt. Gặp Mậu Ngọ là lộc phục thần kình dương.<br>Canh lộc ở Thân: Gặp Nhâm Thân là lộc đại bại, gặp Giáp Thân là lộc đứt đường, tuần không vong, đều xấu. Gặp Bính Thân là lộc đại bại. Gặp Mậu Thân là lộc phục mã, suy nghĩ không nhanh nhạy dẫn đến mọi việc bị trì trệ, nếu gặp phúc tinh quý nhân thì tốt. Gặp Canh Thân là lộc trường sinh, đại cát.<br>Tân lộc ở Dậu: Gặp Quý Dậu là lộc phục thần, xấu. Gặp Ất Dậu là lộc bị phá, mọi công việc gia chủ thực hiện phần lớn là thất bại. Gặp Đinh Dậu là lộc quý thần nhưng tuần không vong, nên chủ về những việc gian dâm, nếu gặp được Hỷ thần thì tốt. Gặp Kỷ Dậu là lộc tiến thần, gặp Tân Dậu là chính lộc, đều tốt. Nếu gặp Ất Hợi là lộc thiên đức, gặp Đinh Hợi là lộc hợp quý thần, gặp Kỷ Hợi là lộc vượng, gặp Tân Hợi là lộc cùng với mã, đều là tốt cả. Gặp Quý Hợi là lộc đại bại, cuộc sống đói khổ, lầm than suốt đời.<br>Quý lộc ở Tý: Gặp Giáp Tý là lộc tiến thần, thi cử đỗ đạt, công danh rộng mở. Gặp Bính Tý là lộc kình dương, nếu có cả thần tinh quý nhân thì là người có chức có quyền. Gặp Mậu Tý là lộc kình dương phục nấp, hợp với lộc quý là chỉ tốt một nửa. Gặp Canh Tý ấn lộc là cát. Gặp Nhâm Tý là chính lộc kình dương, tức là xấu.',

        'hoc-duong' => 'Sao Học đường biểu thị sự học giỏi và thông minh. Cách an như sau: Lấy can ngày sinh làm mốc đối chiếu với chi của tháng và chi của giờ, nếu là can ngày (hoặc giờ) là Giáp thì Học đường ở Hợi, là Ất HĐ ở Ngọ, là Bính HĐ ở Dần, là Đinh HĐ ở Dậu, là Mậu HĐ ở Dần, là Kỷ thì HĐ ở Dậu, là Canh HĐ ở Tỵ, là Tân HĐ ở Tý, là Nhâm HĐ ở Thân, là Quý HĐ ở Mão.<br>Nếu trong Tứ trụ có Học đường thì thường là người thông minh, nhanh trí được học cao hiểu rộng nên có cuộc đời giàu sang, thành đạt. Chủ mệnh có sao Học đường thì nên làm công việc nghiên cứu khoa học, làm nghề dạy học, nghề sáng tạo trong kiến trúc xây dựng… Học đường có ở cột giờ thì con cái học giỏi. Học đường ở cột tháng thì anh em trong nhà đều thông minh, học giỏi. Người trong cột giờ và cột tháng đều có Học đường sẽ là người thông minh, rất chăm chỉ trong học hành, trong nghiên cứu khoa học.',

        'giap-loc' => 'Người có sao Giáp Lộc trong tứ trụ giờ ngày tháng năm sinh thì thường là người có cuộc sống dễ phát tài phát lộc, được hưởng tài sản của cha ông để lại. Cách an sao: Lấy Can ngày làm mốc đối chiếu với chi của năm, tháng, ngày, giờ. Nếu can ngày sinh là Giáp thì GL tại Sửu - Mão, là Ất thì GL tại Dần - Thìn, là Bính thì GL tại Thìn - Ngọ, là Đinh thì GL tại Tỵ - Mùi, là Mậu thì GL tại Thìn - Ngọ, là Kỷ thì GL tại Tỵ - Mùi, là Canh thì GL tại Mùi - Dậu, là Tân thì GL tại Thân - Tuất, là Nhâm thì GL tại Tuất - Tý, là Quý thì GL tại Hợi - Sửu.',

        'kim-du' => 'Mệnh chủ có chứa sao Kim dư thì tính cách ôn hoà nhu thuận, người có lòng trung thành, thuỷ chung, quyết giữ trọn đạo nghĩa nên hôn nhân hòa thuận, yên ấm. Đồng thời mệnh này nhờ âm đức của tổ tiên mà cuộc sống sẽ có nhiều thuận lợi, may mắn hơn người. Cách an như sau: Lấy Can ngày sinh làm mốc đối chiếu với Chi của năm, tháng, ngày, giờ trong Tứ trụ. Nếu Can ngày sinh là Giáp thì KD tại Thìn, là Ất thì KD tại Tỵ, là Bính thì tại Mùi, là Đinh thì tại Thân, là Mậu thì tại Mùi, là Kỷ tại Thân, là Canh tại Tuất, là Tân tại Hợi, là Nhâm tại Sửu, là Quý tại Dần.<br>Nếu trong Tứ trụ ở các cột thời gian có Kim dư thì người đó thường có lòng nhân ái, gia đình xuất thân từ dòng dõi quyền quý, được hưởng phúc trời. Nếu lại thêm sao tốt thì sẽ là người có tài năng hơn người, mệnh nam lấy được vợ có thể trợ giúp cho gia đình thêm phát triển hưng thịnh. Nếu là nữ giới thì sẽ là người đoan chính, con nhà lương thiện, có thể giúp chồng thăng tiến trong công việc, tiền tài và gặp nhiều may mắn. Về đường con cái cũng dễ sinh thành quý tử có trí thông minh hơn người và thành đạt về sau. Cột ngày có Kim dư thì gia đình rất hạnh phúc, tài lộc vẹn toàn, nhiều con và làm nên công danh sự nghiệp, có địa vị cao trong xã hội.',

        'hoc-sy' => 'Trong Tứ trụ có sao Học sĩ, nếu là nữ giới thì sẽ sống rất tình cảm, thông minh, nhẹ nhàng, yểu điệu. Nếu là nam giới thì tính tình và phong thái giống nữ giới.<br>Cách an trong tứ trụ như sau: Lấy Can ngày sinh làm mốc, kết hợp với Chi của năm, tháng, ngày, giờ. Nếu ngày là Giáp thì sao Học sĩ ở Tý, ngày là Ất thì sao Học sĩ ở Hợi, ngày Bính thì ở Mão, ngày Đinh thì ở Dần, ngày Mậu thì ở Ngọ, ngày Kỷ thì ở Tỵ, ngày Canh ở Ngọ, ngày Tân ở Tỵ, Ngày Nhâm ở Dậu, Ngày Quý ở Thân.',

        'hong-diem' => 'Trong Tứ trụ, người có sao này rất yểu điệu, dịu dàng, ăn nói nhỏ nhẹ. Nếu là con trai thì có phong thái nhẹ nhàng giống như con gái.<br>Cách an: Lấy Can ngày sinh làm mốc đối chiếu với Chi của năm, tháng, ngày, giờ. Nếu Can ngày là Giáp thì sao Hồng diễm tại Thân, Can ngày là Ất thì sao Hồng diễm tại Ngọ, là Bính thì tại Dần, là Đinh thì tại Mùi, là Mậu thì tại Thìn, là Kỷ thì tại Thìn, là Canh thì tại Tuất, là Tân thì tại Dậu, là Nhâm thì tại Dần, là Quý thì tại Thân.',

        'am-loc' => 'Sao Ám lộc có trong tứ trụ thì mệnh chủ thường sẽ có cuộc sống vô cùng khó khăn, nghèo khổ đến cùng cực, tính không chân thật, thường không nói đúng sự thật. <br>Cách an: Lấy Can ngày sinh (nhật chủ) làm mốc đối chiếu với các Chi trong Tứ trụ. Nếu Can ngày là Giáp thì Ám lộc tại Hợi, Can ngày là Ất thì Ám lộc tại Tuất, Can ngày là Bính thì Ám lộc tại Thân, là Đinh thì tại Mùi, là Mậu thì tại Thân, là Kỷ thì tại Mùi, là Canh thì tại Tỵ, là Tân thì tại Thìn, là Nhâm thì tại Ngọ, là Quý thì tại Sửu.',

        'phi-nhan' => 'Người có Sao Phi nhận thì thường có tính cách kiêu ngạo, hay đầu cơ tích trữ nên dễ bị sa sút, phá sản. Do tính cách bảo thủ, tự tin nên không nghe lời góp ý của những người xung quanh.<br>Các an như sau: Lấy Can ngày sinh làm mốc đối chiếu với các Chi trong tứ trụ. Nếu Can ngày là Giáp thì Phi nhận tại Dậu, Can ngày là Ất thì Phi nhận tại Tuất, là Bính thì tại Tý, là Đinh thì tại Sửu, là Mậu thì tại Tý, là Kỷ thì tại Sửu, là Canh thì tại Mão, là Tân thì tại Thìn, là Nhâm thì tại Ngọ, là Quý thì tại Mùi.',

        'duong-nhan' => 'Người có sao Dương nhận thì tính tình thô bạo, là người bất chấp, không sợ gì và không chịu khuất phục ai. Ngoài ra mệnh chủ này còn là người nóng nảy, làm việc gì cũng vội vàng, gấp gáp. Cách an sao: lấy Can của ngày sinh làm mốc đối chiếu với Chi của năm tháng ngày giờ. Nếu Can ngày sinh là Giáp thì Dương nhận ở Mão, là Ất thì Dương nhận ở Thìn, là Bính thì ở Ngọ, là Đinh thì ở Mùi, là Mậu thì ở Ngọ, là Kỷ thì ở Mùi, là Canh thì ở Dậu, là Tân thì ở Tuất, là Nhâm thì ở Tý, là Quý thì ở Sửu.<br>Trong Tứ trụ có Dương nhận thì người đó thường tính tình nóng nảy, hung bạo hay gặp sóng gió trong cuộc đời, thích làm những việc khác người. Tuy nhiên người làm nghề quân sự gặp Dương nhận thì công thành danh toại, đạt được kết quả mỹ mãn trên con đường sự nghiệp của mình. Người có Dương nhận lại có Kiếp sát thì có thể nắm quyền lực cao trong công việc. Cột năm có Dương nhận mệnh không tốt lắm, nếu không tu tâm dưỡng tính thì sẽ phá tan cơ nghiệp của tổ tiên, cha ông, sống vô ơn bạc nghĩa, lấy oán trả ân. Cột tháng có Dương nhận thì sống không công bằng hay thiên lệch, đối xử bất công với mọi người. Cột ngày có Dương nhận, cột giờ lại có Thiên ấn thì sẽ gặp khó khăn trong đường con cái. Cột giờ có Dương nhận sẽ khắc hại vợ con, về già hay gặp điều không hay. Nhưng một trong 4 cột thời gian đều có Thiên quan thì sự xấu giảm đi nhiều. Kiếp tài và Dương nhận cùng một cột thì là người có bề ngoài nhu hoà nhưng nội tâm hung bạo, sống cô đơn, phải tha hương lập nghiệp. Dương nhận cùng cột với Chính tài báo hiệu phá tan tài sản, có thể gặp thị phi. Dương nhận cùng Kiếp tài, Thương quan ở một cột thì về già không gặp may, có cuộc sống khổ cực. Dương nhận và Ấn thụ cùng một cột thì lại tốt, có cuộc sống công thành danh toại.<br>Nữ giới cột ngày có Dương nhận, trong tứ trụ có nhiều Thương quan thì cần đề phòng tai nạn, nhất là Dương nhận và Thương quan cùng cột ngày. Tứ trụ có Dương nhận, các địa chi hợp thành cục (tam hội hợp cục) thường phải xa quê hương đi lập nghiệp tại nơi khác mới có thành tựu, nếu trong tứ trụ có các can chi sau: Bính Ngọ, Đinh Mùi, Mậu Ngọ, Kỷ Mùi, Nhâm Tý, Quý Sửu. Dưới các cột thời gian này có Tử hoặc Tuyệt thì là người có tính cách hung bạo, nóng nảy, có Mộc dục thì dễ mắc bệnh hiểm nghèo. Trong tứ trụ có 3 hoặc 4 cột đều có Dương nhận thì tính tình ngang bướng, vợ chồng có thể sớm chia lìa do mệnh nữ đa tình lại bướng bỉnh, có thể làm nghề gái bán hoa. Nữ giới mệnh cung có Dương nhận lại có Ấn thụ, Thương quan thì dễ khó có con.',

        'kinh-duong' => 'Kình dương là hung sát, phần nhiều sẽ mang đến tai họa, thương tật và những tội phạm pháp cho mệnh chủ. Người thân nhược gặp Kình dương lại tốt, thân vượng gặp Kình dương thì cái xấu càng tăng. Do đó người kỵ Kình dương nên làm việc thiện, kiềm chế mình, tôn trọng pháp luật thì tránh được điều xấu. Nếu làm được những việc này sẽ giúp cho bản thân tránh được những tai họa, bản thân an nhàn còn không suốt đời trắc trở, khó khăn.',

        'tuong-tinh' => 'Người có Tướng tinh giống như đại tướng giữ kiếm trong quân. Nếu ngôi trong tam hợp có Tướng tinh thì tốt, nhưng nếu có cát thần phù trợ thì tốt hơn. Nếu Tướng tinh gặp Vong thần thì giữ chức trụ cột của quốc gia. Vậy nên có Tướng tinh trong mệnh sẽ giúp cho mệnh chủ có đường quan lộ rộng mở. Mệnh có Tướng tinh, nếu không bị phá hại thì chỉ về đường quan lộ hiển đạt, Tứ trụ phối hợp được tốt thì là người làm chức quan lớn, có nhiều lính quân dưới quyền. Tướng tinh đóng ở Chính quan là tốt, nếu đóng ở Chính tài thì chủ về nắm quyền tài chính làm mọi nghề thì đều thành công. Tướng tinh là ngôi sao quyền lực, có tài tổ chức lãnh đạo, chỉ huy, có uy trong quần chúng. Nhưng bị tử tuyệt xung phá thì bất lợi, nếu hợp với hung tinh thì tăng thêm khí thế cho hung tinh. Nếu mệnh kỵ Kiếp tài mà gặp phải tướng tinh thì điều hại càng tăng gấp bội.',

        'hoa-cai' => 'Người có sao Hoa cái trong tứ trụ thì đa số sẽ có tư tưởng thanh cao, khả năng và yêu thích văn chương, nghệ thuật hơn người. Có thể thành danh trong các lĩnh vực liên quan đến nghệ thuật, văn chương như nhà thơ, văn phê bình văn học… Hoa cái gặp Ấn thụ là người tài hoa xuất chúng, học rất giỏi. Hoa cái gặp không vong là người thiên tài giúp ích cho đời.<br>Cách an sao như sau: lấy Chi ngày làm mốc đối chiếu với Chi của năm, tháng, ngày, giờ. Nếu Chi ngày sinh là Hợi - Mão - Mùi thì Hoa cái ở Mùi; là Dần - Ngọ - Tuất thì Hoa cái ở Tuất; là Tỵ - Dậu - Sửu thì ở Sửu; là Thân - Tý - Thìn thì ở Thìn.',

        'dich-ma' => 'Sao Dịch mã là sao có khi tạo ra cái tốt, cũng có khi gây ra xấu. Sao này cũng có khi là Thần mà cũng có khi là Sát. Sao cho biết có sự thăng tiến, di chuyển. Trong cuộc sống, không phải sự thăng tiến hay dịch chuyển nào cũng tốt hoặc xấu. <br>Cách an như sau: lấy Chi ngày sinh làm mốc đối chiếu với các Chi của năm, tháng, ngày, giờ hoặc mệnh cung để an Dịch mã tại đó. Nếu ngày có chi Hợi - Mão - Mùi Dịch mã tại Tỵ, ngày có chi Dần - Ngọ - Tuất thì Dịch mã tại Thân, chi ngày Tỵ -  Dậu - Sửu thì tại Hợi, Thân - Tý - Thìn thì ở Dần. Nếu số hay gặp Dịch mã thì có lợi cho sự thăng tiến trong công việc. Nhưng số không hay gặp Dịch mã thì sẽ có cuộc sống nay đây mai đó để mưu sinh. Nếu Dịch mã bị xung, hình thì đời dễ lao đao, cực khổ. Nếu Dịch mã và Chính tài cùng cột thời gian thì người đó sẽ có vợ hiền, gia đình êm ấm. Dịch mã với Chính quan cùng cột thì kinh doanh giỏi và dễ làm nghề buôn bán. Khi có Dịch mã lại có Đào hoa thì dễ vì sắc dục mà tai tiếng, xa cố hương. Chi của mệnh cung gặp Dịch mã thì gia chủ rất dễ sống xa quê. Dịch mã gặp Cô thần hoặc trong Tứ trụ có cả Cô thần và Dịch mã, Quả tú khi sống xa quê hương thì sống rất phóng đãng. Dịch mã gặp Không vong sẽ luôn luôn thay đổi nhà cửa, không có nơi ở cố định.',

        'dao-hoa' => "Người có Đào hoa trong mệnh thì thường là người lanh lợi, sắc sảo, có nhan sắc nhưng ham sắc dục. Cách an như sau: lấy Chi ngày sinh làm mốc, đối chiếu với chi của tháng, giờ (có quan điểm cho cả chi năm). Nếu ngày là Hợi - Mão - Mùi thì Đào hoa tại Tý - Dần - Ngọ, ngày là Tuất thì Đào hoa tại Mão, là Tỵ - Dậu - Sửu thì tại Ngọ, Thân - Tý - Thìn thì tại Dậu. Dưới đây là những trường hợp khi có Đào hoa trong Tứ trụ:<br>●	Nếu là nữ giới, trong mệnh cung có Đào hoa thì thích sống phong lưu, đa tình.<br>
●	Nam giới trong mệnh cung có Đào hoa, lại gặp Kiếp sát thì hoang dâm, mê say tửu sắc.<br>
●	Đào hoa gặp Trường sinh hoặc Đế vượng là người có tướng mạo khôi ngô nhưng thích chơi bời không lo làm ăn, ham tửu sắc.<br>
●	Đào hoa gặp Tử hay Tuyệt thì ăn nói khéo léo, ngọt ngào, nhưng lại là người mưu mô quỷ quyệt, hoang dâm. Ngoài ra mệnh chủ còn ăn chơi lêu lổng, phóng túng và thường làm những điều càn quấy, vong ân bội nghĩa.<br>
●	Nữ giới trong mệnh cung và Tứ trụ có Đào hoa lại có Dịch mã thì cuộc sống bôn ba vì tình.<br>
●	Đào hoa cùng Dương nhận ở cột giờ thì có nhiều nghề, háo sắc nhưng sức khỏe yếu, hay mắc bệnh tật, ốm đau.<br>
●	Đào hoa gặp Mộc dục và Tiến thần thì có nhan sắc lộng lẫy nhưng háo sắc.<br>
●	Đào hoa mà gặp xung hình rất xấu, nhưng gặp Không vong thì lại tốt.<br>
●	Nam giới trong mệnh cung có Đào hoa gặp Thất sát thì sẽ làm nghệ sĩ, làm trong lĩnh vực sân khấu, điện ảnh. Đặc biệt nếu là nữ giới thì sẽ làm ca sĩ, hát xướng.<br>
●	Trong một cột thời gian cùng có Đào hoa và Chính tài là người háo sắc, ăn tiêu xa xỉ.<br>●	Đào hoa và Dương nhận cùng cột thời gian thì thân thể bạc nhược, dễ ốm đau do hoang dâm vô độ mà ra.",

        'kiep-sat' => 'Kiếp sát là một phụ tinh thuộc hành Hỏa và là ác tinh, Kiếp có nghĩa là đoạt, bị cướp đoạt từ ngoài. Kiếp sát tốt thì thông tuệ, nhanh nhẹn, nhạy bén, tài trí hơn người, có lòng bao dung. Khi Sinh vượng đi với Kiếp sát thì gia chủ sẽ gặp lộc, hung sát mạnh thì tâm độc ác. Nếu làm lãnh đạo thì dễ khiến cho cấp dưới bị tổn thương, gặp chuyện không may và làm nảy sinh tâm địa lừa đảo, chiếm đoạt tài sản. Cho nên có câu : “ Kiếp sát là vạ không lường, tài lợi danh trường bỗng nhiên mất hết, phải đề phòng tổ nghiệp tiêu tan, vợ con không kéo dài được cuộc sống. Người mà Tứ trụ gặp phùng sinh và kiếp sát sẽ trở thành bậc nho sĩ chấn hưng sự nghiệp cho triều đình, nếu giờ sinh có cả quan quý thì làm quan to. Kiếp thân gặp quan tinh là chủ về người nắm binh quyền, có uy và được nhiều người ngưỡng mộ”. Kiếp sát chủ về hung, về các tai vạ bệnh tật, bị thương hoặc những vấn đề pháp luật. Trong Tứ trụ không gặp được Kiếp sát là tốt nhất. Nếu nó là kỵ thần thì tính cách cường bạo, gian hoạt xảo trá, thường chuốc lấy tai hoạ. Nếu là cát tinh hoặc Hỷ thần, Dụng thần thì là người hiếu học, có chí cầu tiến, ham lập nghiệp, làm việc chăm chỉ, quyết đoán, dễ thành công.',

        'nguyet-duc' => 'Nguyệt đức là sao giải cứu, hỗ trợ các sao tốt và giảm hung hại do sao xấu mang lại. Cách xác định sao này như sau: lấy Chi của tháng sinh làm mốc, đối chiếu với can của năm, tháng, ngày, giờ trong Tứ trụ. Nếu sinh tháng Dần (Giêng), Ngọ (5)... thì Nguyệt đức sẽ ở trong những trụ có can Bính... Sinh tháng Mão (2), Hợi (10) thì Thiên đức quý nhân ở sẽ ở trong  trụ có Can Giáp. Các trường hợp khác xét tương tự. Theo các nhà mệnh lý, trong Tứ trụ gặp cả Nguyệt lẫn Thiên đức thì rất tốt. Ví dụ như sinh tháng Tuất, ngày Bính thì cuộc đời của người này không gặp nguy hiểm. <br>Nguyệt đức là cát tinh phúc tướng. Nếu trong Tứ trụ có Nguyệt đức thì là người nhân từ, cuộc đời an bình gặp hung hóa cát. Trong Tứ trụ có cả sao Thiên đức và Nguyệt đức thì việc gặp hung hóa cát càng tăng. Tuy nhiên, khi cả 2 sao này gặp xung khắc thì sẽ mất tác dụng. Nguyệt đức gặp Tài, Quan, An, Thực thì phúc lộc gia tăng; gặp Sát, Kiếp, Thương sẽ hoá giải bớt sự hung hại của chúng; gặp xung khắc thì xung khắc sẽ trở nên vô hiệu lực. Nếu Tứ trụ có cả Thiên và Nguyệt đức mà lại không bị hình, xung, khắc, phá thì suốt đời không bị tai nạn. Nếu Thiên và Nguyệt đức ở cùng một cột thời gian (năm, tháng, ngày, giờ sinh) với Chính tài hoặc Ấn thụ, Thực thần, không có sao xấu hoặc không phạm hình xung khắc thì cuộc đời phúc thọ song toàn. Đối với phụ nữ mà gặp 2 sao như vậy, sinh nở rất dễ dàng, con cái tính tình hòa thuận.',

        'thien-duc' => 'Sao Thiên đức là sao thuộc hành Thổ với đặc tính phúc hậu, nhân đạo, có thể giải trừ được bệnh tật và những tai nạn nhỏ trong cuộc sống. Sao Thiên đức là phụ tinh thuộc loại thiện tinh.<br>Nếu có thêm Lộc, Mã, Ấn, Tú quý nhân giúp thêm hoặc có cả Thiên đức và Nguyệt đức thì sẽ có đủ tài, quan, ấn, thực. Nếu còn được tam kỳ ngũ hành sinh vượng, không bị Thực thương khắc, phá, hại thì đạt được vinh hoa phú quý suốt đời không gặp điều gì ngang ngược. Nếu bị cung Tử tức, Thực thương phá thì việc gì cũng không thành. Nếu trong mệnh không có Thái cực quý nhân thì người đó sẽ có cuộc sống bủn xỉn, keo kiệt, hung ác. Nhưng nếu có Thiên đức, Nguyệt đức thì sẽ làm cuộc sống của gi chủ tốt hơn bởi mọi điều xấu đều được hóa giải.<br>Trong mệnh có Thiên đức, Nguyệt đức thì sẽ làm tác dụng của tài, quan, ấn, thụ tăng lên gấp bội. Nếu 2 sao này lâm nhật thì cuộc đời của gia chủ ít khi gặp nguy hiểm. Trong mệnh vừa có Thiên đức, vừa có tướng tinh thì công thành danh toại. Thơ xưa nói : “Thiên đức vốn là đại cát, nếu gặp ngày giờ là rất tốt, thi cử sẽ đỗ cao, làm việc gì cũng thành công.... Trong mệnh nếu có Thiên, Nguyệt đức thì cầu việc gì cũng lợi, sĩ công nông thương làm nghề gì cũng gặp may. Anh em vợ chồng không khắc hại nhau, âm đức tổ tiên dồi dào, còn trẻ đã thành đạt”. Nếu có cả Thiên đức, Nguyệt đức thì người đó có tấm lòng lương thiện, hay đi từ thiện, làm việc theo công bằng, yêu nước thương dân, thông minh trí tuệ, tài cán hơn người, ít bệnh tật, gặp hung hóa cát, có quý nhân phù trợ. Người mà có Tài, Ấn, Thực, lại vừa có Thiên đức, Nguyệt đức thì sẽ giảm được điều xấu, phúc đức được tăng thêm. Nữ giới nếu có cả Thiên đức, Nguyệt đức thì lấy được chồng đẹp, thông minh, giàu sang và dễ sinh đẻ. Thiên đức, Nguyệt đức nếu được cát thần phù trợ thì càng thêm tốt, nếu xung khắc thì xấu.',

        'khong-vong' => 'Không vong có thể ở 1 trong 4 Tứ trụ năm, tháng, ngày, giờ sinh. Không vong trên địa chi của năm thì tổ nghiệp không có gì, mẹ dễ lấy chồng khác, đi xa hoặc mẹ mất và cũng có thể mẹ không nuôi con, có mẹ như không. Không vong trên chi tháng thì đa phần không có anh, chị, em hoặc nếu có thì cũng không nương tựa, giúp đỡ nhau trong cuộc sống. Không vong trên chi giờ sau khi kết hôn không thể có con ngay hoặc không có con, trường hợp có con thì không thể nương tựa được. Như người sinh giờ Giáp Ngọ ngày Bính Tuất, tháng Tân Sửu năm Tân Mùi là: Ngày Bính Tuất trong tuần Giáp Thân “tuần Giáp Thân, Ngọ Mùi là không”, Ngọ trên trụ giờ và Mùi trên trụ năm của Tứ trụ là tuần không. Tuần không này ở ngôi mẹ và trong cung con cái. Sát của tuần không có cát, có hung.<br>Nếu Tứ trụ có hung tinh, ác sát thì đó là đất tụ hội tai họa, đều cần có Không vong giải cứu. Nếu là Lộc mã, Tài quan thì đó là nơi phúc tụ, không nên gặp Không vong vì sẽ làm tiêu tan. Người mà cả ba ngôi tháng, ngày, giờ, sinh đều có Không vong thì lại tốt. Nếu gặp hai ngôi là Không vong thì có làm quan nhưng chức không to. Nếu trong mệnh gặp Không vong mà thân vượng thì người đó phóng khoáng, phong độ, người to lớn đẫy đà nhưng hay có họa bất ngờ. Nếu Không vong gặp Tử tuyệt thì “lên voi xuống chó”, phiêu bạt, khi bản thân có khí vận cũng khó mà thành phúc. Kỵ nhất là can chi tương hợp với thiên trung, như thế gọi là tiểu nhân thắng thế lên ngôi, gian trá quỷ quyệt. Nếu Không vong gặp quan phù thì nữ giới là người hay nịnh chồng. Không vong gặp Kiếp sát thì hẹp hòi, nhút nhát. Không vong gặp Vong thần là bồng bềnh trôi nổi. Không vong gặp Đại hao là điên đảo thất thường. Không vong gặp Giáp lộc, Hoa cái, Tam kỳ thì lại là người thông minh, thoát tục. Nếu Không vong gặp Kiến lộc thì học hành không thành đạt. Trường hợp này, mặc dù được Trạch mã cứu trợ nhưng nếu được nhận chức cũng bị mất chức luôn. Nếu gặp Không vong trên chi giờ thì tính tình bướng bỉnh, đi với Hoa cái thì gia chủ dễ ít con.',

        'co-than' => 'Cô thần là sao thuộc hành Thổ, có đặc tính lạnh lùng, đơn độc, không giao du, ít tri âm, tri kỷ, không có sự thấu hiểu, đồng cảm, thiếu người trợ lực. Sinh ra tôi là mẹ, khắc tôi là chồng, tôi khắc là vợ. Những người mà trong mệnh có Cô thần là người nét mặt không hiền hòa, không lợi cho người thân. Nếu mệnh người đó Sinh vượng thì còn đỡ, Tử tuyệt thì nặng hơn, nếu gặp Trạch mã thì lang thang bốn phương. Nếu gặp Không vong là từ bé đã không có nơi nương tựa. Gặp tang điếu thì cha mẹ mất liền nhau, suốt đời hay gặp trùng tang hoặc tai họa chồng chất, anh em chia lìa. Gặp vận tốt thì việc hôn nhân muộn, gặp vận kém thì cuộc sống phiêu bạt, nay đây mai đó. Mệnh nam sinh chỗ vợ tuyệt lại còn gặp Cô thần thì suốt đời khó kết hôn. Mệnh nữ sinh chỗ chồng tuyệt còn gặp Quả tú thì có lấy được chồng nhưng khó mà bách niên giai lão. Nam gặp Cô thần nhất định tha phương cầu thực, nữ gặp Quả tú thường là mất chồng. Cô thần quả tú, người xưa bàn rất nhiều, chủ về nam nữ, hôn nhân không thuận, mệnh khắc lục thân, tai vạ hình pháp. Nhưng nếu trong Tứ trụ phối hợp được tốt, còn có quý thần tương phù thì không đến nỗi nguy hại. Thậm chí, nếu Cô thần và Quả tú gặp Quan ấn thì nhất định làm đầu đảng ở rừng sâu. Nhưng hôn nhân không thuận là điều dễ xảy ra, hơn nữa lúc phạm vào ngày tháng sẽ khắc phụ mẫu.',

        'qua-tu' => 'Quả tú trong mệnh thì có duyên phận bạc, cô độc. Cách an như sau: lấy Chi năm sinh làm mốc đối chiếu với Chi tháng, ngày, giờ. Nếu sinh năm Tý - Sửu thì Quả tú ở Tuất, năm Dần - Mão - Thìn thì Quả tú ở Sửu, năm Tỵ - Ngọ - Mùi thì Quả tú ở Thìn, năm Thân - Dậu - Tuất thì ở Mùi, năm Hợi thì ở Tuất. Nếu trong Tứ trụ có Cô thần và Quả tú, lại có Quan, Ấn thì người đó sẽ làm tướng cướp trong rừng núi hoặc đi tu, sống cô đơn. Nếu Quả tú gặp Không vong, lúc còn nhỏ sẽ gặp cuộc sống khổ cực, khó khăn. Ở trụ giờ có Quả tú thì người đó khó dạy nổi con cái. Nếu Quả tú gặp Hoa cái thì là số đi tu. Có Quả tú hoặc Cô thần thì luôn xa cách anh em họ hàng hoặc khắc anh em.',

        'tu-quy-nhan' => "Tú quý nhân (Đức quý nhân) là thần giải hung âm dương, là khí thanh tú của trời đất, là thần thịnh vượng của bốn mùa. Có Tú quý nhân là tháng đó đức sinh vượng. Người có Tú quý nhân là sự hòa hợp giữa tứ khí với ngũ hành trong trời đất. Người trong mệnh có đức, tú quý nhân không bị xung, phá, khắc, áp thì là người đó thông minh, ôn hòa, trung hậu. Nếu gặp xung khắc thì các yếu tố này giảm đi.<br>Tóm lại, đức, tú cũng là một loại quý nhân, nó có thể biến hung thành cát. Trong mệnh nếu có nó thì là người thành thật, thông minh, tính tình ôn hòa, lúc nào cũng có tinh thần yêu đời, hành hiệp trượng nghĩa giúp đỡ những người yếu thế. Ngoài ra những người này còn tài hoa xuất chúng, nên con đường công danh sự nghiệp, thăng tiến đều tốt hơn người khác.",

        'duc-quy-nhan' => 'Hai quý nhân thiên đức&nbsp; và nguyệt đức đều chủ về người có cuộc đời không nguy hiểm. Thiên đức quý nhân là cát tinh phúc tường, tính tình nhân từ đôn hậu, cuộc đời phúc nhiều, ít nguy hiểm, gặp hung hóa thành cát, hóa hiểm thành an, như là có thần bảo hộ. Nguyệt đức quý nhân&nbsp; là cát tinh phúc thọ. Trong Tứ trụ có cả thiên, nguyệt đức là người&nbsp; có năng lực gặp hung hóa các rất mạnh, gặp được cát thần thì càng thêm tốt, gặp phải hung thần cũng bớt xấu rất nhiều, nhưng gặp phải xung khắc thì vô dụng.'
    ];

    public $dungThanLuanGiai = [
        'kim' => [
            'vuong' => '<p><b>Luận theo Mệnh Cục cách:</b> Khi vận vượng hoặc những năm canh, tân, mậu kỷ bản thân dễ độc đoán, cứng nhắc, cương quyết, quyết đoán và khá mạnh mẽ, nghiêm túc dốc lòng để đạt được những cái bản thân muốn và đề ra, bản thân có tuy duy tổ chức giỏi nhưng kém linh động, không dễ nhận sự giúp đỡ, đôi lúc cũng khá sầu muộn nội tâm nhưng cứng ngoài mềm trong.</p><ul><li>Ưu Điểm: Bản thân có sự mạnh mẽ, quyết đoán, có thể làm lên việc lớn.</li><li>Khuyết Điểm: Đôi lúc khá độc đoán, cứng nhắc thiếu sự linh động.</li><li>Cũng vì những khuyết điểm của bản thân và chưa biết nắm bắt thời vận, mệnh lý mà cuộc sống cũng như công việc, sự nghiệp chưa được như mong muốn, vậy gia chủ nên làm giảm sự vượng của Kim bằng cách dùng ngũ hành Hỏa hoặc Thủy để trợ mệnh, giúp mệnh cục có sự cân bằng, chỉ có sự cân bằng thì Mệnh Vận mới hanh thông.</li></ul>',
            'nhuoc' => '<p>Luận theo Mệnh Cục cách: Bản thân đôi lúc khá mền yếu, nhu nhược, dễ ỉ lại, nhanh nản và dụt dè, có linh động nhưng hiệu quả thấp. Chính vì điều này nên bản thân cần thêm sự mạnh mẽ, quyết tâm để mệnh vận về sau có nhiều sự cát lành hơn. </p><ul><li>Ưu Điểm: thông minh, sống tình cảm.</li><li>Khuyết Điểm: cản thèm chóng chán, buông xuôi.</li></ul><p>Cũng vì những khuyết điểm của bản thân và chưa biết nắm bắt thời vận, mệnh lý mà cuộc sống cũng như công việc, sự nghiệp chưa được như mong muốn, vậy gia chủ nên làm giảm sự nhược của Kim, bằng cách dùng ngũ hành Kim hoặc Thổ để trợ mệnh, giúp mệnh cục có sự cân bằng, chỉ có sự cân bằng thì Mệnh Vận mới hanh thông.</p>'
        ],
        'thuy' => [
            'vuong' => '<p><b>Luận theo Mệnh Cục cách:</b> Mệnh vượng thủy khá thông minh, tháo vát nhưng đôi khi hởi xảo quyệt, suy nghĩ phức tạp. Đời sống tình cảm phong phú, nhiều ước mơ dễ cả thèm chóng chán, bản thân cần chú ý Những năm Bính Đinh, Nhâm Quý dê càng làm càng mất gia chủ cần chú ý. </p><ul><li>Ưu Điểm: nhanh nhen, nhậy bén.</li><li>Khuyết Điểm: dễ mông lung, ảo tưởng.</li></ul><p>Cũng vì những khuyết điểm của bản thân và chưa biết nắm bắt thời vận, mệnh lý mà cuộc sống cũng như công việc, sự nghiệp chưa được như mong muốn, vậy gia chủ nên làm giảm sự vượng của Thủy bằng cách dùng ngũ hành Thổ hoặc Mộc để trợ mệnh, giúp mệnh cục có sự cân bằng, chỉ có sự cân bằng thì Mệnh Vận mới hanh thông.</p>',
            'nhuoc' => '<p>Luận theo Mệnh Cục cách: Khi mệnh nhược thủy tư duy dễ chậm chạp, đời sống khô cằn, trí nhớ kém, thiếu sự cận thận hay qua loa và buông xuôi, đôi lúc khá nham hiểm, dễ mất bình tĩnh. tâm địa dễ xấu sẽ rất mưu mô và thích tranh giành quyền lực.</p><ul><li>Ưu Điểm: ít khi mông lung, ảo tưởng.</li><li>Khuyết Điểm: trí nhớ kém, chậm chạp.</li><li>Cũng vì những khuyết điểm của bản thân và chưa biết nắm bắt thời vận, mệnh lý mà cuộc sống cũng như công việc, sự nghiệp chưa được như mong muốn, vậy gia chủ nên làm giảm sự nhược của Thủy, bằng cách dùng ngũ hành Thủy hoặc Kim để trợ mệnh, giúp mệnh cục có sự cân bằng, chỉ có sự cân bằng thì Mệnh Vận mới hanh thông.</li></ul>'
        ],
        'moc' => [
            'vuong' => '<p><b>Luận theo Mệnh Cục cách:</b> Bản thân đôi lúc khá cố chấp, bảo thủ và cứng rắn, khi đã quyết việc gì là không từ bỏ, sống có tham vọng, khái tính cũng biết nóng giận nhưng nói xong mới nghĩ hay bị mất lòng và hớ, khi làm ăn dễ không lắm bắt được cơ hội, thân vượng Mộc sinh sôi nhiều nhưng yếu, ví như 1 m2 trồng 1 cây là đủ, đây lại trồng tận 10 cây nếu không cân đối cũng khó hữu lộc lộc tồn.</p><ul><li>Ưu Điểm: mạnh dạn, có nhiều may mắn, cơ hội.</li><li>Khuyết Điểm: gia trưởng, cứng nhắc.</li><li>Cũng vì những khuyết điểm của bản thân và chưa biết nắm bắt thời vận, mệnh lý mà cuộc sống cũng như công việc, sự nghiệp chưa được như mong muốn, vậy gia chủ nên làm giảm sự vượng của Mộc bằng cách dùng ngũ hành Kim hoặc Hỏa để trợ mệnh, giúp mệnh cục có sự cân bằng, chỉ có sự cân bằng thì Mệnh Vận mới hanh thông.</li></ul>',
            'nhuoc' => '<p><b>Luận theo Mệnh Cục cách:</b> Khi thân nhước Mộc bản thân dễ thiếu sự phát triểm và nghị lực, lúc gắp khó khăn dễ lùi bước, ý chí khá kém, cũng có chút vội vàng và buông xuôi, khi vận thế xuống cuộc sống dễ mất phương hướng và định hướng.</p><ul><li>Ưu Điểm: bản thân có sự cân đối không quá cố chấp, bảo thủ.</li><li>Khuyết Điểm: khá yếu đuối, nhút nhát.</li><li>Cũng vì những khuyết điểm của bản thân và chưa biết nắm bắt thời vận, mệnh lý mà cuộc sống cũng như công việc, sự nghiệp chưa được như mong muốn, vậy gia chủ nên làm giảm sự nhược của Mộc, bằng cách dùng ngũ hành Mộc hoặc Thủy để trợ mệnh, giúp mệnh cục có sự cân bằng, chỉ có sự cân bằng thì Mệnh Vận mới hanh thông.</li></ul>'
        ],
        'hoa' => [
            'vuong' => '<p><b>Luận theo Mệnh Cục cách:</b> Bản thân khá khái tính và quy tắc, ý chí mạnh mẽ, kiên cường, luôn tràn đầy năng lượng, thích sự thẳng thắn nói là làm chấp nhận rủi ro. Khá chủ động và tham vọng, tính bộc trực, thật thà nhưng khô khan dễ nóng vội, dễ bốc đồng. Đôi khi vì cái tôi mà bỏ qua cơ hội, cũng vẫn biết không nên nhưng vẫn cố làm, đôi khi khá bảo thủ gia trưởng.</p><ul><li>Ưu Điểm: kiên cường, mạnh mẽ, may mắn.</li><li>Khuyết Điểm: nóng vội, liều lĩnh.</li><li>Cũng vì những khuyết điểm của bản thân và chưa biết nắm bắt thời vận, mệnh lý mà cuộc sống cũng như công việc, sự nghiệp chưa được như mong muốn, vậy gia chủ nên làm giảm sự vượng của Hỏa bằng cách dùng ngũ hành Thủy hoặc Thổ để trợ mệnh, giúp mệnh cục có sự cân bằng, chỉ có sự cân bằng thì Mệnh Vận mới hanh thông.</li></ul>',
            'nhuoc' => '<p><b>Luận theo Mệnh Cục cách:</b> Bản thân đôi khi dễ thiếu sự quyết đoán và Chần chừ, nhút nhát có thể chậm chạp, còn suy nghĩ phải thấu đáo tới mức cơ hội qua mới có quyết định, có những lúc thiếu sự chủ động và còn nhu nhược.</p><ul><li>Ưu Điểm: tính toán cẩn thận, chu đáo.</li><li>Khuyết Điểm: thiếu sự quyết đoán và hay chần chừ.</li><li>Cũng vì những khuyết điểm của bản thân và chưa biết nắm bắt thời vận, mệnh lý mà cuộc sống cũng như công việc, sự nghiệp chưa được như mong muốn, vậy gia chủ nên làm giảm sự nhược của Hỏa, bằng cách dùng ngũ hành Hỏa hoặc Mộc để trợ mệnh, giúp mệnh cục có sự cân bằng, chỉ có sự cân bằng thì Mệnh Vận mới hanh thông.</li></ul>'
        ],
        'tho' => [
            'vuong' => '<p><b>Luận theo Mệnh Cục cách:</b> Bản thân có cái tôi cao, lòng tự trọng và tự ái cao, tinh thần khá vững chắc. Nhưng đôi khi khá chậm chạp, ỉ lại, trì trệ, bảo thủ và cố chấp, khá khô cằn từ đó bản thân dễ cô quạnh, hay bỏ qua cơ hội vì suy tư qua mức.</p><ul><li>Ưu Điểm: ý chí vững vàng, kiên định.</li><li>Khuyết Điểm: trì trệ, bảo thủ.</li><li>Cũng vì những khuyết điểm của bản thân và chưa biết nắm bắt thời vận, mệnh lý mà cuộc sống cũng như công việc, sự nghiệp chưa được như mong muốn, vậy gia chủ nên làm giảm sự vượng của Thổ bằng cách dùng ngũ hành Mộc hoặc Kim để trợ mệnh, giúp mệnh cục có sự cân bằng, chỉ có sự cân bằng thì Mệnh Vận mới hanh thông.</li></ul>',
            'nhuoc' => '<p><b>Luận theo Mệnh Cục cách:</b> Đôi khi gia chủ dễ lay động và có thể thiếu sự quyết đoán hay do dự, tự ti, nhu nhược, thiếu chứng kiếm, đôi lúc nửa vời, cả thèm chóng chán, lập trường không vững, dù là thân nhược nhưng vẫn có sự bảo thủ. Nhưng bản thân khá cần kiệm liêm chính sống không ngại khó khăn.</p><ul><li>Ưu Điểm: cần cù, chăm chỉ.</li><li>Khuyết Điểm: do dự, lập trường không vững.</li><li>Cũng vì những khuyết điểm của bản thân và chưa biết nắm bắt thời vận, mệnh lý mà cuộc sống cũng như công việc, sự nghiệp chưa được như mong muốn, vậy gia chủ nên làm giảm sự nhược của Thổ, bằng cách dùng ngũ hành Thổ hoặc Hỏa để trợ mệnh, giúp mệnh cục có sự cân bằng, chỉ có sự cân bằng thì Mệnh Vận mới hanh thông.</li></ul>'
        ],
    ];

    public $napAmUuKhuyetDiem = [
        'kim' => [
            'uu_diem' => 'mạnh mẽ, tự tin',
            'khuyet_diem' => 'cứng nhắc',
        ],
        'thuy' => [
            'uu_diem' => 'trí nhớ tốt',
            'khuyet_diem' => 'dễ mung lung',
        ],
        'moc' => [
            'uu_diem' => 'nhân hậu, điềm đạm',
            'khuyet_diem' => 'cứng nhắc, bảo thủ',
        ],
        'hoa' => [
            'uu_diem' => 'mạnh mẽ, dũng cảm',
            'khuyet_diem' => 'thô, thẳng, nóng',
        ],
        'tho' => [
            'uu_diem' => 'chăm chỉ, cần kiệm liêm chính',
            'khuyet_diem' => 'dễ trì trệ, chậm tính',
        ],

    ];
    public $napAmLuanGiai = [
        'kim' => '<b>Luận theo Âm/Dương cách: </b> Bản thân có tính cách mạnh mẽ, tự tin, cương quyết. Lúc vượng khí cao dễ độc đoán, cứng nhắc nên dễ sầu muộn, bản thân muốn có được gì sẽ dốc hết lòng để đạt cho bằng được. Có tư duy tổ chức giỏi, có sự quyết đoán tuy nhiên đôi lúc vì tin vào khả năng của bản thân quá dễ kém linh động. Tính khá nghiêm túc khái tính nên không dễ nhận sự giúp đỡ.',

        'thuy' => '<b>Luận theo Âm/Dương cách: </b> Gia chủ khá thông minh, tính cách thẳng thắn và dí dỏm. Có trí nhớ tốt, hay cân nhắc nặng nhẹ và khá cẩn thận, khép kín, thâm ý. Cũng khá hòa đồng, cởi mở, luôn có sự tích cực và năng động, đôi lúc cảm giác khá bận rộn kiểu người của công việc, bản thân thích cuộc sống thanh bình, không thích đối đầu',

        'moc' => '<b>Luận theo Âm/Dương cách: </b> Gia chủ tính cách khá hài hòa, linh hoạt, phóng khoáng, điềm đạn, giàu tình cảm và có trái tim nhân hậu, biết trước biết sau, luôn lạc quan yêu đời, thích kết bạn với mọi người. Bản thân có sự tự tin vào chính mình, có thể sẵn sàng thể hiện bản thân, tác phong nhanh nhẹn, xong cũng dễ thay đổi, đôi khi khá cố chấp, bảo thủ, cứng rắn, nóng giận vội vàng, không dễ dàng giao động, đã quyết việc gì là không từ bỏ, chăm chỉ, gan dạ sống có tham vọng.',

        'hoa' => '<b>Luận theo Âm/Dương cách: </b> Bản tính dũng cảm, nói là làm rất khái tính, thẳng thắn, bộc trực nhưng thật thà sống có quy tắc, không nhất thì bét luôn sẵn sàng chiến đấu, mạo hiểm chấp nhận rủi ro. Tư duy chủ động có tham vọng. Không thích sự dối trá, đôi khi khá khô khan dễ nóng vội dễ bốc đồng, thô thẳng thật, ý chí mạnh mẽ, kiên cường, luôn tràn đầy năng lượng.',

        'tho' => '<b>Luận theo Âm/Dương cách: </b> Tính cách khá dễ thương, dễ gần, hòa đồng, điềm đạm, cần kiệm rất giữ chữ tín nói là làm. Nhưng cái tôi, tự trọng, tự ái cao, bản thân hay tự ti, biết nhìn thẳng sự việc để nhìn nhận, chấp nhận cái sai, họ dám làm dám chịu. Đôi lúc khá nhu nhược, mềm lòng và bao dung, độ lượng. Bản thân có khả năng tổ chức, giỏi sắp xếp, sống kỷ luật, tự giác, luôn nỗ lực hoàn thành công việc, nội tâm sống động hay suy tư, đôi khi bảo thủ nên dễ nhàm chán, khi làm gì cố làm cho bằng được về sau thành công từ từ.',
    ];
    public $luuNienLuanGiai = [
        'quan' => 'Là cái khắc chế ngự mình, đại diện cho quan chức tốt, chính trực trong chính quyền điều hành xã hội. Nhiệm vụ của chính quan trong mệnh là bảo vệ tài, áp chế Thân, khống chế tỷ và kiếp. Trong đại vận có chính quan đại diện cho chức vụ, học vị, thi cử, bầu cử, danh dự, nhưng cần cẩn trong trong đầu tư làm ăn khi đại vạn thuộc quan, dễ nên nhưng cũng dễ vào lao lý nợ nần, Với sự đoan trang nghiêm túc, làm việc có đầu có đuôi. Nhưng dễ bảo thủ cứng nhắc, thậm chí là người không kiên nghị. Vì vậy đại vận này nên thủ thân biết người biết ta suy tính kỹ hãy hành động.',
        'sat' => '(thiên quan) là cái khắc chế ngự mình, nó thường đại diện cho quan lại xấu trong chính quyền. Hoạc trong xã hội và hại mình. Trong đại vận thất sát chuyên tấn công lại minh, cho nên mình dễ bị tổn thương, làm ăn đầu tư dễ thua nỗ, bại sản gai đình tình cảm lao đao cho bản thân và gia đình dễ ngặp chuyện không như mong, thất sát được coi là hung thần. làm tổn hao tài, tốn của gia đình lâm nguy. Trông vận đó chúng ta dễ bị kích động, thậm chí dễ trở thành người ngang ngược, trụy lạc... Vì vậy đại vận này nên thủ thân biết người biết ta suy tính kỹ hãy hành động.',
        'an' => 'Là cái sinh ra ta, hỗ trợ ta nhưng chỉ tốt khi thân ta nhược chứ vượng lại nguy cung như cây đã đủ nước lại được thêm nước thì ủng dễ mà chết. Đại diện cho chức vụ, quyền lợi, học hành, nghề nghiệp, học thuật, sự nghiệp, danh dự, địa vị, phúc thọ.Tâm tính của chính ấn, thông minh, nhân từ, không tham danh lợi, chịu đựng nhưng ít khi tiến thủ, thậm chí còn chậm chạp, trì trệ... Trong đai vận những năm có chính ấn làm ăn thuận lợi cho quý nhân trợ giúp. Có thể tính toán đầu tư làm ăn, báo hiệu 1 đại vận tốt. Nhưng khi xét kỹ cần phải trao đổi cùng với chuyên gia để có lời chia sẻ tốt nhất.',
        'kieu' => 'Là cái sinh trợ cho mình nhưng tốt xấu còn chưa rõ, kiêu đại diện cho quyền uy trong nghề nghiệp như nghệ thuật, nghệ sĩ, y học, luật sư, tôn giáo, kỹ thuật, nghề tự do, những thành tích trong dịch vụ... Trong mệnh hay vận cũng vậy thì thân vượng mà được sinh thì là nguy, còn khi thân nhược được sinh là cát. Nhưng nói chung trông đại vận hay lưu niên mà có ấn tinh là điều đáng mừng còn hung cát cụ thể quý bách gia lên trao đổi cùng chuyên gia cho cụ thể, chứ 1 vài 3 chữ không nói hết nên được.',
        'ty' => 'Là ngang vai với mình (là thiên can có cùng hành cùng dấu với Nhật Can) ví dụ như Canh kim và Tân kim gọi tắt là tỷ. Đại diện cho tay chân cấp dưới, bạn bè, đồng nghiệp, cùng phe, anh chị em. Nhưng cũng có 2 mặt khi thân nhược thì tỷ kiếp là tốt có anh chi em giúp đỡ trợ thân là tốt, nhưng khi thân vượng là có thêm lại không tốt, làm ăn không thuận nhưng cung kiếp sát, tỷ là vượng thì chắc chắn, cương nghị, không cần tính cứ làm, có chí tiến thủ, nhưng dễ cô quạnh. Nếu trong đại vận thuộc tỷ nói chung là kết giao thêm anh em bằng hữu nhưng bạn tốt hay xấu cũng còn tùy gia chủ nên lựa trọn.',
        'kiep' => 'Là ngang vai với mình (là thiên can cùng hành nhưng khác dấu với Nhật Can), kiếp tài đại diện cho tay chân cấp dưới, bạn bè, tranh lợi đoạt tài, khắc vợ, khắc cha, ngao du... Nhưng cũng có 2 mặt khi thân nhược thì kiếp tài là tốt có anh chi em giúp đỡ trợ thân là tốt, nhưng khi thân vượng mà có thêm lại không tốt, làm ăn không thuận nhưng cung kiếp sát . kiếp tài là nhiệt tình, thẳng thắn, ý chí kiên nhẫn, phấn đấu bất khuất, nhưng dễ thiên về mù quáng, thiếu lý trí, thậm chí manh động, liều lĩnh...',
        'thuc' => 'Là ta sinh ra (cùng dấu với Nhật Can). Khi thân vượng có thực thần là rất tốt giúp ta cân bằng lại chân mệnh, hoạc khi nhược thực thần giúp ta hóa giải sát, thực thần là tốt nhưng lại làm ta hao mòn, hung hay cát còn tùy từng thởi vận. Thực thần, ôn hòa, rộng rãi với mọi người, hiền lành, thân mật, ra vẻ tốt bề ngoài nhưng trong không thực bụng, thậm chí nhút nhát, giả tạo. Can chi đều có thực thần thì phúc lộc dồi dào, nhưng không thích hợp cho người công chức mà thích hợp với những người làm nghề tự do. Đại vận thực thần dễ hao sức và của nhưng có cái mất là được, khi lấp thất vận này dễ sinh con, làm ăn thì dễ hao hụt. Đại diện cho phúc thọ, người béo, có lộc.',
        'thuong' => 'Là ta sinh ra (nhưng khác dấu với Nhật Can). Đại diện cho bị mất chức, bỏ học, thôi việc, mất quyền, mất ngôi, không chúng tuyển, không thi đỗ, tài hoa, nhưng dễ hiếu thắng, nhưng dễ tùy tiện, nên dễ hao và cuộc sống bồng bềnh. Vào đại vận thương quan dễ có con cho vợ chồng hiếm muộn và mới lập thất. Về sự nghiệp thăng trầm hao nhưng mất cái nọ được cái kia, trong đại vận thương qua mà lưu niên quan sát thân lại nhượng thì khốn đốn, nhưng thân vwongj lại an gia làm lên.',
        'ctai' => 'Là ta khắc chế (có dấu khác với Nhật Can) là cái nuôi sống ta. Đại diện cho tài lộc, sản nghiệp, tài vận, tiền lương, chính tài được coi là cát thần. Vận chính tài thì cần cù, tiết kịêm, chắc chắn, thật thà, nhưng dễ thiên về ẩu, trì trệ và nhu nhược. Nếu Thân vượng, tài vượng làm ăn phát đạt gia trung trong ấm ngoài êm sự nghiếp có thành tựu. Nếu Thân nhược mà tài vượng thì ngèo và khó khăn, có tài mà không có thời gọi là tài vặt. Trong đại vận chính tài dễ làm ăn dễ phát triển bản thân. Nhưng cũng dễ thất bại.',
        'ttai' => 'Là ta khắc chế (nhưng cùng dấu với Nhật Can) cũng là cái nuôi sống ta. Đại diện cho của riêng, trúng thưởng, phát tài nhanh, đánh bạc, tình cảm với cha. Thiên tài, trọng tình cảm, thông minh, lạc quan, phóng khoáng, nhưng dễ tinh tướng bốc cao có 10 triệu nói có 20 triệu, xem trọng bề ngoài, không kiềm chế, Thân vượng, tài vượng, quan vượng thì tài lộc có đủ, hữu lộc lộc tồn. Trong đại vận thiên tài có thì có dễ thì dễ nhưng cũng tồn được ít hoặc còn mất',
    ];
    public $cungMenhInfo = [
        'ti' => '<b>Cung mệnh Thiên quý tinh:</b> Gia chủ có chí khí lớn lao và giàu có cao quý, làm ăn buôn bán may mắn, có trí có tài.',

        'suu' => '<b>Cung mệnh Thiên ách tinh:</b> Gia chủ dễ phải xa quê Cha đất tổ lập nghiệp mới lên, vất vả, gian nan trước sau mới cát, tiền trung vận buôn ba sau 38 tuổi cuộc sống sẽ an nhàn thảnh thơi',

        'dan' => '<b>Cung mệnh Thiên quyền tinh:</b> Gia chủ thông minh có triển vọng, thời trung niên có quyền chức hoặc làm chủ, sếp cán bộ lãnh đạo, chú ý giữ đức, tu tâm để tránh lao lý.',

        'mao' => '<b>Cung mệnh Thiên xá tịnh:</b> Gia chủ dễ trọng nghĩa khinh tài, sống cao thượng nhưng kiêu ngạo, có trí có tài nhưng cần cảm thông và hòa đồng để có cuộc sống an nhiên bình an.',

        'thin' => '<b>Cung mệnh Thiên như tinh:</b> Công việc, cuộc sống của Gia chủ hay có sự thay đổi, lắm mưu nhiều kế nhưng chưa đâu vào đâu, cần chính kiến, hãy lấy tâm làm móng để mọi sự hanh thông.',

        'ty' => '<b>Cung mệnh Thiên văn tinh:</b> Gia chủ có sự nghiệp văn chương sáng lạng, yêu và có năng khiếu nghệ thuật, chú ý giữ đạo để tránh mắc sai lầm trong tửu sắc, trí vững ắt vận thông.',

        'ngo' => '<b>Cung mệnh Thiên phúc tinh:</b> Mệnh thuộc vinh hoa phú quý, thanh nhàn yên vui, nên tu tâm hướng thiện bao dung độ lượng, biết cảm thông để giữ phúc báu lâu dài.',

        'mui' => '<b>Cung mệnh Thiên dịch:</b> Tuổi trẻ buôn ba vất vả, rời quê tổ lập nhiệp mới lên, vất vả, gian nan trước sau mới có, tiền trung vận buôn ba cần kiệm liêm chính ắt về sau hiển vinh.',

        'than' => '<b>Cung mệnh Thiên cô tinh:</b> Bản thân dễ tự thân vận đông, cô quạnh một phần do bản thân muốn sống khép kín, tâm lành dễ tu đắc đạo, nên tạo phúc trợ duyên để sau có cuộc sống thanh cao viên mãn',

        'dau' => '<b>Cung mệnh Thiên bí tinh:</b> Gia chủ tính tình thẳng thắn nên dễ gặp vạ chuyện thị phi, có chút nóng vội, hay lo chuyện bao đồng và thích giúp người khác nhưng dễ nhiều chuyện, tu khẩu tu tâm mới tốt.',

        'tuat' => '<b>Cung mệnh Thiên nghệ tinh:</b> Bản thân đa tài đa nghệ nhưng dễ dãi hùa theo, có thể cái gì cũng biết nhưng không giỏi, nếu không có sự thay đổi thì dễ khó thành danh, nên chính kiến tập trung theo năng khiếu, về sau mới có cuộc sống như mong',

        'hoi' => '<b>Cung mệnh Thiên thọ tinh:</b> Gia chủ có lòng nhân từ, tính nhanh nhẹn, lấy giúp người làm vui, có cuộc sống bình bình, ghét xô sát trang dành. Không giầu và cũng không nghèo.',
    ];

    public function convertCanchiSlugToText($slug) {
        $arr = [
            'ti' => 'Tý',
            'suu' => 'Sửu',
            'dan' => 'Dần',
            'mao' => 'Mão',
            'thin' => 'Thìn',
            'ty' => 'Tỵ',
            'ngo' => 'Ngọ',
            'mui' => 'Mùi',
            'than' => 'Thân',
            'dau' => 'Dậu',
            'tuat' => 'Tuất',
            'hoi' => 'Hợi',
            'giap' => 'Giáp',
            'at' => 'Ất',
            'binh' => 'Bính',
            'dinh' => 'Đinh',
            'mau' => 'Mậu',
            'ky' => 'Kỷ',
            'canh' => 'Canh',
            'tan' => 'Tân',
            'nham' => 'Nhâm',
            'quy' => 'Quý',
        ];

        return isset($arr[$slug]) ? $arr[$slug] : $slug;
    }

    public $thangTietKhi = [
        'lap-xuan' => 1,
        'vu-thuy' => 1,
        'kinh-trap' => 2,
        'xuan-phan' => 2,
        'thanh-minh' => 3,
        'coc-vu' => 3,
        'lap-ha' => 4,
        'tieu-man' => 4,
        'mang-chung' => 5,
        'ha-chi' => 5,
        'tieu-thu' => 6,
        'dai-thu' => 6,
        'lap-thu' => 7,
        'xu-thu' => 7,
        'bach-lo' => 8,
        'thu-phan' => 8,
        'han-lo' => 9,
        'suong-giang' => 9,
        'lap-dong' => 10,
        'tieu-tuyet' => 10,
        'dai-tuyet' => 11,
        'dong-chi' => 11,
        'tieu-han' => 12,
        'dai-han' => 12,
    ];

    protected Collection $tietkhi;

    public function __construct($ngayDuongLich, $gioSinh, $phutSinh, $gioiTinh = 1, $timeZone = 7, $hoTen = '') {
        $tietkhi = File::get(public_path('phongthuy/tietkhi.json'));
        $this->tietkhi = collect(json_decode($tietkhi, true));

        $this->setVariable();
        $this->ngayDuongLich = $ngayDuongLich;
        $this->gioSinh = $gioSinh;
        $this->phutSinh = !empty($phutSinh) ? $phutSinh : '00';
        $this->gioPhutSinh = $this->gioSinh . ':' . $this->phutSinh;
        $this->gioID = $this->getGioID($this->gioSinh);

        if ($this->gioSinh >=23) {
            $this->ngayDuongLich = date('d-m-Y', strtotime($ngayDuongLich . ' + 1 day' ));
        }
        $ngaysinhArr = explode('-', $this->ngayDuongLich);
        $this->ngayDuong = $ngaysinhArr[0];
        $this->thangDuong = $ngaysinhArr[1];
        $this->namDuong = $ngaysinhArr[2];
        $canChiNgay = $this->canChiNgay($this->ngayDuong, $this->thangDuong, $this->namDuong, true);
        $this->canNgayId = $canChiNgay[0];
        $this->chiNgayId = $canChiNgay[1];

        $this->canGio = $this->fix10($this->fix10(($this->canNgayId * 2) - 1) + $this->gioID - 1);
        $this->chiGio = $this->gioID;

        $this->ngaythangNamAm = $this->ngayThangNamCanChi($this->ngayDuong, $this->thangDuong, $this->namDuong, true, $timeZone);

        $this->ngaythangAm = $this->NgayThangNamAmLich($this->ngayDuong, $this->thangDuong, $this->namDuong, $timeZone, true);
        $this->canThangId = $this->ngaythangNamAm[0];
        $this->chiThangId = $this->fix12($this->ngaythangAm[1] + 2);
        $this->sex = $gioiTinh;
        $this->thangAmlich = $this->can[$this->canThangId] . ' ' . $this->chi[$this->chiThangId];
        $this->chiThangText = $this->chi[$this->chiThangId];
        $this->menhQuaiArr = $this->menhQuai($this->ngaythangAm[2], (int) $this->sex);
        $this->ngaySinhFull = Carbon::parse($this->namDuong . '-' . $this->thangDuong . '-' . $this->ngayDuong . ' ' . $this->gioSinh . ':' . $this->phutSinh . ':00')->format('Y-m-d H:i:s');
        $tinhNam = $this->checkLapXuan() ? $this->namDuong : $this->namDuong-1;
        $this->namAmlich = $this->tinhNamAm($this->ngayDuong, $this->thangDuong, $tinhNam, true, $timeZone);

        $this->canNamText = $this->namAmlich['can']['title'];
        $this->chiNamText = $this->namAmlich['chi']['title'];
        $this->canNamSlug = $this->khongdau($this->canNamText);
        $this->chiNamSlug = $this->khongdau($this->chiNamText);

        $this->canThangText = $this->can[$this->canThangId];
        $this->chiThangText = $this->chi[$this->chiThangId];
        $this->canNgayText = $this->can[$this->canNgayId];
        $this->chiNgayText = $this->chi[$this->chiNgayId];
        $this->canGioText = $this->can[$this->canGio];
        $this->chiGioText = $this->chi[$this->chiGio];

        $this->canThangSlug = $this->khongdau($this->canThangText);
        $this->chiThangSlug = $this->khongdau($this->chiThangText);
        $this->canNgaySlug = $this->khongdau($this->canNgayText);
        $this->chiNgaySlug = $this->khongdau($this->chiNgayText);
        $this->canGioSlug = $this->khongdau($this->canGioText);
        $this->chiGioSlug = $this->khongdau($this->chiGioText);
        $this->hoTen = $hoTen;
        $this->menhAmDuong = $this->ngaythangAm[2] % 2 == 0 ? 1 : 0; // 1: duong 0: am
        $this->getThangCanChi();
        $this->setTamTai();
        $this->tietKhiBySex = $this->getTietKhi();
        $this->genderString = $gioiTinh == 1 ? 'nam' : 'nữ';
        $this->canInfo = [
            'nam' => $this->canAmDuong[$this->canNamSlug],
            'thang' => $this->canAmDuong[$this->canThangSlug],
            'ngay' => $this->canAmDuong[$this->canNgaySlug],
            'gio' => $this->canAmDuong[$this->canGioSlug],
        ];

        $this->chiInfo = [
            'nam' => $this->chiAmDuong[$this->chiNamSlug],
            'thang' => $this->chiAmDuong[$this->chiThangSlug],
            'ngay' => $this->chiAmDuong[$this->chiNgaySlug],
            'gio' => $this->chiAmDuong[$this->chiGioSlug],
        ];
        $this->tinhNguHanhChiThang();
    }

    public function tinhNguHanhChiThang() {
        $tietKhiDate = strtotime($this->tietKhiHienTai['date']);

        $datediff = strtotime($this->ngaySinhFull) - $tietKhiDate;

        $dayNumber = abs(round($datediff / (60 * 60 * 24)));
        // 1: KIM, 2: THỦY, 3: MỘC, 4: HỎA, 5: THỔ
        $item = [];
        switch ($this->tietKhiHienTai['slug']) {
            case 'lap-xuan':
                // 7 ngày mậu(thổ), 7 ngày bính(hỏa), 16 ngày giáp(mộc)
                if ($dayNumber <= 7) {
                    $item['name'] = 'tho';
                    $item['title'] = 'Thổ';
                    $item['id'] = 5;
                } elseif ($dayNumber > 7 && $dayNumber <= 14) {
                    $item['name'] = 'hoa';
                    $item['title'] = 'Hỏa';
                    $item['id'] = 4;
                } else {
                    $item['name'] = 'moc';
                    $item['title'] = 'Mộc';
                    $item['id'] = 3;
                }
                break;
            case 'kinh-trap':
                // 10 ngày giáp(mộc), 20 ngày ất(mộc)
                $item['name'] = 'moc';
                $item['title'] = 'Mộc';
                $item['id'] = 3;
                break;
            case 'thanh-minh':
                // 9 ngày ất(mộc), 3 ngày(quý), 18 ngày mậu(thổ)
                if ($dayNumber <= 9) {
                    $item['name'] = 'moc';
                    $item['title'] = 'Mộc';
                    $item['id'] = 3;
                } elseif ($dayNumber > 9 && $dayNumber <= 12) {
                    $item['name'] = 'thuy';
                    $item['title'] = 'Thủy';
                    $item['id'] = 2;
                } else {
                    $item['name'] = 'tho';
                    $item['title'] = 'Thổ';
                    $item['id'] = 5;
                }
                break;
            case 'lap-ha':
                // 5 ngày mậu(thổ), 9 ngày canh(kim), 16 ngày bính(hỏa)
                if ($dayNumber <= 5) {
                    $item['name'] = 'tho';
                    $item['title'] = 'Thổ';
                    $item['id'] = 5;
                } elseif ($dayNumber > 5 && $dayNumber <= 14) {
                    $item['name'] = 'kim';
                    $item['title'] = 'Kim';
                    $item['id'] = 1;
                } else {
                    $item['name'] = 'hoa';
                    $item['title'] = 'Hỏa';
                    $item['id'] = 4;
                }
                break;
            case 'mang-chung':
                // 10 ngày bính(hỏa), 9 ngày kỷ(thổ), 11 ngày bính(hỏa)
                if ($dayNumber <= 10) {
                    $item['name'] = 'hoa';
                    $item['title'] = 'Hỏa';
                    $item['id'] = 4;
                } elseif ($dayNumber > 10 && $dayNumber <= 19) {
                    $item['name'] = 'tho';
                    $item['title'] = 'Thổ';
                    $item['id'] = 5;
                } else {
                    $item['name'] = 'hoa';
                    $item['title'] = 'Hỏa';
                    $item['id'] = 4;
                }
                break;
            case 'tieu-thu':
                // 9 ngày đinh(hỏa), 3 ngày ất(mộc), 18 ngày kỷ(thổ)
                if ($dayNumber <= 9) {
                    $item['name'] = 'hoa';
                    $item['title'] = 'Hỏa';
                    $item['id'] = 4;
                } elseif ($dayNumber > 9 && $dayNumber <= 12) {
                    $item['name'] = 'moc';
                    $item['title'] = 'Mộc';
                    $item['id'] = 3;
                } else {
                    $item['name'] = 'tho';
                    $item['title'] = 'Thổ';
                    $item['id'] = 5;
                }
                break;
            case 'lap-thu':
                // 7 ngày kỷ(thổ), 3 ngày mậu(thổ), 3 ngày nhâm(thủy), 17 ngày canh(kim)
                if ($dayNumber <= 10) {
                    $item['name'] = 'tho';
                    $item['title'] = 'Thổ';
                    $item['id'] = 5;
                } elseif ($dayNumber > 10 && $dayNumber <= 13) {
                    $item['name'] = 'thuy';
                    $item['title'] = 'Thủy';
                    $item['id'] = 2;
                } else {
                    $item['name'] = 'kim';
                    $item['title'] = 'Kim';
                    $item['id'] = 1;
                }
                break;
            case 'bach-lo':
                // 10 ngày canh(kim), 20 ngày tân(kim)
                $item['name'] = 'kim';
                $item['title'] = 'Kim';
                $item['id'] = 1;
                break;
            case 'han-lo':
                // 9 ngày tân(kim), 3 ngày bính(hỏa), 18 ngày mậu(thổ)
                if ($dayNumber <= 9) {
                    $item['name'] = 'kim';
                    $item['title'] = 'Kim';
                    $item['id'] = 1;
                } elseif ($dayNumber > 9 && $dayNumber <= 12) {
                    $item['name'] = 'hoa';
                    $item['title'] = 'Hỏa';
                    $item['id'] = 4;
                } else {
                    $item['name'] = 'tho';
                    $item['title'] = 'Thổ';
                    $item['id'] = 5;
                }
                break;
            case 'lap-dong':
                // 7 ngày mậu(thổ), 5 ngày giáp(mộc), 18 ngày nhâm(thủy)
                if ($dayNumber <= 7) {
                    $item['name'] = 'tho';
                    $item['title'] = 'Thổ';
                    $item['id'] = 5;
                } elseif ($dayNumber > 7 && $dayNumber <= 12) {
                    $item['name'] = 'moc';
                    $item['title'] = 'Mộc';
                    $item['id'] = 3;
                } else {
                    $item['name'] = 'thuy';
                    $item['title'] = 'Thủy';
                    $item['id'] = 2;
                }
                break;
            case 'dai-tuyet':
                // 10 ngày nhâm(thủy), 20 ngày quý(thủy)
                $item['name'] = 'thuy';
                $item['title'] = 'Thủy';
                $item['id'] = 2;
                break;
            case 'tieu-han':
                // 9 ngày quý(thủy), 3 ngày tân(kim), 18 ngày kỷ(thổ)
                if ($dayNumber <= 9) {
                    $item['name'] = 'thuy';
                    $item['title'] = 'Thủy';
                    $item['id'] = 2;
                } elseif ($dayNumber > 9 && $dayNumber <= 12) {
                    $item['name'] = 'kim';
                    $item['title'] = 'Kim';
                    $item['id'] = 1;
                } else {
                    $item['name'] = 'tho';
                    $item['title'] = 'Thổ';
                    $item['id'] = 5;
                }
                break;
        }
        if (!empty($item)) {
            $this->chiInfo['thang'] = array_merge($this->chiInfo['thang'], $item);
        }

        return $this;
    }

    public function getThangCanChi() {
        $chiThang = [
            'Dần', 'Mão', 'Thìn', 'Tỵ', 'Ngọ', 'Mùi', 'Thân', 'Dậu', 'Tuất', 'Hợi', 'Tí', 'Sửu'
        ];
        $thangGieng = $this->search_revisions($this->canArr, $this->canNamSlug, 'name');
        $canName = $this->canArr[$thangGieng]['thanggieng'];
        $canIndex = $this->search_revisions($this->canArr, $this->khongdau($canName), 'name');
        $canNew = $canIndex != 0 ?
            array_merge(array_slice($this->canArr, $canIndex, count($this->canArr)), array_slice($this->canArr, 0, $canIndex)) : $this->canArr;
        $thangInt = (int)$this->ngaythangAm[1];
        $this->tietKhiHienTai = $this->getTietKhiHienTai();
        $tietKhiHienTaiName = $this->tietKhiHienTai['name'] ?? 'lap-xuan';
        $slug = $this->khongdau($tietKhiHienTaiName);
        $thangInt = $this->thangTietKhi[$slug] -1;
        if ($thangInt < 0) {
            $thangInt = 0;
        }

        $canInt = $thangInt >= 10 ? $thangInt - 10 : $thangInt;
        $this->canThangText = $canNew[$canInt]['title'];
        $this->chiThangText = $chiThang[$thangInt];
        $this->canThangSlug = $this->khongdau($this->canThangText);
        $this->chiThangSlug = $this->khongdau($this->chiThangText);

        return $this;
    }


    public function getTietKhiHienTai(): array
    {
        $compareDate = Carbon::parse($this->ngaySinhFull);
        $tietkhi = $this->tietkhi->where('name','!=', null);
        return $tietkhi->filter(function ($item) use ($compareDate) {
            return Carbon::parse($item['date'])->lte($compareDate);
        })->sortBy('date')->last();
    }

    public function checkLapXuan(): int
    {
        $compareDate = Carbon::parse($this->ngaySinhFull);
        $tietkhi = $this->tietkhi->where('slug','=', 'lap-xuan')
            ->where('year', '=', $this->namDuong);
        return $tietkhi->filter(function ($item) use ($compareDate) {
            return Carbon::parse($item['date'])->lte($compareDate);
        })->count();
    }

    public function getTietKhi() {
        $tietkhi = $this->tietkhi->where('phan', '=', 0);
        $compareDate = Carbon::parse($this->ngaySinhFull);
        if ($this->menhAmDuong == $this->sex) { // duong nam, am nu
            $filtered = $tietkhi->filter(function ($item) use ($compareDate) {
                return Carbon::parse($item['date'])->gte($compareDate);
            })->sortBy('date')->first();
        } else {
            $filtered = $tietkhi->filter(function ($item) use ($compareDate) {
                return Carbon::parse($item['date'])->lte($compareDate);
            })->sortBy('date')->last();
        }

        return $filtered;
    }

    public function tinhToNghiep() {

    }

    public function tinhDaiVan() {
        //$tietKhi = $this->getTietKhi();
        $results = [];
        if (!empty($this->tietKhiBySex)) {
            $dateDiff = $this->getDateDiff($this->ngaySinhFull, $this->tietKhiBySex['date']);
            // tinh tuoi bat dau dai van
            // -- so ngay chia 3
            $ngay1 = floor($dateDiff['day'] / 3); // dai van tt1
            $ngay1Du = $dateDiff['day'] % 3;

            $hourPlus = $dateDiff['minutes'] > 0 ? round(1 / (60 / $dateDiff['minutes']), 3) : 0;
            $soGioDu = $ngay1Du * 24 + $dateDiff['hour'] + $hourPlus;
            $soNgayDu = ($soGioDu * 10);

            $daivan2 = 0;
            $thangDu = $ngayDu = 0;
            if ($soNgayDu == 365) {
                $daivan2 = 1;
            }
            if ($soNgayDu > 365) {
                $daivan2 = 1;
                $t = $soNgayDu - 365;
                // tinh thang du

                if ($t < 30) {
                    $ngayDu = $t;
                }
                if ($t == 30) {
                    $thangDu = 1;
                }
                if ($t > 30) {
                    $thangDu = floor($t / 30);
                    $ngayDu = $t % 30;
                }
            }
            if ($soNgayDu < 365) {
                $t = $soNgayDu;
                // tinh thang du
                if ($t < 30) {
                    $ngayDu = $t;
                } elseif ($t == 30) {
                    $thangDu = 1;
                } elseif ($t > 30) {
                    $thangDu = floor($t / 30);
                    $ngayDu = $t % 30;
                }
            }

            $results['tuoi'] = ($ngay1 + $daivan2);
            $results['thang'] = $thangDu;
            $results['ngay'] = $ngayDu;

            // tinh nam bat dau dai van
            $namBatDauDaiVan = (int)$this->namDuong + $ngay1 + $daivan2 - 1;
            $ngayDu = floor($ngayDu);
            $thangBatDauDaiVan = date('Y-m-d', strtotime($this->ngaySinhFull . ' + ' . $ngayDu . ' day'));
            $results['nam_bd_dai_van'] = $namBatDauDaiVan;
            $results['thang_bd_dai_van'] = $thangBatDauDaiVan;
            $results['tuoi_dv'] = $ngay1 + $daivan2;
            $results['ngay'] = $ngayDu;
        }

        return $results;
    }

    public function tinhCungMenhThaiNguyen() {
        $results = [];
        $tinhCungMenh = $this->tinhCungMenhCanChi($this->canNamSlug, $this->chiNamSlug, $this->chiThangSlug, $this->chiGioSlug);
        $results['cung_menh']['can'] = $tinhCungMenh['can'];
        $results['cung_menh']['chi'] = $tinhCungMenh['chi'];
        $results['cung_menh']['info'] = $this->cungMenhInfo[$this->khongdau($tinhCungMenh['chi'])];

        $tinhThaiNguyen = $this->tinhThaiNguyen($this->canThangSlug, $this->chiThangSlug);
        $results['thai_nguyen']['can'] = $tinhThaiNguyen['can'];
        $results['thai_nguyen']['chi'] = $tinhThaiNguyen['chi'];

        return $results;
    }

    public function tinhDaiVanTieuVan() {
        $daiVan = $this->tinhDaiVan();
        $arrayDaiVan = range($daiVan['nam_bd_dai_van'], $daiVan['nam_bd_dai_van'] + 80);

        $arrayCanUni = array_map(array($this, 'khongdau'), $this->can); // loai bo dau
        $arrayChiUni = array_map(array($this, 'khongdau'), $this->chi); // loai bo dau

        $indexCanDaivan = array_search($this->canThangSlug, $arrayCanUni);
        $indexCanDaivan = $indexCanDaivan == 10 ? 0 : $indexCanDaivan;

        $indexChiDaivan = array_search($this->chiThangSlug, $arrayChiUni);
        $indexChiDaivan = $indexChiDaivan == 12 ? 0 : $indexChiDaivan;

        if (($this->menhAmDuong == 1 && $this->sex == 1) || ($this->menhAmDuong == 0 && $this->sex == 0)) {
            $arrayCanNew = array_merge(array_slice($this->can, $indexCanDaivan, count($this->can)), array_slice($this->can, 0, $indexCanDaivan));
            $arrayChiNew = array_merge(array_slice($this->chi, $indexChiDaivan, count($this->chi)), array_slice($this->chi, 0, $indexChiDaivan));
        } else {
            $arrayCanNew = array_merge(array_reverse((array_slice($this->can, 0, $indexCanDaivan - 1))), array_reverse(array_slice($this->can, $indexCanDaivan - 1, count($this->can))));
            $arrayChiNew = array_merge(array_reverse(array_slice($this->chi, 0, $indexChiDaivan - 1)), array_reverse(array_slice($this->chi, $indexChiDaivan - 1, count($this->chi))));
        }

        $arrayDaiTieuVan = [];
        $i = 0;
        $canIndex = $chiIndex = '';
        $dvIndex = 0;
        foreach ($arrayDaiVan as $index => $dv) {
            if ($index != 0 && ($dv - $daiVan['nam_bd_dai_van']) % 10 == 0) {
                $dvIndex++;
            }
            $amLich = $this->tinhNamAm($this->ngayDuong, $this->thangDuong, $dv, true, 7);
            $arrayDaiTieuVan[$dvIndex]['nam'][$dv]['can'] = $amLich['can']['title'];
            $arrayDaiTieuVan[$dvIndex]['nam'][$dv]['chi'] = $amLich['chi']['title'];
            $arrayDaiTieuVan[$dvIndex]['nam'][$dv]['can_chi'] = $amLich['can']['title'] . ' ' . $amLich['chi']['title'];
            $arrayDaiTieuVan[$dvIndex]['nam'][$dv]['thapthan'] = isset($this->thapthan[$this->canNgaySlug][$amLich['can']['name']]) ? $this->thapthan[$this->canNgaySlug][$amLich['can']['name']] : '';
            if (($dv - $daiVan['nam_bd_dai_van']) % 10 == 0) {
                // nam dai van
                $arrayDaiTieuVan[$dvIndex]['daivan']['can'] = $arrayCanNew[$i];
                $arrayDaiTieuVan[$dvIndex]['daivan']['chi'] = $arrayChiNew[$i];
                $arrayDaiTieuVan[$dvIndex]['daivan']['tuoi'] = $index + $daiVan['tuoi_dv'];
                $arrayDaiTieuVan[$dvIndex]['daivan']['thapthan'] = isset($this->thapthan[$this->canNgaySlug][$this->khongdau($arrayCanNew[$i])]) ? $this->thapthan[$this->canNgaySlug][$this->khongdau($arrayCanNew[$i])] : '';
                $arrayDaiTieuVan[$dvIndex]['daivan']['can_chi'] = $arrayCanNew[$i] . ' ' . $arrayChiNew[$i];
                $arrayDaiTieuVan[$dvIndex]['daivan']['year'] = $dv;
                $i++;
            }
        }

        return $arrayDaiTieuVan;
    }

    // tính xem năm đó thuộc đại vận nào
    public function currentDaiVan($namXem) {
        $daiVan = $this->tinhDaiVan();
        $range = (floor(($namXem - $daiVan['nam_bd_dai_van']) / 10)) * 10;
        $arrayDaiVan = range($daiVan['nam_bd_dai_van'], $daiVan['nam_bd_dai_van'] + $range + 9);

        $arrayCanUni = array_map(array($this, 'khongdau'), $this->can); // loai bo dau
        $arrayChiUni = array_map(array($this, 'khongdau'), $this->chi); // loai bo dau

        $indexCanDaivan = array_search($this->canThangSlug, $arrayCanUni);
        $indexCanDaivan = $indexCanDaivan == 10 ? 0 : $indexCanDaivan;

        $indexChiDaivan = array_search($this->chiThangSlug, $arrayChiUni);
        $indexChiDaivan = $indexChiDaivan == 12 ? 0 : $indexChiDaivan;

        if (($this->menhAmDuong == 1 && $this->sex == 1) || ($this->menhAmDuong == 0 && $this->sex == 0)) {
            $arrayCanNew = array_merge(array_slice($this->can, $indexCanDaivan, count($this->can)), array_slice($this->can, 0, $indexCanDaivan));
            $arrayChiNew = array_merge(array_slice($this->chi, $indexChiDaivan, count($this->chi)), array_slice($this->chi, 0, $indexChiDaivan));
        } else {
            $arrayCanNew = array_merge(array_reverse((array_slice($this->can, 0, $indexCanDaivan - 1))), array_reverse(array_slice($this->can, $indexCanDaivan - 1, count($this->can))));
            $arrayChiNew = array_merge(array_reverse(array_slice($this->chi, 0, $indexChiDaivan - 1)), array_reverse(array_slice($this->chi, $indexChiDaivan - 1, count($this->chi))));
        }

        $i = 0;
        $dvIndex = 0;
        $arrayDaiTieuVan = [];
        foreach ($arrayDaiVan as $index => $dv) {
            if ($index != 0 && ($dv - $daiVan['nam_bd_dai_van']) % 10 == 0) {
                $dvIndex++;
            }
            if ($dv == $namXem) {
                $amLich = $this->tinhNamAm($this->ngayDuong, $this->thangDuong, $dv, true, 7);
                $arrayDaiTieuVan[$dvIndex]['nam']['can'] = $amLich['can']['title'];
                $arrayDaiTieuVan[$dvIndex]['nam']['chi'] = $amLich['chi']['title'];
                $arrayDaiTieuVan[$dvIndex]['nam']['ngu_hanh'] = $this->canAmDuong[$amLich['can']['name']];
                $arrayDaiTieuVan[$dvIndex]['nam']['can_chi'] = $amLich['can']['title'] . ' ' . $amLich['chi']['title'];
                $arrayDaiTieuVan[$dvIndex]['nam']['thapthan'] = isset($this->thapthan[$this->canNgaySlug][$amLich['can']['name']]) ? $this->thapthan[$this->canNgaySlug][$amLich['can']['name']] : '';
            }
            if (($dv - $daiVan['nam_bd_dai_van']) % 10 == 0) {
                $arrayDaiTieuVan[$dvIndex]['can'] = $arrayCanNew[$i];
                $arrayDaiTieuVan[$dvIndex]['chi'] = $arrayChiNew[$i];
                $arrayDaiTieuVan[$dvIndex]['ngu_hanh'] = $this->canAmDuong[$this->khongdau($arrayCanNew[$i])];
                $arrayDaiTieuVan[$dvIndex]['tuoi'] = $index + $daiVan['tuoi_dv'];
                $arrayDaiTieuVan[$dvIndex]['year'] = $dv;
                $arrayDaiTieuVan[$dvIndex]['thapthan'] = isset($this->thapthan[$this->canNgaySlug][$this->khongdau($arrayCanNew[$i])]) ? $this->thapthan[$this->canNgaySlug][$this->khongdau($arrayCanNew[$i])] : '';
                $i++;
            }
        }

        return $arrayDaiTieuVan;
    }

    public function tinhChuTinh() {
        return [
            'nam' => $this->thapthan[$this->canNgaySlug][$this->canNamSlug],
            'thang' => $this->thapthan[$this->canNgaySlug][$this->canThangSlug],
            'ngay' => $this->thapthan[$this->canNgaySlug][$this->canNgaySlug],
            'gio' => $this->thapthan[$this->canNgaySlug][$this->canGioSlug],
        ];
    }

    public function tinhCanTang() {
        return [
            'nam' => $this->canTang[$this->chiNamSlug],
            'thang' => $this->canTang[$this->chiThangSlug],
            'ngay' => $this->canTang[$this->chiNgaySlug],
            'gio' => $this->canTang[$this->chiGioSlug],
        ];
    }

    public function tinhCanTangThapThan($value) {
        $value = $this->khongdau($value);
        return isset($this->thapthan[$this->canNgaySlug][$value]) ? $this->thapthan[$this->canNgaySlug][$value] : '';
    }

    public function tinhCanTangVTS($value) {
        $value = $this->khongdau($value);
        return isset($this->vongTrangSinh[$value][$this->chiThangSlug]) ? $this->vongTrangSinh[$value][$this->chiThangSlug] : '';
    }

    public function tinhNhatKien() {
        return [
            'nam' => $this->vongTrangSinh[$this->canNgaySlug][$this->chiNamSlug],
            'thang' => $this->vongTrangSinh[$this->canNgaySlug][$this->chiThangSlug],
            'ngay' => $this->vongTrangSinh[$this->canNgaySlug][$this->chiNgaySlug],
            'gio' => $this->vongTrangSinh[$this->canNgaySlug][$this->chiGioSlug],
        ];
    }

    public function tinhNguyetKien() {
        return [
            'nam' => $this->vongTrangSinh[$this->canNamSlug][$this->chiThangSlug],
            'thang' => $this->vongTrangSinh[$this->canThangSlug][$this->chiThangSlug],
            'ngay' => $this->vongTrangSinh[$this->canNgaySlug][$this->chiThangSlug],
            'gio' => $this->vongTrangSinh[$this->canGioSlug][$this->chiThangSlug],
        ];
    }

    public function vongTrangSinhTru() {
        return [
            'nam' => $this->vongTrangSinh[$this->canNamSlug][$this->chiNamSlug],
            'thang' => $this->vongTrangSinh[$this->canThangSlug][$this->chiThangSlug],
            'ngay' => $this->vongTrangSinh[$this->canNgaySlug][$this->chiNgaySlug],
            'gio' => $this->vongTrangSinh[$this->canGioSlug][$this->chiGioSlug],
        ];
    }

    public function tinhBatTu() {
        $info = [
            'menh' => $this->namAmlich['chi']['menh'] . ' ' . $this->genderString,
            'nam' => [
                'can' => $this->namAmlich['can']['title'],
                'chi' => $this->namAmlich['chi']['title'],
            ],
            'thang' => [
                'can' => $this->canThangText,
                'chi' => $this->chiThangText
            ],
            'ngay' => [
                'can' => $this->can[$this->canNgayId],
                'chi' => $this->chi[$this->chiNgayId],
            ],
            'gio' => [
                'can' => $this->can[$this->canGio],
                'chi' => $this->chi[$this->chiGio],
            ]
        ];

        return $info;
    }

    public function setVariable() {

        $this->can = [1 => 'Giáp', 2 => 'Ất', 3 => 'Bính', 4 => 'Đinh', 5 => 'Mậu', 6 => 'Kỷ', 7 => 'Canh', 8 => 'Tân', 9 => 'Nhâm', 10 => 'Quý'];
        $this->chi = [1 => 'Tí', 2 => 'Sửu', 3 => 'Dần', 4 => 'Mão', 5 => 'Thìn', 6 => 'Tỵ', 7 => 'Ngọ', 8 => 'Mùi', 9 => 'Thân', 10 => 'Dậu', 11 => 'Tuất', 12 => 'Hợi'];

        $canArr = [
            [
                'name' => 'canh',
                'title' => 'Canh',
                'nguhanh' => 'Kim',
                'thanggieng' => 'Mậu',
                'luan_giai' => '<b>Luận theo Dương cách:</b> Gia chủ có tài về về văn học, khá cứng rắn, mạnh mẽ, kiên cường nhưng đôi lúc hay chống đối, tranh giành, hiếu thắng. Có tài làm kinh tế dễ phát tài vào những năm thuộc tài thần.',
                'uu_diem' => 'Bản thân khá mạnh mẽ, kiên cường',
                'khuyet_diem' => 'Đôi khi dễ hiếu thắng, bảo thủ'
            ],
            [
                'name' => 'tan',
                'title' => 'Tân',
                'nguhanh' => 'Kim',
                'thanggieng' => 'Canh',
                'luan_giai' => '<b>Luận theo Dương cách:</b> Bản thân luôn khắc phục mọi khó khăn để hoàn thành mọi việc, thông minh, trí tuệ, tinh tế, thanh lịch nhưng đôi lúc khá ngoan cố. Nhưng tài lộc sẽ phát khi biết và thấu hiểu về bản thân và thời vận.',
                'uu_diem' => 'Bản thân thông minh',
                'khuyet_diem' => 'Lúc thế suy dễ ngon cố, cố chấp'
            ],
            [
                'name' => 'nham',
                'title' => 'Nhâm',
                'nguhanh' => 'Thủy',
                'thanggieng' => 'Nhâm',
                'luan_giai' => '<b>Luận theo Dương cách:</b> Gia chủ có bản tính khoan dung, hào phóng, luôn thích đùm bọc và bao dung, nhưng đôi khi có chút ỷ lại hoặc chậm chạp, không lo lắng. Bản thân dễ phát tài vào những năm dụng thần và tài thần.',
                'uu_diem' => 'Bản Thân đôn hậu, tốt bụng',
                'khuyet_diem' => 'Khi vận thế xuống dễ chậm chạp, tới đâu thì tới'
            ],
            [
                'name' => 'quy',
                'title' => 'Quý',
                'nguhanh' => 'Thủy',
                'thanggieng' => 'Giáp',
                'luan_giai' => '<b>Luận theo Dương cách:</b> Tính cách khá chính trực, cần mẫn, dù gặp hoàn cảnh khó khăn cũng cố gắng vươn lên, có trí tuệ và chí tiến thủ, nếu biết nắm bắt thời vận ắt phất như diều gặp gió.',
                'uu_diem' => 'Bản thân cần kiệm liêm chính',
                'khuyet_diem' => 'Đôi khi khá vưởn vông, mơ mộng'
            ],
            [
                'name' => 'giap',
                'title' => 'Giáp',
                'nguhanh' => 'Mộc',
                'thanggieng' => 'Bính',
                'luan_giai' => '<b>Luận theo Dương cách:</b> Gia chủ có tính cách khá cương trực và ý thức kỷ luật. Nhưng những lúc khí vượng cao lại dễ có sự cố chấp. Nếu biết nắm bắt thời vận mọi sự sẽ như mong.',
                'uu_diem' => 'Bản thân chính trực',
                'khuyet_diem' => 'Đôi lúc dễ cố chấp'
            ],
            [
                'name' => 'at',
                'title' => 'Ất',
                'nguhanh' => 'Mộc',
                'thanggieng' => 'Mậu',
                'luan_giai' => '<b>Luận theo Dương cách:</b> Gia chủ có tính cách đôi khi hay mềm yếu, cẩn thận, nhưng cũng có lúc khá cố chấp nên dễ bỏ qua cơ hội. Nếu bản thân nắm bắt thời vận, điểm mạnh của bản thân thì sẽ phát tài.',
                'uu_diem' => 'Bản thân chu đáo, cẩn thận',
                'khuyet_diem' => 'Đôi khi dễ cố chấp bảo thủ'
            ],
            [
                'name' => 'binh',
                'title' => 'Bính',
                'nguhanh' => 'Hỏa',
                'thanggieng' => 'Canh',
                'luan_giai' => '<b>Luận theo Dương cách:</b> Gia chủ có tính cách nhiệt tình, hào phóng, cương trực nhưng đôi khi dễ nóng tính, nóng vội, dễ thô thẳng thật, hợp với những hoạt động xã giao, nhưng cũng dễ bị hiểu lầm là thích phóng đại, thích sự khen ninh. Khi gia chủ thấu hiểu được bản thân sẽ dễ phát tài vào những năm tài thần.',
                'uu_diem' => 'Tính cách nhiệt tình',
                'khuyet_diem' => 'Dễ hay nóng tính, vội'
            ],
            [
                'name' => 'dinh',
                'title' => 'Đinh',
                'nguhanh' => 'Hỏa',
                'thanggieng' => 'Nhâm',
                'luan_giai' => '<b>Luận theo Dương cách:</b> Gia chủ có tính cách dễ bên ngoài trầm tĩnh, bên trong sôi nổi, cẩn trọng, bí mật nhưng lại hay đa nghi và mưu tính nhiều nên sẽ tạo thành khuyết điểm. Nếu bản thân nắm bắt được thời vận kiểm soát được ưu khuyết điểm ắt vạn sự hanh thông.',
                'uu_diem' => 'Bản thân luôn cẩn trọng, mạnh mẽ',
                'khuyet_diem' => 'Đôi khi hay đa nghi, nóng tính'
            ],
            [
                'name' => 'mau',
                'title' => 'Mậu',
                'nguhanh' => 'Thổ',
                'thanggieng' => 'Giáp',
                'luan_giai' => '<b>Luận theo Dương cách:</b> Đôi lúc bản thân hơi coi trọng bề ngoài nhưng giỏi giao thiệp, có năng lực xã giao. Nhưng đôi lúc cũng dễ bị mất chính kiến mà thường hay chìm lẫn trong số đông. Bản thân biết nắm bắt thời vận, nghành nghề và làm ăn sẽ phát tài, đắc lộc.',
                'uu_diem' => 'Bản thân biết nhìn bao quát, giỏi ngoại giao',
                'khuyet_diem' => 'Lúc vận suy dễ nhu nhược'
            ],
            [
                'name' => 'ky',
                'title' => 'Kỷ',
                'nguhanh' => 'Thổ',
                'thanggieng' => 'Bính',
                'luan_giai' => '<b>Luận theo Dương cách:</b> Bản thân hay để ý tới chi tiết, cẩn thận, làm việc có trật tự đầu đuôi, nhưng có thể ít sự độ lượng. Khi bản thân biết nắm bắt thời vận, nghành nghề sẽ dễ phát tài lộc tiềm ẩn.',
                'uu_diem' => 'Bản thân khá cẩn thận',
                'khuyet_diem' => 'Đôi lúc dễ trì trệ, chấp vặt'
            ],
        ];
        $chiArr = [
            [
                'name' => 'than',
                'title' => 'Thân',
                'menh' => 'Dương',
                'nguhanh' => 'Kim',
                'luan_giai' => '<b>Luận theo Âm cách:</b> Bản thân có tính tò mò, tinh quái, khôn khéo, thông minh nhạy bén học hỏi nhanh, có sự hài hước biết giao tiếp, giỏi xoay sở nhưng đôi khi dễ cố chấp nên khó tiến thủ, hay đoán biết được ý nghĩ của người khác nên cũng khá đa nghi. Bản thân có sự quyến rũ và sức hút với đối phương, tính khá vui vẻ, tinh nghịch. Dễ thành công trong mọi lĩnh vực mà họ yêu thích và có hứng thú, nhưng hay có tư duy đến đâu thì đến nên đôi lúc cuộc sống vất vả. Hoài bão lớn nhưng nếu không thắng được bản thân thì khó phát triển.',
                'uu_diem' => 'khôn khéo',
                'khuyet_diem' => 'dễ cố chấp'
            ],
            [
                'name' => 'dau',
                'title' => 'Dậu',
                'menh' => 'Âm',
                'nguhanh' => 'Kim',
                'luan_giai' => '<b>Luận theo Âm cách:</b> Gia chủ biết đối nhân xử thế, hòa nhã, thân thiện. Biết tính trước tình sau, có thể sẳn sàng chịu thiệt để làm vui lòng hoặc được việc của mình, có đầu óc nhanh nhạy, linh hoạt nhưng dễ vì sự nóng vội, hấp tấp mà không thể làm tốt một việc lớn. Nhiều lúc dễ có sự tùy tiện, hỗn loạn, thích trang điểm, ăn diện.',
                'uu_diem' => 'nhanh nhậy, linh hoạt',
                'khuyet_diem' => 'hấp tấp'
            ],
            [
                'name' => 'tuat',
                'title' => 'Tuất',
                'menh' => 'Dương',
                'nguhanh' => 'Thổ',
                'luan_giai' => '<b>Luận theo Âm cách:</b> Bản thân chính trực, thành thật và thẳng thắn, giàu lòng chính nghĩa, trượng nghĩa, sống có sự công bằng, đôi khi dễ bốc đồng, tính ngay thẳng chân thành, rất hay thích bênh vực kẻ yếu, có sự đồng cảm có thể sẵn sàng chia sẻ nỗi buồn với họ, phong cách sống ai tốt tốt lại, còn ai phận ý, chơi xấu thì có thể bỏ luôn, sống có trách nhiệm, kiên trì, chính vì vậy gia chủ luôn đạt được thành tích tốt trong công việc.',
                'uu_diem' => 'thẳng thắn, trượng nghĩa',
                'khuyet_diem' => 'nóng tính'
            ],
            [
                'name' => 'hoi',
                'title' => 'Hợi',
                'menh' => 'Âm',
                'nguhanh' => 'Thủy',
                'luan_giai' => '<b>Luận theo Âm cách:</b> Bản tính khá trầm lặng, chắc chắn, kiên trì và cương nghị, dũng cảm có lòng dạ hiền lương, nhẫn nhịn, đôn hậu. Nhận lời là hết mình sẽ dốc toàn bộ sức lực để hoàn thành, khá chất phác nhưng ít màu mè, Tính tình họ ôn hòa, tha thứ không hại người mà còn thương và đồng cảm. Sống thẳng thắn và chân thành, không nhiều chuyện mô kích, không để bụng và tranh giành tới sống chết căng quá thì cho mọi người về nhất.',
                'uu_diem' => 'chắc chắn, kiên trì',
                'khuyet_diem' => 'dễ trì trệ, chậm chạp'
            ],
            [
                'name' => 'ti',
                'title' => 'Tí',
                'menh' => 'Dương',
                'nguhanh' => 'Thủy',
                'luan_giai' => '<b>Luận theo Âm cách:</b> Gia chủ có trí thông minh, duyên dáng và có sức hấp dẫn, luôn là người đứng đầu, tiên phong trong mọi hoạt động, thích sự trải nghiệm phiêu lưu mạo hiểm, quyền lực và tiền bạc. Sống khá sôi nổi, vui vẻ, lạc quan, dễ gần, dễ mến, giỏi giao thiệp, thích kết bạn, hội hè những nơi đông vui náo nhiệt.',
                'uu_diem' => 'luôn tích cực, mạnh dạn',
                'khuyet_diem' => 'dễ buông thả'
            ],
            [
                'name' => 'suu',
                'title' => 'Sửu',
                'menh' => 'Âm',
                'nguhanh' => 'Thổ',
                'luan_giai' => '<b>Luận theo Âm cách:</b> Gia chủ tính cách mạnh mẽ và nổi trội, có sự kiên gan, bền bỉ, trung thực, thẳng thắn nhưng đôi khi hơi cố chấp nhưng sức chịu đựng cao, ý chí vững vàng nói là làm, có tài lãnh đạo, biết nhìn xa trông rộng sống thực tế, không viển vông. Gia chủ thích sống khép kín, quyết đoán, dứt khoát không dễ dàng bị cám dỗ, thích tự do.',
                'uu_diem' => 'trung thực',
                'khuyet_diem' => 'ích kỷ'
            ],
            [
                'name' => 'dan',
                'title' => 'Dần',
                'menh' => 'Dương',
                'nguhanh' => 'Mộc',
                'luan_giai' => '<b>Luận theo Âm cách:</b> Gia chủ có lòng nhân ái, dũng cảm, mạnh mẽ, thẳng thắng, trung thực, công bằng có thể đứng ra bảo vệ kẻ yếu, thích độc lập, khá liều lĩnh, mạo hiểm, luôn cởi mở và chân thành với bạn bè. Có trí sáng tạo, ý tưởng phong phú, quyết đoán không sợ khó khăn, nhưng đôi khi dễ khoe khoang.',
                'uu_diem' => 'công tâm',
                'khuyet_diem' => 'khoe khoang'
            ],
            [
                'name' => 'mao',
                'title' => 'Mão',
                'menh' => 'Âm',
                'nguhanh' => 'Mộc',
                'luan_giai' => '<b>Luận theo Âm cách:</b> Với tâm tính chân thành, tốt bụng, dịu dàng, ghét bạo lực, tinh tế, có con mẳt thẩm mỹ, có sự nhân ái thich giúp người nên đôi khi dễ bị lợi dụng, thích an phận hơn là bon chen tranh đấu thị phi, ăn nói lưu loát, có tài, có lòng tự trọng biết khiêm nhường, biết giữ gìn ý tứ, có đức hạnh, khi gặp sự cố giữ được bình tĩnh, mát tính. Bản thân có ý chí mạnh mẽ nên có thể làm kinh doanh, biết yêu gia đình. Nhưng hay bị phụ thuộc.',
                'uu_diem' => 'chân thành',
                'khuyet_diem' => 'dễ bị lợi dụng'
            ],
            [
                'name' => 'thin',
                'title' => 'Thìn',
                'menh' => 'Dương',
                'nguhanh' => 'Thổ',
                'luan_giai' => '<b>Luận theo Âm cách:</b> Gia chủ có tham vọng lớn và muốn thống trị nắm quyền cao, có sức quyến rũ, khoan dung đại lượng và tỏa sáng, có tính thương người. Bản thân vận vượng luôn tràn trề sinh lực và sức khỏe dồi dào nên khi gặp thời sẽ lên làm sếp nhưng chú ý nhược điểm, nóng vội làm xong mới nghĩ nên dễ nợ lần lao lý. Lúc vận thế suy dễ có tính kiêu ngạo, thanh cao, thẳng thắn nên đôi lúc hơi thiệt thòi, bản tính khó khăn không chịu khuất phục, công việc chưa xong khó chịu làm bằng được nên trong cuộc sống có nhiều thành quả.',
                'uu_diem' => 'có trí',
                'khuyet_diem' => 'kiêu ngạo'
            ],
            [
                'name' => 'ty',
                'title' => 'Tỵ',
                'menh' => 'Âm',
                'nguhanh' => 'Hỏa',
                'luan_giai' => '<b>Luận theo Âm cách:</b> Bản thân khá khôn ngoan, có tính kiên nhẫn, có sự quan sát và bao quát, phán đoán đúng đắn tìm sự rõ ràng, kín đáo, bình tĩnh biết chờ đợi và sống nội tâm chỉ có tri kỷ mới sẻ chia mở lòng. Khi vận vượng dễ bốc đồng, bảo thủ, bí ẩn tinh tế luôn cẩn trọng, tìm cách gánh vác mọi chuyện ổn thỏa mói thôi. Lý luận như nhà triết học, tư duy sâu sắc, nho nhã, lịch sự, rất thích đọc sách nghe nhạc, nợ ai là nóng lòng trả bằng hết. Sống nhiệt tình, chăm chỉ lại rất đa nghi dù bề ngoài luôn tỏ vẻ tin tưởng tuyệt đối.',
                'uu_diem' => 'kiên cường',
                'khuyet_diem' => 'bốc đồng'
            ],
            [
                'name' => 'ngo',
                'title' => 'Ngọ',
                'menh' => 'Dương',
                'nguhanh' => 'Hỏa',
                'luan_giai' => '<b>Luận theo Âm cách:</b> Bản thân thich sự đổi mới, ham hoạt động, thích độc lập, đôi khi hay cả thèm chóng chán, số khá đào hao, nhiều khi chuyện tình duyên như gió cuốn mây trôi, Tính rộng rãi, hào phóng, giỏi đối đáp, ngoại giao, có sự quan sát tốt, đầu óc nhanh nhẹn, cởi mở, dí dỏm, thích tự do đi đây đi đó, không chịu sự ràng buộc vào bất cứ cái gì, thích làm việc theo sở thích, đôi khi khá nóng nảy, nhưng không để bụng. Có thể làm nhiều việc 1 lúc, tâm lý.',
                'uu_diem' => 'đầu óc nhanh nhẹn',
                'khuyet_diem' => 'cả thèm chóng chán'
            ],
            [
                'name' => 'mui',
                'title' => 'Mùi',
                'menh' => 'Âm',
                'nguhanh' => 'Thổ',
                'luan_giai' => '<b>Luận theo Âm cách:</b> Bản thân luôn vui cười nhưng cũng khá nội tâm hay nghĩ nhiều thích sự khép kín, sống chân thực, thân thiệt hòa đồng, cảm thông. hiền lành, dễ xấu hổ, bẽn lẽn. Có con mắt nghệ thuật, sáng tạo, lúc không được việc bi quan, chán nản, buồn bã. Điệu đà nghệ sĩ, có mắt thẩm mỹ, văn hoa phong phú. Hay thích chống đối, không thích bị ép buộc, suy nghĩ sâu sắc, tốt bụng hay giúp đỡ và quan tâm đến người khác. Khá chu đáo, không muốn tổn thương bất kỳ ai và muốn giữ hòa khí.',
                'uu_diem' => 'hiền lành, sáng tạo',
                'khuyet_diem' => 'hay bi quan'
            ],
        ];

        $this->canArr = $canArr;
        $this->chiArr = $chiArr;

        $this->chiThang = [1 => 'Dần', 2 => 'Mão', 3 => 'thìn', 4 => 'tị', 5 => 'ngọ', 6 => 'mùi', 7 => 'thân', 8 => 'dậu', 9 => 'tuất', 10 => 'hợi', 11 => 'tý', 12 => 'sửu'];

        $this->arrayMonths['giap'] = $this->arrayMonths['ky'] = [// giáp, kỷ
            1 => 'Bính dần',
            2 => 'Đinh mão',
            3 => 'Mậu thìn',
            4 => 'Kỷ tị',
            5 => 'Canh ngọ',
            6 => 'Tân mùi',
            7 => 'Nhâm thân',
            8 => 'Quý dậu',
            9 => 'Giáp tuất',
            10 => 'Ất hợi',
            11 => 'Bính tí',
            12 => 'Đinh sửu'
        ];
        $this->arrayMonths['at'] = $this->arrayMonths['canh'] = [// ất canh
            1 => 'Mậu dần',
            2 => 'Kỷ mão',
            3 => 'Canh thìn',
            4 => 'Tân tị',
            5 => 'Nhâm ngọ',
            6 => 'Quý mùi',
            7 => 'Giáp thân',
            8 => 'Ất dậu',
            9 => 'Bính tuất',
            10 => 'Đinh hợi',
            11 => 'Mậu tí',
            12 => 'Kỷ sửu'
        ];
        $this->arrayMonths['binh'] = $this->arrayMonths['tan'] = [// Bính tân
            1 => 'Canh dần',
            2 => 'Tân mão',
            3 => 'Nhâm thìn',
            4 => 'Quý tị',
            5 => 'Giáp ngọ',
            6 => 'Ất mùi',
            7 => 'Bính thân',
            8 => 'Đinh dậu',
            9 => 'Mậu tuất',
            10 => 'Kỷ hợi',
            11 => 'Canh tí',
            12 => 'Tân sửu'
        ];
        $this->arrayMonths['dinh'] = $this->arrayMonths['nham'] = [// Đinh nhâm
            1 => 'Nhâm dần',
            2 => 'Quý mão',
            3 => 'Giáp thìn',
            4 => 'Ất tị',
            5 => 'Bính ngọ',
            6 => 'Đinh mùi',
            7 => 'Mậu thân',
            8 => 'Kỷ dậu',
            9 => 'Canh tuất',
            10 => 'Tân hợi',
            11 => 'Nhâm tí',
            12 => 'Quý sửu'
        ];
        $this->arrayMonths['mau'] = $this->arrayMonths['quy'] = [// Mậu Quý
            1 => 'Giáp dần',
            2 => 'Ất mão',
            3 => 'Bính thìn',
            4 => 'Đinh tị',
            5 => 'Mậu ngọ',
            6 => 'Kỷ mùi',
            7 => 'Canh thân',
            8 => 'Tân dậu',
            9 => 'Nhâm tuất',
            10 => 'Quý hợi',
            11 => 'Giáp tí',
            12 => 'Ất sửu'
        ];

        $this->giosinhArr = [
            1 => [
                'name' => 'Tý',
                'gio' => '23-1h'
            ],
            2 => [
                'name' => 'Sửu',
                'gio' => '1-3h'
            ],
            3 => [
                'name' => 'Dần',
                'gio' => '3-5h'
            ],
            4 => [
                'name' => 'Mão',
                'gio' => '5-7h'
            ],
            5 => [
                'name' => 'Thìn',
                'gio' => '7-9h'
            ],
            6 => [
                'name' => 'Tỵ',
                'gio' => '9-11h'
            ],
            7 => [
                'name' => 'Ngọ',
                'gio' => '11-13h'
            ],
            8 => [
                'name' => 'Mùi',
                'gio' => '13-15h'
            ],
            9 => [
                'name' => 'Thân',
                'gio' => '15-17h'
            ],
            10 => [
                'name' => 'Dậu',
                'gio' => '17-19h'
            ],
            11 => [
                'name' => 'Tuất',
                'gio' => '19-21h'
            ],
            12 => [
                'name' => 'Hợi',
                'gio' => '21-23h'
            ],
        ];

        $this->vongTrangSinh = [
            'giap' => [
                'hoi' => 'Trường sinh',
                'ti' => 'Mộc dục',
                'suu' => 'Quan đới',
                'dan' => 'Lâm quan',
                'mao' => 'Đế vượng',
                'thin' => 'Suy',
                'ty' => 'Bệnh',
                'ngo' => 'Tử',
                'mui' => 'Mộ',
                'than' => 'Tuyệt',
                'dau' => 'Thai',
                'tuat' => 'Dưỡng'
            ],
            'at' => [
                'ngo' => 'Trường sinh',
                'ty' => 'Mộc dục',
                'thin' => 'Quan đới',
                'mao' => 'Lâm quan',
                'dan' => 'Đế vượng',
                'suu' => 'Suy',
                'ti' => 'Bệnh',
                'hoi' => 'Tử',
                'tuat' => 'Mộ',
                'dau' => 'Tuyệt',
                'than' => 'Thai',
                'mui' => 'Dưỡng'
            ],
            'binh' => [
                'dan' => 'Trường sinh',
                'mao' => 'Mộc dục',
                'thin' => 'Quan đới',
                'ty' => 'Lâm quan',
                'ngo' => 'Đế vượng',
                'mui' => 'Suy',
                'than' => 'Bệnh',
                'dau' => 'Tử',
                'tuat' => 'Mộ',
                'hoi' => 'Tuyệt',
                'ti' => 'Thai',
                'suu' => 'Dưỡng'
            ],
            'dinh' => [
                'dau' => 'Trường sinh',
                'than' => 'Mộc dục',
                'mui' => 'Quan đới',
                'ngo' => 'Lâm quan',
                'ty' => 'Đế vượng',
                'thin' => 'Suy',
                'mao' => 'Bệnh',
                'dan' => 'Tử',
                'suu' => 'Mộ',
                'ti' => 'Tuyệt',
                'hoi' => 'Thai',
                'tuat' => 'Dưỡng'
            ],
            'mau' => [
                'dan' => 'Trường sinh',
                'mao' => 'Mộc dục',
                'thin' => 'Quan đới',
                'ty' => 'Lâm quan',
                'ngo' => 'Đế vượng',
                'mui' => 'Suy',
                'than' => 'Bệnh',
                'dau' => 'Tử',
                'tuat' => 'Mộ',
                'hoi' => 'Tuyệt',
                'ti' => 'Thai',
                'suu' => 'Dưỡng'
            ],
            'ky' => [
                'dau' => 'Trường sinh',
                'than' => 'Mộc dục',
                'mui' => 'Quan đới',
                'ngo' => 'Lâm quan',
                'ty' => 'Đế vượng',
                'thin' => 'Suy',
                'mao' => 'Bệnh',
                'dan' => 'Tử',
                'suu' => 'Mộ',
                'ti' => 'Tuyệt',
                'hoi' => 'Thai',
                'tuat' => 'Dưỡng'
            ],
            'canh' => [
                'ty' => 'Trường sinh',
                'ngo' => 'Mộc dục',
                'mui' => 'Quan đới',
                'than' => 'Lâm quan',
                'dau' => 'Đế vượng',
                'tuat' => 'Suy',
                'hoi' => 'Bệnh',
                'ti' => 'Tử',
                'suu' => 'Mộ',
                'dan' => 'Tuyệt',
                'mao' => 'Thai',
                'thin' => 'Dưỡng'
            ],
            'tan' => [
                'ti' => 'Trường sinh',
                'hoi' => 'Mộc dục',
                'tuat' => 'Quan đới',
                'dau' => 'Lâm quan',
                'than' => 'Đế vượng',
                'mui' => 'Suy',
                'ngo' => 'Bệnh',
                'ty' => 'Tử',
                'thin' => 'Mộ',
                'mao' => 'Tuyệt',
                'dan' => 'Thai',
                'suu' => 'Dưỡng'
            ],
            'nham' => [
                'than' => 'Trường sinh',
                'dau' => 'Mộc dục',
                'tuat' => 'Quan đới',
                'hoi' => 'Lâm quan',
                'ti' => 'Đế vượng',
                'suu' => 'Suy',
                'dan' => 'Bệnh',
                'mao' => 'Tử',
                'thin' => 'Mộ',
                'ty' => 'Tuyệt',
                'ngo' => 'Thai',
                'mui' => 'Dưỡng'
            ],
            'quy' => [
                'mao' => 'Trường sinh',
                'dan' => 'Mộc dục',
                'suu' => 'Quan đới',
                'ti' => 'Lâm quan',
                'hoi' => 'Đế vượng',
                'tuat' => 'Suy',
                'dau' => 'Bệnh',
                'than' => 'Tử',
                'mui' => 'Mộ',
                'ngo' => 'Tuyệt',
                'ty' => 'Thai',
                'thin' => 'Dưỡng'
            ],
        ];

        $this->canTang = [
            'ti' => ['Quý'],
            'suu' => ['Kỷ', 'Quý', 'Tân'],
            'dan' => ['Giáp', 'Bính', 'Mậu'],
            'mao' => ['Ất'],
            'thin' => ['Mậu', 'Ất', 'Quý'],
            'ty' => ['Bính', 'Canh', 'Mậu'],
            'ngo' => ['Đinh', 'Kỷ'],
            'mui' => ['Kỷ', 'Đinh', 'Ất'],
            'than' => ['Canh', 'Nhâm', 'Mậu'],
            'dau' => ['Tân'],
            'tuat' => ['Mậu', 'Tân', 'Đinh'],
            'hoi' => ['Nhâm', 'Giáp'],
        ];

        $this->thapthan = [
            'giap' => [ // +
                'giap' => 'Tỷ',
                'at' => 'Kiếp',
                'binh' => 'Thực',
                'dinh' => 'Thương',
                'mau' => 'T.Tài',
                'ky' => 'C.Tài',
                'canh' => 'Sát',
                'tan' => 'Quan',
                'nham' => 'Kiêu',
                'quy' => 'Ấn'
            ],
            'at' => [
                'giap' => 'Kiếp',
                'at' => 'Tỷ',
                'binh' => 'Thương',
                'dinh' => 'Thực',
                'mau' => 'C.Tài',
                'ky' => 'T.Tài',
                'canh' => 'Quan',
                'tan' => 'Sát',
                'nham' => 'Ấn',
                'quy' => 'Kiêu'
            ],
            'binh' => [
                'giap' => 'Kiêu',
                'at' => 'Ấn',
                'binh' => 'Tỷ',
                'dinh' => 'Kiếp',
                'mau' => 'Thực',
                'ky' => 'Thương',
                'canh' => 'T.Tài',
                'tan' => 'C.Tài',
                'nham' => 'Sát',
                'quy' => 'Quan'
            ],
            'dinh' => [
                'giap' => 'Ấn',
                'at' => 'Kiêu',
                'binh' => 'Kiếp',
                'dinh' => 'Tỷ',
                'mau' => 'Thương',
                'ky' => 'Thực',
                'canh' => 'C.Tài',
                'tan' => 'T.Tài',
                'nham' => 'Quan',
                'quy' => 'Sát'
            ],
            'mau' => [
                'giap' => 'Sát',
                'at' => 'Quan',
                'binh' => 'Kiêu',
                'dinh' => 'Ấn',
                'mau' => 'Tỷ',
                'ky' => 'Kiếp',
                'canh' => 'Thực',
                'tan' => 'Thương',
                'nham' => 'T.Tài',
                'quy' => 'C.Tài'
            ],
            'ky' => [
                'giap' => 'Quan',
                'at' => 'Sát',
                'binh' => 'Ấn',
                'dinh' => 'Kiêu',
                'mau' => 'Kiếp',
                'ky' => 'Tỷ',
                'canh' => 'Thương',
                'tan' => 'Thực',
                'nham' => 'C.Tài',
                'quy' => 'T.Tài'
            ],
            'canh' => [
                'giap' => 'T.Tài',
                'at' => 'C.Tài',
                'binh' => 'Sát',
                'dinh' => 'Quan',
                'mau' => 'Kiêu',
                'ky' => 'Ấn',
                'canh' => 'Tỷ',
                'tan' => 'Kiếp',
                'nham' => 'Thực',
                'quy' => 'Thương'
            ],
            'tan' => [
                'giap' => 'C.Tài',
                'at' => 'T.Tài',
                'binh' => 'Quan',
                'dinh' => 'Sát',
                'mau' => 'Ấn',
                'ky' => 'Kiêu',
                'canh' => 'Kiếp',
                'tan' => 'Tỷ',
                'nham' => 'Thương',
                'quy' => 'Thực'
            ],
            'nham' => [
                'giap' => 'Thực',
                'at' => 'Thương',
                'binh' => 'T.Tài',
                'dinh' => 'C.Tài',
                'mau' => 'Sát',
                'ky' => 'Quan',
                'canh' => 'Kiêu',
                'tan' => 'Ấn',
                'nham' => 'Tỷ',
                'quy' => 'Kiếp'
            ],
            'quy' => [
                'giap' => 'Thương',
                'at' => 'Thực',
                'binh' => 'C.Tài',
                'dinh' => 'T.Tài',
                'mau' => 'Quan',
                'ky' => 'Sát',
                'canh' => 'Ấn',
                'tan' => 'Kiêu',
                'nham' => 'Kiếp',
                'quy' => 'Tỷ'
            ],
        ];

        $this->namInfoAl = [
            'giapti' => [
                'name' => 'Giáp Tí',
                'menh' => 'Hải Trung Kim',
                'menh_vn' => 'Kim Đáy Biển',
                'ngu_hanh' => 'kim',
            ],
            'atsuu' => [
                'name' => 'Ất Sửu',
                'menh' => 'Hải Trung Kim',
                'menh_vn' => 'Kim Đáy Biển',
                'ngu_hanh' => 'kim'
            ],
            'binhdan' => [
                'name' => 'Bính Dần',
                'menh' => 'Lư Trung Hỏa',
                'menh_vn' => 'Lửa Trong Lò',
                'ngu_hanh' => 'hoa'
            ],
            'dinhmao' => [
                'name' => 'Đinh Mão',
                'menh' => 'Lư Trung Hỏa',
                'menh_vn' => 'Lửa Trong Lò',
                'ngu_hanh' => 'hoa'
            ],
            'mauthin' => [
                'name' => 'Mậu Thìn',
                'menh' => 'Đại Lâm Mộc',
                'menh_vn' => 'Cây Rừng Rậm',
                'ngu_hanh' => 'moc'
            ],
            'kyty' => [
                'name' => 'Kỷ Tỵ',
                'menh' => 'Đại lâm mộc',
                'menh_vn' => 'Cây gỗ lớn',
                'ngu_hanh' => 'moc'
            ],
            'canhngo' => [
                'name' => 'Canh Ngọ',
                'menh' => 'Lộ bàng thổ',
                'menh_vn' => 'Đất bên đường',
                'ngu_hanh' => 'tho'
            ],
            'tanmui' => [
                'name' => 'Tân mùi',
                'menh' => 'Lộ bàng thổ',
                'menh_vn' => 'Đất bên đường',
                'ngu_hanh' => 'tho'
            ],
            'nhamthan' => [
                'name' => 'Nhâm thân',
                'menh' => 'Kiếm phong kim',
                'menh_vn' => 'Kim mũi kiếm',
                'ngu_hanh' => 'kim'
            ],
            'quydau' => [
                'name' => 'quý dậu',
                'menh' => 'Kiếm phong kim',
                'menh_vn' => 'Kim mũi kiếm',
                'ngu_hanh' => 'kim'
            ],
            'giaptuat' => [
                'name' => 'giáp tuất',
                'menh' => 'Sơn đầu hỏa',
                'menh_vn' => 'Lửa đầu núi',
                'ngu_hanh' => 'hoa'
            ],
            'athoi' => [
                'name' => 'ất hợi',
                'menh' => 'Sơn đầu hỏa',
                'menh_vn' => 'Lửa đầu núi',
                'ngu_hanh' => 'hoa'
            ],
            'binhti' => [
                'name' => 'Bính tí',
                'menh' => 'Giản hạ thủy',
                'menh_vn' => 'Nước dưới khe',
                'ngu_hanh' => 'thuy'
            ],
            'dinhsuu' => [
                'name' => 'Bính tí',
                'menh' => 'Giản hạ thủy',
                'menh_vn' => 'Nước dưới khe',
                'ngu_hanh' => 'thuy'
            ],
            'maudan' => [
                'name' => 'Mậu dần',
                'menh' => 'Thành đầu thổ',
                'menh_vn' => 'Đất trên thành',
                'ngu_hanh' => 'tho'
            ],
            'kymao' => [
                'name' => 'Kỷ mão',
                'menh' => 'Thành đầu thổ',
                'menh_vn' => 'Đất trên thành',
                'ngu_hanh' => 'tho'
            ],
            'canhthin' => [
                'name' => 'Canh thìn',
                'menh' => 'Bạch lạp kim',
                'menh_vn' => 'Kim bạch lạp',
                'ngu_hanh' => 'kim'
            ],
            'tanty' => [
                'name' => 'Tân tỵ',
                'menh' => 'Bạch lạp kim',
                'menh_vn' => 'Kim bạch lạp',
                'ngu_hanh' => 'kim'
            ],
            'nhamngo' => [
                'name' => 'Nhâm ngọ',
                'menh' => 'Dương liễu mộc',
                'menh_vn' => 'Cây dương liễu',
                'ngu_hanh' => 'moc'
            ],
            'quymui' => [
                'name' => 'Quý mùi',
                'menh' => 'Dương liễu mộc',
                'menh_vn' => 'Cây dương liễu',
                'ngu_hanh' => 'moc'
            ],
            'giapthan' => [
                'name' => 'Giáp thân',
                'menh' => 'Tuyền trung thủy',
                'menh_vn' => 'Nước trong suối',
                'ngu_hanh' => 'thuy'
            ],
            'atdau' => [
                'name' => 'Ất dậu',
                'menh' => 'Tuyền trung thủy',
                'menh_vn' => 'Nước trong suối',
                'ngu_hanh' => 'thuy'
            ],
            'binhtuat' => [
                'name' => 'Bính tuất',
                'menh' => 'Ốc thượng thổ',
                'menh_vn' => 'Trên đất nhà',
                'ngu_hanh' => 'tho'
            ],
            'dinhhoi' => [
                'name' => 'Đinh hợi',
                'menh' => 'Ốc thượng thổ',
                'menh_vn' => 'Trên đất nhà',
                'ngu_hanh' => 'tho'
            ],
            'mauti' => [
                'name' => 'Mậu tí',
                'menh' => 'Tích lịch hỏa',
                'menh_vn' => 'Lửa sấm sét',
                'ngu_hanh' => 'hoa'
            ],
            'kysuu' => [
                'name' => 'Kỷ sửu',
                'menh' => 'Tích lịch hỏa',
                'menh_vn' => 'Lửa sấm sét',
                'ngu_hanh' => 'hoa'
            ],
            'canhdan' => [
                'name' => 'canh dần',
                'menh' => 'Tùng bách mộc',
                'menh_vn' => 'Cây tùng bách',
                'ngu_hanh' => 'moc'
            ],
            'tanmao' => [
                'name' => 'Tân mão',
                'menh' => 'Tùng bách mộc',
                'menh_vn' => 'Cây tùng bách',
                'ngu_hanh' => 'moc'
            ],
            'nhamthin' => [
                'name' => 'Nhâm thìn',
                'menh' => 'Trường lưu thủy',
                'menh_vn' => 'Nước chảy dài',
                'ngu_hanh' => 'thuy'
            ],
            'quyty' => [
                'name' => 'Quý tỵ',
                'menh' => 'Trường lưu thủy',
                'menh_vn' => 'Nước chảy dài',
                'ngu_hanh' => 'thuy'
            ],
            'giapngo' => [
                'name' => 'Giáp ngọ',
                'menh' => 'Sa trung kim',
                'menh_vn' => 'Kim trong cát',
                'ngu_hanh' => 'kim'
            ],
            'atmui' => [
                'name' => 'Ất mùi',
                'menh' => 'Sa trung kim',
                'menh_vn' => 'Kim trong cát',
                'ngu_hanh' => 'kim'
            ],
            'binhthan' => [
                'name' => 'Bính thân',
                'menh' => 'Sơn hạ hỏa',
                'menh_vn' => 'Lửa dưới núi',
                'ngu_hanh' => 'hoa'
            ],
            'dinhdau' => [
                'name' => 'Đinh dậu',
                'menh' => 'Sơn hạ hỏa',
                'menh_vn' => 'Lửa dưới núi',
                'ngu_hanh' => 'hoa'
            ],
            'mautuat' => [
                'name' => 'Mậu tuất',
                'menh' => 'Bình địa mộc',
                'menh_vn' => 'Cây đồng bằng',
                'ngu_hanh' => 'moc'
            ],
            'kyhoi' => [
                'name' => 'Kỷ hợi',
                'menh' => 'Bình địa mộc',
                'menh_vn' => 'Cây đồng bằng',
                'ngu_hanh' => 'moc'
            ],
            'canhti' => [
                'name' => 'Canh tí',
                'menh' => 'Bích thượng thổ',
                'menh_vn' => 'Đất trên vách',
                'ngu_hanh' => 'tho'
            ],
            'tansuu' => [
                'name' => 'Tân sửu',
                'menh' => 'Bích thượng thổ',
                'menh_vn' => 'Đất trên vách',
                'ngu_hanh' => 'tho'
            ],
            'nhamdan' => [
                'name' => 'Nhâm dần',
                'menh' => 'Kim bạc kim',
                'menh_vn' => 'Kim dát vàng',
                'ngu_hanh' => 'kim'
            ],
            'quymao' => [
                'name' => 'Quý mão',
                'menh' => 'Kim bạc kim',
                'menh_vn' => 'Kim dát vàng',
                'ngu_hanh' => 'kim'
            ],
            'giapthin' => [
                'name' => 'Giáp thìn',
                'menh' => 'Phúc đăng hỏa',
                'menh_vn' => 'Lửa đèn chụp',
                'ngu_hanh' => 'hoa'
            ],
            'atty' => [
                'name' => 'Ất tỵ',
                'menh' => 'Phúc đăng hỏa',
                'menh_vn' => 'Lửa đèn chụp',
                'ngu_hanh' => 'hoa'
            ],
            'binhngo' => [
                'name' => 'Bính ngọ',
                'menh' => 'Thiên hà thủy',
                'menh_vn' => 'Nước sông ngân',
                'ngu_hanh' => 'thuy'
            ],
            'dinhmui' => [
                'name' => 'Đinh mùi',
                'menh' => 'Thiên hà thủy',
                'menh_vn' => 'Nước sông ngân',
                'ngu_hanh' => 'thuy'
            ],
            'mauthan' => [
                'name' => 'Mậu thân',
                'menh' => 'Đại dịch thổ',
                'menh_vn' => 'Đất nhà lớn',
                'ngu_hanh' => 'tho'
            ],
            'kydau' => [
                'name' => 'Kỷ dậu',
                'menh' => 'Đại dịch thổ',
                'menh_vn' => 'Đất nhà lớn',
                'ngu_hanh' => 'tho'
            ],
            'canhtuat' => [
                'name' => 'Canh tuất',
                'menh' => 'Thoa xuyến kim',
                'menh_vn' => 'Kim trâm vòng',
                'ngu_hanh' => 'kim'
            ],
            'tanhoi' => [
                'name' => 'Kỷ dậu',
                'menh' => 'Thoa xuyến kim',
                'menh_vn' => 'Kim trâm vòng',
                'ngu_hanh' => 'kim'
            ],
            'nhamti' => [
                'name' => 'Nhâm tí',
                'menh' => 'Tang giá mộc',
                'menh_vn' => 'cây dâu đay',
                'ngu_hanh' => 'moc'
            ],
            'quysuu' => [
                'name' => 'Quý sửu',
                'menh' => 'Tang giá mộc',
                'menh_vn' => 'cây dâu đay',
                'ngu_hanh' => 'moc'
            ],
            'giapdan' => [
                'name' => 'Giáp dần',
                'menh' => 'đại khê thủy',
                'menh_vn' => 'Nước suối lớn',
                'ngu_hanh' => 'thuy'
            ],
            'atmao' => [
                'name' => 'Ất mão',
                'menh' => 'đại khê thủy',
                'menh_vn' => 'Nước suối lớn',
                'ngu_hanh' => 'thuy'
            ],
            'binhthin' => [
                'name' => 'Bính thìn',
                'menh' => 'Sa trung thổ',
                'menh_vn' => 'Đất trong cát',
                'ngu_hanh' => 'tho'
            ],
            'dinhty' => [
                'name' => 'Đinh tỵ',
                'menh' => 'Sa trung thổ',
                'menh_vn' => 'Đất trong cát',
                'ngu_hanh' => 'tho'
            ],
            'maungo' => [
                'name' => 'Mậu ngọ',
                'menh' => 'thiên thượng hỏa',
                'menh_vn' => 'lửa trên trời',
                'ngu_hanh' => 'hoa'
            ],
            'kymui' => [
                'name' => 'Kỷ mùi',
                'menh' => 'thiên thượng hỏa',
                'menh_vn' => 'lửa trên trời',
                'ngu_hanh' => 'hoa'
            ],
            'canhthan' => [
                'name' => 'canh thân',
                'menh' => 'thạch lựu mộc',
                'menh_vn' => 'cây lựu đá',
                'ngu_hanh' => 'moc'
            ],
            'tandau' => [
                'name' => 'tân dậu',
                'menh' => 'thạch lựu mộc',
                'menh_vn' => 'cây lựu đá',
                'ngu_hanh' => 'moc'
            ],
            'nhamtuat' => [
                'name' => 'Nhâm tuất',
                'menh' => 'đại hải thủy',
                'menh_vn' => 'nước biển lớn',
                'ngu_hanh' => 'thuy'
            ],
            'quyhoi' => [
                'name' => 'Quý hợi',
                'menh' => 'đại hải thủy',
                'menh_vn' => 'nước biển lớn',
                'ngu_hanh' => 'thuy'
            ],
        ];


        $this->saoDepArr = ['thien-at', 'van-xuong', 'loc-than', 'hoc-duong', 'giap-loc', 'kim-du', 'hoc-sy', 'am-loc', 'phi-nhan', 'duong-nhan', 'tuong-tinh', 'hoa-cai', 'dich-ma', 'thien-duc', 'nguyet-duc', 'tu-quy-nhan', 'quoc-an', 'duc-quy-nhan', 'thien-at'];

        $this->saoArr = [
            'giap' => [
                'suu' => ['Thiên ất', 'Giáp lộc'],
                'mui' => ['Thiên ất'],
                'ty' => ['Văn xương'],
                'dan' => ['Lộc thần'],
                'hoi' => ['Học đường', 'Ấm lộc'],
                'mao' => ['Giáp lộc', 'Dương nhẫn', 'Kình dương'],
                'thin' => ['Kim dư'],
                'ti' => ['Học sỹ'],
                //'than'	=> ['Hồng diễm'],
                'ngo' => ['Hồng diễm'],
                'dau' => ['Phi nhân'],
            ],
            'at' => [
                'ti' => ['Thiên ất', 'Giáp lộc'],
                'than' => ['Thiên ất', 'Giáp lộc', 'Hồng diễm'],
                'ngo' => ['Văn xương', 'Học đường'],
                'mao' => ['Lộc thần'],
                'dau' => ['Giáp lộc'],
                'thin' => ['Giáp lộc', 'Dương nhẫn'],
                'mui' => ['Kim dư'],
                'hoi' => ['Học sỹ'],
                'tuat' => ['Ấm lộc', 'Phi nhân'],
                'dan' => ['Kình dương']
            ],
            'binh' => [
                'dau' => ['Thiên ất'],
                'hoi' => ['Thiên ất'],
                'than' => ['Văn xương', 'Ấm lộc'],
                'ty' => ['Lộc thần'],
                'dan' => ['Học đường', 'Hồng diễm'],
                'thin' => ['Giáp lộc'],
                'ngo' => ['Giáp lộc', 'Dương nhẫn', 'Kình dương'],
                'mui' => ['Kim dư'],
                'mao' => ['Học sỹ'],
            ],
            'dinh' => [
                'dau' => ['Thiên ất', 'Văn xương', 'Học đường'],
                'hoi' => ['Thiên ất'],
                'ngo' => ['Lộc thần'],
                'ty' => ['Giáp lộc', 'Kình dương'],
                'mui' => ['Giáp lộc', 'Hồng diễm', 'Ấm lộc', 'Dương nhẫn'],
                'than' => ['Kim dư'],
                'dan' => ['Học sỹ'],
                'suu' => ['Phi nhân'],
            ],
            'mau' => [
                'suu' => ['Thiên ất'],
                'mui' => ['Thiên ất', 'Kim dư'],
                'than' => ['Văn xương', 'Ấm lộc'],
                'ty' => ['Lộc thần'],
                'dan' => ['Học đường'],
                'thin' => ['Giáp lộc', 'Hồng diễm'],
                'ngo' => ['Giáp lộc', 'Học sỹ', 'Dương nhẫn', 'Kình dương'],
                'ti' => ['Phi nhân'],
            ],
            'ky' => [
                'ti' => ['Thiên ất'],
                'than' => ['Thiên ất', 'Kim dư'],
                'dau' => ['Văn xương', 'Học đường'],
                'ngo' => ['Lộc thần'],
                'ty' => ['Giáp lộc', 'Học sỹ', 'Kình dương'],
                'mui' => ['Giáp lộc', 'Ấm lộc', 'Dương nhẫn'],
                'thin' => ['Hồng diễm'],
                'suu' => ['Phi thân'],
            ],
            'canh' => [
                'suu' => ['Thiên ất'],
                'mui' => ['Thiên ất', 'Giáp lộc'],
                'hoi' => ['Văn xương'],
                'than' => ['Lộc thần'],
                'ty' => ['Học đường', 'Ấm lộc'],
                'dau' => ['Giáp lộc', 'Dương nhẫn', 'Kình dương'],
                'tuat' => ['Kim dư', 'Hồng diễm'],
                'ngo' => ['Học sỹ'],
                'mao' => ['Phi nhân'],
            ],
            'tan' => [
                'dan' => ['Thiên ất'],
                'ngo' => ['Thiên ất'],
                'ti' => ['Văn xương', 'Học đường'],
                'dau' => ['Lộc thần', 'Hồng diễm'],
                'than' => ['Giáp lộc', 'Kình dương'],
                'tuat' => ['Giáp lộc', 'Dương nhẫn'],
                'hoi' => ['Kim dư'],
                'ty' => ['Học sỹ'],
                'thin' => ['Ấm lộc', 'Phi nhân'],
            ],
            'nham' => [
                'mao' => ['Thiên ất'],
                'ty' => ['Thiên ất'],
                'dan' => ['Văn xương', 'Học sỹ', 'Ấm lộc'],
                'hoi' => ['Lộc thần'],
                'than' => ['Học đường'],
                'tuat' => ['Giáp lộc'],
                'ti' => ['Giáp lộc', 'Hồng diễm', 'Dương nhẫn', 'Kình dương'],
                'suu' => ['Kim dư'],
                'ngo' => ['Phi nhân'],
            ],
            'quy' => [
                'mao' => ['Thiên ất', 'Văn xương', 'Học đường'],
                'ty' => ['Thiên ất'],
                'ti' => ['Lộc thần'],
                'hoi' => ['Giáp lộc', 'Kình dương'],
                'suu' => ['Giáp lộc', 'Ấm lộc', 'Dương nhẫn'],
                'dan' => ['Kim dư'],
                'than' => ['Học sỹ', 'Hồng diễm'],
                'mui' => ['Phi nhân'],
            ],
        ];

        // chi nien-chi tru
        $sao2Arr['ti']['hoi'] = $sao2Arr['suu']['hoi'] = $sao2Arr['dan']['ty'] = $sao2Arr['mao']['ty'] = $sao2Arr['thin']['ty'] = $sao2Arr['ty']['than'] = $sao2Arr['ngo']['than'] = $sao2Arr['mui']['than'] = $sao2Arr['than']['hoi'] = $sao2Arr['dau']['hoi'] = $sao2Arr['tuat']['hoi'] = $sao2Arr['hoi']['dan'] = 'Cô thần';

        $sao2Arr['ti']['tuat'] = $sao2Arr['suu']['tuat'] = $sao2Arr['dan']['suu'] = $sao2Arr['mao']['suu'] = $sao2Arr['thin']['suu'] = $sao2Arr['ty']['thin'] = $sao2Arr['ngo']['thin'] = $sao2Arr['mui']['thin'] = $sao2Arr['than']['mui'] = $sao2Arr['dau']['mui'] = $sao2Arr['tuat']['mui'] = $sao2Arr['hoi']['tuat'] = 'Quả tú';

        $this->sao2Arr = $sao2Arr;

        $this->bangKhongVong['tuat'] = $this->bangKhongVong['hoi'] = ['giap-ti', 'at-suu', 'binh-dan', 'dinh-mao', 'mau-thin', 'ky-ty', 'canh-ngo', 'tan-mui', 'nham-than', 'quy-dau'];
        $this->bangKhongVong['than'] = $this->bangKhongVong['dau'] = ['giap-tuat', 'at-hoi', 'binh-ti', 'dinh-suu', 'mau-dan', 'ky-mao', 'canh-thin', 'tan-ty', 'nham-ngo', 'quy-mui'];
        $this->bangKhongVong['ngo'] = $this->bangKhongVong['mui'] = ['giap-than', 'at-dau', 'binh-tuat', 'dinh-hoi', 'mau-ti', 'ky-suu', 'canh-dan', 'tan-mao', 'nham-thin', 'quy-ty'];
        $this->bangKhongVong['thin'] = $this->bangKhongVong['ty'] = ['giap-ngo', 'at-mui', 'binh-than', 'dinh-dau', 'mau-tuat', 'ky-hoi', 'canh-ti', 'tan-suu', 'nham-dan', 'quy-mao'];
        $this->bangKhongVong['dan'] = $this->bangKhongVong['mao'] = ['giap-thin', 'at-ty', 'binh-ngo', 'dinh-mui', 'mau-than', 'ky-dau', 'canh-tuat', 'tan-hoi', 'nham-ti', 'quy-suu'];
        $this->bangKhongVong['ti'] = $this->bangKhongVong['suu'] = ['giap-dan', 'at-mao', 'binh-thin', 'dinh-ty', 'mau-ngo', 'ky-mui', 'canh-than', 'tan-dau', 'nham-tuat', 'quy-hoi'];
        $this->bangMenhQuai = [
            1 => ['name' => 'Cung Khảm Thủy', 'class' => 'thuy', 'name2' => 'kham', 'menh' => 'Đông tứ mệnh', 'menh2' => 'dong'],
            6 => ['name' => 'Cung Khôn Thổ', 'class' => 'tho', 'name2' => 'khon', 'menh' => 'Tây tứ mệnh', 'menh2' => 'tay'],
            9 => ['name' => 'Cung Khôn Thổ', 'class' => 'tho', 'name2' => 'khon', 'menh' => 'Tây tứ mệnh', 'menh2' => 'tay'],
            8 => ['name' => 'Cung Chấn Mộc', 'class' => 'moc', 'name2' => 'chan', 'menh' => 'Đông tứ mệnh', 'menh2' => 'dong'],
            7 => ['name' => 'Cung Tốn Mộc', 'class' => 'moc', 'name2' => 'ton', 'menh' => 'Đông tứ mệnh', 'menh2' => 'dong'],
            5 => ['name' => 'Cung Càn Kim', 'class' => 'kim', 'name2' => 'can', 'menh' => 'Tây tứ mệnh', 'menh2' => 'tay'],
            4 => ['name' => 'Cung Đoài Kim', 'class' => 'kim', 'name2' => 'doai', 'menh' => 'Tây tứ mệnh', 'menh2' => 'tay'],
            3 => ['name' => 'Cung Cấn Thổ', 'class' => 'tho', 'name2' => 'can2', 'menh' => 'Tây tứ mệnh', 'menh2' => 'tay'],
            2 => ['name' => 'Cung Ly Hỏa', 'class' => 'hoa', 'name2' => 'ly', 'menh' => 'Đông tứ mệnh', 'menh2' => 'dong'],
        ];
        $this->bangMenhQuaiNu = [
            6 => ['name' => 'Cung Khảm Thủy', 'class' => 'thuy', 'name2' => 'kham', 'menh' => 'Đông tứ mệnh', 'menh2' => 'dong'],
            7 => ['name' => 'Cung Khôn Thổ', 'class' => 'tho', 'name2' => 'khon', 'menh' => 'Tây tứ mệnh', 'menh2' => 'tay'],
            8 => ['name' => 'Cung Chấn Mộc', 'class' => 'moc', 'name2' => 'chan', 'menh' => 'Đông tứ mệnh', 'menh2' => 'dong'],
            9 => ['name' => 'Cung Tốn Mộc', 'class' => 'moc', 'name2' => 'ton', 'menh' => 'Đông tứ mệnh', 'menh2' => 'dong'],
            2 => ['name' => 'Cung Càn Kim', 'class' => 'kim', 'name2' => 'can', 'menh' => 'Tây tứ mệnh', 'menh2' => 'tay'],
            3 => ['name' => 'Cung Đoài Kim', 'class' => 'kim', 'name2' => 'doai', 'menh' => 'Tây tứ mệnh', 'menh2' => 'tay'],
            1 => ['name' => 'Cung Cấn Thổ', 'class' => 'tho', 'name2' => 'can2', 'menh' => 'Tây tứ mệnh', 'menh2' => 'tay'],
            4 => ['name' => 'Cung Cấn Thổ', 'class' => 'tho', 'name2' => 'can2', 'menh' => 'Tây tứ mệnh', 'menh2' => 'tay'],
            5 => ['name' => 'Cung Ly Hỏa', 'class' => 'hoa', 'name2' => 'ly', 'menh' => 'Đông tứ mệnh', 'menh2' => 'dong'],
        ];

        $this->cungMenhArr2 = [
            1 => ['Cấn', 'Khảm'], // nu, nam
            2 => ['Càn', 'Ly'], // nu, nam
            3 => ['Đoài', 'Cấn'], // nu, nam
            4 => ['Cấn', 'Đoài'], // nu, nam
            5 => ['Ly', 'Càn'], // nu, nam
            6 => ['Khảm', 'Khôn'], // nu, nam
            7 => ['Khôn', 'Tốn'], // nu, nam
            8 => ['Chấn', 'Chấn'], // nu, nam
            9 => ['Khôn', 'Tốn'], // nu, nam
        ];

        // chồng trc, vo sau
        $this->cungMenhTamHop = [
            'can' => [
                'can' => 'Phục vị', // càn
                'kham' => 'Lục Sát', // khảm
                'cana' => 'Thiên Y', // cấn
                'chan' => 'Ngũ Quỷ', // chấn
                'ton' => 'Họa Hại', // tốn
                'ly' => 'Tuyệt Mệnh', // ly
                'khon' => 'Diên Niên', // khôn
                'doai' => 'Sinh Khí', // đoài
            ],
            'kham' => [
                'can' => 'Lục Sát', // càn
                'kham' => 'Phục Vị', // khảm
                'cana' => 'Ngũ Quỷ', // cấn
                'chan' => 'Thiên Y', // chấn
                'ton' => 'Sinh Khí', // tốn
                'ly' => 'Diên Niên', // ly
                'khon' => 'Tuyệt Mệnh', // khôn
                'doai' => 'Họa Hại', // đoài
            ],
            'cana' => [
                'can' => 'Thiên Y', // càn
                'kham' => 'Ngũ Quỷ', // khảm
                'cana' => 'Phục Vị', // cấn
                'chan' => 'Lục Sát', // chấn
                'ton' => 'Tuyệt Mệnh', // tốn
                'ly' => 'Họa Hại', // ly
                'khon' => 'Sinh Khí', // khôn
                'doai' => 'Diên Niên', // đoài
            ],
            'chan' => [
                'can' => 'Ngũ Quỷ', // càn
                'kham' => 'Thiên Y', // khảm
                'cana' => 'Ngũ Quỷ', // cấn
                'chan' => 'Phục Vị', // chấn
                'ton' => 'Diên Niên', // tốn
                'ly' => 'Sinh Khí', // ly
                'khon' => 'Họa Hại', // khôn
                'doai' => 'Tuyệt Mệnh', // đoài
            ],
            'ton' => [
                'can' => 'Họa Hại', // càn
                'kham' => 'Sinh Khí', // khảm
                'cana' => 'Tuyệt Mệnh', // cấn
                'chan' => 'Diên Niên', // chấn
                'ton' => 'Phục Vị', // tốn
                'ly' => 'Thiên Y', // ly
                'khon' => 'Ngũ Quỷ', // khôn
                'doai' => 'Sinh Khí', // đoài
            ],
            'ly' => [
                'can' => 'Tuyệt Mệnh', // càn
                'kham' => 'Diên Niên', // khảm
                'cana' => 'Họa Hại', // cấn
                'chan' => 'Sinh Khí', // chấn
                'ton' => 'Thiên Y', // tốn
                'ly' => 'Phục Vị', // ly
                'khon' => 'Lục Sát', // khôn
                'doai' => 'Ngũ Quỷ', // đoài
            ],
            'khon' => [
                'can' => 'Diên Niên', // càn
                'kham' => 'Tuyệt Mệnh', // khảm
                'cana' => 'Sinh Khí', // cấn
                'chan' => 'Họa Hại', // chấn
                'ton' => 'Ngũ Quỷ', // tốn
                'ly' => 'Lục Sát', // ly
                'khon' => 'Phục Vị', // khôn
                'doai' => 'Thiên Y', // đoài
            ],
            'doai' => [
                'can' => 'Sinh Khí', // càn
                'kham' => 'Họa Hại', // khảm
                'cana' => 'Diên Niên', // cấn
                'chan' => 'Tuyệt Mệnh', // chấn
                'ton' => 'Lục Sát', // tốn
                'ly' => 'Ngũ Quỷ', // ly
                'khon' => 'Thiên Y', // khôn
                'doai' => 'Phục Vị', // đoài
            ],
        ];

        $this->cungMenhArr = [
            'dan' => [
                'name' => 'Dần',
                'number' => 1,
                'luan_giai' => 'Thiên quyền tinh: Là người thông minh có khả năng phát triển rất tốt trong công việc. Vậy nên thời trung niên sẽ đạt được nhiều thành tựu lớn, có quyền chức hoặc làm cán bộ lãnh đạo. Tuy nhiên khi còn đương chức cần chú ý giữ đạo đức nghề nghiệp, sống lương thiện, tử tế để tránh vướng vào vòng lao lý.'
            ],
            'mao' => [
                'name' => 'Mão',
                'number' => 2,
                'luan_giai' => 'Thiên xá tinh: Cung mệnh coi trọng đạo nghĩa, nghĩa khí mà không chú ý đến vật chất, tiền tài, trong sáng cao thượng, luôn nghĩ đến lợi ích của người khác trước bản thân. Tuy nhiên tính tình lại kiêu ngạo do thông minh, tài trí hơn người vậy nên cần cảm thông và hòa đồng để cuộc sống an nhiên bình an, hòa hợp với mọi người.',
            ],
            'thin' => [
                'name' => 'Thìn',
                'number' => 3,
                'luan_giai' => 'Thiên như tinh: Người cung mệnh này hay thay đổi, lắm mưu nhiều kế. Là người có vận đào hoa nhưng “lắm mối tối nằm không” vì có tình cảm với rất nhiều người nên không biết ai mới là người hợp với mình. Vậy nên cần chính kiến, lấy lòng nhân ái, tử tế làm nền móng để phát triển cuộc sống, công việc, tình duyên như vậy sẽ giúp cho cuộc sống an nhiên, bình an, hưởng nhiều phúc lộc.',
            ],
            'ty' => [
                'name' => 'Tỵ',
                'number' => 4,
                'luan_giai' => 'Thiên văn tinh: Là người yêu văn học, nghệ thuật, có trí tưởng tượng phong phú nên sự nghiệp văn chương xán lạn. Mệnh này nữ giới có thể gặp được tình duyên tốt, mọi chuyện tình cảm đều thuận lợi. Tuy nhiên cần chú ý giữ đạo đức để tránh mắc sai lầm trong tửu sắc, tâm trí vững vàng chắc chắn vận mệnh sẽ hanh thông.',
            ],
            'ngo' => [
                'name' => 'Ngọ',
                'number' => 5,
                'luan_giai' => 'Thiên phúc tinh: Người cung mệnh này có cuộc sống vinh hoa phú quý, thanh nhàn yên vui. Nhưng nên tu tâm hướng thiện bao dung độ lượng cảm thông với mọi người xung quanh để giữ phước báu.',
            ],
            'mui' => [
                'name' => 'Mùi',
                'number' => 6,
                'luan_giai' => 'Thiên dịch: Người cung mệnh này phải bôn ba vất vả, rời quê hương đi lập nghiệp mới có cuộc sống tốt đẹp, may mắn. Cuộc sống vất vả, gian nan, nay đây mai đó, nhưng  sau 38 tuổi cuộc sống sẽ an nhàn, thảnh thơi.',
            ],
            'than' => [
                'name' => 'Thân',
                'number' => 7,
                'luan_giai' => 'Thiên cô tinh: Cuộc sống cô đơn vắng vẻ, nếu là nữ mệnh thì dễ hại chồng nên sẽ sống cuộc đời cô quạnh. Vì vậy hãy luôn sống hướng thiện sẽ giúp gặt hái được nhiều điều may mắn và nên tạo phúc trợ duyên để sau có cuộc sống thanh cao viên mãn.',
            ],
            'dau' => [
                'name' => 'Dậu',
                'number' => 8,
                'luan_giai' => 'Thiên bí tinh: Người mệnh này tính tình thẳng thắn, dễ gặp vạ chuyện thị phi do ăn nói thường không suy nghĩ thấu đáo. Tính cách nóng vội, hay lo chuyện bao đồng thích giúp người khác. Để cuộc sống tốt hơn thì nên tránh nhiều chuyện, tu khẩu tu tâm mới tốt.',
            ],
            'tuat' => [
                'name' => 'Tuất',
                'number' => 9,
                'luan_giai' => 'Thiên nghệ tinh: Là người đa tài đa nghệ, cái gì cũng biết nhưng không giỏi. Người cung mệnh này khó thành danh vì không chuyên tâm về 1 lĩnh vực nào cả nên muốn thành công thì cần tập trung theo năng khiếu và phát triển 1 thế mạnh của bản thân như thế mới có cuộc sống như mong muốn.',
            ],
            'hoi' => [
                'name' => 'Hợi',
                'number' => 10,
                'luan_giai' => 'Thiên thọ tinh: Người có tính nhanh nhẹn, lòng nhân từ, lấy việc giúp người làm vui, cuộc sống bình an. Cuộc sống của những người này bình bình, không có nhiều biến cố hay sự việc lớn xảy ra trong đời bởi người cung mệnh Hợi ghét xô xát tranh giành.',
            ],
            'ti' => [
                'name' => 'Tí',
                'number' => 11,
                'luan_giai' => 'Cung mệnh Thiên quý tinh: Người cung mệnh này có chí khí lớn lao, cuộc sống giàu có cao quý. Nếu làm ăn buôn bán sẽ gặp nhiều may mắn, thuận lợi thu về được nhiều tài lộc. Là người thông minh, có trí khí hơn người nên trong công việc sẽ gặt hái được nhiều thành công vượt bậc, hơn người.',
            ],
            'suu' => [
                'name' => 'Sửu',
                'number' => 12,
                'luan_giai' => 'Thiên ách tinh: Người cung mệnh này phải làm ăn xa quê cha đất tổ, vất vả gian nan trước sau mới cát. Khoảng thời gian khi còn trẻ có cuộc sống bôn ba, chịu nhiều gian nan vất vả. Nhưng sau 38 tuổi (trung vận) cuộc sống sẽ an nhàn, thảnh thơi, không phải đi đây đi đó làm việc mà đã bắt đầu được hưởng quả ngọt từ thành quả lao động trước đó.',
            ],
        ];

        $this->diaChiXung = [
            'ti' => ['ngo', 'dau', 'mui'],
            'suu' => ['mui', 'thin', 'ngo'],
            'dan' => ['than', 'hoi', 'ty'],
            'mao' => ['dau', 'ngo', 'thin'],
            'thin' => ['tuat', 'suu', 'mao'],
            'ty' => ['hoi', 'than', 'dan'],
            'ngo' => ['ti', 'mao', 'suu'],
            'mui' => ['suu', 'tuat', 'ti'],
            'than' => ['dan', 'ty', 'hoi'],
            'dau' => ['mao', 'ti', 'tuat'],
            'tuat' => ['thin', 'mui', 'dau'],
            'hoi' => ['ty', 'dan', 'than']
        ];

        $this->diaChiHinh = [
            'dan' => 'ty',
            'ty' => 'than',
            'than' => 'dan',
            'mui' => 'suu',
            'suu' => 'tuat',
            'tuat' => 'mui',
            'ti' => 'mao',
            'mao' => 'ti',
            'thin' => 'thin',
            'ngo' => 'ngo',
            'dau' => 'dau',
            'hoi' => 'hoi'
        ];
    }

    public function getGioID($gio) {
        if ($gio >= 1 && $gio < 3) {
            return 2; // suu
        }
        if ($gio >= 3 && $gio < 5) {
            return 3; // dan
        }
        if ($gio >= 5 && $gio < 7) {
            return 4; // mao
        }
        if ($gio >= 7 && $gio < 9) {
            return 5; // thin
        }
        if ($gio >= 9 && $gio < 11) {
            return 6; // tỵ
        }
        if ($gio >= 11 && $gio < 13) {
            return 7; // ngo
        }
        if ($gio >= 13 && $gio < 15) {
            return 8; // mui
        }
        if ($gio >= 15 && $gio < 17) {
            return 9; // than
        }
        if ($gio >= 17 && $gio < 19) {
            return 10; // dau
        }
        if ($gio >= 19 && $gio < 21) {
            return 11; // tuat
        }
        if ($gio >= 21 && $gio < 23) {
            return 12; // hoi
        }

        return 1; // ty
    }

    public function hourToText($gio) {
        if ($gio >= 1 && $gio < 3) {
            return 'Sửu'; // suu
        }
        if ($gio >= 3 && $gio < 5) {
            return 'Dần'; // dan
        }
        if ($gio >= 5 && $gio < 7) {
            return 'Mão'; // mao
        }
        if ($gio >= 7 && $gio < 9) {
            return 'Thìn'; // thin
        }
        if ($gio >= 9 && $gio < 11) {
            return 'Tỵ'; // tỵ
        }
        if ($gio >= 11 && $gio < 13) {
            return 'Ngọ'; // ngo
        }
        if ($gio >= 13 && $gio < 15) {
            return 'Mùi'; // mui
        }
        if ($gio >= 15 && $gio < 17) {
            return 'Thân'; // than
        }
        if ($gio >= 17 && $gio < 19) {
            return 'Dậu'; // dau
        }
        if ($gio >= 19 && $gio < 21) {
            return 'Tuất'; // tuat
        }
        if ($gio >= 21 && $gio < 23) {
            return 'Hợi'; // hoi
        }

        return 'Tý'; // ty
    }

    function tuongSinh($value) {
        $array = [
            'kim' => 'thuy',
            'thuy' => 'moc',
            'moc' => 'hoa',
            'hoa' => 'tho',
            'tho' => 'kim'
        ];

        return isset($array[$value]) ? $array[$value] : [];
    }

    function ngSinh($value) {
        $array = [
            'kim' => 'tho',
            'thuy' => 'kim',
            'moc' => 'thuy',
            'hoa' => 'moc',
            'tho' => 'hoa'
        ];

        return isset($array[$value]) ? $array[$value] : [];
    }

    function tuongKhac($value) {
        $array = [
            'kim' => 'moc',
            'thuy' => 'hoa',
            'moc' => 'tho',
            'hoa' => 'kim',
            'tho' => 'thuy'
        ];

        return isset($array[$value]) ? $array[$value] : [];
    }

    function biKhac($value) {
        $array = [
            'moc' => 'kim',
            'kim' => 'hoa',
            'hoa' => 'thuy',
            'thuy' => 'tho',
            'tho' => 'moc'
        ];

        return isset($array[$value]) ? $array[$value] : [];
    }

    function khacThanhSinh($value) {
        $array = [
            'moc' => 'thuy',
            'kim' => 'tho',
            'hoa' => 'moc',
            'thuy' => 'kim',
            'tho' => 'hoa'
        ];

        return isset($array[$value]) ? $array[$value] : [];
    }

    function getNguHanhId($value) {
        $array = [
            'kim' => 1,
            'thuy' => 2,
            'moc' => 3,
            'hoa' => 4,
            'tho' => 5
        ];

        return isset($array[$value]) ? $array[$value] : [];
    }

    function id2Nh($value) {
        $array = [
            1 => 'kim',
            2 => 'thuy',
            3 => 'moc',
            4 => 'hoa',
            5 => 'tho'
        ];

        return isset($array[$value]) ? $array[$value] : [];
    }

    function convertSlugToText($value) {
        $array = [
            'kim' => 'Kim',
            'thuy' => 'Thủy',
            'moc' => 'Mộc',
            'hoa' => 'Hỏa',
            'tho' => 'Thổ'
        ];

        return isset($array[$value]) ? $array[$value] : [];
    }

    function cmp($a, $b) {
        if ($a == $b) {
            return 0;
        }
        return ($a < $b) ? 1 : -1;
    }

    function nguHanhVuong($doVuongSuy) {
        $array = $doVuongSuy['total'];
        uasort($array, array($this, 'cmp'));
        return array_slice($array, 0, 2, true);
    }

    function sinhKhacInfo($nguHanh, $nguHanh2, $tru = 'nam') {
        $index = '';
        switch ($nguHanh) {
            case 'kim':
                if ($nguHanh2 == 'kim') {
                    $index = 2; // tuong tro
                    break;
                }
                if ($nguHanh2 == 'thuy' || $nguHanh2 == 'tho') {
                    $index = 1; // tuong sinh
                    break;
                }
                if ($nguHanh2 == 'moc' || $nguHanh2 == 'hoa') {
                    $index = 3; // tuong khac
                    break;
                }
            case 'thuy':
                if ($nguHanh2 == 'thuy') {
                    $index = 2; // tuong tro
                    break;
                }
                if ($nguHanh2 == 'moc' || $nguHanh2 == 'kim') {
                    $index = 1; // tuong sinh
                    break;
                }
                if ($nguHanh2 == 'hoa' || $nguHanh2 == 'tho') {
                    $index = 3; // tuong khac
                    break;
                }
            case 'moc':
                if ($nguHanh2 == 'moc') {
                    $index = 2; // tuong tro
                    break;
                }
                if ($nguHanh2 == 'thuy' || $nguHanh2 == 'hoa') {
                    $index = 1; // tuong sinh
                    break;
                }
                if ($nguHanh2 == 'kim' || $nguHanh2 == 'tho') {
                    $index = 3; // tuong khac
                    break;
                }
            case 'hoa':
                if ($nguHanh2 == 'hoa') {
                    $index = 2; // tuong tro
                    break;
                }
                if ($nguHanh2 == 'moc' || $nguHanh2 == 'tho') {
                    $index = 1; // tuong sinh
                    break;
                }
                if ($nguHanh2 == 'kim' || $nguHanh2 == 'thuy') {
                    $index = 3; // tuong khac
                    break;
                }
            case 'tho':
                if ($nguHanh2 == 'tho') {
                    $index = 2; // tuong tro
                    break;
                }
                if ($nguHanh2 == 'hoa' || $nguHanh2 == 'kim') {
                    $index = 1; // tuong sinh
                    break;
                }
                if ($nguHanh2 == 'thuy' || $nguHanh2 == 'moc') {
                    $index = 3; // tuong khac
                    break;
                }
            default :
                $index = 0;
        }
        if ($tru == 'nam') {
            if ($index == 1) {
                return 'Trong khoảng thời gian đầu đời này gia chủ sẽ có cuộc sống may mắn, học hành đỗ đạt. Luôn có người giúp đỡ khiến cho cuộc sống diễn ra bình an, thuận buồm xuôi gió.';
            }
            if ($index == 3) {
                return 'Khoảng thời gian này gia chủ có cuộc sống khó khăn, gặp nhiều vất vả gian truân. Công việc học hành không được tốt, nếu có học theo người khác kinh doanh, buôn bán thì có thể thua lỗ. Vậy nên cần ngũ hành thông quan để hóa giải.';
            }
            if ($index == 2) {
                return 'Cuộc sống trong khoảng thời gian đại vận này thì bình an, không gặp nhiều vất vả gian truân. Cuộc sống sẽ có những thăng trầm lúc lên lúc xuống, vì vậy nên không cần quá nản lòng nếu cuộc sống, học tập không được như mong muốn. Nên nắm chắc được các năm vượng suy để có cách giải quyết, nắm bắt vấn đề được tốt hơn.';
            }
        }
        if ($tru == 'thang') {
            if ($index == 1) {
                return 'Khoảng thời gian này cuộc sống gặp nhiều may mắn, thuận lợi. Học hành thì đỗ đạt, kinh doanh buôn bán thì thu lại nhiều tài lộc, tấn tới. Cuộc sống, công việc sẽ ngày càng đi lên như diều gặp gió do có quý nhân phù trợ.';
            }
            if ($index == 3) {
                return 'Thời gian trong những năm vận này cuộc sống khó khăn, gian truân, 3 chìm 7 nổi 9 cái lênh đênh. Công việc làm ăn thì không thuận lợi, có thể thua lỗ. Tình duyên thì trắc trở, khó gặp được ý trung nhân hoặc có gặp được cũng thường xuyên xảy ra cãi vã, bất đồng quan điểm. Muốn mọi việc được thuận lợi thì cần ngũ hành thông quan để hóa giải.';
            }
            if ($index == 2) {
                return 'Cuộc sống trong những năm đại vận này sẽ bình hòa, không giàu cũng không nghèo. Nếu gặp năm vận tốt thì có thể phất lên nhưng cần biết nắm bắt tốt cơ hội của mình. Vào năm vượng suy thì nên tiết chế mình hơn, biết tiến biết lùi sẽ làm cho cuộc sống hài hòa, không gặp nhiều khó khăn trắc trở.';
            }
        }
        if ($tru == 'ngay') {
            if ($index == 1) {
                return 'Khoảng thời gian đại vận này bạn sẽ có cuộc sống may mắn, làm ăn thì tấn tới, công danh sự nghiệp thì vững vàng, được rất nhiều người ái mộ. Do có quý nhân phù trợ nên việc gì bạn thực hiện trong khoảng thời gian này cũng sẽ đạt được kết quả như mong muốn.';
            }
            if ($index == 3) {
                return 'Gia chủ trong khoảng thời gian này sẽ có cuộc sống gặp nhiều khó khăn, gian truân và không thuận lợi lắm. Công việc thì không có nhiều tiến triển tốt, đôi lúc khiến bạn mệt mỏi, kiệt sức. Nếu có làm ăn buôn bán thì cũng không tốt, có thể dẫn đến thua lỗ, nợ nần. Gia đình, con cái cũng thiếu hòa khí, thường xuyên xảy ra mâu thuẫn, tranh cãi làm cho không khí gia đình lúc nào cũng căng thẳng, mệt mỏi.';
            }
            if ($index == 2) {
                return 'Trong khoảng thời gian năm vận này bạn sẽ có cuộc sống bình hòa, không giàu sang phú quý nhưng cũng không quá cơ hàn khổ cực. Nếu gặp niên vượng thì sẽ lên nhưng nếu gặp niên suy thì sẽ lao đao lận đận, khó khăn. Nhưng mọi việc rồi sẽ qua đi nếu bạn biết nắm bắt thời cơ, biết tiết chế và đưa ra được quyết định chính xác thì tất cả sẽ được hóa giải.';
            }
        }
        if ($tru == 'gio') {
            if ($index == 1) {
                return 'Trong những năm đại vận này gia chủ sẽ gặp nhiều thuận lợi, may mắn. Nhờ những công danh, sự nghiệp mà bạn gây dựng trước đó mà giờ là lúc bạn thu lại được quả ngọt. Cuộc sống gia đình bình lặng, không có nhiều biến cố lớn xảy ra. Già trẻ lớn bé trong nhà yêu thương nhau, cố gắng học hành, đạt được nhiều thành tựu trong cuộc sống.';
            }
            if ($index == 3) {
                return 'Cuộc sống trong khoảng đại vận này gia chủ sẽ gặp nhiều khó khăn, vất vả, làm việc gì cũng không mang đến hiệu quả như mong muốn. Nếu có kinh doanh, buôn bán thì có thể dẫn đến thua lỗ, không mang lại lợi nhuận. Vợ chồng thường xuyên cãi vã, các thành viên trong gia đình thường bất đồng quan điểm với nhau. Không khí gia đình lúc nào cũng căng thẳng, không có tiếng nói chung để giải quyết các vấn đề khúc mắc trong cuộc sống. Muốn mọi việc được êm ấm, tốt đẹp hơn cần ngũ hành thông quan để hóa giải.';
            }
            if ($index == 2) {
                return 'Những năm vận này cuộc sống sẽ không có nhiều thay đổi hay gặp biến cố. Gặp năm vượng thì cuộc sống gia đình hạnh phúc, tài lộc dồi dào. Vào những năm suy thì cuộc sống sẽ gặp khó khăn gia đình bất hòa. Vậy nên biết nắm bắt năm vượng năm suy sẽ giúp gia chủ giải quyết các khó khăn 1 cách tốt hơn, cuộc sống gia đình êm ấm, hòa thuận.';
            }
        }

        return '';
    }

    function tinhThienCanHopHoa() {
        //$this->canNamSlug = $this->canNamSlug;
        //$this->chiNamSlug = $this->chiNamSlug;
        //$this->canThangSlug = $this->canThangSlug;
        //$this->chiThangSlug = $this->chiThangSlug;
//        $this->canNgaySlug = $this->canNgaySlug;
//        $this->chiNgaySlug = $this->chiNgaySlug;
        //$this->canGioSlug = $this->canGioSlug;
        //$this->chiGioSlug = $this->chiGioSlug;
        $results = [];
        //
        $canTangNam = $this->canTang[$this->chiNamSlug];
        $canTangThang = $this->canTang[$this->chiThangSlug];
        $canTangNgay = $this->canTang[$this->chiNgaySlug];
        $canTangGio = $this->canTang[$this->chiGioSlug];
        $canTangArr = array_merge($canTangNam, $canTangThang, $canTangNgay, $canTangGio);
        $canTangArrUni = array_map(array($this, 'khongdau'), $canTangArr); // loai bo dau
        //echo $canNam, $chiNam, $canThang, $chiThang, $canNgay, $chiNgay, $canGio, $chiGio;
        $diaChiHopHoa = $this->diaChiHopHoa();
        // ** ------------------------------------- NAM VS THANG ------------------------------------- **/
        // GIAP VS KY
        if (($this->canNamSlug == 'giap' && $this->canThangSlug == 'ky' && $this->canNgaySlug != 'giap') ||
            ($this->canNamSlug == 'ky' && $this->canThangSlug == 'giap' && $this->canNgaySlug != 'ky')) {

            // Hóa mạnh nhất
            // xung - xung, khac - khac, xung - khac, khac - xung
            $daHoa = false;
            if (($this->chiNamSlug != $this->diaChiLucXung[$this->chiThangSlug] && $this->chiNgaySlug != $this->diaChiLucXung[$this->chiThangSlug]) ||
                ($this->chiInfo['nam']['name'] != $this->biKhac($this->chiInfo['thang']['name']) && $this->chiInfo['ngay']['name'] != $this->biKhac($this->chiInfo['thang']['name'])) ||
                ($this->chiNamSlug != $this->diaChiLucXung[$this->chiThangSlug] && $this->chiInfo['ngay']['name'] != $this->biKhac($this->chiInfo['thang']['name'])) ||
                ($this->chiInfo['nam']['name'] != $this->biKhac($this->chiInfo['thang']['name']) && $this->chiNgaySlug != $this->diaChiLucXung[$this->chiThangSlug])) {
                if (in_array($this->chiInfo['thang']['name'], ['tho', 'moc'])) {
                    $results['tru_nam'] = $results['tru_thang'] = [
                        'text' => 'Hóa ' . $this->chiInfo['thang']['title'],
                        'number' => $this->chiInfo['thang']['id']
                    ];
                    $daHoa = true;
                }
            }
            /**
             * Chính Hóa
             * 2 trụ có chi là Thổ
             * Thiên can Ngày không được xung với thiên can Tháng
             */
            if (!$daHoa && (($this->chiInfo['nam']['name'] == 'tho' && $this->chiInfo['thang']['name'] == 'tho') ||
                    ($this->chiInfo['nam']['name'] == 'tho' && $this->chiInfo['thang']['name'] == 'hoa') ||
                    ($this->chiInfo['nam']['name'] == 'hoa' && $this->chiInfo['thang']['name'] == 'tho') ||
                    ($this->chiInfo['ngay']['name'] == 'tho'))) {
                $results['tru_nam'] = $results['tru_thang'] = [
                    'text' => 'Hóa thổ',
                    'number' => 5
                ];
            }

            /**
             * Phu tòng thê hóa
             * 1 trong 2 trụ có chi là Thổ
             * Can chi bên cạnh đều là Thổ
             * Có Đinh, Kỷ ở can tàng
             */
            if (!$daHoa && (($this->chiInfo['nam']['name'] == 'tho' || $this->chiInfo['thang']['name'] == 'tho') &&
                    ($this->canInfo['thang']['name'] == 'tho' && $this->chiInfo['ngay']['name'] == 'tho') &&
                    (in_array('dinh', $canTangArrUni) || in_array('ky', $canTangArrUni)))
            ) {
                $flagPha = false;
                if ($this->canThangSlug == 'ky' && $this->canInfo['thang']['name'] == 'moc') {
                    // Khắc phải là Mộc ở can ngày
                    // tính vương cho Thằng mộc
                    // chi ngày mộc|thủy và chi giờ là mộc|thủy
                    if ($this->chiInfo['ngay']['name'] == 'thuy' && $this->canInfo['gio']['name'] == 'thuy' && !in_array($this->chiInfo['gio']['name'], ['tho', 'hoa'])) {
                        $flagPha = true;
                    }
                    if ($this->chiInfo['ngay']['name'] == 'moc' && $this->canInfo['gio']['name'] == 'moc' && !in_array($this->chiInfo['gio']['name'], ['kim', 'tho'])) {
                        $flagPha = true;
                    }
                    if ($this->chiInfo['ngay']['name'] == 'thuy' && $this->canInfo['gio']['name'] == 'thuy' && $this->chiInfo['thang']['name'] == 'thuy') {
                        $flagPha = true;
                    }
                    if ($this->chiInfo['ngay']['name'] == 'moc' && $this->canInfo['gio']['name'] == 'moc' && $this->chiInfo['thang']['name'] == 'moc') {
                        $flagPha = true;
                    }
                }

                if ($this->canThangSlug == 'giap' && $this->canInfo['thang']['name'] == 'kim') {
                    // Khắc phải là Mộc ở can ngày
                    // tính vương cho Thằng mộc
                    // chi ngày mộc|thủy và chi giờ là mộc|thủy
                    if ($this->chiInfo['ngay']['name'] == 'tho' && $this->canInfo['gio']['name'] == 'tho' && !in_array($this->chiInfo['gio']['name'], ['moc', 'thuy'])) {
                        $flagPha = true;
                    }
                    if ($this->chiInfo['ngay']['name'] == 'kim' && $this->canInfo['gio']['name'] == 'kim' && !in_array($this->chiInfo['gio']['name'], ['hoa', 'thuy'])) {
                        $flagPha = true;
                    }
                    if ($this->chiInfo['ngay']['name'] == 'tho' && $this->canInfo['gio']['name'] == 'tho' && $this->chiInfo['gio']['name'] == 'tho') {
                        $flagPha = true;
                    }
                    if ($this->chiInfo['ngay']['name'] == 'kim' && $this->canInfo['gio']['name'] == 'kim' && $this->chiInfo['gio']['name'] == 'kim') {
                        $flagPha = true;
                    }
                }
                if (!$flagPha) {
                    $results['tru_nam'] = $results['tru_thang'] = [
                        'text' => 'Hóa thổ',
                        'number' => 5
                    ];
                }
            }

            /**
             * Thê tòng phu hóa
             * 1 trong 2 tru co chi mộc
             * Can chi bên cạnh đều là mộc
             * Có Giáp, Nhâm ở can tàng
             */
            if (!$daHoa && (($this->chiInfo['nam']['name'] == 'moc' || $this->chiInfo['thang']['name'] == 'moc') &&
                    ($this->canInfo['thang']['name'] == 'moc' || $this->chiInfo['ngay']['name'] == 'moc') &&
                    (in_array('giap', $canTangArrUni) || in_array('nham', $canTangArrUni)))) {
                $results['tru_nam'] = $results['tru_thang'] = [
                    'text' => 'Hóa mộc',
                    'number' => 3
                ];
            }

            // ----------------------------------- Xét địa chi hợp hóa -----------------------------------
            // 1: kim, 2: thuy, 3: moc, 4: hoa, 5: tho
            // ----- Tam hop -----
            // Nếu ngũ hành hóa của địa chi không phải là Mộc, Thổ thì thiên can ko xét hóa
            if (!empty($diaChiHopHoa['tam_hop']['tru_thang']) && !in_array($diaChiHopHoa['tam_hop']['tru_thang']['number'], [3, 5])) {
                unset($results['tru_nam']);
                unset($results['tru_thang']);
            } else {
                if (!empty($results) && !empty($diaChiHopHoa['tam_hop']['tru_thang']) && $diaChiHopHoa['tam_hop']['tru_thang']['number'] == 5) { // HOA THO
                    $results['tru_nam'] = $results['tru_thang'] = [
                        'text' => 'Hóa Thổ',
                        'number' => 5
                    ];
                }
                if (!empty($results) && !empty($diaChiHopHoa['tam_hop']['tru_thang']) && $diaChiHopHoa['tam_hop']['tru_thang']['number'] == 3) { // HOA MOC
                    $results['tru_nam'] = $results['tru_thang'] = [
                        'text' => 'Hóa mộc',
                        'number' => 3
                    ];
                }
                // ----- Tam Hoi -----
                if (!empty($results) && !empty($diaChiHopHoa['tam_hoi']['tru_thang']) && $diaChiHopHoa['tam_hoi']['tru_thang']['number'] == 5) { // HOA THO
                    $results['tru_nam'] = $results['tru_thang'] = [
                        'text' => 'Hóa Thổ',
                        'number' => 5
                    ];
                }
                if (!empty($results) && !empty($diaChiHopHoa['tam_hoi']['tru_thang']) && $diaChiHopHoa['tam_hoi']['tru_thang']['number'] == 3) { // HOA MOC
                    $results['tru_nam'] = $results['tru_thang'] = [
                        'text' => 'Hóa mộc',
                        'number' => 3
                    ];
                }
                // ----- Lục hợp -----
                if (!empty($results) && !empty($diaChiHopHoa['luc_hop']['tru_thang']) && $diaChiHopHoa['luc_hop']['tru_thang']['number'] == 5) { // HOA THO
                    $results['tru_nam'] = $results['tru_thang'] = [
                        'text' => 'Hóa Thổ',
                        'number' => 5
                    ];
                }
                if (!empty($results) && !empty($diaChiHopHoa['luc_hop']['tru_thang']) && $diaChiHopHoa['luc_hop']['tru_thang']['number'] == 3) { // HOA MOC
                    $results['tru_nam'] = $results['tru_thang'] = [
                        'text' => 'Hóa Mộc',
                        'number' => 3
                    ];
                }
                // ----- Bán tam hợp -----
                if (!empty($results) && !empty($diaChiHopHoa['ban_tam_hop']['tru_thang']) && $diaChiHopHoa['ban_tam_hop']['tru_thang']['number'] == 5) { // HOA THO
                    $results['tru_nam'] = $results['tru_thang'] = [
                        'text' => 'Hóa Thổ',
                        'number' => 5
                    ];
                }
                if (!empty($results) && !empty($diaChiHopHoa['ban_tam_hop']['tru_thang']) && $diaChiHopHoa['ban_tam_hop']['tru_thang']['number'] == 3) { // HOA MOC
                    $results['tru_nam'] = $results['tru_thang'] = [
                        'text' => 'Hóa Mộc',
                        'number' => 3
                    ];
                }
                // ----- Bán tam mộ -----
                if (!empty($results) && !empty($diaChiHopHoa['ban_tam_mo']['tru_thang']) && $diaChiHopHoa['ban_tam_mo']['tru_thang']['number'] == 5) { // HOA THO
                    $results['tru_nam'] = $results['tru_thang'] = [
                        'text' => 'Hóa Thổ',
                        'number' => 5
                    ];
                }
                if (!empty($results) && !empty($diaChiHopHoa['ban_tam_mo']['tru_thang']) && $diaChiHopHoa['ban_tam_mo']['tru_thang']['number'] == 3) { // HOA MOC
                    $results['tru_nam'] = $results['tru_thang'] = [
                        'text' => 'Hóa Mộc',
                        'number' => 3
                    ];
                }
            }
        }
        // AT VS CANH
        if (($this->canNamSlug == 'at' && $this->canThangSlug == 'canh' && $this->canNgaySlug != 'at') ||
            ($this->canNamSlug == 'canh' && $this->canThangSlug == 'at' && $this->canNgaySlug != 'canh')) {

            // Hóa mạnh nhất
            // xung - xung, khac - khac, xung - khac, khac - xung
            $daHoa = false;
            if (($this->chiNamSlug != $this->diaChiLucXung[$this->chiThangSlug] && $this->chiNgaySlug != $this->diaChiLucXung[$this->chiThangSlug]) ||
                ($this->chiInfo['nam']['name'] != $this->biKhac($this->chiInfo['thang']['name']) && $this->chiInfo['ngay']['name'] != $this->biKhac($this->chiInfo['thang']['name'])) ||
                ($this->chiNamSlug != $this->diaChiLucXung[$this->chiThangSlug] && $this->chiInfo['ngay']['name'] != $this->biKhac($this->chiInfo['thang']['name'])) ||
                ($this->chiInfo['nam']['name'] != $this->biKhac($this->chiInfo['thang']['name']) && $this->chiNgaySlug != $this->diaChiLucXung[$this->chiThangSlug])) {
                if (in_array($this->chiInfo['thang']['name'], ['kim', 'moc'])) {
                    $results['tru_nam'] = $results['tru_thang'] = [
                        'text' => 'Hóa ' . $this->chiInfo['thang']['title'],
                        'number' => $this->chiInfo['thang']['id']
                    ];
                    $daHoa = true;
                }
            }

            /**
             * Chính Hóa
             * 2 trụ có chi là KIM
             * Thiên can Ngày không được xung với thiên can Tháng
             */
            if (!$daHoa && (($this->chiInfo['nam']['name'] == 'kim' && $this->chiInfo['thang']['name'] == 'kim') ||
                    (($this->chiInfo['nam']['name'] == 'kim' && $this->chiInfo['thang']['name'] == 'tho')) ||
                    ($this->chiInfo['nam']['name'] == 'tho' && $this->chiInfo['thang']['name'] == 'kim') ||
                    ($this->chiInfo['ngay']['name'] == 'kim'))) {
                $results['tru_nam'] = $results['tru_thang'] = [
                    'text' => 'Hóa kim',
                    'number' => 1
                ];
            }
            /**
             * Phu tòng thê hóa -> Hóa mộc
             * 1 trong 2 trụ có chi là mộc
             * Can chi bên cạnh đều là mộc
             * Có Ất, Đinh ở can tàng
             */
            if (!$daHoa && (($this->chiInfo['nam']['name'] == 'moc' || $this->chiInfo['thang']['name'] == 'moc') &&
                    ($this->canInfo['thang']['name'] == 'moc' && $this->chiInfo['ngay']['name'] == 'moc') &&
                    (in_array('at', $canTangArrUni) || in_array('dinh', $canTangArrUni)))) {
                $flagPha = false;
                if ($this->canThangSlug == 'at' && $this->canInfo['thang']['name'] == 'kim') {
                    // Khắc phải là Kim ở can ngày
                    // tính vương cho Thằng Kim
                    // chi ngày kim|thủy và chi giờ là kim|thủy
                    if ($this->chiInfo['ngay']['name'] == 'kim' && $this->canInfo['gio']['name'] == 'kim' && !in_array($this->chiInfo['gio']['name'], ['thuy', 'hoa'])) {
                        $flagPha = true;
                    }
                    if ($this->chiInfo['ngay']['name'] == 'thuy' && $this->canInfo['gio']['name'] == 'thuy' && !in_array($this->chiInfo['gio']['name'], ['moc', 'tho'])) {
                        $flagPha = true;
                    }
                    if ($this->chiInfo['ngay']['name'] == 'thuy' && $this->canInfo['gio']['name'] == 'thuy' && $this->chiInfo['thang']['name'] == 'thuy') {
                        $flagPha = true;
                    }
                    if ($this->chiInfo['ngay']['name'] == 'kim' && $this->canInfo['gio']['name'] == 'kim' && $this->chiInfo['thang']['name'] == 'kim') {
                        $flagPha = true;
                    }
                }

                if ($this->canThangSlug == 'canh' && $this->canInfo['thang']['name'] == 'hoa') {
                    // Khắc phải là Hỏa ở can ngày
                    // tính vương cho Thằng Hỏa
                    // chi ngày mộc|hỏa và chi giờ là mộc|hỏa
                    if ($this->chiInfo['ngay']['name'] == 'hoa' && $this->canInfo['gio']['name'] == 'hoa' && !in_array($this->chiInfo['gio']['name'], ['thuy', 'tho'])) {
                        $flagPha = true;
                    }
                    if ($this->chiInfo['ngay']['name'] == 'moc' && $this->canInfo['gio']['name'] == 'moc' && !in_array($this->chiInfo['gio']['name'], ['hoa', 'thuy'])) {
                        $flagPha = true;
                    }
                    if ($this->chiInfo['ngay']['name'] == 'hoa' && $this->canInfo['gio']['name'] == 'hoa' && $this->chiInfo['thang']['name'] == 'hoa') {
                        $flagPha = true;
                    }
                    if ($this->chiInfo['ngay']['name'] == 'moc' && $this->canInfo['gio']['name'] == 'moc' && $this->chiInfo['thang']['name'] == 'moc') {
                        $flagPha = true;
                    }
                }
                if (!$flagPha) {
                    $results['tru_nam'] = $results['tru_thang'] = [
                        'text' => 'Hóa mộc',
                        'number' => 3
                    ];
                }
            }

            /**
             * Thê tòng phu hóa -> Hóa kim
             * 1 trong 2 tru co chi kim
             * Can chi bên cạnh đều là kim
             * Có Canh, Mậu ở can tàng
             */
            if (!$daHoa && (($this->chiInfo['nam']['name'] == 'kim' || $this->chiInfo['thang']['name'] == 'kim') &&
                    ($this->canInfo['thang']['name'] == 'kim' || $this->chiInfo['ngay']['name'] == 'kim') &&
                    (in_array('canh', $canTangArrUni) || in_array('mau', $canTangArrUni)))) {
                $results['tru_nam'] = $results['tru_thang'] = [
                    'text' => 'Hóa kim',
                    'number' => 1
                ];
            }

            // ----------------------------------- Xét địa chi hợp hóa -----------------------------------
            // 1: kim, 2: thuy, 3: moc, 4: hoa, 5: tho
            // Nếu ngũ hành hóa của địa chi không phải là Mộc, Kim thì thiên can ko xét hóa
            if (!empty($diaChiHopHoa['tam_hop']['tru_thang']) && !in_array($diaChiHopHoa['tam_hop']['tru_thang']['number'], [3, 1])) {
                unset($results['tru_nam']);
                unset($results['tru_thang']);
            } else {
                // ----- Tam Hợp -----
                if (!empty($results) && !empty($diaChiHopHoa['tam_hop']['tru_thang']) && $diaChiHopHoa['tam_hop']['tru_thang']['number'] == 1) { // HOA KIM
                    $results['tru_nam'] = $results['tru_thang'] = [
                        'text' => 'Hóa Kim',
                        'number' => 1
                    ];
                }
                if (!empty($results) && !empty($diaChiHopHoa['tam_hop']['tru_thang']) && $diaChiHopHoa['tam_hop']['tru_thang']['number'] == 3) { // HOA MOC
                    $results['tru_nam'] = $results['tru_thang'] = [
                        'text' => 'Hóa mộc',
                        'number' => 3
                    ];
                }
                // ----- Tam Hội -----
                if (!empty($results) && !empty($diaChiHopHoa['tam_hoi']['tru_thang']) && $diaChiHopHoa['tam_hoi']['tru_thang']['number'] == 1) { // HOA KIM
                    $results['tru_nam'] = $results['tru_thang'] = [
                        'text' => 'Hóa Kim',
                        'number' => 1
                    ];
                }
                if (!empty($results) && !empty($diaChiHopHoa['tam_hoi']['tru_thang']) && $diaChiHopHoa['tam_hoi']['tru_thang']['number'] == 3) { // HOA MOC
                    $results['tru_nam'] = $results['tru_thang'] = [
                        'text' => 'Hóa mộc',
                        'number' => 3
                    ];
                }
                // ----- Lục Hợp -----
                if (!empty($results) && !empty($diaChiHopHoa['luc_hop']['tru_thang']) && $diaChiHopHoa['luc_hop']['tru_thang']['number'] == 1) { // HOA KIM
                    $results['tru_nam'] = $results['tru_thang'] = [
                        'text' => 'Hóa Kim',
                        'number' => 1
                    ];
                }
                if (!empty($results) && !empty($diaChiHopHoa['luc_hop']['tru_thang']) && $diaChiHopHoa['luc_hop']['tru_thang']['number'] == 3) { // HOA MOC
                    $results['tru_nam'] = $results['tru_thang'] = [
                        'text' => 'Hóa Mộc',
                        'number' => 3
                    ];
                }
                // ----- Bán tam hợp -----
                if (!empty($results) && !empty($diaChiHopHoa['ban_tam_hop']['tru_thang']) && $diaChiHopHoa['ban_tam_hop']['tru_thang']['number'] == 1) { // HOA KIM
                    $results['tru_nam'] = $results['tru_thang'] = [
                        'text' => 'Hóa Kim',
                        'number' => 1
                    ];
                }
                if (!empty($results) && !empty($diaChiHopHoa['ban_tam_hop']['tru_thang']) && $diaChiHopHoa['ban_tam_hop']['tru_thang']['number'] == 3) { // HOA MOC
                    $results['tru_nam'] = $results['tru_thang'] = [
                        'text' => 'Hóa Mộc',
                        'number' => 3
                    ];
                }
                // ----- Bán tam mộ -----
                if (!empty($results) && !empty($diaChiHopHoa['ban_tam_mo']['tru_thang']) && $diaChiHopHoa['ban_tam_mo']['tru_thang']['number'] == 1) { // HOA KIM
                    $results['tru_nam'] = $results['tru_thang'] = [
                        'text' => 'Hóa Kim',
                        'number' => 1
                    ];
                }
                if (!empty($results) && !empty($diaChiHopHoa['ban_tam_mo']['tru_thang']) && $diaChiHopHoa['ban_tam_mo']['tru_thang']['number'] == 3) { // HOA MOC
                    $results['tru_nam'] = $results['tru_thang'] = [
                        'text' => 'Hóa Mộc',
                        'number' => 3
                    ];
                }
            }
        }
        // BINH VS TAN
        // 1: kim, 2: thuy, 3: moc, 4: hoa, 5: tho
        if (($this->canNamSlug == 'binh' && $this->canThangSlug == 'tan' && $this->canThangSlug != 'binh') || ($this->canNamSlug == 'tan' && $this->canThangSlug == 'binh' && $this->canNgaySlug != 'tan')) {

            // Hóa mạnh nhất
            // xung - xung, khac - khac, xung - khac, khac - xung
            $daHoa = false;
            if (($this->chiNamSlug != $this->diaChiLucXung[$this->chiThangSlug] && $this->chiNgaySlug != $this->diaChiLucXung[$this->chiThangSlug]) ||
                ($this->chiInfo['nam']['name'] != $this->biKhac($this->chiInfo['thang']['name']) && $this->chiInfo['ngay']['name'] != $this->biKhac($this->chiInfo['thang']['name'])) ||
                ($this->chiNamSlug != $this->diaChiLucXung[$this->chiThangSlug] && $this->chiInfo['ngay']['name'] != $this->biKhac($this->chiInfo['thang']['name'])) ||
                ($this->chiInfo['nam']['name'] != $this->biKhac($this->chiInfo['thang']['name']) && $this->chiNgaySlug != $this->diaChiLucXung[$this->chiThangSlug])) {
                if (in_array($this->chiInfo['thang']['name'], ['thuy', 'kim', 'hoa'])) {
                    $results['tru_nam'] = $results['tru_thang'] = [
                        'text' => 'Hóa ' . $this->chiInfo['thang']['title'],
                        'number' => $this->chiInfo['thang']['id']
                    ];
                    $daHoa = true;
                }
            }

            /**
             * Chính Hóa
             * 2 trụ có chi là Thủy
             */
            if (!$daHoa && (($this->chiInfo['nam']['name'] == 'thuy' && $this->chiInfo['thang']['name'] == 'thuy') ||
                    (($this->chiInfo['nam']['name'] == 'kim' && $this->chiInfo['thang']['name'] == 'thuy')) ||
                    ($this->chiInfo['nam']['name'] == 'thuy' && $this->chiInfo['thang']['name'] == 'kim') ||
                    ($this->chiInfo['ngay']['name'] == 'thuy'))) {
                $results['tru_nam'] = $results['tru_thang'] = [
                    'text' => 'Hóa thủy',
                    'number' => 2
                ];
            }
            /**
             * Phu tòng thê hóa -> Hóa Kim
             * 1 trong 2 trụ có chi là Kim
             * Can chi bên cạnh đều là Kim
             * Có Bính, Giáp ở can tàng
             */
            if (!$daHoa && (($this->chiInfo['nam']['name'] == 'kim' || $this->chiInfo['thang']['name'] == 'kim') &&
                    ($this->canInfo['thang']['name'] == 'kim' && $this->chiInfo['ngay']['name'] == 'kim') &&
                    (in_array('tan', $canTangArrUni) || in_array('quy', $canTangArrUni)))) {
                $flagPha = false;
                if ($this->canThangSlug == 'binh' && $this->canInfo['thang']['name'] == 'thuy') { // thủy phá bính(Hỏa)
                    // Khắc phải là Hỏa ở can ngày
                    // tính vương cho Thằng Hỏa
                    // chi ngày Mộc|Hỏa và chi giờ là Mộc|hỏa
                    if ($this->chiInfo['ngay']['name'] == 'kim' && $this->canInfo['gio']['name'] == 'kim' && !in_array($this->chiInfo['gio']['name'], ['thuy', 'hoa'])) {
                        $flagPha = true;
                    }
                    if ($this->chiInfo['ngay']['name'] == 'thuy' && $this->canInfo['gio']['name'] == 'thuy' && !in_array($this->chiInfo['gio']['name'], ['moc', 'tho'])) {
                        $flagPha = true;
                    }
                    if ($this->chiInfo['ngay']['name'] == 'thuy' && $this->canInfo['gio']['name'] == 'thuy' && $this->chiInfo['thang']['name'] == 'thuy') {
                        $flagPha = true;
                    }
                    if ($this->chiInfo['ngay']['name'] == 'kim' && $this->canInfo['gio']['name'] == 'kim' && $this->chiInfo['thang']['name'] == 'kim') {
                        $flagPha = true;
                    }
                }

                if ($this->canThangSlug == 'tan' && $this->canInfo['thang']['name'] == 'hoa') { // hỏa phá tân(kim)
                    // Khắc phải là Hỏa ở can ngày
                    // tính vương cho Thằng Hỏa
                    // chi ngày mộc|hỏa và chi giờ là mộc|hỏa
                    if ($this->chiInfo['ngay']['name'] == 'hoa' && $this->canInfo['gio']['name'] == 'hoa' && !in_array($this->chiInfo['gio']['name'], ['thuy', 'tho'])) {
                        $flagPha = true;
                    }
                    if ($this->chiInfo['ngay']['name'] == 'moc' && $this->canInfo['gio']['name'] == 'moc' && !in_array($this->chiInfo['gio']['name'], ['hoa', 'thuy'])) {
                        $flagPha = true;
                    }
                    if ($this->chiInfo['ngay']['name'] == 'hoa' && $this->canInfo['gio']['name'] == 'hoa' && $this->chiInfo['thang']['name'] == 'hoa') {
                        $flagPha = true;
                    }
                    if ($this->chiInfo['ngay']['name'] == 'moc' && $this->canInfo['gio']['name'] == 'moc' && $this->chiInfo['thang']['name'] == 'moc') {
                        $flagPha = true;
                    }
                }
                if (!$flagPha) {
                    $results['tru_nam'] = $results['tru_thang'] = [
                        'text' => 'Hóa kim',
                        'number' => 1
                    ];
                }
            }

            /**
             * Thê tòng phu hóa -> Hóa hỏa
             * 1 trong 2 tru co chi hỏa
             * Can chi bên cạnh đều là hỏa
             * Có Bính, Giáp ở can tàng
             */
            if (!$daHoa && (($this->chiInfo['nam']['name'] == 'hoa' || $this->chiInfo['thang']['name'] == 'hoa') &&
                    ($this->canInfo['thang']['name'] == 'hoa' || $this->chiInfo['ngay']['name'] == 'hoa') &&
                    (in_array('binh', $canTangArrUni) || in_array('giap', $canTangArrUni)))) {
                $results['tru_nam'] = $results['tru_thang'] = [
                    'text' => 'Hóa hỏa',
                    'number' => 4
                ];
            }

            // ----------------------------------- Xét địa chi hợp hóa -----------------------------------
            // 1: kim, 2: thuy, 3: moc, 4: hoa, 5: tho
            // Nếu ngũ hành hóa của địa chi không phải là Kim, Thủy, Hỏa thì thiên can ko xét hóa
            if (!empty($diaChiHopHoa['tam_hop']['tru_thang']) && !in_array($diaChiHopHoa['tam_hop']['tru_thang']['number'], [1, 2, 4])) {
                unset($results['tru_nam']);
                unset($results['tru_thang']);
            } else {
                // ----- Tam hợp -----
                if (!empty($results) && !empty($diaChiHopHoa['tam_hop']['tru_thang']) && $diaChiHopHoa['tam_hop']['tru_thang']['number'] == 2) { // HOA THUY
                    $results['tru_nam'] = $results['tru_thang'] = [
                        'text' => 'Hóa Thủy',
                        'number' => 2
                    ];
                }
                if (!empty($results) && !empty($diaChiHopHoa['tam_hop']['tru_thang']) && $diaChiHopHoa['tam_hop']['tru_thang']['number'] == 1) { // HOA KIM
                    $results['tru_nam'] = $results['tru_thang'] = [
                        'text' => 'Hóa Kim',
                        'number' => 1
                    ];
                }
                if (!empty($results) && !empty($diaChiHopHoa['tam_hop']['tru_thang']) && $diaChiHopHoa['tam_hop']['tru_thang']['number'] == 4) { // HOA HOA
                    $results['tru_nam'] = $results['tru_thang'] = [
                        'text' => 'Hóa Hỏa',
                        'number' => 4
                    ];
                }
                // ----- Tam mộ -----
                if (!empty($results) && !empty($diaChiHopHoa['tam_hoi']['tru_thang']) && $diaChiHopHoa['tam_hoi']['tru_thang']['number'] == 2) { // HOA THUY
                    $results['tru_nam'] = $results['tru_thang'] = [
                        'text' => 'Hóa Thủy',
                        'number' => 2
                    ];
                }
                if (!empty($results) && !empty($diaChiHopHoa['tam_hoi']['tru_thang']) && $diaChiHopHoa['tam_hoi']['tru_thang']['number'] == 1) { // HOA KIM
                    $results['tru_nam'] = $results['tru_thang'] = [
                        'text' => 'Hóa Kim',
                        'number' => 1
                    ];
                }
                if (!empty($results) && !empty($diaChiHopHoa['tam_hoi']['tru_thang']) && $diaChiHopHoa['tam_hoi']['tru_thang']['number'] == 4) { // HOA HOA
                    $results['tru_nam'] = $results['tru_thang'] = [
                        'text' => 'Hóa Hỏa',
                        'number' => 4
                    ];
                }
                // ----- Lục hợp -----
                if (!empty($results) && !empty($diaChiHopHoa['luc_hop']['tru_thang']) && $diaChiHopHoa['luc_hop']['tru_thang']['number'] == 2) { // HOA THUY
                    $results['tru_nam'] = $results['tru_thang'] = [
                        'text' => 'Hóa Thủy',
                        'number' => 2
                    ];
                }
                if (!empty($results) && !empty($diaChiHopHoa['luc_hop']['tru_thang']) && $diaChiHopHoa['luc_hop']['tru_thang']['number'] == 1) { // HOA KIM
                    $results['tru_nam'] = $results['tru_thang'] = [
                        'text' => 'Hóa Kim',
                        'number' => 1
                    ];
                }
                if (!empty($results) && !empty($diaChiHopHoa['luc_hop']['tru_thang']) && $diaChiHopHoa['luc_hop']['tru_thang']['number'] == 4) { // HOA HOA
                    $results['tru_nam'] = $results['tru_thang'] = [
                        'text' => 'Hóa Hỏa',
                        'number' => 4
                    ];
                }
                // ----- Bán tam hợp -----
                if (!empty($results) && !empty($diaChiHopHoa['ban_tam_hop']['tru_thang']) && $diaChiHopHoa['ban_tam_hop']['tru_thang']['number'] == 2) { // HOA THUY
                    $results['tru_nam'] = $results['tru_thang'] = [
                        'text' => 'Hóa Thủy',
                        'number' => 2
                    ];
                }
                if (!empty($results) && !empty($diaChiHopHoa['ban_tam_hop']['tru_thang']) && $diaChiHopHoa['ban_tam_hop']['tru_thang']['number'] == 1) { // HOA KIM
                    $results['tru_nam'] = $results['tru_thang'] = [
                        'text' => 'Hóa Kim',
                        'number' => 1
                    ];
                }
                if (!empty($results) && !empty($diaChiHopHoa['ban_tam_hop']['tru_thang']) && $diaChiHopHoa['ban_tam_hop']['tru_thang']['number'] == 4) { // HOA HOA
                    $results['tru_nam'] = $results['tru_thang'] = [
                        'text' => 'Hóa Hỏa',
                        'number' => 4
                    ];
                }
                // ----- Bán tam mộ -----
                if (!empty($results) && !empty($diaChiHopHoa['ban_tam_mo']['tru_thang']) && $diaChiHopHoa['ban_tam_mo']['tru_thang']['number'] == 2) { // HOA THUY
                    $results['tru_nam'] = $results['tru_thang'] = [
                        'text' => 'Hóa Thủy',
                        'number' => 2
                    ];
                }
                if (!empty($results) && !empty($diaChiHopHoa['ban_tam_mo']['tru_thang']) && $diaChiHopHoa['ban_tam_mo']['tru_thang']['number'] == 1) { // HOA KIM
                    $results['tru_nam'] = $results['tru_thang'] = [
                        'text' => 'Hóa Kim',
                        'number' => 1
                    ];
                }
                if (!empty($results) && !empty($diaChiHopHoa['ban_tam_mo']['tru_thang']) && $diaChiHopHoa['ban_tam_mo']['tru_thang']['number'] == 4) { // HOA HOA
                    $results['tru_nam'] = $results['tru_thang'] = [
                        'text' => 'Hóa Hỏa',
                        'number' => 4
                    ];
                }
            }
        }
        // ĐINH VS NHÂM
        // 1: kim, 2: thuy, 3: moc, 4: hoa, 5: tho
        if (($this->canNamSlug == 'dinh' && $this->canThangSlug == 'nham' && $this->canNgaySlug != 'dinh') ||
            ($this->canNamSlug == 'nham' && $this->canThangSlug == 'dinh' && $this->canNgaySlug != 'nham')) {
            // Hóa mạnh nhất
            // xung - xung, khac - khac, xung - khac, khac - xung
            $daHoa = false;
            if (($this->chiNamSlug != $this->diaChiLucXung[$this->chiThangSlug] && $this->chiNgaySlug != $this->diaChiLucXung[$this->chiThangSlug]) ||
                ($this->chiInfo['nam']['name'] != $this->biKhac($this->chiInfo['thang']['name']) && $this->chiInfo['ngay']['name'] != $this->biKhac($this->chiInfo['thang']['name'])) ||
                ($this->chiNamSlug != $this->diaChiLucXung[$this->chiThangSlug] && $this->chiInfo['ngay']['name'] != $this->biKhac($this->chiInfo['thang']['name'])) ||
                ($this->chiInfo['nam']['name'] != $this->biKhac($this->chiInfo['thang']['name']) && $this->chiNgaySlug != $this->diaChiLucXung[$this->chiThangSlug])) {
                if (in_array($this->chiInfo['thang']['name'], ['thuy', 'moc', 'hoa'])) {
                    $results['tru_nam'] = $results['tru_thang'] = [
                        'text' => 'Hóa ' . $this->chiInfo['thang']['title'],
                        'number' => $this->chiInfo['thang']['id']
                    ];
                    $daHoa = true;
                }
            }

            /**
             * Chính Hóa
             * 2 trụ có chi là Mộc
             */
            if (!$daHoa && (($this->chiInfo['nam']['name'] == 'moc' && $this->chiInfo['thang']['name'] == 'moc') ||
                    (($this->chiInfo['nam']['name'] == 'moc' && $this->chiInfo['thang']['name'] == 'thuy')) ||
                    ($this->chiInfo['nam']['name'] == 'thuy' && $this->chiInfo['thang']['name'] == 'moc'))) {
                $results['tru_nam'] = $results['tru_thang'] = [
                    'text' => 'Hóa mộc',
                    'number' => 3
                ];
            }
            /**
             * Phu tòng thê hóa -> Hóa Hỏa
             * 1 trong 2 trụ có chi là Hỏa
             * Can chi bên cạnh đều là Hỏa
             * Có Bính, Giáp ở can tàng
             */
            if (!$daHoa && (($this->chiInfo['nam']['name'] == 'hoa' || $this->chiInfo['thang']['name'] == 'hoa') &&
                    ($this->canInfo['thang']['name'] == 'hoa' && $this->chiInfo['ngay']['name'] == 'hoa') &&
                    (in_array('dinh', $canTangArrUni) || in_array('at', $canTangArrUni)))) {
                $flagPha = false;
                if ($this->canThangSlug == 'dinh' && $this->canInfo['thang']['name'] == 'thuy') { // thủy phá bính(Hỏa)
                    // Khắc phải là Thủy ở can ngày
                    // tính vương cho Thằng Thủy
                    // chi ngày Kim|Thủy và chi giờ là Kim|Thủy
                    if ($this->chiInfo['ngay']['name'] == 'kim' && $this->canInfo['gio']['name'] == 'kim' && !in_array($this->chiInfo['gio']['name'], ['thuy', 'hoa'])) {
                        $flagPha = true;
                    }
                    if ($this->chiInfo['ngay']['name'] == 'thuy' && $this->canInfo['gio']['name'] == 'thuy' && !in_array($this->chiInfo['gio']['name'], ['moc', 'tho'])) {
                        $flagPha = true;
                    }
                    if ($this->chiInfo['ngay']['name'] == 'kim' && $this->canInfo['gio']['name'] == 'kim' && $this->chiInfo['thang']['name'] == 'kim') {
                        $flagPha = true;
                    }
                    if ($this->chiInfo['ngay']['name'] == 'thuy' && $this->canInfo['gio']['name'] == 'thuy' && $this->chiInfo['thang']['name'] == 'thuy') {
                        $flagPha = true;
                    }
                }

                if ($this->canThangSlug == 'nham' && $this->canInfo['thang']['name'] == 'tho') { // Thổ phá nhâm(thủy)
                    // Khắc phải là Thổ ở can ngày
                    // tính vương cho Thằng Thổ
                    // chi ngày thổ|hỏa và chi giờ là thổ|hỏa
                    if ($this->chiInfo['ngay']['name'] == 'tho' && $this->canInfo['gio']['name'] == 'tho' && !in_array($this->chiInfo['gio']['name'], ['kim', 'moc'])) {
                        $flagPha = true;
                    }
                    if ($this->chiInfo['ngay']['name'] == 'hoa' && $this->canInfo['gio']['name'] == 'hoa' && !in_array($this->chiInfo['gio']['name'], ['tho', 'thuy'])) {
                        $flagPha = true;
                    }
                    if ($this->chiInfo['ngay']['name'] == 'hoa' && $this->canInfo['gio']['name'] == 'hoa' && $this->chiInfo['thang']['name'] == 'hoa') {
                        $flagPha = true;
                    }
                    if ($this->chiInfo['ngay']['name'] == 'moc' && $this->canInfo['gio']['name'] == 'moc' && $this->chiInfo['thang']['name'] == 'moc') {
                        $flagPha = true;
                    }
                }
                if (!$flagPha) {
                    $results['tru_nam'] = $results['tru_thang'] = [
                        'text' => 'Hóa hỏa',
                        'number' => 4
                    ];
                }
            }

            /**
             * Thê tòng phu hóa -> Hóa Thủy
             * 1 trong 2 tru co chi Thủy
             * Can chi bên cạnh đều là Thủy
             * Có Bính, Giáp ở can tàng
             */
            if (!$daHoa && (($this->chiInfo['nam']['name'] == 'thuy' || $this->chiInfo['thang']['name'] == 'thuy') &&
                    ($this->canInfo['thang']['name'] == 'thuy' || $this->chiInfo['ngay']['name'] == 'thuy') &&
                    (in_array('nham', $canTangArrUni) || in_array('canh', $canTangArrUni)))) {
                $results['tru_nam'] = $results['tru_thang'] = [
                    'text' => 'Hóa thủy',
                    'number' => 2
                ];
            }

            // ----------------------------------- Xét địa chi hợp hóa -----------------------------------
            // 1: kim, 2: thuy, 3: moc, 4: hoa, 5: tho
            // Nếu ngũ hành hóa của địa chi không phải là Mộc, Hỏa, Thủy thì thiên can ko xét hóa
            if (!empty($diaChiHopHoa['tam_hop']['tru_thang']) && !in_array($diaChiHopHoa['tam_hop']['tru_thang']['number'], [2, 3, 4])) {
                unset($results['tru_nam']);
                unset($results['tru_thang']);
            } else {
                // ----- Tam hợp -----
                if (!empty($results) && !empty($diaChiHopHoa['tam_hop']['tru_thang']) && $diaChiHopHoa['tam_hop']['tru_thang']['number'] == 3) { // HOA MOC
                    $results['tru_nam'] = $results['tru_thang'] = [
                        'text' => 'Hóa Mộc',
                        'number' => 3
                    ];
                }
                if (!empty($results) && !empty($diaChiHopHoa['tam_hop']['tru_thang']) && $diaChiHopHoa['tam_hop']['tru_thang']['number'] == 4) { // HOA HOA
                    $results['tru_nam'] = $results['tru_thang'] = [
                        'text' => 'Hóa Hỏa',
                        'number' => 4
                    ];
                }
                if (!empty($results) && !empty($diaChiHopHoa['tam_hop']['tru_thang']) && $diaChiHopHoa['tam_hop']['tru_thang']['number'] == 2) { // HOA THUY
                    $results['tru_nam'] = $results['tru_thang'] = [
                        'text' => 'Hóa Thủy',
                        'number' => 2
                    ];
                }
                // ----- Tam mộ -----
                if (!empty($results) && !empty($diaChiHopHoa['tam_hoi']['tru_thang']) && $diaChiHopHoa['tam_hoi']['tru_thang']['number'] == 3) { // HOA MOC
                    $results['tru_nam'] = $results['tru_thang'] = [
                        'text' => 'Hóa Mộc',
                        'number' => 3
                    ];
                }
                if (!empty($results) && !empty($diaChiHopHoa['tam_hoi']['tru_thang']) && $diaChiHopHoa['tam_hoi']['tru_thang']['number'] == 4) { // HOA HOA
                    $results['tru_nam'] = $results['tru_thang'] = [
                        'text' => 'Hóa Hỏa',
                        'number' => 4
                    ];
                }
                if (!empty($results) && !empty($diaChiHopHoa['tam_hoi']['tru_thang']) && $diaChiHopHoa['tam_hoi']['tru_thang']['number'] == 2) { // HOA THUY
                    $results['tru_nam'] = $results['tru_thang'] = [
                        'text' => 'Hóa Thủy',
                        'number' => 2
                    ];
                }
                // ----- Lục hợp -----
                if (!empty($results) && !empty($diaChiHopHoa['luc_hop']['tru_thang']) && $diaChiHopHoa['luc_hop']['tru_thang']['number'] == 3) { // HOA MOC
                    $results['tru_nam'] = $results['tru_thang'] = [
                        'text' => 'Hóa Mộc',
                        'number' => 3
                    ];
                }
                if (!empty($results) && !empty($diaChiHopHoa['luc_hop']['tru_thang']) && $diaChiHopHoa['luc_hop']['tru_thang']['number'] == 4) { // HOA HOA
                    $results['tru_nam'] = $results['tru_thang'] = [
                        'text' => 'Hóa Hỏa',
                        'number' => 4
                    ];
                }
                if (!empty($results) && !empty($diaChiHopHoa['luc_hop']['tru_thang']) && $diaChiHopHoa['luc_hop']['tru_thang']['number'] == 2) { // HOA THUY
                    $results['tru_nam'] = $results['tru_thang'] = [
                        'text' => 'Hóa Thủy',
                        'number' => 2
                    ];
                }
                // ----- Bán tam hợp -----
                if (!empty($results) && !empty($diaChiHopHoa['ban_tam_hop']['tru_thang']) && $diaChiHopHoa['ban_tam_hop']['tru_thang']['number'] == 3) { // HOA MOC
                    $results['tru_nam'] = $results['tru_thang'] = [
                        'text' => 'Hóa Mộc',
                        'number' => 3
                    ];
                }
                if (!empty($results) && !empty($diaChiHopHoa['ban_tam_hop']['tru_thang']) && $diaChiHopHoa['ban_tam_hop']['tru_thang']['number'] == 4) { // HOA HOA
                    $results['tru_nam'] = $results['tru_thang'] = [
                        'text' => 'Hóa Hỏa',
                        'number' => 4
                    ];
                }
                if (!empty($results) && !empty($diaChiHopHoa['ban_tam_hop']['tru_thang']) && $diaChiHopHoa['ban_tam_hop']['tru_thang']['number'] == 2) { // HOA THUY
                    $results['tru_nam'] = $results['tru_thang'] = [
                        'text' => 'Hóa Thủy',
                        'number' => 2
                    ];
                }
                // ----- Bán tam mộ -----
                if (!empty($results) && !empty($diaChiHopHoa['ban_tam_mo']['tru_thang']) && $diaChiHopHoa['ban_tam_mo']['tru_thang']['number'] == 3) { // HOA MOC
                    $results['tru_nam'] = $results['tru_thang'] = [
                        'text' => 'Hóa Mộc',
                        'number' => 3
                    ];
                }
                if (!empty($results) && !empty($diaChiHopHoa['ban_tam_mo']['tru_thang']) && $diaChiHopHoa['ban_tam_mo']['tru_thang']['number'] == 4) { // HOA HOA
                    $results['tru_nam'] = $results['tru_thang'] = [
                        'text' => 'Hóa Hỏa',
                        'number' => 4
                    ];
                }
                if (!empty($results) && !empty($diaChiHopHoa['ban_tam_mo']['tru_thang']) && $diaChiHopHoa['ban_tam_mo']['tru_thang']['number'] == 2) { // HOA THUY
                    $results['tru_nam'] = $results['tru_thang'] = [
                        'text' => 'Hóa Thủy',
                        'number' => 2
                    ];
                }
            }
        }
        // MAU VS QUY
        // 1: kim, 2: thuy, 3: moc, 4: hoa, 5: tho
        if (($this->canNamSlug == 'mau' && $this->canThangSlug == 'quy' && $this->canNgaySlug != 'mau') || ($this->canNamSlug == 'quy' && $this->canThangSlug == 'mau' && $this->canNgaySlug != 'quy')) {
            // Hóa mạnh nhất
            // xung - xung, khac - khac, xung - khac, khac - xung
            $daHoa = false;
            if (($this->chiNamSlug != $this->diaChiLucXung[$this->chiThangSlug] && $this->chiNgaySlug != $this->diaChiLucXung[$this->chiThangSlug]) ||
                ($this->chiInfo['nam']['name'] != $this->biKhac($this->chiInfo['thang']['name']) && $this->chiInfo['ngay']['name'] != $this->biKhac($this->chiInfo['thang']['name'])) ||
                ($this->chiNamSlug != $this->diaChiLucXung[$this->chiThangSlug] && $this->chiInfo['ngay']['name'] != $this->biKhac($this->chiInfo['thang']['name'])) ||
                ($this->chiInfo['nam']['name'] != $this->biKhac($this->chiInfo['thang']['name']) && $this->chiNgaySlug != $this->diaChiLucXung[$this->chiThangSlug])) {
                if (in_array($this->chiInfo['thang']['name'], ['hoa', 'thuy', 'tho'])) {
                    $results['tru_nam'] = $results['tru_thang'] = [
                        'text' => 'Hóa ' . $this->chiInfo['thang']['title'],
                        'number' => $this->chiInfo['thang']['id']
                    ];
                    $daHoa = true;
                }
            }
            /**
             * Chính Hóa
             * 2 trụ có chi là HỎA
             */
            if (!$daHoa && (($this->chiInfo['nam']['name'] == 'hoa' && $this->chiInfo['thang']['name'] == 'hoa') ||
                    (($this->chiInfo['nam']['name'] == 'hoa' && $this->chiInfo['thang']['name'] == 'moc')) ||
                    ($this->chiInfo['nam']['name'] == 'moc' && $this->chiInfo['thang']['name'] == 'hoa') ||
                    ($this->chiInfo['thang']['name'] == 'hoa'))) {
                $results['tru_nam'] = $results['tru_thang'] = [
                    'text' => 'Hóa Hỏa',
                    'number' => 4
                ];
            }
            /**
             * Phu tòng thê hóa -> Hóa Thủy
             * 1 trong 2 trụ có chi là Thủy
             * Can chi bên cạnh đều là Thủy
             * Có Quý, Canh ở can tàng
             */
            if (!$daHoa && (($this->chiInfo['nam']['name'] == 'thuy' || $this->chiInfo['thang']['name'] == 'thuy') &&
                    ($this->canInfo['thang']['name'] == 'thuy' && $this->chiInfo['ngay']['name'] == 'thuy') &&
                    (in_array('quy', $canTangArrUni) || in_array('canh', $canTangArrUni)))) {
                $flagPha = false;
                if ($this->canThangSlug == 'mau' && $this->canInfo['thang']['name'] == 'moc') { // Mộc phá mậu(thổ)
                    // Khắc phải là Mộc ở can ngày
                    // tính vương cho Thằng Mộc
                    // chi ngày Mộc|Thủy và chi giờ là Mộc|Thủy
                    if ($this->chiInfo['ngay']['name'] == 'moc' && $this->canInfo['gio']['name'] == 'moc' && !in_array($this->chiInfo['gio']['name'], ['hoa', 'kim'])) {
                        $flagPha = true;
                    }
                    if ($this->chiInfo['ngay']['name'] == 'thuy' && $this->canInfo['gio']['name'] == 'thuy' && !in_array($this->chiInfo['gio']['name'], ['moc', 'tho'])) {
                        $flagPha = true;
                    }
                    if ($this->chiInfo['ngay']['name'] == 'moc' && $this->canInfo['gio']['name'] == 'moc' && $this->chiInfo['thang']['name'] == 'moc') {
                        $flagPha = true;
                    }
                    if ($this->chiInfo['ngay']['name'] == 'thuy' && $this->canInfo['gio']['name'] == 'thuy' && $this->chiInfo['thang']['name'] == 'thuy') {
                        $flagPha = true;
                    }
                }

                if ($this->canThangSlug == 'quy' && $this->canInfo['thang']['name'] == 'tho') { // Thổ phá quý(thủy)
                    // Khắc phải là Thổ ở can ngày
                    // tính vương cho Thằng Thổ
                    // chi ngày thổ|hỏa và chi giờ là thổ|hỏa
                    if ($this->chiInfo['ngay']['name'] == 'tho' && $this->canInfo['gio']['name'] == 'tho' && !in_array($this->chiInfo['gio']['name'], ['kim', 'moc'])) {
                        $flagPha = true;
                    }
                    if ($this->chiInfo['ngay']['name'] == 'hoa' && $this->canInfo['gio']['name'] == 'hoa' && !in_array($this->chiInfo['gio']['name'], ['tho', 'thuy'])) {
                        $flagPha = true;
                    }
                    if ($this->chiInfo['ngay']['name'] == 'hoa' && $this->canInfo['gio']['name'] == 'hoa' && $this->chiInfo['thang']['name'] == 'hoa') {
                        $flagPha = true;
                    }
                    if ($this->chiInfo['ngay']['name'] == 'moc' && $this->canInfo['gio']['name'] == 'moc' && $this->chiInfo['thang']['name'] == 'moc') {
                        $flagPha = true;
                    }
                }
                if (!$flagPha) {
                    $results['tru_nam'] = $results['tru_thang'] = [
                        'text' => 'Hóa Thủy',
                        'number' => 2
                    ];
                }
            }

            /**
             * Thê tòng phu hóa -> Hóa Thổ
             * 1 trong 2 tru co chi Thổ
             * Can chi bên cạnh đều là Thổ
             * Có Mậu, Bính ở can tàng
             */
            if (!$daHoa && (($this->chiInfo['nam']['name'] == 'tho' || $this->chiInfo['thang']['name'] == 'tho') &&
                    ($this->canInfo['thang']['name'] == 'tho' || $this->chiInfo['ngay']['name'] == 'tho') &&
                    (in_array('mau', $canTangArrUni) || in_array('binh', $canTangArrUni)))) {
                $results['tru_nam'] = $results['tru_thang'] = [
                    'text' => 'Hóa thổ',
                    'number' => 5
                ];
            }

            // ----------------------------------- Xét địa chi hợp hóa -----------------------------------
            // 1: kim, 2: thuy, 3: moc, 4: hoa, 5: tho
            // Nếu ngũ hành hóa của địa chi không phải là Hỏa, Thủy, Thổ thì thiên can ko xét hóa
            if (!empty($diaChiHopHoa['tam_hop']['tru_thang']) && !in_array($diaChiHopHoa['tam_hop']['tru_thang']['number'], [2, 4, 5])) {
                unset($results['tru_nam']);
                unset($results['tru_thang']);
            } else {
                // ----- Tam hợp -----
                if (!empty($results) && !empty($diaChiHopHoa['tam_hop']['tru_thang']) && $diaChiHopHoa['tam_hop']['tru_thang']['number'] == 4) { // HOA HOA
                    $results['tru_nam'] = $results['tru_thang'] = [
                        'text' => 'Hóa Hỏa',
                        'number' => 4
                    ];
                }
                if (!empty($results) && !empty($diaChiHopHoa['tam_hop']['tru_thang']) && $diaChiHopHoa['tam_hop']['tru_thang']['number'] == 2) { // HOA THUY
                    $results['tru_nam'] = $results['tru_thang'] = [
                        'text' => 'Hóa Thủy',
                        'number' => 2
                    ];
                }
                if (!empty($results) && !empty($diaChiHopHoa['tam_hop']['tru_thang']) && $diaChiHopHoa['tam_hop']['tru_thang']['number'] == 5) { // HOA THO
                    $results['tru_nam'] = $results['tru_thang'] = [
                        'text' => 'Hóa Thổ',
                        'number' => 5
                    ];
                }
                // ----- Tam mộ -----
                if (!empty($results) && !empty($diaChiHopHoa['tam_hoi']['tru_thang']) && $diaChiHopHoa['tam_hoi']['tru_thang']['number'] == 4) { // HOA HOA
                    $results['tru_nam'] = $results['tru_thang'] = [
                        'text' => 'Hóa Hỏa',
                        'number' => 4
                    ];
                }
                if (!empty($results) && !empty($diaChiHopHoa['tam_hoi']['tru_thang']) && $diaChiHopHoa['tam_hoi']['tru_thang']['number'] == 2) { // HOA THUY
                    $results['tru_nam'] = $results['tru_thang'] = [
                        'text' => 'Hóa Thủy',
                        'number' => 2
                    ];
                }
                if (!empty($results) && !empty($diaChiHopHoa['tam_hoi']['tru_thang']) && $diaChiHopHoa['tam_hoi']['tru_thang']['number'] == 5) { // HOA THO
                    $results['tru_nam'] = $results['tru_thang'] = [
                        'text' => 'Hóa Thổ',
                        'number' => 5
                    ];
                }
                // ----- Lục hợp -----
                if (!empty($results) && !empty($diaChiHopHoa['luc_hop']['tru_thang']) && $diaChiHopHoa['luc_hop']['tru_thang']['number'] == 4) { // HOA HOA
                    $results['tru_nam'] = $results['tru_thang'] = [
                        'text' => 'Hóa Hỏa',
                        'number' => 4
                    ];
                }
                if (!empty($results) && !empty($diaChiHopHoa['luc_hop']['tru_thang']) && $diaChiHopHoa['luc_hop']['tru_thang']['number'] == 2) { // HOA THUY
                    $results['tru_nam'] = $results['tru_thang'] = [
                        'text' => 'Hóa Thủy',
                        'number' => 2
                    ];
                }
                if (!empty($results) && !empty($diaChiHopHoa['luc_hop']['tru_thang']) && $diaChiHopHoa['luc_hop']['tru_thang']['number'] == 5) { // HOA THO
                    $results['tru_nam'] = $results['tru_thang'] = [
                        'text' => 'Hóa Thổ',
                        'number' => 5
                    ];
                }
                // ----- Bán tam hợp -----
                if (!empty($results) && !empty($diaChiHopHoa['ban_tam_hop']['tru_thang']) && $diaChiHopHoa['ban_tam_hop']['tru_thang']['number'] == 4) { // HOA HOA
                    $results['tru_nam'] = $results['tru_thang'] = [
                        'text' => 'Hóa Hỏa',
                        'number' => 4
                    ];
                }
                if (!empty($results) && !empty($diaChiHopHoa['ban_tam_hop']['tru_thang']) && $diaChiHopHoa['ban_tam_hop']['tru_thang']['number'] == 2) { // HOA THỦY
                    $results['tru_nam'] = $results['tru_thang'] = [
                        'text' => 'Hóa Thủy',
                        'number' => 2
                    ];
                }
                if (!empty($results) && !empty($diaChiHopHoa['ban_tam_hop']['tru_thang']) && $diaChiHopHoa['ban_tam_hop']['tru_thang']['number'] == 5) { // HOA THO
                    $results['tru_nam'] = $results['tru_thang'] = [
                        'text' => 'Hóa Thổ',
                        'number' => 5
                    ];
                }
                // ----- Bán tam mộ -----
                if (!empty($results) && !empty($diaChiHopHoa['ban_tam_mo']['tru_thang']) && $diaChiHopHoa['ban_tam_mo']['tru_thang']['number'] == 4) { // HOA HOA
                    $results['tru_nam'] = $results['tru_thang'] = [
                        'text' => 'Hóa Hỏa',
                        'number' => 4
                    ];
                }
                if (!empty($results) && !empty($diaChiHopHoa['ban_tam_mo']['tru_thang']) && $diaChiHopHoa['ban_tam_mo']['tru_thang']['number'] == 2) { // HOA THUY
                    $results['tru_nam'] = $results['tru_thang'] = [
                        'text' => 'Hóa Thủy',
                        'number' => 2
                    ];
                }
                if (!empty($results) && !empty($diaChiHopHoa['ban_tam_mo']['tru_thang']) && $diaChiHopHoa['ban_tam_mo']['tru_thang']['number'] == 5) { // HOA THO
                    $results['tru_nam'] = $results['tru_thang'] = [
                        'text' => 'Hóa Thổ',
                        'number' => 5
                    ];
                }
            }
        }

        // ** ------------------------------------- THANG + NGAY ------------------------------------- **/
        // GIAP VS KY
        if (($this->canThangSlug == 'giap' && $this->canNgaySlug == 'ky' && $this->canNamSlug != 'ky') ||
            ($this->canThangSlug == 'ky' && $this->canNgaySlug == 'giap' && $this->canNamSlug != 'giap') ||
            ($this->canThangSlug == 'ky' && $this->canNgaySlug == 'giap' && $this->canGioSlug != 'ky') ||
            ($this->canThangSlug == 'giap' && $this->canNgaySlug == 'ky' && $this->canGioSlug != 'giap')) {

            // Hóa mạnh nhất
            // xung - xung, khac - khac, xung - khac, khac - xung
            $daHoa = false;
            if (($this->chiNamSlug != $this->diaChiLucXung[$this->chiThangSlug] && $this->chiNgaySlug != $this->diaChiLucXung[$this->chiThangSlug]) ||
                ($this->chiInfo['nam']['name'] != $this->biKhac($this->chiInfo['thang']['name']) && $this->chiInfo['ngay']['name'] != $this->biKhac($this->chiInfo['thang']['name'])) ||
                ($this->chiNamSlug != $this->diaChiLucXung[$this->chiThangSlug] && $this->chiInfo['ngay']['name'] != $this->biKhac($this->chiInfo['thang']['name'])) ||
                ($this->chiInfo['nam']['name'] != $this->biKhac($this->chiInfo['thang']['name']) && $this->chiNgaySlug != $this->diaChiLucXung[$this->chiThangSlug])) {
                if (in_array($this->chiInfo['thang']['name'], ['tho', 'moc'])) {
                    $results['tru_thang'] = $results['tru_ngay'] = [
                        'text' => 'Hóa ' . $this->chiInfo['thang']['title'],
                        'number' => $this->chiInfo['thang']['id']
                    ];
                    $daHoa = true;
                }
            }
            /**
             * Chính Hóa
             * 2 trụ có chi là Thổ
             * Thiên can Ngày không được xung với thiên can Tháng
             */
            if (!$daHoa && (($this->chiInfo['nam']['name'] == 'tho' && $this->chiInfo['thang']['name'] == 'tho') ||
                    ($this->chiInfo['nam']['name'] == 'tho' && $this->chiInfo['thang']['name'] == 'hoa') ||
                    ($this->chiInfo['nam']['name'] == 'hoa' && $this->chiInfo['thang']['name'] == 'tho') ||
                    ($this->chiInfo['nam']['name'] == 'tho' || $this->chiInfo['gio'] == 'tho'))) {
                $results['tru_thang'] = $results['tru_ngay'] = [
                    'text' => 'Hóa thổ',
                    'number' => 5
                ];
            }
            /**
             * Phu tòng thê hóa
             * 1 trong 2 trụ có chi là Thổ
             * Can chi bên cạnh đều là Thổ
             * Có Đinh, Kỷ ở can tàng
             */
            if (!$daHoa && (($this->chiInfo['nam']['name'] == 'tho' || $this->chiInfo['thang']['name'] == 'tho') &&
                    ($this->canInfo['thang']['name'] == 'tho' && $this->chiInfo['ngay']['name'] == 'tho') &&
                    (in_array('dinh', $canTangArrUni) || in_array('ky', $canTangArrUni)))) {
                $flagPha = false;
                if ($this->canThangSlug == 'ky' && $this->canInfo['thang']['name'] == 'moc') {
                    // Khắc phải là Mộc ở can ngày
                    // tính vương cho Thằng mộc
                    // chi ngày mộc|thủy và chi giờ là mộc|thủy
                    if ($this->chiInfo['ngay']['name'] == 'thuy' && $this->canInfo['gio']['name'] == 'thuy' && !in_array($this->chiInfo['gio']['name'], ['tho', 'hoa'])) {
                        $flagPha = true;
                    }
                    if ($this->chiInfo['ngay']['name'] == 'moc' && $this->canInfo['gio']['name'] == 'moc' && !in_array($this->chiInfo['gio']['name'], ['kim', 'tho'])) {
                        $flagPha = true;
                    }
                    if ($this->chiInfo['ngay']['name'] == 'thuy' && $this->canInfo['gio']['name'] == 'thuy' && $this->chiInfo['thang']['name'] == 'thuy') {
                        $flagPha = true;
                    }
                    if ($this->chiInfo['ngay']['name'] == 'moc' && $this->canInfo['gio']['name'] == 'moc' && $this->chiInfo['thang']['name'] == 'moc') {
                        $flagPha = true;
                    }
                }

                if ($this->canThangSlug == 'giap' && $this->canInfo['thang']['name'] == 'kim') {
                    // Khắc phải là Mộc ở can ngày
                    // tính vương cho Thằng mộc
                    // chi ngày mộc|thủy và chi giờ là mộc|thủy
                    if ($this->chiInfo['ngay']['name'] == 'tho' && $this->canInfo['gio']['name'] == 'tho' && !in_array($this->chiInfo['gio']['name'], ['moc', 'thuy'])) {
                        $flagPha = true;
                    }
                    if ($this->chiInfo['ngay']['name'] == 'kim' && $this->canInfo['gio']['name'] == 'kim' && !in_array($this->chiInfo['gio']['name'], ['hoa', 'thuy'])) {
                        $flagPha = true;
                    }
                    if ($this->chiInfo['ngay']['name'] == 'tho' && $this->canInfo['gio']['name'] == 'tho' && $this->chiInfo['gio']['name'] == 'tho') {
                        $flagPha = true;
                    }
                    if ($this->chiInfo['ngay']['name'] == 'kim' && $this->canInfo['gio']['name'] == 'kim' && $this->chiInfo['gio']['name'] == 'kim') {
                        $flagPha = true;
                    }
                }
                if (!$flagPha) {
                    $results['tru_thang'] = $results['tru_ngay'] = [
                        'text' => 'Hóa thổ',
                        'number' => 5
                    ];
                }
            }

            /**
             * Thê tòng phu hóa
             * 1 trong 2 tru co chi mộc
             * Can chi bên cạnh đều là mộc
             * Có Giáp, Nhâm ở can tàng
             */
            if (!$daHoa && (($this->chiInfo['nam']['name'] == 'moc' || $this->chiInfo['thang']['name'] == 'moc') &&
                    ($this->canInfo['thang']['name'] == 'moc' || $this->chiInfo['ngay']['name'] == 'moc') &&
                    (in_array('giap', $canTangArrUni) || in_array('nham', $canTangArrUni)))) {
                $results['tru_thang'] = $results['tru_ngay'] = [
                    'text' => 'Hóa mộc',
                    'number' => 3
                ];
            }

            // ----------------------------------- Xét địa chi hợp hóa -----------------------------------
            // 1: kim, 2: thuy, 3: moc, 4: hoa, 5: tho
            if (!empty($diaChiHopHoa['tam_hop']['tru_thang']) && !in_array($diaChiHopHoa['tam_hop']['tru_thang']['number'], [3, 5])) {
                unset($results['tru_thang']);
                unset($results['tru_ngay']);
            } else {
                // ----- Tam hop -----
                if (!empty($results) && !empty($diaChiHopHoa['tam_hop']['tru_thang']) && $diaChiHopHoa['tam_hop']['tru_thang']['number'] == 5) { // HOA THO
                    $results['tru_thang'] = $results['tru_ngay'] = [
                        'text' => 'Hóa Thổ',
                        'number' => 5
                    ];
                }
                if (!empty($results) && !empty($diaChiHopHoa['tam_hop']['tru_thang']) && $diaChiHopHoa['tam_hop']['tru_thang']['number'] == 3) { // HOA MOC
                    $results['tru_thang'] = $results['tru_ngay'] = [
                        'text' => 'Hóa mộc',
                        'number' => 3
                    ];
                }
                // ----- Tam Hoi -----
                if (!empty($results) && !empty($diaChiHopHoa['tam_hoi']['tru_thang']) && $diaChiHopHoa['tam_hoi']['tru_thang']['number'] == 5) { // HOA THO
                    $results['tru_thang'] = $results['tru_ngay'] = [
                        'text' => 'Hóa Thổ',
                        'number' => 5
                    ];
                }
                if (!empty($results) && !empty($diaChiHopHoa['tam_hoi']['tru_thang']) && $diaChiHopHoa['tam_hoi']['tru_thang']['number'] == 3) { // HOA MOC
                    $results['tru_thang'] = $results['tru_ngay'] = [
                        'text' => 'Hóa mộc',
                        'number' => 3
                    ];
                }
                // ----- Lục hợp -----
                if (!empty($results) && !empty($diaChiHopHoa['luc_hop']['tru_thang']) && $diaChiHopHoa['luc_hop']['tru_thang']['number'] == 5) { // HOA THO
                    $results['tru_thang'] = $results['tru_ngay'] = [
                        'text' => 'Hóa Thổ',
                        'number' => 5
                    ];
                }
                if (!empty($results) && !empty($diaChiHopHoa['luc_hop']['tru_thang']) && $diaChiHopHoa['luc_hop']['tru_thang']['number'] == 3) { // HOA MOC
                    $results['tru_thang'] = $results['tru_ngay'] = [
                        'text' => 'Hóa Mộc',
                        'number' => 3
                    ];
                }
                // ----- Bán tam hợp -----
                if (!empty($results) && !empty($diaChiHopHoa['ban_tam_hop']['tru_thang']) && $diaChiHopHoa['ban_tam_hop']['tru_thang']['number'] == 5) { // HOA THO
                    $results['tru_thang'] = $results['tru_ngay'] = [
                        'text' => 'Hóa Thổ',
                        'number' => 5
                    ];
                }
                if (!empty($results) && !empty($diaChiHopHoa['ban_tam_hop']['tru_thang']) && $diaChiHopHoa['ban_tam_hop']['tru_thang']['number'] == 3) { // HOA MOC
                    $results['tru_thang'] = $results['tru_ngay'] = [
                        'text' => 'Hóa Mộc',
                        'number' => 3
                    ];
                }
                // ----- Bán tam mộ -----
                if (!empty($results) && !empty($diaChiHopHoa['ban_tam_mo']['tru_thang']) && $diaChiHopHoa['ban_tam_mo']['tru_thang']['number'] == 5) { // HOA THO
                    $results['tru_thang'] = $results['tru_ngay'] = [
                        'text' => 'Hóa Thổ',
                        'number' => 5
                    ];
                }
                if (!empty($results) && !empty($diaChiHopHoa['ban_tam_mo']['tru_thang']) && $diaChiHopHoa['ban_tam_mo']['tru_thang']['number'] == 3) { // HOA MOC
                    $results['tru_thang'] = $results['tru_ngay'] = [
                        'text' => 'Hóa Mộc',
                        'number' => 3
                    ];
                }
            }
        }
        // AT VS CANH
        if (($this->canThangSlug == 'at' && $this->canNgaySlug == 'canh' && $this->canNamSlug != 'canh') ||
            ($this->canThangSlug == 'canh' && $this->canNgaySlug == 'at' && $this->canNamSlug != 'at') ||
            ($this->canThangSlug == 'canh' && $this->canNgaySlug == 'at' && $this->canGioSlug != 'canh') ||
            ($this->canThangSlug == 'at' && $this->canNgaySlug == 'canh' && $this->canGioSlug != 'at')) {

            // Hóa mạnh nhất
            // xung - xung, khac - khac, xung - khac, khac - xung
            $daHoa = false;
            if (($this->chiNamSlug != $this->diaChiLucXung[$this->chiThangSlug] && $this->chiNgaySlug != $this->diaChiLucXung[$this->chiThangSlug]) ||
                ($this->chiInfo['nam']['name'] != $this->biKhac($this->chiInfo['thang']['name']) && $this->chiInfo['ngay']['name'] != $this->biKhac($this->chiInfo['thang']['name'])) ||
                ($this->chiNamSlug != $this->diaChiLucXung[$this->chiThangSlug] && $this->chiInfo['ngay']['name'] != $this->biKhac($this->chiInfo['thang']['name'])) ||
                ($this->chiInfo['nam']['name'] != $this->biKhac($this->chiInfo['thang']['name']) && $this->chiNgaySlug != $this->diaChiLucXung[$this->chiThangSlug])) {
                if (in_array($this->chiInfo['thang']['name'], ['kim', 'moc'])) {
                    $results['tru_nam'] = $results['tru_thang'] = [
                        'text' => 'Hóa ' . $this->chiInfo['thang']['title'],
                        'number' => $this->chiInfo['thang']['id']
                    ];
                    $daHoa = true;
                }
            }

            /**
             * Chính Hóa
             * 2 trụ có chi là KIM
             * Thiên can Ngày không được xung với thiên can Tháng
             */
            if (!$daHoa && (($this->chiInfo['nam']['name'] == 'kim' && $this->chiInfo['thang']['name'] == 'kim') ||
                    (($this->chiInfo['nam']['name'] == 'kim' && $this->chiInfo['thang']['name'] == 'tho')) ||
                    ($this->chiInfo['nam']['name'] == 'tho' && $this->chiInfo['thang']['name'] == 'kim') ||
                    ($this->chiInfo['nam']['name'] == 'kim' || $this->chiInfo['gio'] == 'kim'))) {
                $results['tru_thang'] = $results['tru_ngay'] = [
                    'text' => 'Hóa kim',
                    'number' => 1
                ];
            }
            /**
             * Phu tòng thê hóa -> Hóa mộc
             * 1 trong 2 trụ có chi là mộc
             * Can chi bên cạnh đều là mộc
             * Có Ất, Đinh ở can tàng
             */
            if (!$daHoa && (($this->chiInfo['nam']['name'] == 'moc' || $this->chiInfo['thang']['name'] == 'moc') &&
                    ($this->canInfo['thang']['name'] == 'moc' && $this->chiInfo['ngay']['name'] == 'moc') &&
                    (in_array('at', $canTangArrUni) || in_array('dinh', $canTangArrUni)))) {
                $flagPha = false;
                if ($this->canThangSlug == 'at' && $this->canInfo['thang']['name'] == 'kim') {
                    // Khắc phải là Kim ở can ngày
                    // tính vương cho Thằng Kim
                    // chi ngày kim|thủy và chi giờ là kim|thủy
                    if ($this->chiInfo['ngay']['name'] == 'kim' && $this->canInfo['gio']['name'] == 'kim' && !in_array($this->chiInfo['gio']['name'], ['thuy', 'hoa'])) {
                        $flagPha = true;
                    }
                    if ($this->chiInfo['ngay']['name'] == 'thuy' && $this->canInfo['gio']['name'] == 'thuy' && !in_array($this->chiInfo['gio']['name'], ['moc', 'tho'])) {
                        $flagPha = true;
                    }
                    if ($this->chiInfo['ngay']['name'] == 'thuy' && $this->canInfo['gio']['name'] == 'thuy' && $this->chiInfo['thang']['name'] == 'thuy') {
                        $flagPha = true;
                    }
                    if ($this->chiInfo['ngay']['name'] == 'kim' && $this->canInfo['gio']['name'] == 'kim' && $this->chiInfo['thang']['name'] == 'kim') {
                        $flagPha = true;
                    }
                }

                if ($this->canThangSlug == 'canh' && $this->canInfo['thang']['name'] == 'hoa') {
                    // Khắc phải là Hỏa ở can ngày
                    // tính vương cho Thằng Hỏa
                    // chi ngày mộc|hỏa và chi giờ là mộc|hỏa
                    if ($this->chiInfo['ngay']['name'] == 'hoa' && $this->canInfo['gio']['name'] == 'hoa' && !in_array($this->chiInfo['gio']['name'], ['thuy', 'tho'])) {
                        $flagPha = true;
                    }
                    if ($this->chiInfo['ngay']['name'] == 'moc' && $this->canInfo['gio']['name'] == 'moc' && !in_array($this->chiInfo['gio']['name'], ['hoa', 'thuy'])) {
                        $flagPha = true;
                    }
                    if ($this->chiInfo['ngay']['name'] == 'hoa' && $this->canInfo['gio']['name'] == 'hoa' && $this->chiInfo['thang']['name'] == 'hoa') {
                        $flagPha = true;
                    }
                    if ($this->chiInfo['ngay']['name'] == 'moc' && $this->canInfo['gio']['name'] == 'moc' && $this->chiInfo['thang']['name'] == 'moc') {
                        $flagPha = true;
                    }
                }
                if (!$flagPha) {
                    $results['tru_thang'] = $results['tru_ngay'] = [
                        'text' => 'Hóa mộc',
                        'number' => 3
                    ];
                }
            }

            /**
             * Thê tòng phu hóa -> Hóa kim
             * 1 trong 2 tru co chi kim
             * Can chi bên cạnh đều là kim
             * Có Canh, Mậu ở can tàng
             */
            if (!$daHoa && (($this->chiInfo['nam']['name'] == 'kim' || $this->chiInfo['thang']['name'] == 'kim') &&
                    ($this->canInfo['thang']['name'] == 'kim' || $this->chiInfo['ngay']['name'] == 'kim') &&
                    (in_array('canh', $canTangArrUni) || in_array('mau', $canTangArrUni)))) {
                $results['tru_thang'] = $results['tru_ngay'] = [
                    'text' => 'Hóa kim',
                    'number' => 1
                ];
            }

            // ----------------------------------- Xét địa chi hợp hóa -----------------------------------
            // 1: kim, 2: thuy, 3: moc, 4: hoa, 5: tho
            if (!empty($diaChiHopHoa['tam_hop']['tru_thang']) && !in_array($diaChiHopHoa['tam_hop']['tru_thang']['number'], [1, 3])) {
                unset($results['tru_thang']);
                unset($results['tru_ngay']);
            } else {
                // ----- Tam Hợp -----
                if (!empty($results) && !empty($diaChiHopHoa['tam_hop']['tru_thang']) && $diaChiHopHoa['tam_hop']['tru_thang']['number'] == 1) { // HOA KIM
                    $results['tru_thang'] = $results['tru_ngay'] = [
                        'text' => 'Hóa Kim',
                        'number' => 1
                    ];
                }
                if (!empty($results) && !empty($diaChiHopHoa['tam_hop']['tru_thang']) && $diaChiHopHoa['tam_hop']['tru_thang']['number'] == 3) { // HOA MOC
                    $results['tru_thang'] = $results['tru_ngay'] = [
                        'text' => 'Hóa mộc',
                        'number' => 3
                    ];
                }
                // ----- Tam Hội -----
                if (!empty($results) && !empty($diaChiHopHoa['tam_hoi']['tru_thang']) && $diaChiHopHoa['tam_hoi']['tru_thang']['number'] == 1) { // HOA KIM
                    $results['tru_thang'] = $results['tru_ngay'] = [
                        'text' => 'Hóa Kim',
                        'number' => 1
                    ];
                }
                if (!empty($results) && !empty($diaChiHopHoa['tam_hoi']['tru_thang']) && $diaChiHopHoa['tam_hoi']['tru_thang']['number'] == 3) { // HOA MOC
                    $results['tru_thang'] = $results['tru_ngay'] = [
                        'text' => 'Hóa mộc',
                        'number' => 3
                    ];
                }
                // ----- Lục Hợp -----
                if (!empty($results) && !empty($diaChiHopHoa['luc_hop']['tru_thang']) && $diaChiHopHoa['luc_hop']['tru_thang']['number'] == 1) { // HOA KIM
                    $results['tru_thang'] = $results['tru_ngay'] = [
                        'text' => 'Hóa Kim',
                        'number' => 1
                    ];
                }
                if (!empty($results) && !empty($diaChiHopHoa['luc_hop']['tru_thang']) && $diaChiHopHoa['luc_hop']['tru_thang']['number'] == 3) { // HOA MOC
                    $results['tru_thang'] = $results['tru_ngay'] = [
                        'text' => 'Hóa Mộc',
                        'number' => 3
                    ];
                }
                // ----- Bán tam hợp -----
                if (!empty($results) && !empty($diaChiHopHoa['ban_tam_hop']['tru_thang']) && $diaChiHopHoa['ban_tam_hop']['tru_thang']['number'] == 1) { // HOA KIM
                    $results['tru_thang'] = $results['tru_ngay'] = [
                        'text' => 'Hóa Kim',
                        'number' => 1
                    ];
                }
                if (!empty($results) && !empty($diaChiHopHoa['ban_tam_hop']['tru_thang']) && $diaChiHopHoa['ban_tam_hop']['tru_thang']['number'] == 3) { // HOA MOC
                    $results['tru_thang'] = $results['tru_ngay'] = [
                        'text' => 'Hóa Mộc',
                        'number' => 3
                    ];
                }
                // ----- Bán tam mộ -----
                if (!empty($results) && !empty($diaChiHopHoa['ban_tam_mo']['tru_thang']) && $diaChiHopHoa['ban_tam_mo']['tru_thang']['number'] == 1) { // HOA KIM
                    $results['tru_thang'] = $results['tru_ngay'] = [
                        'text' => 'Hóa Kim',
                        'number' => 1
                    ];
                }
                if (!empty($results) && !empty($diaChiHopHoa['ban_tam_mo']['tru_thang']) && $diaChiHopHoa['ban_tam_mo']['tru_thang']['number'] == 3) { // HOA MOC
                    $results['tru_thang'] = $results['tru_ngay'] = [
                        'text' => 'Hóa Mộc',
                        'number' => 3
                    ];
                }
            }
        }
        // BINH VS TAN
        // 1: kim, 2: thuy, 3: moc, 4: hoa, 5: tho
        if (($this->canThangSlug == 'binh' && $this->canNgaySlug == 'tan' && $this->canNamSlug != 'tan') ||
            ($this->canThangSlug == 'tan' && $this->canNgaySlug == 'binh' && $this->canNamSlug != 'binh') ||
            ($this->canThangSlug == 'binh' && $this->canNgaySlug == 'tan' && $this->canGioSlug != 'binh') ||
            ($this->canThangSlug == 'tan' && $this->canNgaySlug == 'binh' && $this->canGioSlug != 'tan')) {

            // Hóa mạnh nhất
            // xung - xung, khac - khac, xung - khac, khac - xung
            $daHoa = false;
            if (($this->chiNamSlug != $this->diaChiLucXung[$this->chiThangSlug] && $this->chiNgaySlug != $this->diaChiLucXung[$this->chiThangSlug]) ||
                ($this->chiInfo['nam']['name'] != $this->biKhac($this->chiInfo['thang']['name']) && $this->chiInfo['ngay']['name'] != $this->biKhac($this->chiInfo['thang']['name'])) ||
                ($this->chiNamSlug != $this->diaChiLucXung[$this->chiThangSlug] && $this->chiInfo['ngay']['name'] != $this->biKhac($this->chiInfo['thang']['name'])) ||
                ($this->chiInfo['nam']['name'] != $this->biKhac($this->chiInfo['thang']['name']) && $this->chiNgaySlug != $this->diaChiLucXung[$this->chiThangSlug])) {
                if (in_array($this->chiInfo['thang']['name'], ['thuy', 'kim', 'hoa'])) {
                    $results['tru_nam'] = $results['tru_thang'] = [
                        'text' => 'Hóa ' . $this->chiInfo['thang']['title'],
                        'number' => $this->chiInfo['thang']['id']
                    ];
                    $daHoa = true;
                }
            }

            /**
             * Chính Hóa
             * 2 trụ có chi là Thủy
             */
            if (!$daHoa && (($this->chiInfo['nam']['name'] == 'thuy' && $this->chiInfo['thang']['name'] == 'thuy') ||
                    (($this->chiInfo['nam']['name'] == 'kim' && $this->chiInfo['thang']['name'] == 'thuy')) ||
                    ($this->chiInfo['nam']['name'] == 'thuy' && $this->chiInfo['thang']['name'] == 'kim') ||
                    ($this->chiInfo['nam']['name'] == 'thuy' || $this->chiInfo['gio'] == ['thuy']) ||
                    ($this->chiInfo['nam']['name'] == 'thuy' || $this->chiInfo['gio'] == 'thuy'))) {
                $results['tru_thang'] = $results['tru_ngay'] = [
                    'text' => 'Hóa thủy',
                    'number' => 2
                ];
            }
            /**
             * Phu tòng thê hóa -> Hóa Kim
             * 1 trong 2 trụ có chi là Kim
             * Can chi bên cạnh đều là Kim
             * Có Bính, Giáp ở can tàng
             */
            if (!$daHoa && (($this->chiInfo['nam']['name'] == 'kim' || $this->chiInfo['thang']['name'] == 'kim') &&
                    ($this->canInfo['thang']['name'] == 'kim' && $this->chiInfo['ngay']['name'] == 'kim') &&
                    (in_array('tan', $canTangArrUni) || in_array('quy', $canTangArrUni)))) {
                $flagPha = false;
                if ($this->canThangSlug == 'binh' && $this->canInfo['thang']['name'] == 'thuy') { // thủy phá bính(Hỏa)
                    // Khắc phải là Hỏa ở can ngày
                    // tính vương cho Thằng Hỏa
                    // chi ngày Mộc|Hỏa và chi giờ là Mộc|hỏa
                    if ($this->chiInfo['ngay']['name'] == 'kim' && $this->canInfo['gio']['name'] == 'kim' && !in_array($this->chiInfo['gio']['name'], ['thuy', 'hoa'])) {
                        $flagPha = true;
                    }
                    if ($this->chiInfo['ngay']['name'] == 'thuy' && $this->canInfo['gio']['name'] == 'thuy' && !in_array($this->chiInfo['gio']['name'], ['moc', 'tho'])) {
                        $flagPha = true;
                    }
                    if ($this->chiInfo['ngay']['name'] == 'thuy' && $this->canInfo['gio']['name'] == 'thuy' && $this->chiInfo['thang']['name'] == 'thuy') {
                        $flagPha = true;
                    }
                    if ($this->chiInfo['ngay']['name'] == 'kim' && $this->canInfo['gio']['name'] == 'kim' && $this->chiInfo['thang']['name'] == 'kim') {
                        $flagPha = true;
                    }
                }

                if ($this->canThangSlug == 'tan' && $this->canInfo['thang']['name'] == 'hoa') { // hỏa phá tân(kim)
                    // Khắc phải là Hỏa ở can ngày
                    // tính vương cho Thằng Hỏa
                    // chi ngày mộc|hỏa và chi giờ là mộc|hỏa
                    if ($this->chiInfo['ngay']['name'] == 'hoa' && $this->canInfo['gio']['name'] == 'hoa' && !in_array($this->chiInfo['gio']['name'], ['thuy', 'tho'])) {
                        $flagPha = true;
                    }
                    if ($this->chiInfo['ngay']['name'] == 'moc' && $this->canInfo['gio']['name'] == 'moc' && !in_array($this->chiInfo['gio']['name'], ['hoa', 'thuy'])) {
                        $flagPha = true;
                    }
                    if ($this->chiInfo['ngay']['name'] == 'hoa' && $this->canInfo['gio']['name'] == 'hoa' && $this->chiInfo['thang']['name'] == 'hoa') {
                        $flagPha = true;
                    }
                    if ($this->chiInfo['ngay']['name'] == 'moc' && $this->canInfo['gio']['name'] == 'moc' && $this->chiInfo['thang']['name'] == 'moc') {
                        $flagPha = true;
                    }
                }
                if (!$flagPha) {
                    $results['tru_thang'] = $results['tru_ngay'] = [
                        'text' => 'Hóa kim',
                        'number' => 1
                    ];
                }
            }

            /**
             * Thê tòng phu hóa -> Hóa hỏa
             * 1 trong 2 tru co chi hỏa
             * Can chi bên cạnh đều là hỏa
             * Có Bính, Giáp ở can tàng
             */
            if (!$daHoa && (($this->chiInfo['nam']['name'] == 'hoa' || $this->chiInfo['thang']['name'] == 'hoa') &&
                    ($this->canInfo['thang']['name'] == 'hoa' || $this->chiInfo['ngay']['name'] == 'hoa') &&
                    (in_array('binh', $canTangArrUni) || in_array('giap', $canTangArrUni)))) {
                $results['tru_thang'] = $results['tru_ngay'] = [
                    'text' => 'Hóa hỏa',
                    'number' => 4
                ];
            }

            // ----------------------------------- Xét địa chi hợp hóa -----------------------------------
            // 1: kim, 2: thuy, 3: moc, 4: hoa, 5: tho
            if (!empty($diaChiHopHoa['tam_hop']['tru_thang']) && !in_array($diaChiHopHoa['tam_hop']['tru_thang']['number'], [1, 2, 4])) {
                unset($results['tru_thang']);
                unset($results['tru_ngay']);
            } else {
                // ----- Tam hợp -----
                if (!empty($results) && !empty($diaChiHopHoa['tam_hop']['tru_thang']) && $diaChiHopHoa['tam_hop']['tru_thang']['number'] == 2) { // HOA THUY
                    $results['tru_thang'] = $results['tru_ngay'] = [
                        'text' => 'Hóa Thủy',
                        'number' => 2
                    ];
                }
                if (!empty($results) && !empty($diaChiHopHoa['tam_hop']['tru_thang']) && $diaChiHopHoa['tam_hop']['tru_thang']['number'] == 1) { // HOA KIM
                    $results['tru_thang'] = $results['tru_ngay'] = [
                        'text' => 'Hóa Kim',
                        'number' => 1
                    ];
                }
                if (!empty($results) && !empty($diaChiHopHoa['tam_hop']['tru_thang']) && $diaChiHopHoa['tam_hop']['tru_thang']['number'] == 4) { // HOA HOA
                    $results['tru_thang'] = $results['tru_ngay'] = [
                        'text' => 'Hóa Hỏa',
                        'number' => 4
                    ];
                }
                // ----- Tam mộ -----
                if (!empty($results) && !empty($diaChiHopHoa['tam_hoi']['tru_thang']) && $diaChiHopHoa['tam_hoi']['tru_thang']['number'] == 2) { // HOA THUY
                    $results['tru_thang'] = $results['tru_ngay'] = [
                        'text' => 'Hóa Thủy',
                        'number' => 2
                    ];
                }
                if (!empty($results) && !empty($diaChiHopHoa['tam_hoi']['tru_thang']) && $diaChiHopHoa['tam_hoi']['tru_thang']['number'] == 1) { // HOA KIM
                    $results['tru_thang'] = $results['tru_ngay'] = [
                        'text' => 'Hóa Kim',
                        'number' => 1
                    ];
                }
                if (!empty($results) && !empty($diaChiHopHoa['tam_hoi']['tru_thang']) && $diaChiHopHoa['tam_hoi']['tru_thang']['number'] == 4) { // HOA HOA
                    $results['tru_thang'] = $results['tru_ngay'] = [
                        'text' => 'Hóa Hỏa',
                        'number' => 4
                    ];
                }
                // ----- Lục hợp -----
                if (!empty($results) && !empty($diaChiHopHoa['luc_hop']['tru_thang']) && $diaChiHopHoa['luc_hop']['tru_thang']['number'] == 2) { // HOA THUY
                    $results['tru_thang'] = $results['tru_ngay'] = [
                        'text' => 'Hóa Thủy',
                        'number' => 2
                    ];
                }
                if (!empty($results) && !empty($diaChiHopHoa['luc_hop']['tru_thang']) && $diaChiHopHoa['luc_hop']['tru_thang']['number'] == 1) { // HOA KIM
                    $results['tru_thang'] = $results['tru_ngay'] = [
                        'text' => 'Hóa Kim',
                        'number' => 1
                    ];
                }
                if (!empty($results) && !empty($diaChiHopHoa['luc_hop']['tru_thang']) && $diaChiHopHoa['luc_hop']['tru_thang']['number'] == 4) { // HOA HOA
                    $results['tru_thang'] = $results['tru_ngay'] = [
                        'text' => 'Hóa Hỏa',
                        'number' => 4
                    ];
                }
                // ----- Bán tam hợp -----
                if (!empty($results) && !empty($diaChiHopHoa['ban_tam_hop']['tru_thang']) && $diaChiHopHoa['ban_tam_hop']['tru_thang']['number'] == 2) { // HOA THUY
                    $results['tru_thang'] = $results['tru_ngay'] = [
                        'text' => 'Hóa Thủy',
                        'number' => 2
                    ];
                }
                if (!empty($results) && !empty($diaChiHopHoa['ban_tam_hop']['tru_thang']) && $diaChiHopHoa['ban_tam_hop']['tru_thang']['number'] == 1) { // HOA KIM
                    $results['tru_thang'] = $results['tru_ngay'] = [
                        'text' => 'Hóa Kim',
                        'number' => 1
                    ];
                }
                if (!empty($results) && !empty($diaChiHopHoa['ban_tam_hop']['tru_thang']) && $diaChiHopHoa['ban_tam_hop']['tru_thang']['number'] == 4) { // HOA HOA
                    $results['tru_thang'] = $results['tru_ngay'] = [
                        'text' => 'Hóa Hỏa',
                        'number' => 4
                    ];
                }
                // ----- Bán tam mộ -----
                if (!empty($results) && !empty($diaChiHopHoa['ban_tam_mo']['tru_thang']) && $diaChiHopHoa['ban_tam_mo']['tru_thang']['number'] == 2) { // HOA THUY
                    $results['tru_thang'] = $results['tru_ngay'] = [
                        'text' => 'Hóa Thủy',
                        'number' => 2
                    ];
                }
                if (!empty($results) && !empty($diaChiHopHoa['ban_tam_mo']['tru_thang']) && $diaChiHopHoa['ban_tam_mo']['tru_thang']['number'] == 1) { // HOA KIM
                    $results['tru_thang'] = $results['tru_ngay'] = [
                        'text' => 'Hóa Kim',
                        'number' => 1
                    ];
                }
                if (!empty($results) && !empty($diaChiHopHoa['ban_tam_mo']['tru_thang']) && $diaChiHopHoa['ban_tam_mo']['tru_thang']['number'] == 4) { // HOA HOA
                    $results['tru_thang'] = $results['tru_ngay'] = [
                        'text' => 'Hóa Hỏa',
                        'number' => 4
                    ];
                }
            }
        }
        // ĐINH VS NHÂM
        // 1: kim, 2: thuy, 3: moc, 4: hoa, 5: tho
        if (($this->canThangSlug == 'dinh' && $this->canNgaySlug == 'nham' && $this->canNamSlug != 'nham') ||
            ($this->canThangSlug == 'nham' && $this->canNgaySlug == 'dinh' && $this->canNamSlug != 'dinh') ||
            ($this->canThangSlug == 'nham' && $this->canNgaySlug == 'dinh' && $this->canGioSlug != 'nham') ||
            ($this->canThangSlug == 'dinh' && $this->canNgaySlug == 'nham' && $this->canGioSlug != 'dinh')) {

            // Hóa mạnh nhất
            // xung - xung, khac - khac, xung - khac, khac - xung
            $daHoa = false;
            if (($this->chiNamSlug != $this->diaChiLucXung[$this->chiThangSlug] && $this->chiNgaySlug != $this->diaChiLucXung[$this->chiThangSlug]) ||
                ($this->chiInfo['nam']['name'] != $this->biKhac($this->chiInfo['thang']['name']) && $this->chiInfo['ngay']['name'] != $this->biKhac($this->chiInfo['thang']['name'])) ||
                ($this->chiNamSlug != $this->diaChiLucXung[$this->chiThangSlug] && $this->chiInfo['ngay']['name'] != $this->biKhac($this->chiInfo['thang']['name'])) ||
                ($this->chiInfo['nam']['name'] != $this->biKhac($this->chiInfo['thang']['name']) && $this->chiNgaySlug != $this->diaChiLucXung[$this->chiThangSlug])) {
                if (in_array($this->chiInfo['thang']['name'], ['thuy', 'moc', 'hoa'])) {
                    $results['tru_thang'] = $results['tru_ngay'] = [
                        'text' => 'Hóa ' . $this->chiInfo['thang']['title'],
                        'number' => $this->chiInfo['thang']['id']
                    ];
                    $daHoa = true;
                }
            }

            /**
             * Chính Hóa
             * 2 trụ có chi là Mộc
             */
            if (!$daHoa && (($this->chiInfo['nam']['name'] == 'moc' && $this->chiInfo['thang']['name'] == 'moc') ||
                    (($this->chiInfo['nam']['name'] == 'moc' && $this->chiInfo['thang']['name'] == 'thuy')) ||
                    ($this->chiInfo['nam']['name'] == 'thuy' && $this->chiInfo['thang']['name'] == 'moc') ||
                    ($this->chiInfo['nam']['name'] == 'moc' || $this->chiInfo['gio'] == 'moc'))) {
                $results['tru_nam'] = $results['tru_thang'] = [
                    'text' => 'Hóa mộc',
                    'number' => 3
                ];
            }
            /**
             * Phu tòng thê hóa -> Hóa Hỏa
             * 1 trong 2 trụ có chi là Hỏa
             * Can chi bên cạnh đều là Hỏa
             * Có Bính, Giáp ở can tàng
             */
            if (!$daHoa && (($this->chiInfo['nam']['name'] == 'hoa' || $this->chiInfo['thang']['name'] == 'hoa') &&
                    ($this->canInfo['thang']['name'] == 'hoa' && $this->chiInfo['ngay']['name'] == 'hoa') &&
                    (in_array('dinh', $canTangArrUni) || in_array('at', $canTangArrUni)))) {
                $flagPha = false;
                if ($this->canThangSlug == 'dinh' && $this->canInfo['thang']['name'] == 'thuy') { // thủy phá bính(Hỏa)
                    // Khắc phải là Thủy ở can ngày
                    // tính vương cho Thằng Thủy
                    // chi ngày Kim|Thủy và chi giờ là Kim|Thủy
                    if ($this->chiInfo['ngay']['name'] == 'kim' && $this->canInfo['gio']['name'] == 'kim' && !in_array($this->chiInfo['gio']['name'], ['thuy', 'hoa'])) {
                        $flagPha = true;
                    }
                    if ($this->chiInfo['ngay']['name'] == 'thuy' && $this->canInfo['gio']['name'] == 'thuy' && !in_array($this->chiInfo['gio']['name'], ['moc', 'tho'])) {
                        $flagPha = true;
                    }
                    if ($this->chiInfo['ngay']['name'] == 'kim' && $this->canInfo['gio']['name'] == 'kim' && $this->chiInfo['thang']['name'] == 'kim') {
                        $flagPha = true;
                    }
                    if ($this->chiInfo['ngay']['name'] == 'thuy' && $this->canInfo['gio']['name'] == 'thuy' && $this->chiInfo['thang']['name'] == 'thuy') {
                        $flagPha = true;
                    }
                }

                if ($this->canThangSlug == 'nham' && $this->canInfo['thang']['name'] == 'tho') { // Thổ phá nhâm(thủy)
                    // Khắc phải là Thổ ở can ngày
                    // tính vương cho Thằng Thổ
                    // chi ngày thổ|hỏa và chi giờ là thổ|hỏa
                    if ($this->chiInfo['ngay']['name'] == 'tho' && $this->canInfo['gio']['name'] == 'tho' && !in_array($this->chiInfo['gio']['name'], ['kim', 'moc'])) {
                        $flagPha = true;
                    }
                    if ($this->chiInfo['ngay']['name'] == 'hoa' && $this->canInfo['gio']['name'] == 'hoa' && !in_array($this->chiInfo['gio']['name'], ['tho', 'thuy'])) {
                        $flagPha = true;
                    }
                    if ($this->chiInfo['ngay']['name'] == 'hoa' && $this->canInfo['gio']['name'] == 'hoa' && $this->chiInfo['thang']['name'] == 'hoa') {
                        $flagPha = true;
                    }
                    if ($this->chiInfo['ngay']['name'] == 'moc' && $this->canInfo['gio']['name'] == 'moc' && $this->chiInfo['thang']['name'] == 'moc') {
                        $flagPha = true;
                    }
                }
                if (!$flagPha) {
                    $results['tru_thang'] = $results['tru_ngay'] = [
                        'text' => 'Hóa hỏa',
                        'number' => 4
                    ];
                }
            }

            /**
             * Thê tòng phu hóa -> Hóa Thủy
             * 1 trong 2 tru co chi Thủy
             * Can chi bên cạnh đều là Thủy
             * Có Bính, Giáp ở can tàng
             */
            if (!$daHoa && (($this->chiInfo['nam']['name'] == 'thuy' || $this->chiInfo['thang']['name'] == 'thuy') &&
                    ($this->canInfo['thang']['name'] == 'thuy' || $this->chiInfo['ngay']['name'] == 'thuy') &&
                    (in_array('nham', $canTangArrUni) || in_array('canh', $canTangArrUni)))) {
                $results['tru_thang'] = $results['tru_ngay'] = [
                    'text' => 'Hóa thủy',
                    'number' => 2
                ];
            }

            // ----------------------------------- Xét địa chi hợp hóa -----------------------------------
            // 1: kim, 2: thuy, 3: moc, 4: hoa, 5: tho
            // Nếu ngũ hành hóa của địa chi không phải là Mộc, Hỏa, Thủy thì thiên can ko xét hóa
            if (!empty($diaChiHopHoa['tam_hop']['tru_thang']) && !in_array($diaChiHopHoa['tam_hop']['tru_thang']['number'], [2, 3, 4])) {
                unset($results['tru_thang']);
                unset($results['tru_ngay']);
            } else {
                // ----- Tam hợp -----
                if (!empty($results) && !empty($diaChiHopHoa['tam_hop']['tru_thang']) && $diaChiHopHoa['tam_hop']['tru_thang']['number'] == 3) { // HOA MOC
                    $results['tru_thang'] = $results['tru_ngay'] = [
                        'text' => 'Hóa Mộc',
                        'number' => 3
                    ];
                }
                if (!empty($results) && !empty($diaChiHopHoa['tam_hop']['tru_thang']) && $diaChiHopHoa['tam_hop']['tru_thang']['number'] == 4) { // HOA HOA
                    $results['tru_thang'] = $results['tru_ngay'] = [
                        'text' => 'Hóa Hỏa',
                        'number' => 4
                    ];
                }
                if (!empty($results) && !empty($diaChiHopHoa['tam_hop']['tru_thang']) && $diaChiHopHoa['tam_hop']['tru_thang']['number'] == 2) { // HOA THUY
                    $results['tru_thang'] = $results['tru_ngay'] = [
                        'text' => 'Hóa Thủy',
                        'number' => 2
                    ];
                }
                // ----- Tam mộ -----
                if (!empty($results) && !empty($diaChiHopHoa['tam_hoi']['tru_thang']) && $diaChiHopHoa['tam_hoi']['tru_thang']['number'] == 3) { // HOA MOC
                    $results['tru_thang'] = $results['tru_ngay'] = [
                        'text' => 'Hóa Mộc',
                        'number' => 3
                    ];
                }
                if (!empty($results) && !empty($diaChiHopHoa['tam_hoi']['tru_thang']) && $diaChiHopHoa['tam_hoi']['tru_thang']['number'] == 4) { // HOA HOA
                    $results['tru_thang'] = $results['tru_ngay'] = [
                        'text' => 'Hóa Hỏa',
                        'number' => 4
                    ];
                }
                if (!empty($results) && !empty($diaChiHopHoa['tam_hoi']['tru_thang']) && $diaChiHopHoa['tam_hoi']['tru_thang']['number'] == 2) { // HOA THUY
                    $results['tru_thang'] = $results['tru_ngay'] = [
                        'text' => 'Hóa Thủy',
                        'number' => 2
                    ];
                }
                // ----- Lục hợp -----
                if (!empty($results) && !empty($diaChiHopHoa['luc_hop']['tru_thang']) && $diaChiHopHoa['luc_hop']['tru_thang']['number'] == 3) { // HOA MOC
                    $results['tru_thang'] = $results['tru_ngay'] = [
                        'text' => 'Hóa Mộc',
                        'number' => 3
                    ];
                }
                if (!empty($results) && !empty($diaChiHopHoa['luc_hop']['tru_thang']) && $diaChiHopHoa['luc_hop']['tru_thang']['number'] == 4) { // HOA HOA
                    $results['tru_thang'] = $results['tru_ngay'] = [
                        'text' => 'Hóa Hỏa',
                        'number' => 4
                    ];
                }
                if (!empty($results) && !empty($diaChiHopHoa['luc_hop']['tru_thang']) && $diaChiHopHoa['luc_hop']['tru_thang']['number'] == 2) { // HOA THUY
                    $results['tru_thang'] = $results['tru_ngay'] = [
                        'text' => 'Hóa Thủy',
                        'number' => 2
                    ];
                }
                // ----- Bán tam hợp -----
                if (!empty($results) && !empty($diaChiHopHoa['ban_tam_hop']['tru_thang']) && $diaChiHopHoa['ban_tam_hop']['tru_thang']['number'] == 3) { // HOA MOC
                    $results['tru_thang'] = $results['tru_ngay'] = [
                        'text' => 'Hóa Mộc',
                        'number' => 3
                    ];
                }
                if (!empty($results) && !empty($diaChiHopHoa['ban_tam_hop']['tru_thang']) && $diaChiHopHoa['ban_tam_hop']['tru_thang']['number'] == 4) { // HOA HOA
                    $results['tru_thang'] = $results['tru_ngay'] = [
                        'text' => 'Hóa Hỏa',
                        'number' => 4
                    ];
                }
                if (!empty($results) && !empty($diaChiHopHoa['ban_tam_hop']['tru_thang']) && $diaChiHopHoa['ban_tam_hop']['tru_thang']['number'] == 2) { // HOA THUY
                    $results['tru_thang'] = $results['tru_ngay'] = [
                        'text' => 'Hóa Thủy',
                        'number' => 2
                    ];
                }
                // ----- Bán tam mộ -----
                if (!empty($results) && !empty($diaChiHopHoa['ban_tam_mo']['tru_thang']) && $diaChiHopHoa['ban_tam_mo']['tru_thang']['number'] == 3) { // HOA MOC
                    $results['tru_thang'] = $results['tru_ngay'] = [
                        'text' => 'Hóa Mộc',
                        'number' => 3
                    ];
                }
                if (!empty($results) && !empty($diaChiHopHoa['ban_tam_mo']['tru_thang']) && $diaChiHopHoa['ban_tam_mo']['tru_thang']['number'] == 4) { // HOA HOA
                    $results['tru_thang'] = $results['tru_ngay'] = [
                        'text' => 'Hóa Hỏa',
                        'number' => 4
                    ];
                }
                if (!empty($results) && !empty($diaChiHopHoa['ban_tam_mo']['tru_thang']) && $diaChiHopHoa['ban_tam_mo']['tru_thang']['number'] == 2) { // HOA THUY
                    $results['tru_thang'] = $results['tru_ngay'] = [
                        'text' => 'Hóa Thủy',
                        'number' => 2
                    ];
                }
            }
        }
        // MAU VS QUY
        // 1: kim, 2: thuy, 3: moc, 4: hoa, 5: tho
        if (($this->canThangSlug == 'mau' && $this->canNgaySlug == 'quy' && $this->canNamSlug != 'quy') ||
            ($this->canThangSlug == 'quy' && $this->canNgaySlug == 'mau' && $this->canNamSlug != 'mau') ||
            ($this->canThangSlug == 'mau' && $this->canNgaySlug == 'quy' && $this->canGioSlug != 'mau') ||
            ($this->canThangSlug == 'quy' && $this->canNgaySlug == 'mau' && $this->canGioSlug != 'quy')) {

            // Hóa mạnh nhất
            // xung - xung, khac - khac, xung - khac, khac - xung
            $daHoa = false;
            if (($this->chiNamSlug != $this->diaChiLucXung[$this->chiThangSlug] && $this->chiNgaySlug != $this->diaChiLucXung[$this->chiThangSlug]) ||
                ($this->chiInfo['nam']['name'] != $this->biKhac($this->chiInfo['thang']['name']) && $this->chiInfo['ngay']['name'] != $this->biKhac($this->chiInfo['thang']['name'])) ||
                ($this->chiNamSlug != $this->diaChiLucXung[$this->chiThangSlug] && $this->chiInfo['ngay']['name'] != $this->biKhac($this->chiInfo['thang']['name'])) ||
                ($this->chiInfo['nam']['name'] != $this->biKhac($this->chiInfo['thang']['name']) && $this->chiNgaySlug != $this->diaChiLucXung[$this->chiThangSlug])) {
                if (in_array($this->chiInfo['thang']['name'], ['hoa', 'thuy', 'tho'])) {
                    $results['tru_thang'] = $results['tru_ngay'] = [
                        'text' => 'Hóa ' . $this->chiInfo['thang']['title'],
                        'number' => $this->chiInfo['thang']['id']
                    ];
                    $daHoa = true;
                }
            }

            /**
             * Chính Hóa
             * 2 trụ có chi là HỎA
             */
            if (!$daHoa && (($this->chiInfo['nam']['name'] == 'hoa' && $this->chiInfo['thang']['name'] == 'hoa') ||
                    (($this->chiInfo['nam']['name'] == 'hoa' && $this->chiInfo['thang']['name'] == 'moc')) ||
                    ($this->chiInfo['nam']['name'] == 'moc' && $this->chiInfo['thang']['name'] == 'hoa') ||
                    ($this->chiInfo['nam']['name'] == 'hoa' || $this->chiInfo['gio'] == 'hoa'))) {
                $results['tru_thang'] = $results['tru_ngay'] = [
                    'text' => 'Hóa Hỏa',
                    'number' => 4
                ];
            }
            /**
             * Phu tòng thê hóa -> Hóa Thủy
             * 1 trong 2 trụ có chi là Thủy
             * Can chi bên cạnh đều là Thủy
             * Có Quý, Canh ở can tàng
             */
            if (!$daHoa && (($this->chiInfo['nam']['name'] == 'thuy' || $this->chiInfo['thang']['name'] == 'thuy') &&
                    ($this->canInfo['thang']['name'] == 'thuy' && $this->chiInfo['ngay']['name'] == 'thuy') &&
                    (in_array('quy', $canTangArrUni) || in_array('canh', $canTangArrUni)))) {
                $flagPha = false;
                if ($this->canThangSlug == 'mau' && $this->canInfo['thang']['name'] == 'moc') { // Mộc phá mậu(thổ)
                    // Khắc phải là Mộc ở can ngày
                    // tính vương cho Thằng Mộc
                    // chi ngày Mộc|Thủy và chi giờ là Mộc|Thủy
                    if ($this->chiInfo['ngay']['name'] == 'moc' && $this->canInfo['gio']['name'] == 'moc' && !in_array($this->chiInfo['gio']['name'], ['hoa', 'kim'])) {
                        $flagPha = true;
                    }
                    if ($this->chiInfo['ngay']['name'] == 'thuy' && $this->canInfo['gio']['name'] == 'thuy' && !in_array($this->chiInfo['gio']['name'], ['moc', 'tho'])) {
                        $flagPha = true;
                    }
                    if ($this->chiInfo['ngay']['name'] == 'moc' && $this->canInfo['gio']['name'] == 'moc' && $this->chiInfo['thang']['name'] == 'moc') {
                        $flagPha = true;
                    }
                    if ($this->chiInfo['ngay']['name'] == 'thuy' && $this->canInfo['gio']['name'] == 'thuy' && $this->chiInfo['thang']['name'] == 'thuy') {
                        $flagPha = true;
                    }
                }

                if ($this->canThangSlug == 'quy' && $this->canInfo['thang']['name'] == 'tho') { // Thổ phá quý(thủy)
                    // Khắc phải là Thổ ở can ngày
                    // tính vương cho Thằng Thổ
                    // chi ngày thổ|hỏa và chi giờ là thổ|hỏa
                    if ($this->chiInfo['ngay']['name'] == 'tho' && $this->canInfo['gio']['name'] == 'tho' && !in_array($this->chiInfo['gio']['name'], ['kim', 'moc'])) {
                        $flagPha = true;
                    }
                    if ($this->chiInfo['ngay']['name'] == 'hoa' && $this->canInfo['gio']['name'] == 'hoa' && !in_array($this->chiInfo['gio']['name'], ['tho', 'thuy'])) {
                        $flagPha = true;
                    }
                    if ($this->chiInfo['ngay']['name'] == 'hoa' && $this->canInfo['gio']['name'] == 'hoa' && $this->chiInfo['thang']['name'] == 'hoa') {
                        $flagPha = true;
                    }
                    if ($this->chiInfo['ngay']['name'] == 'moc' && $this->canInfo['gio']['name'] == 'moc' && $this->chiInfo['thang']['name'] == 'moc') {
                        $flagPha = true;
                    }
                }
                if (!$flagPha) {
                    $results['tru_thang'] = $results['tru_ngay'] = [
                        'text' => 'Hóa Thủy',
                        'number' => 2
                    ];
                }
            }

            /**
             * Thê tòng phu hóa -> Hóa Thổ
             * 1 trong 2 tru co chi Thổ
             * Can chi bên cạnh đều là Thổ
             * Có Mậu, Bính ở can tàng
             */
            if (!$daHoa && (($this->chiInfo['nam']['name'] == 'tho' || $this->chiInfo['thang']['name'] == 'tho') &&
                    ($this->canInfo['thang']['name'] == 'tho' || $this->chiInfo['ngay']['name'] == 'tho') &&
                    (in_array('mau', $canTangArrUni) || in_array('binh', $canTangArrUni)))) {
                $results['tru_thang'] = $results['tru_ngay'] = [
                    'text' => 'Hóa thổ',
                    'number' => 5
                ];
            }

            // ----------------------------------- Xét địa chi hợp hóa -----------------------------------
            // 1: kim, 2: thuy, 3: moc, 4: hoa, 5: tho
            if (!empty($diaChiHopHoa['tam_hop']['tru_thang']) && !in_array($diaChiHopHoa['tam_hop']['tru_thang']['number'], [2, 4, 5])) {
                unset($results['tru_thang']);
                unset($results['tru_ngay']);
            } else {
                // ----- Tam hợp -----
                if (!empty($results) && !empty($diaChiHopHoa['tam_hop']['tru_thang']) && $diaChiHopHoa['tam_hop']['tru_thang']['number'] == 4) { // HOA HOA
                    $results['tru_thang'] = $results['tru_ngay'] = [
                        'text' => 'Hóa Hỏa',
                        'number' => 4
                    ];
                }
                if (!empty($results) && !empty($diaChiHopHoa['tam_hop']['tru_thang']) && $diaChiHopHoa['tam_hop']['tru_thang']['number'] == 2) { // HOA THUY
                    $results['tru_thang'] = $results['tru_ngay'] = [
                        'text' => 'Hóa Thủy',
                        'number' => 2
                    ];
                }
                if (!empty($results) && !empty($diaChiHopHoa['tam_hop']['tru_thang']) && $diaChiHopHoa['tam_hop']['tru_thang']['number'] == 5) { // HOA THO
                    $results['tru_thang'] = $results['tru_ngay'] = [
                        'text' => 'Hóa Thổ',
                        'number' => 5
                    ];
                }
                // ----- Tam mộ -----
                if (!empty($results) && !empty($diaChiHopHoa['tam_hoi']['tru_thang']) && $diaChiHopHoa['tam_hoi']['tru_thang']['number'] == 4) { // HOA HOA
                    $results['tru_thang'] = $results['tru_ngay'] = [
                        'text' => 'Hóa Hỏa',
                        'number' => 4
                    ];
                }
                if (!empty($results) && !empty($diaChiHopHoa['tam_hoi']['tru_thang']) && $diaChiHopHoa['tam_hoi']['tru_thang']['number'] == 2) { // HOA THUY
                    $results['tru_thang'] = $results['tru_ngay'] = [
                        'text' => 'Hóa Thủy',
                        'number' => 2
                    ];
                }
                if (!empty($results) && !empty($diaChiHopHoa['tam_hoi']['tru_thang']) && $diaChiHopHoa['tam_hoi']['tru_thang']['number'] == 5) { // HOA THO
                    $results['tru_thang'] = $results['tru_ngay'] = [
                        'text' => 'Hóa Thổ',
                        'number' => 5
                    ];
                }
                // ----- Lục hợp -----
                if (!empty($results) && !empty($diaChiHopHoa['luc_hop']['tru_thang']) && $diaChiHopHoa['luc_hop']['tru_thang']['number'] == 4) { // HOA HOA
                    $results['tru_thang'] = $results['tru_ngay'] = [
                        'text' => 'Hóa Hỏa',
                        'number' => 4
                    ];
                }
                if (!empty($results) && !empty($diaChiHopHoa['luc_hop']['tru_thang']) && $diaChiHopHoa['luc_hop']['tru_thang']['number'] == 2) { // HOA THUY
                    $results['tru_thang'] = $results['tru_ngay'] = [
                        'text' => 'Hóa Thủy',
                        'number' => 2
                    ];
                }
                if (!empty($results) && !empty($diaChiHopHoa['luc_hop']['tru_thang']) && $diaChiHopHoa['luc_hop']['tru_thang']['number'] == 5) { // HOA THO
                    $results['tru_thang'] = $results['tru_ngay'] = [
                        'text' => 'Hóa Thổ',
                        'number' => 5
                    ];
                }
                // ----- Bán tam hợp -----
                if (!empty($results) && !empty($diaChiHopHoa['ban_tam_hop']['tru_thang']) && $diaChiHopHoa['ban_tam_hop']['tru_thang']['number'] == 4) { // HOA HOA
                    $results['tru_thang'] = $results['tru_ngay'] = [
                        'text' => 'Hóa Hỏa',
                        'number' => 4
                    ];
                }
                if (!empty($results) && !empty($diaChiHopHoa['ban_tam_hop']['tru_thang']) && $diaChiHopHoa['ban_tam_hop']['tru_thang']['number'] == 2) { // HOA THỦY
                    $results['tru_thang'] = $results['tru_ngay'] = [
                        'text' => 'Hóa Thủy',
                        'number' => 2
                    ];
                }
                if (!empty($results) && !empty($diaChiHopHoa['ban_tam_hop']['tru_thang']) && $diaChiHopHoa['ban_tam_hop']['tru_thang']['number'] == 5) { // HOA THO
                    $results['tru_thang'] = $results['tru_ngay'] = [
                        'text' => 'Hóa Thổ',
                        'number' => 5
                    ];
                }
                // ----- Bán tam mộ -----
                if (!empty($results) && !empty($diaChiHopHoa['ban_tam_mo']['tru_thang']) && $diaChiHopHoa['ban_tam_mo']['tru_thang']['number'] == 4) { // HOA HOA
                    $results['tru_thang'] = $results['tru_ngay'] = [
                        'text' => 'Hóa Hỏa',
                        'number' => 4
                    ];
                }
                if (!empty($results) && !empty($diaChiHopHoa['ban_tam_mo']['tru_thang']) && $diaChiHopHoa['ban_tam_mo']['tru_thang']['number'] == 2) { // HOA THUY
                    $results['tru_thang'] = $results['tru_ngay'] = [
                        'text' => 'Hóa Thủy',
                        'number' => 2
                    ];
                }
                if (!empty($results) && !empty($diaChiHopHoa['ban_tam_mo']['tru_thang']) && $diaChiHopHoa['ban_tam_mo']['tru_thang']['number'] == 5) { // HOA THO
                    $results['tru_thang'] = $results['tru_ngay'] = [
                        'text' => 'Hóa Thổ',
                        'number' => 5
                    ];
                }
            }
        }

        // ** ------------------------------------- NGAY VS GIO ------------------------------------- **/
        // GIAP VS KY
        if (($this->canNgaySlug == 'giap' && $this->canGioSlug == 'ky' && $this->canThangSlug != 'ky') ||
            ($this->canNgaySlug == 'ky' && $this->canGioSlug == 'giap' && $this->canThangSlug != 'giap')) {
            /**
             * Chính Hóa
             * 2 trụ có chi là Thổ
             * Thiên can Ngày không được xung với thiên can Tháng
             */
            if (($this->chiInfo['nam']['name'] == 'tho' && $this->chiInfo['thang']['name'] == 'tho') ||
                ($this->chiInfo['nam']['name'] == 'tho' && $this->chiInfo['thang']['name'] == 'hoa') ||
                ($this->chiInfo['nam']['name'] == 'hoa' && $this->chiInfo['thang']['name'] == 'tho') ||
                ($this->chiInfo['thang']['name'] == 'tho')) {
                $results['tru_ngay'] = $results['tru_gio'] = [
                    'text' => 'Hóa thổ',
                    'number' => 5
                ];
            }
            /**
             * Phu tòng thê hóa
             * 1 trong 2 trụ có chi là Thổ
             * Can chi bên cạnh đều là Thổ
             * Có Đinh, Kỷ ở can tàng
             */
            if (($this->chiInfo['nam']['name'] == 'tho' || $this->chiInfo['thang']['name'] == 'tho') &&
                ($this->canInfo['thang']['name'] == 'tho' && $this->chiInfo['ngay']['name'] == 'tho') &&
                (in_array('dinh', $canTangArrUni) || in_array('ky', $canTangArrUni))
            ) {
                $flagPha = false;
                if ($this->canThangSlug == 'ky' && $this->canInfo['thang']['name'] == 'moc') {
                    // Khắc phải là Mộc ở can ngày
                    // tính vương cho Thằng mộc
                    // chi ngày mộc|thủy và chi giờ là mộc|thủy
                    if ($this->chiInfo['ngay']['name'] == 'thuy' && $this->canInfo['gio']['name'] == 'thuy' && !in_array($this->chiInfo['gio']['name'], ['tho', 'hoa'])) {
                        $flagPha = true;
                    }
                    if ($this->chiInfo['ngay']['name'] == 'moc' && $this->canInfo['gio']['name'] == 'moc' && !in_array($this->chiInfo['gio']['name'], ['kim', 'tho'])) {
                        $flagPha = true;
                    }
                    if ($this->chiInfo['ngay']['name'] == 'thuy' && $this->canInfo['gio']['name'] == 'thuy' && $this->chiInfo['thang']['name'] == 'thuy') {
                        $flagPha = true;
                    }
                    if ($this->chiInfo['ngay']['name'] == 'moc' && $this->canInfo['gio']['name'] == 'moc' && $this->chiInfo['thang']['name'] == 'moc') {
                        $flagPha = true;
                    }
                }

                if ($this->canThangSlug == 'giap' && $this->canInfo['thang']['name'] == 'kim') {
                    // Khắc phải là Mộc ở can ngày
                    // tính vương cho Thằng mộc
                    // chi ngày mộc|thủy và chi giờ là mộc|thủy
                    if ($this->chiInfo['ngay']['name'] == 'tho' && $this->canInfo['gio']['name'] == 'tho' && !in_array($this->chiInfo['gio']['name'], ['moc', 'thuy'])) {
                        $flagPha = true;
                    }
                    if ($this->chiInfo['ngay']['name'] == 'kim' && $this->canInfo['gio']['name'] == 'kim' && !in_array($this->chiInfo['gio']['name'], ['hoa', 'thuy'])) {
                        $flagPha = true;
                    }
                    if ($this->chiInfo['ngay']['name'] == 'tho' && $this->canInfo['gio']['name'] == 'tho' && $this->chiInfo['gio']['name'] == 'tho') {
                        $flagPha = true;
                    }
                    if ($this->chiInfo['ngay']['name'] == 'kim' && $this->canInfo['gio']['name'] == 'kim' && $this->chiInfo['gio']['name'] == 'kim') {
                        $flagPha = true;
                    }
                }
                if (!$flagPha && !in_array($this->canThangSlug, ['thin', 'tuat', 'suu', 'mui', 'dan', 'ty', 'ngo', 'than'])) {
                    $results['tru_ngay'] = $results['tru_gio'] = [
                        'text' => 'Hóa thổ',
                        'number' => 5
                    ];
                }
            }

            /**
             * Thê tòng phu hóa
             * 1 trong 2 tru co chi mộc
             * Can chi bên cạnh đều là mộc
             * Có Giáp, Nhâm ở can tàng
             */
            if (($this->chiInfo['nam']['name'] == 'moc' || $this->chiInfo['thang']['name'] == 'moc') &&
                ($this->canInfo['thang']['name'] == 'moc' || $this->chiInfo['ngay']['name'] == 'moc') &&
                (in_array('giap', $canTangArrUni) || in_array('nham', $canTangArrUni)) && in_array($this->chiThangSlug, ['dan', 'mao', 'thin', 'mui', 'hoi'])
            ) {
                $results['tru_ngay'] = $results['tru_gio'] = [
                    'text' => 'Hóa mộc',
                    'number' => 3
                ];
            }

            // ----------------------------------- Xét địa chi hợp hóa -----------------------------------
            // 1: kim, 2: thuy, 3: moc, 4: hoa, 5: tho
            // ----- Tam hop -----
            if (!empty($results) && !empty($diaChiHopHoa['tam_hop']['tru_ngay']) && $diaChiHopHoa['tam_hop']['tru_ngay']['number'] == 5) { // HOA THO
                $results['tru_ngay'] = $results['tru_gio'] = [
                    'text' => 'Hóa Thổ',
                    'number' => 5
                ];
            }
            if (!empty($results) && !empty($diaChiHopHoa['tam_hop']['tru_ngay']) && $diaChiHopHoa['tam_hop']['tru_ngay']['number'] == 3) { // HOA MOC
                $results['tru_ngay'] = $results['tru_gio'] = [
                    'text' => 'Hóa mộc',
                    'number' => 3
                ];
            }
            // ----- Tam Hoi -----
            if (!empty($results) && !empty($diaChiHopHoa['tam_hoi']['tru_ngay']) && $diaChiHopHoa['tam_hoi']['tru_ngay']['number'] == 5) { // HOA THO
                $results['tru_ngay'] = $results['tru_gio'] = [
                    'text' => 'Hóa Thổ',
                    'number' => 5
                ];
            }
            if (!empty($results) && !empty($diaChiHopHoa['tam_hoi']['tru_ngay']) && $diaChiHopHoa['tam_hoi']['tru_ngay']['number'] == 3) { // HOA MOC
                $results['tru_ngay'] = $results['tru_gio'] = [
                    'text' => 'Hóa mộc',
                    'number' => 3
                ];
            }
            // ----- Lục hợp -----
            if (!empty($results) && !empty($diaChiHopHoa['luc_hop']['tru_ngay']) && $diaChiHopHoa['luc_hop']['tru_ngay']['number'] == 5) { // HOA THO
                $results['tru_ngay'] = $results['tru_gio'] = [
                    'text' => 'Hóa Thổ',
                    'number' => 5
                ];
            }
            if (!empty($results) && !empty($diaChiHopHoa['luc_hop']['tru_ngay']) && $diaChiHopHoa['luc_hop']['tru_ngay']['number'] == 3) { // HOA MOC
                $results['tru_ngay'] = $results['tru_gio'] = [
                    'text' => 'Hóa Mộc',
                    'number' => 3
                ];
            }
            // ----- Bán tam hợp -----
            if (!empty($results) && !empty($diaChiHopHoa['ban_tam_hop']['tru_ngay']) && $diaChiHopHoa['ban_tam_hop']['tru_ngay']['number'] == 5) { // HOA THO
                $results['tru_ngay'] = $results['tru_gio'] = [
                    'text' => 'Hóa Thổ',
                    'number' => 5
                ];
            }
            if (!empty($results) && !empty($diaChiHopHoa['ban_tam_hop']['tru_ngay']) && $diaChiHopHoa['ban_tam_hop']['tru_ngay']['number'] == 3) { // HOA MOC
                $results['tru_ngay'] = $results['tru_gio'] = [
                    'text' => 'Hóa Mộc',
                    'number' => 3
                ];
            }
            // ----- Bán tam mộ -----
            if (!empty($results) && !empty($diaChiHopHoa['ban_tam_mo']['tru_ngay']) && $diaChiHopHoa['ban_tam_mo']['tru_ngay']['number'] == 5) { // HOA THO
                $results['tru_ngay'] = $results['tru_gio'] = [
                    'text' => 'Hóa Thổ',
                    'number' => 5
                ];
            }
            if (!empty($results) && !empty($diaChiHopHoa['ban_tam_mo']['tru_ngay']) && $diaChiHopHoa['ban_tam_mo']['tru_ngay']['number'] == 3) { // HOA MOC
                $results['tru_ngay'] = $results['tru_gio'] = [
                    'text' => 'Hóa Mộc',
                    'number' => 3
                ];
            }
        }
        // AT VS CANH
        if (($this->canNgaySlug == 'at' && $this->canGioSlug == 'canh' && $this->canThangSlug != 'canh') ||
            ($this->canNgaySlug == 'canh' && $this->canGioSlug == 'at' && $this->canThangSlug != 'at')) {
            /**
             * Chính Hóa
             * 2 trụ có chi là KIM
             * Thiên can Ngày không được xung với thiên can Tháng
             */
            if (($this->chiInfo['nam']['name'] == 'kim' && $this->chiInfo['thang']['name'] == 'kim') ||
                (($this->chiInfo['nam']['name'] == 'kim' && $this->chiInfo['thang']['name'] == 'tho')) ||
                ($this->chiInfo['nam']['name'] == 'tho' && $this->chiInfo['thang']['name'] == 'kim') ||
                ($this->chiInfo['thang']['name'] == 'kim')) {
                $results['tru_ngay'] = $results['tru_gio'] = [
                    'text' => 'Hóa kim',
                    'number' => 1
                ];
            }
            /**
             * Phu tòng thê hóa -> Hóa mộc
             * 1 trong 2 trụ có chi là mộc
             * Can chi bên cạnh đều là mộc
             * Có Ất, Đinh ở can tàng
             */
            if (($this->chiInfo['nam']['name'] == 'moc' || $this->chiInfo['thang']['name'] == 'moc') &&
                ($this->canInfo['thang']['name'] == 'moc' && $this->chiInfo['ngay']['name'] == 'moc') &&
                (in_array('at', $canTangArrUni) || in_array('dinh', $canTangArrUni))
            ) {
                $flagPha = false;
                if ($this->canThangSlug == 'at' && $this->canInfo['thang']['name'] == 'kim') {
                    // Khắc phải là Kim ở can ngày
                    // tính vương cho Thằng Kim
                    // chi ngày kim|thủy và chi giờ là kim|thủy
                    if ($this->chiInfo['ngay']['name'] == 'kim' && $this->canInfo['gio']['name'] == 'kim' && !in_array($this->chiInfo['gio']['name'], ['thuy', 'hoa'])) {
                        $flagPha = true;
                    }
                    if ($this->chiInfo['ngay']['name'] == 'thuy' && $this->canInfo['gio']['name'] == 'thuy' && !in_array($this->chiInfo['gio']['name'], ['moc', 'tho'])) {
                        $flagPha = true;
                    }
                    if ($this->chiInfo['ngay']['name'] == 'thuy' && $this->canInfo['gio']['name'] == 'thuy' && $this->chiInfo['thang']['name'] == 'thuy') {
                        $flagPha = true;
                    }
                    if ($this->chiInfo['ngay']['name'] == 'kim' && $this->canInfo['gio']['name'] == 'kim' && $this->chiInfo['thang']['name'] == 'kim') {
                        $flagPha = true;
                    }
                }

                if ($this->canThangSlug == 'canh' && $this->canInfo['thang']['name'] == 'hoa') {
                    // Khắc phải là Hỏa ở can ngày
                    // tính vương cho Thằng Hỏa
                    // chi ngày mộc|hỏa và chi giờ là mộc|hỏa
                    if ($this->chiInfo['ngay']['name'] == 'hoa' && $this->canInfo['gio']['name'] == 'hoa' && !in_array($this->chiInfo['gio']['name'], ['thuy', 'tho'])) {
                        $flagPha = true;
                    }
                    if ($this->chiInfo['ngay']['name'] == 'moc' && $this->canInfo['gio']['name'] == 'moc' && !in_array($this->chiInfo['gio']['name'], ['hoa', 'thuy'])) {
                        $flagPha = true;
                    }
                    if ($this->chiInfo['ngay']['name'] == 'hoa' && $this->canInfo['gio']['name'] == 'hoa' && $this->chiInfo['thang']['name'] == 'hoa') {
                        $flagPha = true;
                    }
                    if ($this->chiInfo['ngay']['name'] == 'moc' && $this->canInfo['gio']['name'] == 'moc' && $this->chiInfo['thang']['name'] == 'moc') {
                        $flagPha = true;
                    }
                }
                if (!$flagPha && in_array($this->chiThangSlug, ['dan', 'mao', 'thin', 'mui', 'hoi'])) {
                    $results['tru_ngay'] = $results['tru_gio'] = [
                        'text' => 'Hóa mộc',
                        'number' => 3
                    ];
                }
            }

            /**
             * Thê tòng phu hóa -> Hóa kim
             * 1 trong 2 tru co chi kim
             * Can chi bên cạnh đều là kim
             * Có Canh, Mậu ở can tàng
             */
            if (($this->chiInfo['nam']['name'] == 'kim' || $this->chiInfo['thang']['name'] == 'kim') &&
                ($this->canInfo['thang']['name'] == 'kim' || $this->chiInfo['ngay']['name'] == 'kim') &&
                (in_array('canh', $canTangArrUni) || in_array('mau', $canTangArrUni)) && in_array($this->chiThangSlug, ['than', 'dau', 'suu', 'ty', 'tuat'])
            ) {
                $results['tru_ngay'] = $results['tru_gio'] = [
                    'text' => 'Hóa kim',
                    'number' => 1
                ];
            }

            // ----------------------------------- Xét địa chi hợp hóa -----------------------------------
            // 1: kim, 2: thuy, 3: moc, 4: hoa, 5: tho
            // ----- Tam Hợp -----
            if (!empty($results) && !empty($diaChiHopHoa['tam_hop']['tru_ngay']) && $diaChiHopHoa['tam_hop']['tru_ngay']['number'] == 1) { // HOA KIM
                $results['tru_ngay'] = $results['tru_gio'] = [
                    'text' => 'Hóa Kim',
                    'number' => 1
                ];
            }
            if (!empty($results) && !empty($diaChiHopHoa['tam_hop']['tru_ngay']) && $diaChiHopHoa['tam_hop']['tru_ngay']['number'] == 3) { // HOA MOC
                $results['tru_ngay'] = $results['tru_gio'] = [
                    'text' => 'Hóa mộc',
                    'number' => 3
                ];
            }
            // ----- Tam Hội -----
            if (!empty($results) && !empty($diaChiHopHoa['tam_hoi']['tru_ngay']) && $diaChiHopHoa['tam_hoi']['tru_ngay']['number'] == 1) { // HOA KIM
                $results['tru_ngay'] = $results['tru_gio'] = [
                    'text' => 'Hóa Kim',
                    'number' => 1
                ];
            }
            if (!empty($results) && !empty($diaChiHopHoa['tam_hoi']['tru_ngay']) && $diaChiHopHoa['tam_hoi']['tru_ngay']['number'] == 3) { // HOA MOC
                $results['tru_ngay'] = $results['tru_gio'] = [
                    'text' => 'Hóa mộc',
                    'number' => 3
                ];
            }
            // ----- Lục Hợp -----
            if (!empty($results) && !empty($diaChiHopHoa['luc_hop']['tru_ngay']) && $diaChiHopHoa['luc_hop']['tru_ngay']['number'] == 1) { // HOA KIM
                $results['tru_ngay'] = $results['tru_gio'] = [
                    'text' => 'Hóa Kim',
                    'number' => 1
                ];
            }
            if (!empty($results) && !empty($diaChiHopHoa['luc_hop']['tru_ngay']) && $diaChiHopHoa['luc_hop']['tru_ngay']['number'] == 3) { // HOA MOC
                $results['tru_ngay'] = $results['tru_gio'] = [
                    'text' => 'Hóa Mộc',
                    'number' => 3
                ];
            }
            // ----- Bán tam hợp -----
            if (!empty($results) && !empty($diaChiHopHoa['ban_tam_hop']['tru_ngay']) && $diaChiHopHoa['ban_tam_hop']['tru_ngay']['number'] == 1) { // HOA KIM
                $results['tru_ngay'] = $results['tru_gio'] = [
                    'text' => 'Hóa Kim',
                    'number' => 1
                ];
            }
            if (!empty($results) && !empty($diaChiHopHoa['ban_tam_hop']['tru_ngay']) && $diaChiHopHoa['ban_tam_hop']['tru_ngay']['number'] == 3) { // HOA MOC
                $results['tru_ngay'] = $results['tru_gio'] = [
                    'text' => 'Hóa Mộc',
                    'number' => 3
                ];
            }
            // ----- Bán tam mộ -----
            if (!empty($results) && !empty($diaChiHopHoa['ban_tam_mo']['tru_ngay']) && $diaChiHopHoa['ban_tam_mo']['tru_ngay']['number'] == 1) { // HOA KIM
                $results['tru_ngay'] = $results['tru_gio'] = [
                    'text' => 'Hóa Kim',
                    'number' => 1
                ];
            }
            if (!empty($results) && !empty($diaChiHopHoa['ban_tam_mo']['tru_ngay']) && $diaChiHopHoa['ban_tam_mo']['tru_ngay']['number'] == 3) { // HOA MOC
                $results['tru_ngay'] = $results['tru_gio'] = [
                    'text' => 'Hóa Mộc',
                    'number' => 3
                ];
            }
        }
        // BINH VS TAN
        // 1: kim, 2: thuy, 3: moc, 4: hoa, 5: tho
        if (($this->canNgaySlug == 'binh' && $this->canGioSlug == 'tan' && $this->canThangSlug != 'tan') ||
            ($this->canNgaySlug == 'tan' && $this->canGioSlug == 'binh' && $this->canThangSlug != 'binh')) {
            /**
             * Chính Hóa
             * 2 trụ có chi là Thủy
             */
            if (($this->chiInfo['nam']['name'] == 'thuy' && $this->chiInfo['thang']['name'] == 'thuy') ||
                (($this->chiInfo['nam']['name'] == 'kim' && $this->chiInfo['thang']['name'] == 'thuy')) ||
                ($this->chiInfo['nam']['name'] == 'thuy' && $this->chiInfo['thang']['name'] == 'kim') ||
                ($this->chiInfo['thang']['name'] == 'thuy')) {
                $results['tru_ngay'] = $results['tru_gio'] = [
                    'text' => 'Hóa thủy',
                    'number' => 2
                ];
            }
            /**
             * Phu tòng thê hóa -> Hóa Kim
             * 1 trong 2 trụ có chi là Kim
             * Can chi bên cạnh đều là Kim
             * Có Bính, Giáp ở can tàng
             */
            if (($this->chiInfo['nam']['name'] == 'kim' || $this->chiInfo['thang']['name'] == 'kim') &&
                ($this->canInfo['thang']['name'] == 'kim' && $this->chiInfo['ngay']['name'] == 'kim') &&
                (in_array('tan', $canTangArrUni) || in_array('quy', $canTangArrUni))
            ) {
                $flagPha = false;
                if ($this->canThangSlug == 'binh' && $this->canInfo['thang']['name'] == 'thuy') { // thủy phá bính(Hỏa)
                    // Khắc phải là Hỏa ở can ngày
                    // tính vương cho Thằng Hỏa
                    // chi ngày Mộc|Hỏa và chi giờ là Mộc|hỏa
                    if ($this->chiInfo['ngay']['name'] == 'kim' && $this->canInfo['gio']['name'] == 'kim' && !in_array($this->chiInfo['gio']['name'], ['thuy', 'hoa'])) {
                        $flagPha = true;
                    }
                    if ($this->chiInfo['ngay']['name'] == 'thuy' && $this->canInfo['gio']['name'] == 'thuy' && !in_array($this->chiInfo['gio']['name'], ['moc', 'tho'])) {
                        $flagPha = true;
                    }
                    if ($this->chiInfo['ngay']['name'] == 'thuy' && $this->canInfo['gio']['name'] == 'thuy' && $this->chiInfo['thang']['name'] == 'thuy') {
                        $flagPha = true;
                    }
                    if ($this->chiInfo['ngay']['name'] == 'kim' && $this->canInfo['gio']['name'] == 'kim' && $this->chiInfo['thang']['name'] == 'kim') {
                        $flagPha = true;
                    }
                }

                if ($this->canThangSlug == 'tan' && $this->canInfo['thang']['name'] == 'hoa') { // hỏa phá tân(kim)
                    // Khắc phải là Hỏa ở can ngày
                    // tính vương cho Thằng Hỏa
                    // chi ngày mộc|hỏa và chi giờ là mộc|hỏa
                    if ($this->chiInfo['ngay']['name'] == 'hoa' && $this->canInfo['gio']['name'] == 'hoa' && !in_array($this->chiInfo['gio']['name'], ['thuy', 'tho'])) {
                        $flagPha = true;
                    }
                    if ($this->chiInfo['ngay']['name'] == 'moc' && $this->canInfo['gio']['name'] == 'moc' && !in_array($this->chiInfo['gio']['name'], ['hoa', 'thuy'])) {
                        $flagPha = true;
                    }
                    if ($this->chiInfo['ngay']['name'] == 'hoa' && $this->canInfo['gio']['name'] == 'hoa' && $this->chiInfo['thang']['name'] == 'hoa') {
                        $flagPha = true;
                    }
                    if ($this->chiInfo['ngay']['name'] == 'moc' && $this->canInfo['gio']['name'] == 'moc' && $this->chiInfo['thang']['name'] == 'moc') {
                        $flagPha = true;
                    }
                }
                if (!$flagPha && in_array($this->chiThangSlug, ['than', 'dau', 'suu', 'ty', 'tuat'])) {
                    $results['tru_ngay'] = $results['tru_gio'] = [
                        'text' => 'Hóa kim',
                        'number' => 1
                    ];
                }
            }

            /**
             * Thê tòng phu hóa -> Hóa hỏa
             * 1 trong 2 tru co chi hỏa
             * Can chi bên cạnh đều là hỏa
             * Có Bính, Giáp ở can tàng
             */
            if (($this->chiInfo['nam']['name'] == 'hoa' || $this->chiInfo['thang']['name'] == 'hoa') &&
                ($this->canInfo['thang']['name'] == 'hoa' || $this->chiInfo['ngay']['name'] == 'hoa') &&
                (in_array('binh', $canTangArrUni) || in_array('giap', $canTangArrUni)) && in_array($this->chiThangSlug, ['ty', 'ngo', 'dan', 'mui', 'tuat'])
            ) {
                $results['tru_ngay'] = $results['tru_gio'] = [
                    'text' => 'Hóa hỏa',
                    'number' => 4
                ];
            }

            // ----------------------------------- Xét địa chi hợp hóa -----------------------------------
            // 1: kim, 2: thuy, 3: moc, 4: hoa, 5: tho
            // ----- Tam hợp -----
            if (!empty($results) && !empty($diaChiHopHoa['tam_hop']['tru_ngay']) && $diaChiHopHoa['tam_hop']['tru_ngay']['number'] == 2) { // HOA THUY
                $results['tru_ngay'] = $results['tru_gio'] = [
                    'text' => 'Hóa Thủy',
                    'number' => 2
                ];
            }
            if (!empty($results) && !empty($diaChiHopHoa['tam_hop']['tru_ngay']) && $diaChiHopHoa['tam_hop']['tru_ngay']['number'] == 1) { // HOA KIM
                $results['tru_ngay'] = $results['tru_gio'] = [
                    'text' => 'Hóa Kim',
                    'number' => 1
                ];
            }
            if (!empty($results) && !empty($diaChiHopHoa['tam_hop']['tru_ngay']) && $diaChiHopHoa['tam_hop']['tru_ngay']['number'] == 4) { // HOA HOA
                $results['tru_ngay'] = $results['tru_gio'] = [
                    'text' => 'Hóa Hỏa',
                    'number' => 4
                ];
            }
            // ----- Tam mộ -----
            if (!empty($results) && !empty($diaChiHopHoa['tam_hoi']['tru_ngay']) && $diaChiHopHoa['tam_hoi']['tru_ngay']['number'] == 2) { // HOA THUY
                $results['tru_ngay'] = $results['tru_gio'] = [
                    'text' => 'Hóa Thủy',
                    'number' => 2
                ];
            }
            if (!empty($results) && !empty($diaChiHopHoa['tam_hoi']['tru_ngay']) && $diaChiHopHoa['tam_hoi']['tru_ngay']['number'] == 1) { // HOA KIM
                $results['tru_ngay'] = $results['tru_gio'] = [
                    'text' => 'Hóa Kim',
                    'number' => 1
                ];
            }
            if (!empty($results) && !empty($diaChiHopHoa['tam_hoi']['tru_ngay']) && $diaChiHopHoa['tam_hoi']['tru_ngay']['number'] == 4) { // HOA HOA
                $results['tru_ngay'] = $results['tru_gio'] = [
                    'text' => 'Hóa Hỏa',
                    'number' => 4
                ];
            }
            // ----- Lục hợp -----
            if (!empty($results) && !empty($diaChiHopHoa['luc_hop']['tru_ngay']) && $diaChiHopHoa['luc_hop']['tru_ngay']['number'] == 2) { // HOA THUY
                $results['tru_ngay'] = $results['tru_gio'] = [
                    'text' => 'Hóa Thủy',
                    'number' => 2
                ];
            }
            if (!empty($results) && !empty($diaChiHopHoa['luc_hop']['tru_ngay']) && $diaChiHopHoa['luc_hop']['tru_ngay']['number'] == 1) { // HOA KIM
                $results['tru_ngay'] = $results['tru_gio'] = [
                    'text' => 'Hóa Kim',
                    'number' => 1
                ];
            }
            if (!empty($results) && !empty($diaChiHopHoa['luc_hop']['tru_ngay']) && $diaChiHopHoa['luc_hop']['tru_ngay']['number'] == 4) { // HOA HOA
                $results['tru_ngay'] = $results['tru_gio'] = [
                    'text' => 'Hóa Hỏa',
                    'number' => 4
                ];
            }
            // ----- Bán tam hợp -----
            if (!empty($results) && !empty($diaChiHopHoa['ban_tam_hop']['tru_ngay']) && $diaChiHopHoa['ban_tam_hop']['tru_ngay']['number'] == 2) { // HOA THUY
                $results['tru_ngay'] = $results['tru_gio'] = [
                    'text' => 'Hóa Thủy',
                    'number' => 2
                ];
            }
            if (!empty($results) && !empty($diaChiHopHoa['ban_tam_hop']['tru_ngay']) && $diaChiHopHoa['ban_tam_hop']['tru_ngay']['number'] == 1) { // HOA KIM
                $results['tru_ngay'] = $results['tru_gio'] = [
                    'text' => 'Hóa Kim',
                    'number' => 1
                ];
            }
            if (!empty($results) && !empty($diaChiHopHoa['ban_tam_hop']['tru_ngay']) && $diaChiHopHoa['ban_tam_hop']['tru_ngay']['number'] == 4) { // HOA HOA
                $results['tru_ngay'] = $results['tru_gio'] = [
                    'text' => 'Hóa Hỏa',
                    'number' => 4
                ];
            }
            // ----- Bán tam mộ -----
            if (!empty($results) && !empty($diaChiHopHoa['ban_tam_mo']['tru_ngay']) && $diaChiHopHoa['ban_tam_mo']['tru_ngay']['number'] == 2) { // HOA THUY
                $results['tru_ngay'] = $results['tru_gio'] = [
                    'text' => 'Hóa Thủy',
                    'number' => 2
                ];
            }
            if (!empty($results) && !empty($diaChiHopHoa['ban_tam_mo']['tru_ngay']) && $diaChiHopHoa['ban_tam_mo']['tru_ngay']['number'] == 1) { // HOA KIM
                $results['tru_ngay'] = $results['tru_gio'] = [
                    'text' => 'Hóa Kim',
                    'number' => 1
                ];
            }
            if (!empty($results) && !empty($diaChiHopHoa['ban_tam_mo']['tru_ngay']) && $diaChiHopHoa['ban_tam_mo']['tru_ngay']['number'] == 4) { // HOA HOA
                $results['tru_ngay'] = $results['tru_gio'] = [
                    'text' => 'Hóa Hỏa',
                    'number' => 4
                ];
            }
        }
        // ĐINH VS NHÂM
        // 1: kim, 2: thuy, 3: moc, 4: hoa, 5: tho
        if (($this->canNgaySlug == 'dinh' && $this->canGioSlug == 'nham' && $this->canThangSlug != 'nham') ||
            ($this->canNgaySlug == 'nham' && $this->canGioSlug == 'dinh' && $this->canThangSlug != 'dinh')) {
            /**
             * Chính Hóa
             * 2 trụ có chi là Mộc
             */
            if (($this->chiInfo['nam']['name'] == 'moc' && $this->chiInfo['thang']['name'] == 'moc') ||
                (($this->chiInfo['nam']['name'] == 'moc' && $this->chiInfo['thang']['name'] == 'thuy')) ||
                ($this->chiInfo['nam']['name'] == 'thuy' && $this->chiInfo['thang']['name'] == 'moc') ||
                ($this->chiInfo['thang']['name'] == 'moc')) {
                $results['tru_ngay'] = $results['tru_gio'] = [
                    'text' => 'Hóa mộc',
                    'number' => 3
                ];
            }
            /**
             * Phu tòng thê hóa -> Hóa Hỏa
             * 1 trong 2 trụ có chi là Hỏa
             * Can chi bên cạnh đều là Hỏa
             * Có Bính, Giáp ở can tàng
             */
            if (($this->chiInfo['nam']['name'] == 'hoa' || $this->chiInfo['thang']['name'] == 'hoa') &&
                ($this->canInfo['thang']['name'] == 'hoa' && $this->chiInfo['ngay']['name'] == 'hoa') &&
                (in_array('dinh', $canTangArrUni) || in_array('at', $canTangArrUni))
            ) {
                $flagPha = false;
                if ($this->canThangSlug == 'dinh' && $this->canInfo['thang']['name'] == 'thuy') { // thủy phá bính(Hỏa)
                    // Khắc phải là Thủy ở can ngày
                    // tính vương cho Thằng Thủy
                    // chi ngày Kim|Thủy và chi giờ là Kim|Thủy
                    if ($this->chiInfo['ngay']['name'] == 'kim' && $this->canInfo['gio']['name'] == 'kim' && !in_array($this->chiInfo['gio']['name'], ['thuy', 'hoa'])) {
                        $flagPha = true;
                    }
                    if ($this->chiInfo['ngay']['name'] == 'thuy' && $this->canInfo['gio']['name'] == 'thuy' && !in_array($this->chiInfo['gio']['name'], ['moc', 'tho'])) {
                        $flagPha = true;
                    }
                    if ($this->chiInfo['ngay']['name'] == 'kim' && $this->canInfo['gio']['name'] == 'kim' && $this->chiInfo['thang']['name'] == 'kim') {
                        $flagPha = true;
                    }
                    if ($this->chiInfo['ngay']['name'] == 'thuy' && $this->canInfo['gio']['name'] == 'thuy' && $this->chiInfo['thang']['name'] == 'thuy') {
                        $flagPha = true;
                    }
                }

                if ($this->canThangSlug == 'nham' && $this->canInfo['thang']['name'] == 'tho') { // Thổ phá nhâm(thủy)
                    // Khắc phải là Thổ ở can ngày
                    // tính vương cho Thằng Thổ
                    // chi ngày thổ|hỏa và chi giờ là thổ|hỏa
                    if ($this->chiInfo['ngay']['name'] == 'tho' && $this->canInfo['gio']['name'] == 'tho' && !in_array($this->chiInfo['gio']['name'], ['kim', 'moc'])) {
                        $flagPha = true;
                    }
                    if ($this->chiInfo['ngay']['name'] == 'hoa' && $this->canInfo['gio']['name'] == 'hoa' && !in_array($this->chiInfo['gio']['name'], ['tho', 'thuy'])) {
                        $flagPha = true;
                    }
                    if ($this->chiInfo['ngay']['name'] == 'hoa' && $this->canInfo['gio']['name'] == 'hoa' && $this->chiInfo['thang']['name'] == 'hoa') {
                        $flagPha = true;
                    }
                    if ($this->chiInfo['ngay']['name'] == 'moc' && $this->canInfo['gio']['name'] == 'moc' && $this->chiInfo['thang']['name'] == 'moc') {
                        $flagPha = true;
                    }
                }
                if (!$flagPha && in_array($this->chiThangSlug, ['ty', 'ngo', 'dan', 'mui', 'tuat'])) {
                    $results['tru_ngay'] = $results['tru_gio'] = [
                        'text' => 'Hóa hỏa',
                        'number' => 4
                    ];
                }
            }

            /**
             * Thê tòng phu hóa -> Hóa Thủy
             * 1 trong 2 tru co chi Thủy
             * Can chi bên cạnh đều là Thủy
             * Có Bính, Giáp ở can tàng
             */
            if (($this->chiInfo['nam']['name'] == 'thuy' || $this->chiInfo['thang']['name'] == 'thuy') &&
                ($this->canInfo['thang']['name'] == 'thuy' || $this->chiInfo['ngay']['name'] == 'thuy') &&
                (in_array('nham', $canTangArrUni) || in_array('canh', $canTangArrUni)) && in_array($this->chiThangSlug, ['hoi', 'ti', 'suu', 'thin', 'than', 'dau', 'tuat'])
            ) {
                $results['tru_ngay'] = $results['tru_gio'] = [
                    'text' => 'Hóa thủy',
                    'number' => 2
                ];
            }

            // ----------------------------------- Xét địa chi hợp hóa -----------------------------------
            // 1: kim, 2: thuy, 3: moc, 4: hoa, 5: tho
            // ----- Tam hợp -----
            if (!empty($results) && !empty($diaChiHopHoa['tam_hop']['tru_ngay']) && $diaChiHopHoa['tam_hop']['tru_ngay']['number'] == 3) { // HOA MOC
                $results['tru_ngay'] = $results['tru_gio'] = [
                    'text' => 'Hóa Mộc',
                    'number' => 3
                ];
            }
            if (!empty($results) && !empty($diaChiHopHoa['tam_hop']['tru_ngay']) && $diaChiHopHoa['tam_hop']['tru_ngay']['number'] == 4) { // HOA HOA
                $results['tru_ngay'] = $results['tru_gio'] = [
                    'text' => 'Hóa Hỏa',
                    'number' => 4
                ];
            }
            if (!empty($results) && !empty($diaChiHopHoa['tam_hop']['tru_ngay']) && $diaChiHopHoa['tam_hop']['tru_ngay']['number'] == 2) { // HOA THUY
                $results['tru_ngay'] = $results['tru_gio'] = [
                    'text' => 'Hóa Thủy',
                    'number' => 2
                ];
            }
            // ----- Tam mộ -----
            if (!empty($results) && !empty($diaChiHopHoa['tam_hoi']['tru_ngay']) && $diaChiHopHoa['tam_hoi']['tru_ngay']['number'] == 3) { // HOA MOC
                $results['tru_ngay'] = $results['tru_gio'] = [
                    'text' => 'Hóa Mộc',
                    'number' => 3
                ];
            }
            if (!empty($results) && !empty($diaChiHopHoa['tam_hoi']['tru_ngay']) && $diaChiHopHoa['tam_hoi']['tru_ngay']['number'] == 4) { // HOA HOA
                $results['tru_ngay'] = $results['tru_gio'] = [
                    'text' => 'Hóa Hỏa',
                    'number' => 4
                ];
            }
            if (!empty($results) && !empty($diaChiHopHoa['tam_hoi']['tru_ngay']) && $diaChiHopHoa['tam_hoi']['tru_ngay']['number'] == 2) { // HOA THUY
                $results['tru_ngay'] = $results['tru_gio'] = [
                    'text' => 'Hóa Thủy',
                    'number' => 2
                ];
            }
            // ----- Lục hợp -----
            if (!empty($results) && !empty($diaChiHopHoa['luc_hop']['tru_ngay']) && $diaChiHopHoa['luc_hop']['tru_ngay']['number'] == 3) { // HOA MOC
                $results['tru_ngay'] = $results['tru_gio'] = [
                    'text' => 'Hóa Mộc',
                    'number' => 3
                ];
            }
            if (!empty($results) && !empty($diaChiHopHoa['luc_hop']['tru_ngay']) && $diaChiHopHoa['luc_hop']['tru_ngay']['number'] == 4) { // HOA HOA
                $results['tru_ngay'] = $results['tru_gio'] = [
                    'text' => 'Hóa Hỏa',
                    'number' => 4
                ];
            }
            if (!empty($results) && !empty($diaChiHopHoa['luc_hop']['tru_ngay']) && $diaChiHopHoa['luc_hop']['tru_ngay']['number'] == 2) { // HOA THUY
                $results['tru_ngay'] = $results['tru_gio'] = [
                    'text' => 'Hóa Thủy',
                    'number' => 2
                ];
            }
            // ----- Bán tam hợp -----
            if (!empty($results) && !empty($diaChiHopHoa['ban_tam_hop']['tru_ngay']) && $diaChiHopHoa['ban_tam_hop']['tru_ngay']['number'] == 3) { // HOA MOC
                $results['tru_ngay'] = $results['tru_gio'] = [
                    'text' => 'Hóa Mộc',
                    'number' => 3
                ];
            }
            if (!empty($results) && !empty($diaChiHopHoa['ban_tam_hop']['tru_ngay']) && $diaChiHopHoa['ban_tam_hop']['tru_ngay']['number'] == 4) { // HOA HOA
                $results['tru_ngay'] = $results['tru_gio'] = [
                    'text' => 'Hóa Hỏa',
                    'number' => 4
                ];
            }
            if (!empty($results) && !empty($diaChiHopHoa['ban_tam_hop']['tru_ngay']) && $diaChiHopHoa['ban_tam_hop']['tru_ngay']['number'] == 2) { // HOA THUY
                $results['tru_ngay'] = $results['tru_gio'] = [
                    'text' => 'Hóa Thủy',
                    'number' => 2
                ];
            }
            // ----- Bán tam mộ -----
            if (!empty($results) && !empty($diaChiHopHoa['ban_tam_mo']['tru_ngay']) && $diaChiHopHoa['ban_tam_mo']['tru_ngay']['number'] == 3) { // HOA MOC
                $results['tru_ngay'] = $results['tru_gio'] = [
                    'text' => 'Hóa Mộc',
                    'number' => 3
                ];
            }
            if (!empty($results) && !empty($diaChiHopHoa['ban_tam_mo']['tru_ngay']) && $diaChiHopHoa['ban_tam_mo']['tru_ngay']['number'] == 4) { // HOA HOA
                $results['tru_ngay'] = $results['tru_gio'] = [
                    'text' => 'Hóa Hỏa',
                    'number' => 4
                ];
            }
            if (!empty($results) && !empty($diaChiHopHoa['ban_tam_mo']['tru_ngay']) && $diaChiHopHoa['ban_tam_mo']['tru_ngay']['number'] == 2) { // HOA THUY
                $results['tru_ngay'] = $results['tru_gio'] = [
                    'text' => 'Hóa Thủy',
                    'number' => 2
                ];
            }
        }
        // MAU VS QUY
        // 1: kim, 2: thuy, 3: moc, 4: hoa, 5: tho
        if (($this->canNgaySlug == 'mau' && $this->canGioSlug == 'quy' && $this->canThangSlug != 'quy') ||
            ($this->canNgaySlug == 'quy' && $this->canGioSlug == 'mau' && $this->canThangSlug != 'mau')) {
            /**
             * Chính Hóa
             * 2 trụ có chi là HỎA
             */
            if (($this->chiInfo['nam']['name'] == 'hoa' && $this->chiInfo['thang']['name'] == 'hoa') ||
                (($this->chiInfo['nam']['name'] == 'hoa' && $this->chiInfo['thang']['name'] == 'moc')) ||
                ($this->chiInfo['nam']['name'] == 'moc' && $this->chiInfo['thang']['name'] == 'hoa') ||
                ($this->chiInfo['thang']['name'] == 'hoa')) {
                $results['tru_ngay'] = $results['tru_gio'] = [
                    'text' => 'Hóa Hỏa',
                    'number' => 4
                ];
            }
            /**
             * Phu tòng thê hóa -> Hóa Thủy
             * 1 trong 2 trụ có chi là Thủy
             * Can chi bên cạnh đều là Thủy
             * Có Quý, Canh ở can tàng
             */
            if (($this->chiInfo['nam']['name'] == 'thuy' || $this->chiInfo['thang']['name'] == 'thuy') &&
                ($this->canInfo['thang']['name'] == 'thuy' && $this->chiInfo['ngay']['name'] == 'thuy') &&
                (in_array('quy', $canTangArrUni) || in_array('canh', $canTangArrUni))
            ) {
                $flagPha = false;
                if ($this->canThangSlug == 'mau' && $this->canInfo['thang']['name'] == 'moc') { // Mộc phá mậu(thổ)
                    // Khắc phải là Mộc ở can ngày
                    // tính vương cho Thằng Mộc
                    // chi ngày Mộc|Thủy và chi giờ là Mộc|Thủy
                    if ($this->chiInfo['ngay']['name'] == 'moc' && $this->canInfo['gio']['name'] == 'moc' && !in_array($this->chiInfo['gio']['name'], ['hoa', 'kim'])) {
                        $flagPha = true;
                    }
                    if ($this->chiInfo['ngay']['name'] == 'thuy' && $this->canInfo['gio']['name'] == 'thuy' && !in_array($this->chiInfo['gio']['name'], ['moc', 'tho'])) {
                        $flagPha = true;
                    }
                    if ($this->chiInfo['ngay']['name'] == 'moc' && $this->canInfo['gio']['name'] == 'moc' && $this->chiInfo['thang']['name'] == 'moc') {
                        $flagPha = true;
                    }
                    if ($this->chiInfo['ngay']['name'] == 'thuy' && $this->canInfo['gio']['name'] == 'thuy' && $this->chiInfo['thang']['name'] == 'thuy') {
                        $flagPha = true;
                    }
                }

                if ($this->canThangSlug == 'quy' && $this->canInfo['thang']['name'] == 'tho') { // Thổ phá quý(thủy)
                    // Khắc phải là Thổ ở can ngày
                    // tính vương cho Thằng Thổ
                    // chi ngày thổ|hỏa và chi giờ là thổ|hỏa
                    if ($this->chiInfo['ngay']['name'] == 'tho' && $this->canInfo['gio']['name'] == 'tho' && !in_array($this->chiInfo['gio']['name'], ['kim', 'moc'])) {
                        $flagPha = true;
                    }
                    if ($this->chiInfo['ngay']['name'] == 'hoa' && $this->canInfo['gio']['name'] == 'hoa' && !in_array($this->chiInfo['gio']['name'], ['tho', 'thuy'])) {
                        $flagPha = true;
                    }
                    if ($this->chiInfo['ngay']['name'] == 'hoa' && $this->canInfo['gio']['name'] == 'hoa' && $this->chiInfo['thang']['name'] == 'hoa') {
                        $flagPha = true;
                    }
                    if ($this->chiInfo['ngay']['name'] == 'moc' && $this->canInfo['gio']['name'] == 'moc' && $this->chiInfo['thang']['name'] == 'moc') {
                        $flagPha = true;
                    }
                }
                if (!$flagPha && in_array($this->chiThangSlug, ['hoi', 'ti', 'suu', 'thin', 'than', 'dau', 'tuat'])) {
                    $results['tru_ngay'] = $results['tru_gio'] = [
                        'text' => 'Hóa Thủy',
                        'number' => 2
                    ];
                }
            }

            /**
             * Thê tòng phu hóa -> Hóa Thổ
             * 1 trong 2 tru co chi Thổ
             * Can chi bên cạnh đều là Thổ
             * Có Mậu, Bính ở can tàng
             */
            if (($this->chiInfo['nam']['name'] == 'tho' || $this->chiInfo['thang']['name'] == 'tho') &&
                ($this->canInfo['thang']['name'] == 'tho' || $this->chiInfo['ngay']['name'] == 'tho') &&
                (in_array('mau', $canTangArrUni) || in_array('binh', $canTangArrUni)) && in_array($this->chiThangSlug, ['thin', 'tuat', 'suu', 'mui', 'dan', 'ty', 'ngo', 'than'])
            ) {
                $results['tru_ngay'] = $results['tru_gio'] = [
                    'text' => 'Hóa thổ',
                    'number' => 5
                ];
            }

            // ----------------------------------- Xét địa chi hợp hóa -----------------------------------
            // 1: kim, 2: thuy, 3: moc, 4: hoa, 5: tho
            // ----- Tam hợp -----
            if (!empty($results) && !empty($diaChiHopHoa['tam_hop']['tru_ngay']) && $diaChiHopHoa['tam_hop']['tru_ngay']['number'] == 4) { // HOA HOA
                $results['tru_ngay'] = $results['tru_gio'] = [
                    'text' => 'Hóa Hỏa',
                    'number' => 4
                ];
            }
            if (!empty($results) && !empty($diaChiHopHoa['tam_hop']['tru_ngay']) && $diaChiHopHoa['tam_hop']['tru_ngay']['number'] == 2) { // HOA THUY
                $results['tru_ngay'] = $results['tru_gio'] = [
                    'text' => 'Hóa Thủy',
                    'number' => 2
                ];
            }
            if (!empty($results) && !empty($diaChiHopHoa['tam_hop']['tru_ngay']) && $diaChiHopHoa['tam_hop']['tru_ngay']['number'] == 5) { // HOA THO
                $results['tru_ngay'] = $results['tru_gio'] = [
                    'text' => 'Hóa Thổ',
                    'number' => 5
                ];
            }
            // ----- Tam mộ -----
            if (!empty($results) && !empty($diaChiHopHoa['tam_hoi']['tru_ngay']) && $diaChiHopHoa['tam_hoi']['tru_ngay']['number'] == 4) { // HOA HOA
                $results['tru_ngay'] = $results['tru_gio'] = [
                    'text' => 'Hóa Hỏa',
                    'number' => 4
                ];
            }
            if (!empty($results) && !empty($diaChiHopHoa['tam_hoi']['tru_ngay']) && $diaChiHopHoa['tam_hoi']['tru_ngay']['number'] == 2) { // HOA THUY
                $results['tru_ngay'] = $results['tru_gio'] = [
                    'text' => 'Hóa Thủy',
                    'number' => 2
                ];
            }
            if (!empty($results) && !empty($diaChiHopHoa['tam_hoi']['tru_ngay']) && $diaChiHopHoa['tam_hoi']['tru_ngay']['number'] == 5) { // HOA THO
                $results['tru_ngay'] = $results['tru_gio'] = [
                    'text' => 'Hóa Thổ',
                    'number' => 5
                ];
            }
            // ----- Lục hợp -----
            if (!empty($results) && !empty($diaChiHopHoa['luc_hop']['tru_ngay']) && $diaChiHopHoa['luc_hop']['tru_ngay']['number'] == 4) { // HOA HOA
                $results['tru_ngay'] = $results['tru_gio'] = [
                    'text' => 'Hóa Hỏa',
                    'number' => 4
                ];
            }
            if (!empty($results) && !empty($diaChiHopHoa['luc_hop']['tru_ngay']) && $diaChiHopHoa['luc_hop']['tru_ngay']['number'] == 2) { // HOA THUY
                $results['tru_ngay'] = $results['tru_gio'] = [
                    'text' => 'Hóa Thủy',
                    'number' => 2
                ];
            }
            if (!empty($results) && !empty($diaChiHopHoa['luc_hop']['tru_ngay']) && $diaChiHopHoa['luc_hop']['tru_ngay']['number'] == 5) { // HOA THO
                $results['tru_ngay'] = $results['tru_gio'] = [
                    'text' => 'Hóa Thổ',
                    'number' => 5
                ];
            }
            // ----- Bán tam hợp -----
            if (!empty($results) && !empty($diaChiHopHoa['ban_tam_hop']['tru_ngay']) && $diaChiHopHoa['ban_tam_hop']['tru_ngay']['number'] == 4) { // HOA HOA
                $results['tru_ngay'] = $results['tru_gio'] = [
                    'text' => 'Hóa Hỏa',
                    'number' => 4
                ];
            }
            if (!empty($results) && !empty($diaChiHopHoa['ban_tam_hop']['tru_ngay']) && $diaChiHopHoa['ban_tam_hop']['tru_ngay']['number'] == 2) { // HOA THỦY
                $results['tru_ngay'] = $results['tru_gio'] = [
                    'text' => 'Hóa Thủy',
                    'number' => 2
                ];
            }
            if (!empty($results) && !empty($diaChiHopHoa['ban_tam_hop']['tru_ngay']) && $diaChiHopHoa['ban_tam_hop']['tru_ngay']['number'] == 5) { // HOA THO
                $results['tru_ngay'] = $results['tru_gio'] = [
                    'text' => 'Hóa Thổ',
                    'number' => 5
                ];
            }
            // ----- Bán tam mộ -----
            if (!empty($results) && !empty($diaChiHopHoa['ban_tam_mo']['tru_ngay']) && $diaChiHopHoa['ban_tam_mo']['tru_ngay']['number'] == 4) { // HOA HOA
                $results['tru_ngay'] = $results['tru_gio'] = [
                    'text' => 'Hóa Hỏa',
                    'number' => 4
                ];
            }
            if (!empty($results) && !empty($diaChiHopHoa['ban_tam_mo']['tru_ngay']) && $diaChiHopHoa['ban_tam_mo']['tru_ngay']['number'] == 2) { // HOA THUY
                $results['tru_ngay'] = $results['tru_gio'] = [
                    'text' => 'Hóa Thủy',
                    'number' => 2
                ];
            }
            if (!empty($results) && !empty($diaChiHopHoa['ban_tam_mo']['tru_ngay']) && $diaChiHopHoa['ban_tam_mo']['tru_ngay']['number'] == 5) { // HOA THO
                $results['tru_ngay'] = $results['tru_gio'] = [
                    'text' => 'Hóa Thổ',
                    'number' => 5
                ];
            }
        }

        return $results;
    }

    public function tinhNapAm() {
        return [
            'nam' => $this->namInfoAl[$this->canNamSlug . $this->chiNamSlug],
            'thang' => $this->namInfoAl[$this->canThangSlug . $this->chiThangSlug],
            'ngay' => $this->namInfoAl[$this->canNgaySlug . $this->chiNgaySlug],
            'gio' => $this->namInfoAl[$this->canGioSlug . $this->chiGioSlug],
        ];
    }

    public function tinhNapAmThaiNguyen($canChi) {
        $slug = $this->khongdau($canChi);

        return isset($this->namInfoAl[$slug]) ? $this->namInfoAl[$slug] : [];
    }

    public function tinhThienDucQuyNhan($type = 'nam') {
        $chiTru = $canTru = '';
        if ($type == 'nam') {
            $chiTru = $this->chiNamSlug;
            $canTru = $this->canNamSlug;
        }
        if ($type == 'thang') {
            $chiTru = $this->chiThangSlug;
            $canTru = $this->canThangSlug;
        }
        if ($type == 'ngay') {
            $chiTru = $this->chiNgaySlug;
            $canTru = $this->canNgaySlug;
        }
        if ($type == 'gio') {
            $chiTru = $this->chiGioSlug;
            $canTru = $this->canGioSlug;
        }
        if (($this->chiThangSlug == 'ti' && $chiTru == 'Tỵ') ||
            ($this->chiThangSlug == 'suu' && $canTru == 'canh') ||
            ($this->chiThangSlug == 'dan' && $canTru == 'dinh') ||
            ($this->chiThangSlug == 'mao' && $chiTru == 'than') ||
            ($this->chiThangSlug == 'thin' && $canTru == 'nham') ||
            ($this->chiThangSlug == 'ty' && $canTru == 'tan') ||
            ($this->chiThangSlug == 'ngo' && $chiTru == 'hoi') ||
            ($this->chiThangSlug == 'mui' && $canTru == 'giap') ||
            ($this->chiThangSlug == 'than' && $canTru == 'quy') ||
            ($this->chiThangSlug == 'dau' && $chiTru == 'dan') ||
            ($this->chiThangSlug == 'tuat' && $canTru == 'binh') ||
            ($this->chiThangSlug == 'hoi' && $canTru == 'at')
        ) {
            return 'Thiên Đức';
        }

        return '';
    }

    public function tinhThienAtQuyNhan($type = 'nam') {
        $chiTru = '';
        if ($type == 'nam') {
            $chiTru = $this->chiNamSlug;
        }
        if ($type == 'thang') {
            $chiTru = $this->chiThangSlug;
        }
        if ($type == 'ngay') {
            $chiTru = $this->chiNgaySlug;
        }
        if ($type == 'gio') {
            $chiTru = $this->chiGioSlug;
        }
        if ((in_array($this->canNgaySlug, ['giap', 'mau']) && in_array($chiTru, ['suu', 'mui'])) ||
            (in_array($this->canNgaySlug, ['at', 'ky']) && in_array($chiTru, ['ti', 'than'])) ||
            (in_array($this->canNgaySlug, ['binh', 'dinh']) && in_array($chiTru, ['hoi', 'mau'])) ||
            (in_array($this->canNgaySlug, ['canh', 'tan']) && in_array($chiTru, ['dan', 'ngo'])) ||
            (in_array($this->canNgaySlug, ['nham', 'quy']) && in_array($chiTru, ['mao', 'ty']))
        ) {
            return 'Thiên Ất';
        }
        if ((in_array($this->canNgaySlug, ['giap', 'mau']) && in_array($chiTru, ['suu', 'mui'])) ||
            (in_array($this->canNgaySlug, ['at', 'ky']) && in_array($chiTru, ['ti', 'than'])) ||
            (in_array($this->canNgaySlug, ['binh', 'dinh']) && in_array($chiTru, ['hoi', 'mau'])) ||
            (in_array($this->canNgaySlug, ['canh', 'tan']) && in_array($chiTru, ['dan', 'ngo'])) ||
            (in_array($this->canNgaySlug, ['nham', 'quy']) && in_array($chiTru, ['mao', 'ty'])) ||
            (in_array($this->canNamSlug, ['giap', 'mau']) && in_array($chiTru, ['suu', 'mui'])) ||
            (in_array($this->canNamSlug, ['at', 'ky']) && in_array($chiTru, ['ti', 'than'])) ||
            (in_array($this->canNamSlug, ['binh', 'dinh']) && in_array($chiTru, ['hoi', 'mau'])) ||
            (in_array($this->canNamSlug, ['canh', 'tan']) && in_array($chiTru, ['dan', 'ngo'])) ||
            (in_array($this->canNamSlug, ['nham', 'quy']) && in_array($chiTru, ['mao', 'ty']))
        ) {
            return 'Thiên Ất';
        }

        if ((in_array($this->canNamSlug, ['giap', 'mau']) && in_array($chiTru, ['suu', 'mui'])) ||
            (in_array($this->canNamSlug, ['at', 'ky']) && in_array($chiTru, ['ti', 'than'])) ||
            (in_array($this->canNamSlug, ['binh', 'dinh']) && in_array($chiTru, ['hoi', 'mau'])) ||
            (in_array($this->canNamSlug, ['canh', 'tan']) && in_array($chiTru, ['dan', 'ngo'])) ||
            (in_array($this->canNamSlug, ['nham', 'quy']) && in_array($chiTru, ['mao', 'ty']))
        ) {
            return 'Thiên Ất';
        }

        return '';
    }

    public function tinhDucTuQuyNhan($type = 'nam') {

        $canTru = '';
        if ($type == 'nam') {
            $canTru = $this->canNamSlug;
        }
        if ($type == 'thang') {
            $canTru = $this->canThangSlug;
        }
        if ($type == 'ngay') {
            $canTru = $this->canNgaySlug;
        }
        if ($type == 'gio') {
            $canTru = $this->canGioSlug;
        }

        $arr = [];
        if ((in_array($this->chiThangSlug, ['dan', 'ngo', 'tuat']) && in_array($canTru, ['binh', 'dinh'])) ||
            (in_array($this->chiThangSlug, ['than', 'ti', 'thin']) && in_array($canTru, ['nham', 'quy', 'mau', 'ky'])) ||
            (in_array($this->chiThangSlug, ['hoi', 'mao', 'mui']) && in_array($canTru, ['giap', 'at'])) ||
            (in_array($this->chiThangSlug, ['ty', 'dau', 'suu']) && in_array($canTru, ['canh', 'tan']))
        ) {
            $arr[] = 'Đức Quý Nhân';
        }
        if ((in_array($this->chiThangSlug, ['dan', 'ngo', 'tuat']) && in_array($canTru, ['mau', 'quy'])) ||
            (in_array($this->chiThangSlug, ['than', 'ti', 'thin']) && in_array($canTru, ['binh', 'tan', 'giap', 'ky'])) ||
            (in_array($this->chiThangSlug, ['hoi', 'mao', 'mui']) && in_array($canTru, ['dinh', 'nham'])) ||
            (in_array($this->chiThangSlug, ['ty', 'dau', 'suu']) && in_array($canTru, ['at', 'canh']))
        ) {
            $arr[] = 'Tú Quý Nhân';
        }

        return $arr;
    }

    public function tinhNguyetDucQuyNhan($type = 'nam') {
        $canTru = '';
        if ($type == 'nam') {
            $canTru = $this->canNamSlug;
        }
        if ($type == 'thang') {
            $canTru = $this->canThangSlug;
        }
        if ($type == 'ngay') {
            $canTru = $this->canNgaySlug;
        }
        if ($type == 'gio') {
            $canTru = $this->canGioSlug;
        }

        if ((in_array($this->chiThangSlug, ['dan', 'ngo', 'tuat']) && $canTru == 'binh') ||
            (in_array($this->chiThangSlug, ['than', 'ti', 'thin']) && $canTru == 'nham') ||
            (in_array($this->chiThangSlug, ['hoi', 'mao', 'mui']) && $canTru == 'giap') ||
            (in_array($this->chiThangSlug, ['ty', 'dau', 'suu']) && $canTru == 'canh')
        ) {
            return 'Nguyệt Đức';
        }

        return '';
    }

    public function tinhQuocAnQuyNhan($type = 'nam') {
        $chiTru = '';
        if ($type == 'nam') {
            $chiTru = $this->chiNamSlug;
        }
        if ($type == 'thang') {
            $chiTru = $this->chiThangSlug;
        }
        if ($type == 'ngay') {
            $chiTru = $this->chiNgaySlug;
        }
        if ($type == 'gio') {
            $chiTru = $this->chiGioSlug;
        }

        if ((($this->canNgaySlug == 'giap' || $this->canNamSlug == 'giap') && $chiTru == 'tuat') ||
            (($this->canNgaySlug == 'at' || $this->canNamSlug == 'at') && $chiTru == 'hoi') ||
            (($this->canNgaySlug == 'binh' || $this->canNamSlug == 'binh') && $chiTru == 'suu') ||
            (($this->canNgaySlug == 'dinh' || $this->canNamSlug == 'dinh') && $chiTru == 'dan') ||
            (($this->canNgaySlug == 'ky' || $this->canNamSlug == 'ky') && $chiTru == 'dan') ||
            (($this->canNgaySlug == 'mau' || $this->canNamSlug == 'mau') && $chiTru == 'suu') ||
            (($this->canNgaySlug == 'canh' || $this->canNamSlug == 'canh') && $chiTru == 'thin') ||
            (($this->canNgaySlug == 'tan' || $this->canNamSlug == 'tan') && $chiTru == 'ty') ||
            (($this->canNgaySlug == 'nham' || $this->canNamSlug == 'nham') && $chiTru == 'mui') ||
            (($this->canNgaySlug == 'quy' || $this->canNamSlug == 'quy') && $chiTru == 'than')
        ) {
            return 'Quốc Ấn';
        }

        return '';
    }

    public function tinhKhongVong($type = 'nam') {

        $chiTru = '';
        if ($type == 'nam') {
            $chiTru = $this->chiNamSlug;
        }
        if ($type == 'thang') {
            $chiTru = $this->chiThangSlug;
        }
        if ($type == 'ngay') {
            $chiTru = $this->chiNgaySlug;
        }
        if ($type == 'gio') {
            $chiTru = $this->chiGioSlug;
        }

        $canChingay = $this->canNgaySlug . '-' . $this->chiNgaySlug;

        $chiKhongVong = [];
        foreach ($this->bangKhongVong as $key => $val) {
            if (in_array($canChingay, $val)) {
                $chiKhongVong[] = $key;
            }
        }
        if (in_array($chiTru, $chiKhongVong)) {
            return 'Không vong';
        }

        return '';
    }

    function tinhSao($type = 'nam') {
        $canNgay = $this->canNgaySlug;
        $chiNgay = $this->chiNgaySlug;
        $chiNam = $this->chiNamSlug;
        $canNam = $this->canNamSlug;

        $chiTru = '';
        if ($type == 'nam') {
            $chiTru = $this->chiNamSlug;
            $canTru = $this->canNamSlug;
        }
        if ($type == 'thang') {
            $chiTru = $this->chiThangSlug;
            $canTru = $this->canThangSlug;
        }
        if ($type == 'ngay') {
            $chiTru = $this->chiNgaySlug;
            $canTru = $this->canNgaySlug;
        }
        if ($type == 'gio') {
            $chiTru = $this->chiGioSlug;
            $canTru = $this->canGioSlug;
        }

        // sao list 1
        $results = isset($this->saoArr[$canNgay][$chiTru]) ? $this->saoArr[$canNgay][$chiTru] : [];
        $results2 = isset($this->saoArr[$canNam][$chiTru]) ? $this->saoArr[$canNam][$chiTru] : [];
        $results = array_merge($results, $results2);

        if (in_array($chiNgay, ['hoi', 'mao', 'mui']) || in_array($chiNam, ['hoi', 'mao', 'mui'])) {
            if ($chiTru == 'mao') {
                $results[] = 'Tướng tinh';
            }
            if ($chiTru == 'mui') {
                $results[] = 'Hoa cái';
            }
            if ($chiTru == 'ty') {
                $results[] = 'Dịch mã';
            }
            if ($chiTru == 'ti') {
                $results[] = 'Đào hoa';
            }
            if ($chiTru == 'than') {
                $results[] = 'Kiếp sát';
            }
        }

        if (in_array($chiNgay, ['dan', 'tuat', 'ngo']) || in_array($chiNam, ['dan', 'tuat', 'ngo'])) {
            if ($chiTru == 'ngo') {
                $results[] = 'Tướng tinh';
            }
            if ($chiTru == 'tuat') {
                $results[] = 'Hoa cái';
            }
            if ($chiTru == 'than') {
                $results[] = 'Dịch mã';
            }
            if ($chiTru == 'mao') {
                $results[] = 'Đào hoa';
            }
            if ($chiTru == 'hoi') {
                $results[] = 'Kiếp sát';
            }
        }

        if (in_array($chiNgay, ['ty', 'dan', 'suu']) || in_array($chiNam, ['ty', 'dan', 'suu'])) {
            if ($chiTru == 'dau') {
                $results[] = 'Tướng tinh';
            }
            if ($chiTru == 'suu') {
                $results[] = 'Hoa cái';
            }
            if ($chiTru == 'hoi') {
                $results[] = 'Dịch mã';
            }
            if ($chiTru == 'ngo') {
                $results[] = 'Đào hoa';
            }
            if ($chiTru == 'dan') {
                $results[] = 'Kiếp sát';
            }
        }
        if (in_array($chiNgay, ['than', 'ti', 'thin']) || in_array($chiNam, ['than', 'ti', 'thin'])) {
            if ($chiTru == 'ti') {
                $results[] = 'Tướng tinh';
            }
            if ($chiTru == 'than') {
                $results[] = 'Hoa cái';
            }
            if ($chiTru == 'dan') {
                $results[] = 'Dịch mã';
            }
            if ($chiTru == 'dau') {
                $results[] = 'Đào hoa';
            }
            if ($chiTru == 'ty') {
                $results[] = 'Kiếp sát';
            }
        }

        // Chi nien so voi chi tru
        if (isset($this->sao2Arr[$chiNam][$chiTru])) {
            $results[] = $this->sao2Arr[$chiNam][$chiTru];
        }

        return $results;
    }

    public function khongdau($str) {
        $str = preg_replace("/(à|á|ạ|ả|ã|â|ầ|ấ|ậ|ẩ|ẫ|ă|ằ|ắ|ặ|ẳ|ẵ)/", "a", $str);
        $str = preg_replace("/(è|é|ẹ|ẻ|ẽ|ê|ề|ế|ệ|ể|ễ)/", "e", $str);
        $str = preg_replace("/(ì|í|ị|ỉ|ĩ)/", "i", $str);
        $str = preg_replace("/(ò|ó|ọ|ỏ|õ|ô|ồ|ố|ộ|ổ|ỗ|ơ|ờ|ớ|ợ|ở|ỡ)/", "o", $str);
        $str = preg_replace("/(ù|ú|ụ|ủ|ũ|ư|ừ|ứ|ự|ử|ữ)/", "u", $str);
        $str = preg_replace("/(ỳ|ý|ỵ|ỷ|ỹ)/", "y", $str);
        $str = preg_replace("/(đ)/", "d", $str);
        $str = preg_replace("/(À|Á|Ạ|Ả|Ã|Â|Ầ|Ấ|Ậ|Ẩ|Ẫ|Ă|Ằ|Ắ|Ặ|Ẳ|Ẵ)/", "A", $str);
        $str = preg_replace("/(È|É|Ẹ|Ẻ|Ẽ|Ê|Ề|Ế|Ệ|Ể|Ễ)/", "E", $str);
        $str = preg_replace("/(Ì|Í|Ị|Ỉ|Ĩ)/", "I", $str);
        $str = preg_replace("/(Ò|Ó|Ọ|Ỏ|Õ|Ô|Ồ|Ố|Ộ|Ổ|Ỗ|Ơ|Ờ|Ớ|Ợ|Ở|Ỡ)/", "O", $str);
        $str = preg_replace("/(Ù|Ú|Ụ|Ủ|Ũ|Ư|Ừ|Ứ|Ự|Ử|Ữ)/", "U", $str);
        $str = preg_replace("/(Ỳ|Ý|Ỵ|Ỷ|Ỹ)/", "Y", $str);
        $str = preg_replace("/(Đ)/", "D", $str);
        $str = str_replace(" ", "-", str_replace("&amp;*#39;", "", str_replace("/", "-", str_replace("?", "-", $str))));
        $str = preg_replace("/[^a-zA-Z0-9\\/_|+ -]/", "", $str);
        $str = strtolower(trim($str, "-"));
        $str = preg_replace("/[\/_|+ -]+/", "-", $str);
        return $str;
    }

    public function getNewMoonDay($k, $timeZone) {
        $T = $k / 1236.85; // Time in Julian centuries from 1900 January 0.5
        $T2 = $T * $T;
        $T3 = $T2 * $T;
        $pi = pi();
        $dr = $pi / 180;
        $Jd1 = 2415020.75933 + 29.53058868 * $k + 0.0001178 * $T2 - 0.000000155 * $T3;
        $Jd1 = $Jd1 + 0.00033 * sin((166.56 + 132.87 * $T - 0.009173 * $T2) * $dr); // Mean new moon
        $M = 359.2242 + 29.10535608 * $k - 0.0000333 * $T2 - 0.00000347 * $T3; // Sun's mean anomaly
        $Mpr = 306.0253 + 385.81691806 * $k + 0.0107306 * $T2 + 0.00001236 * $T3; // Moon's mean anomaly
        $F = 21.2964 + 390.67050646 * $k - 0.0016528 * $T2 - 0.00000239 * $T3; // Moon's argument of latitude
        $C1 = (0.1734 - 0.000393 * $T) * sin($M * $dr) + 0.0021 * sin(2 * $dr * $M);
        $C1 = $C1 - 0.4068 * sin($Mpr * $dr) + 0.0161 * sin($dr * 2 * $Mpr);
        $C1 = $C1 - 0.0004 * sin($dr * 3 * $Mpr);
        $C1 = $C1 + 0.0104 * sin($dr * 2 * $F) - 0.0051 * sin($dr * ($M + $Mpr));
        $C1 = $C1 - 0.0074 * sin($dr * ($M - $Mpr)) + 0.0004 * sin($dr * (2 * $F + $M));
        $C1 = $C1 - 0.0004 * sin($dr * (2 * $F - $M)) - 0.0006 * sin($dr * (2 * $F + $Mpr));
        $C1 = $C1 + 0.0010 * sin($dr * (2 * $F - $Mpr)) + 0.0005 * sin($dr * (2 * $Mpr + $M));
        if ($T < -11) {
            $deltat = 0.001 + 0.000839 * $T + 0.0002261 * $T2 - 0.00000845 * $T3 - 0.000000081 * $T * $T3;
        } else {
            $deltat = -0.000278 + 0.000265 * $T + 0.000262 * $T2;
        };
        $JdNew = $Jd1 + $C1 - $deltat;
        //echo "JdNew = $JdNew\n";
        return $this->INT($JdNew + 0.5 + $timeZone / 24);
    }

    public function getLunarMonth11($yy, $timeZone) {
        $off = $this->jdFromDate(31, 12, $yy) - 2415021;
        $k = $this->INT($off / 29.530588853);
        $nm = $this->getNewMoonDay($k, $timeZone);
        $sunLong = $this->getSunLongitude($nm, $timeZone); // sun longitude at local midnight
        if ($sunLong >= 9) {
            $nm = $this->getNewMoonDay($k - 1, $timeZone);
        }
        return $nm;
    }

    public function getLeapMonthOffset($a11, $timeZone) {
        $k = $this->INT(($a11 - 2415021.076998695) / 29.530588853 + 0.5);
        $last = 0;
        $i = 1; // We start with the month following lunar month 11
        $arc = $this->getSunLongitude($this->getNewMoonDay($k + $i, $timeZone), $timeZone);
        do {
            $last = $arc;
            $i = $i + 1;
            $arc = $this->getSunLongitude($this->getNewMoonDay($k + $i, $timeZone), $timeZone);
        } while ($arc != $last && $i < 14);
        return $i - 1;
    }

    public function convertSolar2Lunar($dd, $mm, $yy, $timeZone, $array = false) {
        $dayNumber = $this->jdFromDate($dd, $mm, $yy);

        $k = $this->INT(($dayNumber - 2415021.076998695) / 29.530588853);
        $monthStart = $this->getNewMoonDay($k + 1, $timeZone);
        if ($monthStart > $dayNumber) {
            $monthStart = $this->getNewMoonDay($k, $timeZone);
        }
        $a11 = $this->getLunarMonth11($yy, $timeZone);
        $b11 = $a11;
        if ($a11 >= $monthStart) {
            $lunarYear = $yy;
            $a11 = $this->getLunarMonth11($yy - 1, $timeZone);
        } else {
            $lunarYear = $yy + 1;
            $b11 = $this->getLunarMonth11($yy + 1, $timeZone);
        }
        $lunarDay = $dayNumber - $monthStart + 1;
        $diff = $this->INT(($monthStart - $a11) / 29);
        $lunarLeap = 0;
        $lunarMonth = $diff + 11;
        if ($b11 - $a11 > 365) {
            $leapMonthDiff = $this->getLeapMonthOffset($a11, $timeZone);
            if ($diff >= $leapMonthDiff) {
                $lunarMonth = $diff + 10;
                if ($diff == $leapMonthDiff) {
                    $lunarLeap = 1;
                }
            }
        }
        if ($lunarMonth > 12) {
            $lunarMonth = $lunarMonth - 12;
        }
        if ($lunarMonth >= 11 && $diff < 4) {
            $lunarYear -= 1;
        }
        if ($array) {
            return [
                sprintf("%02d", $lunarDay),
                sprintf("%02d", $lunarMonth),
                sprintf("%04d", $lunarYear),
                $lunarLeap
            ];
        }
        return sprintf("%02d", $lunarDay) . '/' . sprintf("%02d", $lunarMonth) . '/' . sprintf("%04d", $lunarYear);
    }

    public function INT($d) {
        return floor($d);
    }

    public function getSunLongitude($jdn, $timeZone) {
        $T = ($jdn - 2451545.5 - $timeZone / 24) / 36525; // Time in Julian centuries from 2000-01-01 12:00:00 GMT
        $T2 = $T * $T;
        $pi = pi();
        $dr = $pi / 180; // degree to radian
        $M = 357.52910 + 35999.05030 * $T - 0.0001559 * $T2 - 0.00000048 * $T * $T2; // mean anomaly, degree
        $L0 = 280.46645 + 36000.76983 * $T + 0.0003032 * $T2; // mean longitude, degree
        $DL = (1.914600 - 0.004817 * $T - 0.000014 * $T2) * sin($dr * $M);
        $DL = $DL + (0.019993 - 0.000101 * $T) * sin($dr * 2 * $M) + 0.000290 * sin($dr * 3 * $M);
        $L = $L0 + $DL; // true longitude, degree
        //echo "\ndr = $dr, M = $M, T = $T, DL = $DL, L = $L, L0 = $L0\n";
        // obtain apparent longitude by correcting for nutation and aberration
        $omega = 125.04 - 1934.136 * $T;
        $L = $L - 0.00569 - 0.00478 * sin($omega * $dr);
        $L = $L * $dr;
        $L = $L - $pi * 2 * ($this->INT($L / ($pi * 2))); // Normalize to (0, 2*PI)
        return $this->INT($L / $pi * 6);
    }

    public function jdFromDate($dd, $mm, $yy) {
        $a = $this->INT((14 - $mm) / 12);
        $y = $yy + 4800 - $a;
        $m = $mm + 12 * $a - 3;
        $jd = $dd + $this->INT((153 * $m + 2) / 5) + 365 * $y + $this->INT($y / 4) - $this->INT($y / 100) + $this->INT($y / 400) - 32045;
        if ($jd < 2299161) {
            $jd = $dd + $this->INT((153 * $m + 2) / 5) + 365 * $y + $this->INT($y / 4) - 32083;
        }
        return $jd;
    }

    public function tinhNamAm($nn, $tt, $nnnn, $duongLich = true, $timeZone = 7) {
        $du = $nnnn % 12;
        $last = substr($nnnn, -1);
        //print_r([$du, $last]); die();
        return ['can' => $this->canArr[$last], 'chi' => $this->chiArr[$du]];
    }

    public function ngayThangNam($nn, $tt, $nnnn, $duongLich = true, $timeZone = 7) {
        $thangNhuan = 0;
        # if nnnn > 1000 and nnnn < 3000 and nn > 0 and \
        if ($nn > 0 && $nn < 32 && $tt < 13 && $tt > 0):
            if ($duongLich) {
                $aaaa = $this->convertSolar2Lunar($nn, $tt, $nnnn, $timeZone, true);

                return $aaaa;
            }
            return [$nn, $tt, $nnnn, $thangNhuan];
        else:
            return "Ngày, tháng, năm không chính xác.";
        endif;
    }

    function jdToDate($jd) {
        if ($jd > 2299160) { // After 5/10/1582, Gregorian calendar
            $a = $jd + 32044;
            $b = $this->INT((4 * $a + 3) / 146097);
            $c = $a - $this->INT(($b * 146097) / 4);
        } else {
            $b = 0;
            $c = $jd + 32082;
        }
        $d = $this->INT((4 * $c + 3) / 1461);
        $e = $c - $this->INT((1461 * $d) / 4);
        $m = $this->INT((5 * $e + 2) / 153);
        $day = $e - $this->INT((153 * $m + 2) / 5) + 1;
        $month = $m + 3 - 12 * $this->INT($m / 10);
        $year = $b * 100 + $d - 4800 + $this->INT($m / 10);
        //echo "day = $day, month = $month, year = $year\n";
        return array($day, $month, $year);
    }

    function fix12($n) {
        while ($n > 12) {
            $n = $n - 12;
        }
        while ($n <= 0) {
            $n = $n + 12;
        }
        return $n;
    }

    function NgayThangNamAmLich($dd, $mm, $yy, $timeZone, $array = true) {

        $dayNumber = $this->jdFromDate($dd, $mm, $yy);
        $k = $this->INT(($dayNumber - 2415021.07699869) / 29.530588853);
        $monthStart = $this->getNewMoonDay($k + 1, $timeZone);
        if ($monthStart > $dayNumber) {
            $monthStart = $this->getNewMoonDay($k, $timeZone);
        }
        $a11 = $this->getLunarMonth11($yy, $timeZone);
        $b11 = $a11;

        if ($a11 >= $monthStart) {
            $lunarYear = $yy;
            $a11 = $this->getLunarMonth11($yy - 1, $timeZone);
        } else {
            $lunarYear = $yy + 1;
            $b11 = $this->getLunarMonth11($yy + 1, $timeZone);
        }

        $lunarDay = $dayNumber - $monthStart + 1;

        $diff = $this->INT(($monthStart - $a11) / 29);
        $lunarLeap = 0;
        $lunarMonth = $diff + 11;
        if (($b11 - $a11) > 365) {
            $leapMonthDiff = $this->getLeapMonthOffset($a11, $timeZone);
            if ($diff >= $leapMonthDiff) {
                $lunarMonth = $diff + 10;
                if ($diff = $leapMonthDiff) {
                    $lunarLeap = 1;
                }
            }
        }
        if ($lunarMonth > 12) {
            $lunarMonth = $lunarMonth - 12;
        }
        if ($lunarMonth >= 11 && $diff < 4) {
            $lunarYear = $lunarYear - 1;
        }

        if ($array) {
            return [
                sprintf("%02d", $lunarDay),
                sprintf("%02d", $lunarMonth),
                sprintf("%04d", $lunarYear),
                $lunarLeap
            ];
        }
    }

    function convertLunar2Solar($lunarDay, $lunarMonth, $lunarYear, $lunarLeap, $timeZone) {
        if ($lunarMonth < 11) {
            $a11 = $this->getLunarMonth11($lunarYear - 1, $timeZone);
            $b11 = $this->getLunarMonth11($lunarYear, $timeZone);
        } else {
            $a11 = $this->getLunarMonth11($lunarYear, $timeZone);
            $b11 = $this->getLunarMonth11($lunarYear + 1, $timeZone);
        }
        $k = $this->INT(0.5 + ($a11 - 2415021.076998695) / 29.530588853);
        $off = $lunarMonth - 11;
        if ($off < 0) {
            $off += 12;
        }
        if ($b11 - $a11 > 365) {
            $leapOff = $this->getLeapMonthOffset($a11, $timeZone);
            $leapMonth = $leapOff - 2;
            if ($leapMonth < 0) {
                $leapMonth += 12;
            }
            if ($lunarLeap != 0 && $lunarMonth != $leapMonth) {
                return array(0, 0, 0);
            } else if ($lunarLeap != 0 || $off >= $leapOff) {
                $off += 1;
            }
        }
        $monthStart = $this->getNewMoonDay($k + $off, $timeZone);
        return $this->jdToDate($monthStart + $lunarDay - 1);
    }

    function fix10($n) {
        while ($n > 10) {
            $n = $n - 10;
        }
        while ($n <= 0) {
            $n = $n + 10;
        }
        return $n;
    }

    function canChiNgay($nn, $tt, $nnnn, $duongLich = true, $timeZone = 7, $thangNhuan = false) {
        if (!$duongLich) {
            $l2s = $this->convertLunar2Solar($nn, $tt, $nnnn, $thangNhuan, $timeZone);
            $nn = $l2s[0];
            $tt = $l2s[1];
            $nnnn = $l2s[2];
        }
        $jd = $this->jdFromDate($nn, $tt, $nnnn);
        # print jd
        $canNgay = ($jd + 9) % 10 + 1;
        $chiNgay = ($jd + 1) % 12 + 1;
        return [$canNgay, $chiNgay];
    }

    function ngayThangNamCanChi($nn, $tt, $nnnn, $duongLich = true, $timeZone = 7) {
        if ($duongLich) {
            $ngaythangnam = $this->ngayThangNam($nn, $tt, $nnnn, $timeZone);
            if (is_array($ngaythangnam)) {
                list($nn, $tt, $nnnn, $thangNhuan) = $ngaythangnam;
            }
        }
        # Can của tháng
        $canThang = ($nnnn * 12 + $tt + 3) % 10 + 1;
        # Can chi của năm
        $canNamSinh = ($nnnn + 6) % 10 + 1;
        $chiNam = ($nnnn + 8) % 12 + 1;

        return [$canThang, $canNamSinh, $chiNam];
    }

    function validateDate($date, $format = 'Y-m-d H:i:s') {
        $d = \DateTime::createFromFormat($format, $date);
        return $d && $d->format($format) == $date;
    }

    function getDateDiff($from, $to) {
        if ($this->validateDate($from) && $this->validateDate($to)) {
            $date1 = new \DateTime($from);
            $date2 = $date1->diff(new \DateTime($to));

            return [
                'days' => $date2->days,
                'years' => $date2->y,
                'month' => $date2->m,
                'day' => $date2->d,
                'hour' => $date2->h,
                'minutes' => $date2->i,
                'seconds' => $date2->s
            ];
        }

        return [];
    }

    // dong tu menh
    // khảm trấn tốn ly
    // tay tu menh
    // khôn đoài càn cấn
    function menhQuai($year, $gioitinh) {
        $soDuNamSinhChia9 = array_sum(str_split($year)) % 9;
        if ($soDuNamSinhChia9 == 0) {
            $soDuNamSinhChia9 = 9;
        }
        $menhQuai = $gioitinh == 1 ? $this->bangMenhQuai[$soDuNamSinhChia9] : $this->bangMenhQuaiNu[$soDuNamSinhChia9];

        return [
            'menhquai' => $menhQuai,
            'menh' => $menhQuai['menh'],
            'huong' => '',
            'menh2' => $menhQuai['menh2']
        ];
    }

    function search_revisions($dataArray, $search_value, $key_to_search) {
        // This function will search the revisions for a certain value
        // related to the associative key you are looking for.
        $keys = array();
        foreach ($dataArray as $key => $cur_value) {
            if ($cur_value[$key_to_search] == $search_value) {
                $keys = $key;
                break;
            }
        }
        return $keys;
    }

    function tinhCungMenhCanChi($canNam, $chiNam, $chiThang, $chiGio) { // nguyet chi, thoi chi
        $this->chiThangSlug = $this->khongdau($chiThang);
        $this->chiGioSlug = $this->khongdau($chiGio);
        $soCungMenh = 26 - ($this->cungMenhArr[$this->chiThangSlug]['number'] + $this->cungMenhArr[$this->chiGioSlug]['number']);
        if ($soCungMenh > 12) {
            $soCungMenh = $soCungMenh - 12;
        }
        $key = $this->search_revisions($this->cungMenhArr, $soCungMenh, 'number');
        $chi = $this->cungMenhArr[$key]['name'];
        $thangGieng = $this->search_revisions($this->canArr, $this->khongdau($canNam), 'name');
        $canName = $this->canArr[$thangGieng]['thanggieng'];
        $canIndex = $this->search_revisions($this->canArr, $this->khongdau($canName), 'name');
        $canNew = $canIndex != 0 ? array_merge(array_slice($this->canArr, $canIndex, count($this->canArr)), array_slice($this->canArr, 0, $canIndex)) : $this->canArr;
        $socm = $this->cungMenhArr[$key]['number'] - 1;
        if ($socm >= 10) {
            $socm = $socm - 10;
        }
        return [
            'can' => $canNew[$socm]['title'],
            'chi' => $chi
        ];
    }

    function tinhCungMenh($namAmLich, $gioitinh) {
        $arrayNumber = str_split($namAmLich);
        $sum = array_sum($arrayNumber);
        $soCm = $sum % 9;
    }

    function tinhThaiNguyen($canThang, $chiThang) {
        $canIndex = $this->search_revisions($this->canArr, $this->khongdau($canThang), 'name');
        $canIndex = $canIndex + 1;
        if ($canIndex > count($this->canArr)) {
            $canIndex = $canIndex - count($this->canArr);
        }
        $canNew = $canIndex != 0 ? array_merge(array_slice($this->canArr, $canIndex, count($this->canArr)), array_slice($this->canArr, 0, $canIndex)) : $this->canArr;

        $chiIndex = $this->search_revisions($this->chiArr, $this->khongdau($chiThang), 'name');
        $chiIndex = $chiIndex + 3;
        if ($chiIndex > count($this->chiArr)) {
            $chiIndex = $chiIndex - count($this->chiArr);
        }
        $chiNew = $canIndex != 0 ? array_merge(array_slice($this->chiArr, $chiIndex, count($this->chiArr)), array_slice($this->chiArr, 0, $chiIndex)) : $this->chiArr;

        return [
            'can' => $canNew[0]['title'],
            'chi' => $chiNew[0]['title']
        ];
    }

    function diaChiHopHoa() {
        $diaChiXung = $this->diaChiXung;
        $diaChiHinh = $this->diaChiHinh;

        $daHoa = [
            'tru_nam' => false,
            'tru_thang' => false,
            'tru_ngay' => false,
            'tru_gio' => false
        ];
        $hop = [
            'tru_nam' => false,
            'tru_thang' => false,
            'tru_ngay' => false,
            'tru_gio' => false
        ];

        $results = [];

        // 1: kim, 2: thuy, 3: moc, 4: hoa, 5: tho
        $diachiTamHop = [
            ['can' => ['quy', 'at', 'ky'], 'chi' => ['hoi', 'mao', 'mui'], 'thuoc_dan' => ['giap', 'at'], 'text' => 'Hóa mộc', 'number' => 3],
            ['can' => ['giap', 'binh', 'mau'], 'chi' => ['dan', 'ngo', 'tuat'], 'thuoc_dan' => ['binh', 'dinh'], 'text' => 'Hóa hỏa', 'number' => 4],
            ['can' => ['dinh', 'tan', 'ky'], 'chi' => ['ty', 'dau', 'suu'], 'thuoc_dan' => ['tan', 'canh'], 'text' => 'Hóa kim', 'number' => 1],
            ['can' => ['canh', 'nham', 'mau'], 'chi' => ['than', 'ti', 'thin'], 'thuoc_dan' => ['quy', 'nham'], 'text' => 'Hóa thủy', 'number' => 2],
        ];

        // nang cao check thêm vương suu của ngũ hành
        // Đia chi tam hợp
        foreach ($diachiTamHop as $tamHop) {
            // Năm tháng ngày
            if (in_array($this->chiNamSlug, $tamHop['chi']) && in_array($this->chiThangSlug, $tamHop['chi']) && in_array($this->chiNgaySlug, $tamHop['chi']) && $this->chiNamSlug != $this->chiThangSlug && $this->chiThangSlug != $this->chiNgaySlug && $this->chiNamSlug != $this->chiNgaySlug) {
                $hop['tru_nam'] = true;
                $hop['tru_thang'] = true;
                $hop['tru_ngay'] = true;
                if ((in_array($this->canNamSlug, $tamHop['can']) || in_array($this->canThangSlug, $tamHop['can']) || in_array($this->canNgaySlug, $tamHop['can']) || in_array($this->canGioSlug, $tamHop['can']))) {
                    $results['tam_hop']['tru_nam'] = $tamHop;
                    $results['tam_hop']['tru_thang'] = $tamHop;
                    $results['tam_hop']['tru_ngay'] = $tamHop;
                    $daHoa = [
                        'tru_nam' => true,
                        'tru_thang' => true,
                        'tru_ngay' => true,
                        //'tru_gio' => true
                    ];
                    $hop['tru_nam'] = false;
                    $hop['tru_thang'] = false;
                    $hop['tru_ngay'] = false;
                    if (isset($diaChiXung[$this->chiNgaySlug]) && in_array($this->chiGioSlug, $diaChiXung[$this->chiNgaySlug]) || $this->chiGioSlug == $diaChiHinh[$this->chiNgaySlug]) {
                        unset($results['tam_hop']['tru_ngay']);
                        $daHoa['tru_ngay'] = false;
                        $hop['tru_ngay'] = true;
                    }
                }
            }
            // tháng ngày giờ
            if (in_array($this->chiThangSlug, $tamHop['chi']) && in_array($this->chiNgaySlug, $tamHop['chi']) && in_array($this->chiGioSlug, $tamHop['chi']) && $this->chiThangSlug != $this->chiNgaySlug && $this->chiNgaySlug != $this->chiGioSlug && $this->chiThangSlug != $this->chiGioSlug) {

                $hop['tru_thang'] = true;
                $hop['tru_ngay'] = true;
                $hop['tru_gio'] = true;
                if (!$daHoa['tru_thang'] && (in_array($this->canNamSlug, $tamHop['can']) || in_array($this->canThangSlug, $tamHop['can']) || in_array($this->canNgaySlug, $tamHop['can']) || in_array($this->canGioSlug, $tamHop['can']))) {
                    $results['tam_hop']['tru_thang'] = $tamHop;
                    $results['tam_hop']['tru_ngay'] = $tamHop;
                    $results['tam_hop']['tru_gio'] = $tamHop;
                    $daHoa['tru_thang'] = true;
                    $daHoa['tru_ngay'] = true;
                    $daHoa['tru_gio'] = true;

                    $hop['tru_thang'] = false;
                    $hop['tru_ngay'] = false;
                    $hop['tru_gio'] = false;
                    if (isset($diaChiXung[$this->chiThangSlug]) && in_array($this->chiNamSlug, $diaChiXung[$this->chiThangSlug]) || $this->chiThangSlug == $diaChiHinh[$this->chiNamSlug]) {
                        unset($results['tam_hop']['tru_thang']);
                        $daHoa['tru_thang'] = false;
                        $hop['tru_thang'] = true;
                    }
                }
            }
        }
        //var_dump($daHoa);die;
        // nếu đã hóa tam hợp thì tam hội sẽ ko bao giờ hóa được nữa
        // nang cao check thêm vương suu của ngũ hành
        if (!$daHoa['tru_thang']) {
            // dia chi tam hoi
            $diachiTamHoi = [
                ['can' => ['giap', 'at', 'mau'], 'chi' => ['dan', 'mao', 'thin'], 'thongcan' => ['giap-dan', 'at-mao', 'mau-thin'], 'text' => 'Hóa mộc', 'number' => 3],
                ['can' => ['dinh', 'binh', 'ky'], 'chi' => ['ty', 'ngo', 'mui'], 'thongcan' => ['dinh-ty', 'binh-ngo', 'ky-mui'], 'text' => 'Hóa hỏa', 'number' => 4],
                ['can' => ['canh', 'tan', 'mau'], 'chi' => ['than', 'dau', 'tuat'], 'thongcan' => ['canh-than', 'tan-dau', 'mau-tuat'], 'text' => 'Hóa kim', 'number' => 1],
                ['can' => ['quy', 'nham', 'ky'], 'chi' => ['hoi', 'ti', 'suu'], 'thongcan' => ['quy-hoi', 'nham-ti', 'ky-suu'], 'text' => 'Hóa thủy', 'number' => 2],
            ];
            foreach ($diachiTamHoi as $tamHop) {
                // Năm tháng ngày
                if (in_array($this->chiNamSlug, $tamHop['chi']) && in_array($this->chiThangSlug, $tamHop['chi']) && in_array($this->chiNgaySlug, $tamHop['chi']) && $this->chiNamSlug != $this->chiThangSlug && $this->chiThangSlug != $this->chiNgaySlug && $this->chiNamSlug != $this->chiNgaySlug) {
                    $hop['tru_nam'] = true;
                    $hop['tru_thang'] = true;
                    $hop['tru_ngay'] = true;

                    if ((in_array($this->canNamSlug, $tamHop['can']) || in_array($this->canThangSlug, $tamHop['can']) || in_array($this->canNgaySlug, $tamHop['can']) || in_array($this->canGioSlug, $tamHop['can']))) {
                        $results['tam_hoi']['tru_nam'] = $tamHop;
                        $results['tam_hoi']['tru_thang'] = $tamHop;
                        $results['tam_hoi']['tru_ngay'] = $tamHop;
                        $daHoa['tru_nam'] = true;
                        $daHoa['tru_thang'] = true;
                        $daHoa['tru_ngay'] = true;
                        $hop['tru_nam'] = false;
                        $hop['tru_thang'] = false;
                        $hop['tru_ngay'] = false;
                        if (isset($diaChiXung[$this->chiNgaySlug]) && in_array($this->chiGioSlug, $diaChiXung[$this->chiNgaySlug]) || $this->chiGioSlug == $diaChiHinh[$this->chiNgaySlug]) {
                            unset($results['tam_hoi']['tru_ngay']);
                            $daHoa['tru_ngay'] = false;
                            $hop['tru_ngay'] = true;
                        }
                    }
                }
                // tháng ngày giờ
                if (in_array($this->chiThangSlug, $tamHop['chi']) && in_array($this->chiNgaySlug, $tamHop['chi']) && in_array($this->chiGioSlug, $tamHop['chi']) && $this->chiThangSlug != $this->chiNgaySlug && $this->chiNgaySlug != $this->chiGioSlug && $this->chiThangSlug != $this->chiGioSlug) {
                    $hop['tru_thang'] = true;
                    $hop['tru_ngay'] = true;
                    $hop['tru_gio'] = true;
                    if (!$daHoa['tru_thang'] && (in_array($this->canNamSlug, $tamHop['can']) || in_array($this->canThangSlug, $tamHop['can']) || in_array($this->canNgaySlug, $tamHop['can']) || in_array($this->canGioSlug, $tamHop['can']))) {
                        $results['tam_hoi']['tru_thang'] = $tamHop;
                        $results['tam_hoi']['tru_ngay'] = $tamHop;
                        $results['tam_hoi']['tru_gio'] = $tamHop;
                        $daHoa['tru_thang'] = true;
                        $daHoa['tru_ngay'] = true;
                        $daHoa['tru_gio'] = true;
                        $hop['tru_thang'] = false;
                        $hop['tru_ngay'] = false;
                        $hop['tru_gio'] = false;
                        if (isset($diaChiXung[$this->chiThangSlug]) && in_array($this->chiNamSlug, $diaChiXung[$this->chiThangSlug]) || $this->chiThangSlug == $diaChiHinh[$this->chiNamSlug]) {
                            unset($results['tam_hoi']['tru_thang']);
                            $daHoa['tru_thang'] = false;
                            $hop['tru_thang'] = true;
                        }
                    }
                }
            }
        }

        // luc hop

        $diachiLucHop = [
            ['can' => ['ky', 'mau'], 'chi' => 'suu', 'chi2' => 'ti', 'text' => 'Hóa thổ', 'number' => 5],
            ['can' => ['giap', 'at'], 'chi' => 'dan', 'chi2' => 'hoi', 'text' => 'Hóa mộc', 'number' => 3],
            ['can' => ['binh', 'dinh'], 'chi' => 'tuat', 'chi2' => 'mao', 'text' => 'Hóa hỏa', 'number' => 4],
            ['can' => ['tan', 'canh'], 'chi' => 'dau', 'chi2' => 'thin', 'text' => 'Hóa kim', 'number' => 1],
            ['can' => ['quy', 'nham'], 'chi' => 'ty', 'chi2' => 'than', 'text' => 'Hóa thủy', 'number' => 2],
            ['can' => ['ky', 'mau'], 'chi' => 'mui', 'chi2' => 'ngo', 'text' => 'Hóa thổ', 'number' => 5],
        ];

        foreach ($diachiLucHop as $lucHop) {
            // nam + thang
            // Nếu trụ năm hoặc trụ tháng đã hóa thì ko xét hóa nữa
            //if (!$daHoa['tru_nam'] || !$daHoa['tru_thang']) {
            if ((in_array($this->canNamSlug, $lucHop['can']) || in_array($this->canThangSlug, $lucHop['can'])) &&
                ($this->chiNamSlug == $lucHop['chi'] && $this->chiThangSlug == $lucHop['chi2']) || ($this->chiThangSlug == $lucHop['chi'] && $this->chiNamSlug == $lucHop['chi2'])) {
                if (isset($diaChiXung[$this->chiThangSlug]) && !in_array($this->chiNgaySlug, $diaChiXung[$this->chiThangSlug]) && $this->chiThangSlug != $diaChiHinh[$this->chiNgaySlug]) { // xet dia chi xung + hinh
                    $results['luc_hop']['tru_nam'] = $lucHop;
                    $results['luc_hop']['tru_thang'] = $lucHop;
                    $daHoa['tru_nam'] = true;
                    $daHoa['tru_thang'] = true;
                } else {
                    $hop['tru_nam'] = true;
                    $hop['tru_thang'] = true;
                }
            }
            // }
            // thang + ngay
            // Nếu trụ tháng hoặc trụ ngày đã hóa thì ko xét nữa
            //if (!$daHoa['tru_thang'] && !$daHoa['tru_ngay']) {
            if ((in_array($this->canThangSlug, $lucHop['can']) || in_array($this->canNgaySlug, $lucHop['can'])) &&
                ($this->chiThangSlug == $lucHop['chi'] && $this->chiNgaySlug == $lucHop['chi2']) || ($this->chiNgaySlug == $lucHop['chi'] && $this->chiThangSlug == $lucHop['chi2'])) {
                if (isset($diaChiXung[$this->chiThangSlug]) && !in_array($this->chiNamSlug, $diaChiXung[$this->chiThangSlug]) && !in_array($this->chiGioSlug, $diaChiXung[$this->chiNgaySlug]) && $this->chiThangSlug != $diaChiHinh[$this->chiNamSlug] && $this->chiGioSlug != $diaChiHinh[$this->chiNgaySlug]) { // xet dia chi xung
                    $results['luc_hop']['tru_thang'] = $lucHop;
                    $results['luc_hop']['tru_ngay'] = $lucHop;
                    $daHoa['tru_thang'] = true;
                    $daHoa['tru_ngay'] = true;
                } else {
                    $hop['tru_thang'] = true;
                    $hop['tru_ngay'] = true;
                }
            }
            // }
            // ngay + gio
            // Nếu trụ ngày hoặc trụ giờ đã hóa thì ko xét nữa
            //if (!$daHoa['tru_ngay']) {
            if ((in_array($this->canNgaySlug, $lucHop['can']) || in_array($this->canGioSlug, $lucHop['can'])) &&
                ($this->chiNgaySlug == $lucHop['chi'] && $this->chiGioSlug == $lucHop['chi2']) || ($this->chiGioSlug == $lucHop['chi'] && $this->chiNgaySlug == $lucHop['chi2'])) {
                if (isset($diaChiXung[$this->chiNgaySlug]) && !in_array($this->chiThangSlug, $diaChiXung[$this->chiNgaySlug]) && $this->chiNgaySlug != $diaChiHinh[$this->chiThangSlug]) { // xet dia chi hinh+xung
                    $results['luc_hop']['tru_ngay'] = $lucHop;
                    $results['luc_hop']['tru_gio'] = $lucHop;
                    $daHoa['tru_ngay'] = true;
                    $daHoa['tru_gio'] = true;
                } else {
                    $hop['tru_ngay'] = true;
                    $hop['tru_gio'] = true;
                }
            }
            //}
        }


        // ban tam hop

        $diachiBanTamHop = [
            ['can' => ['quy', 'at'], 'chi' => ['hoi', 'mao'], 'text' => 'Hóa mộc', 'number' => 3],
            ['can' => ['giap', 'binh'], 'chi' => ['dan', 'ngo'], 'text' => 'Hóa hỏa', 'number' => 4],
            ['can' => ['dinh', 'tan'], 'chi' => ['ty', 'dau'], 'text' => 'Hóa kim', 'number' => 1],
            ['can' => ['canh', 'nham'], 'chi' => ['than', 'ti'], 'text' => 'Hóa thủy', 'number' => 2],
        ];

        foreach ($diachiBanTamHop as $tamHop) {

            // nam - thang
            // Nếu trụ năm hoặc trụ tháng đã hóa thì ko xét hóa nữa
            //if (!$daHoa['tru_nam'] || !$daHoa['tru_thang']) {
            if (in_array($this->chiNamSlug, $tamHop['chi']) && in_array($this->chiThangSlug, $tamHop['chi']) && $this->chiNamSlug != $this->chiThangSlug) {
                $hop['tru_nam'] = true;
                $hop['tru_thang'] = true;
                if ((in_array($this->canNamSlug, $tamHop['can']) || in_array($this->canThangSlug, $tamHop['can'])) && isset($diaChiXung[$this->chiThangSlug]) && !in_array($this->chiNgaySlug, $diaChiXung[$this->chiThangSlug]) && $this->chiNgaySlug != $diaChiHinh[$this->chiThangSlug]
                ) {
                    $results['ban_tam_hop']['tru_nam'] = $tamHop;
                    $results['ban_tam_hop']['tru_thang'] = $tamHop;
                    $daHoa['tru_nam'] = true;
                    $daHoa['tru_thang'] = true;

                    $hop['tru_nam'] = false;
                    $hop['tru_thang'] = false;
                }
            }
            // }
            // thang - ngay
            // Nếu trụ tháng hoặc trụ ngày đã hóa thì ko xét hóa nữa
            // if (!$daHoa['tru_thang'] && !$daHoa['tru_ngay']) {
            if (in_array($this->chiThangSlug, $tamHop['chi']) && in_array($this->chiNgaySlug, $tamHop['chi']) && $this->chiThangSlug != $this->chiNgaySlug) {
                $hop['tru_thang'] = true;
                $hop['tru_ngay'] = true;
                if ((in_array($this->canThangSlug, $tamHop['can']) || in_array($this->canNgaySlug, $tamHop['can'])) && $this->chiThangSlug != $diaChiHinh[$this->chiNamSlug] && $this->chiGioSlug != $diaChiHinh[$this->chiNgaySlug]
                ) {
                    $results['ban_tam_hop']['tru_thang'] = $tamHop;
                    $results['ban_tam_hop']['tru_ngay'] = $tamHop;
                    $daHoa['tru_thang'] = true;
                    $daHoa['tru_ngay'] = true;
                    $hop['tru_thang'] = false;
                    $hop['tru_ngay'] = false;
                }
            }
            //}
            // ngay - gio
            // Nếu trụ ngày hoặc trụ giờ đã hóa thì ko xét hóa nữa
            //echo $this->chiNgaySlug . '--' . $this->chiGioSlug;
            //if (!$daHoa['tru_ngay']) {
            if (in_array($this->chiNgaySlug, $tamHop['chi']) && in_array($this->chiGioSlug, $tamHop['chi']) && $this->chiNgaySlug != $this->chiGioSlug) {
                $hop['tru_ngay'] = true;
                $hop['tru_gio'] = true;
                if ((in_array($this->canNgaySlug, $tamHop['can']) || in_array($this->canGioSlug, $tamHop['can'])) && isset($diaChiXung[$this->chiNgaySlug]) && !in_array($this->chiThangSlug, $diaChiXung[$this->chiNgaySlug]) && $this->chiNgaySlug != $diaChiHinh[$this->chiThangSlug]
                ) {
                    //echo $this->chiNgaySlug . '--' . $this->chiGioSlug;
                    $results['ban_tam_hop']['tru_ngay'] = $tamHop;
                    $results['ban_tam_hop']['tru_gio'] = $tamHop;
                    $daHoa['tru_ngay'] = true;
                    $daHoa['tru_gio'] = true;
                    $hop['tru_ngay'] = false;
                    $hop['tru_gio'] = false;
                }
            }
            //}
        }

        // tam mo
        $diachiBanTamMo = [
            ['can' => ['at', 'ky'], 'chi' => ['mao', 'mui'], 'text' => 'Hóa mộc', 'number' => 3],
            ['can' => ['binh', 'mau'], 'chi' => ['ngo', 'tuat'], 'text' => 'Hóa hỏa', 'number' => 4],
            ['can' => ['tan', 'ky'], 'chi' => ['dau', 'suu'], 'text' => 'Hóa kim', 'number' => 1],
            ['can' => ['nham', 'mau'], 'chi' => ['ti', 'thin'], 'text' => 'Hóa thủy', 'number' => 2],
        ];
        foreach ($diachiBanTamMo as $tamHop) {
            // nam - thang
            // Nếu trụ năm hoặc trụ tháng đã hóa thì ko xét hóa nữa
            //if (!$daHoa['tru_nam'] || !$daHoa['tru_thang']) {
            if (in_array($this->chiNamSlug, $tamHop['chi']) && in_array($this->chiThangSlug, $tamHop['chi']) && $this->chiNamSlug != $this->chiThangSlug) {
                $hop['tru_nam'] = true;
                $hop['tru_thang'] = true;
                if ((in_array($this->canNamSlug, $tamHop['can']) || in_array($this->canThangSlug, $tamHop['can'])) && isset($diaChiXung[$this->chiThangSlug]) && !in_array($this->chiNgaySlug, $diaChiXung[$this->chiThangSlug]) && $this->chiNgaySlug != $diaChiHinh[$this->chiThangSlug]
                ) {
                    $results['ban_tam_mo']['tru_nam'] = $tamHop;
                    $results['ban_tam_mo']['tru_thang'] = $tamHop;
                    $daHoa['tru_nam'] = true;
                    $daHoa['tru_thang'] = true;
                    $hop['tru_nam'] = false;
                    $hop['tru_thang'] = false;
                }
            }
            //}
            // thang - ngay
            // Nếu trụ tháng hoặc trụ ngày đã hóa thì ko xét hóa nữa
            //if (!$daHoa['tru_thang'] && !$daHoa['tru_ngay']) {
            if (in_array($this->chiThangSlug, $tamHop['chi']) && in_array($this->chiNgaySlug, $tamHop['chi']) && $this->chiThangSlug != $this->chiNgaySlug) {
                $hop['tru_thang'] = true;
                $hop['tru_ngay'] = true;
                if ((in_array($this->canThangSlug, $tamHop['can']) || in_array($this->canNgaySlug, $tamHop['can'])) && $this->chiThangSlug != $diaChiHinh[$this->chiNamSlug] && $this->chiGioSlug != $diaChiHinh[$this->chiNgaySlug]
                ) {
                    $results['ban_tam_mo']['tru_thang'] = $tamHop;
                    $results['ban_tam_mo']['tru_ngay'] = $tamHop;
                    $daHoa['tru_thang'] = true;
                    $daHoa['tru_ngay'] = true;
                    $hop['tru_thang'] = false;
                    $hop['tru_ngay'] = false;
                }
            }
            //}
            // ngay - gio
            // Nếu trụ ngày hoặc trụ giờ đã hóa thì ko xét hóa nữa
            //if (!$daHoa['tru_ngay']) {
            if (in_array($this->chiNgaySlug, $tamHop['chi']) && in_array($this->chiGioSlug, $tamHop['chi']) && $this->chiNgaySlug != $this->chiGioSlug) {
                $hop['tru_ngay'] = true;
                $hop['tru_gio'] = true;
                if ((in_array($this->canNgaySlug, $tamHop['can']) || in_array($this->canGioSlug, $tamHop['can'])) && isset($diaChiXung[$this->chiNgaySlug]) && !in_array($this->chiThangSlug, $diaChiXung[$this->chiNgaySlug]) && $this->chiNgaySlug != $diaChiHinh[$this->chiThangSlug]
                ) {
                    $results['ban_tam_mo']['tru_ngay'] = $tamHop;
                    $results['ban_tam_mo']['tru_gio'] = $tamHop;
                    $daHoa['tru_ngay'] = true;
                    $daHoa['tru_gio'] = true;
                    $hop['tru_ngay'] = false;
                    $hop['tru_gio'] = false;
                }
            }
            // }
        }

        if (isset($results['luc_hop']['tru_thang']) && isset($results['luc_hop']['tru_ngay'])) {
            if (isset($results['ban_tam_hop']['tru_ngay']) && $results['ban_tam_hop']['tru_ngay']['number'] != $results['luc_hop']['tru_ngay']['number']) {
                unset($results['ban_tam_hop']);
            } else {
                unset($results['ban_tam_hop']['tru_ngay']);
            }

            if (isset($results['ban_tam_hoi']['tru_ngay']) && $results['ban_tam_hoi']['tru_ngay']['number'] != $results['luc_hop']['tru_ngay']['number']) {
                unset($results['ban_tam_hoi']);
            } else {
                unset($results['ban_tam_hoi']['tru_ngay']);
            }

            if (isset($results['ban_tam_mo']['tru_ngay']) && $results['ban_tam_mo']['tru_ngay']['number'] != $results['luc_hop']['tru_ngay']['number']) {
                unset($results['ban_tam_mo']);
            } else {
                unset($results['ban_tam_mo']['tru_ngay']);
            }
        }

        if (isset($results['ban_tam_hop']['tru_thang']) && isset($results['ban_tam_hop']['tru_ngay'])) {

            if (isset($results['luc_hop']['tru_ngay']) && $results['luc_hop']['tru_ngay']['number'] != $results['ban_tam_hop']['tru_ngay']['number']) {
                unset($results['luc_hop']);
            } else {
                unset($results['luc_hop']['tru_ngay']);
            }

            if (isset($results['ban_tam_hoi']['tru_ngay']) && $results['ban_tam_hoi']['tru_ngay']['number'] != $results['ban_tam_hop']['tru_ngay']['number']) {
                unset($results['ban_tam_hoi']);
            } else {
                unset($results['ban_tam_hoi']['tru_ngay']);
            }
            if (isset($results['ban_tam_mo']['tru_ngay']) && $results['ban_tam_mo']['tru_ngay']['number'] != $results['ban_tam_hop']['tru_ngay']['number']) {
                unset($results['ban_tam_mo']);
            } else {
                unset($results['ban_tam_mo']['tru_ngay']);
            }
        }

        if (isset($results['ban_tam_hoi']['tru_thang']) && isset($results['ban_tam_hoi']['tru_ngay'])) {
            if (isset($results['luc_hop']['tru_ngay']) && $results['luc_hop']['tru_ngay']['number'] != $results['ban_tam_hoi']['tru_ngay']['number']) {
                unset($results['luc_hop']);
            } else {
                unset($results['ban_tam_hoi']['tru_ngay']);
            }
            if (isset($results['ban_tam_hop']['tru_ngay']) && $results['ban_tam_hop']['tru_ngay']['number'] != $results['ban_tam_hoi']['tru_ngay']['number']) {
                unset($results['ban_tam_hop']);
            } else {
                unset($results['ban_tam_hop']['tru_ngay']);
            }
            if (isset($results['ban_tam_mo']['tru_ngay']) && $results['ban_tam_mo']['tru_ngay']['number'] != $results['ban_tam_hoi']['tru_ngay']['number']) {
                unset($results['ban_tam_mo']);
            } else {
                unset($results['ban_tam_mo']['tru_ngay']);
            }
        }

        if (isset($results['ban_tam_mo']['tru_thang']) && isset($results['ban_tam_mo']['tru_ngay'])) {
            if (isset($results['luc_hop']['tru_ngay']) && $results['luc_hop']['tru_ngay']['number'] != $results['ban_tam_mo']['tru_ngay']['number']) {
                unset($results['luc_hop']);
            } else {
                unset($results['luc_hop']['tru_ngay']);
            }
            if (isset($results['ban_tam_hop']['tru_ngay']) && $results['ban_tam_hop']['tru_ngay']['number'] != $results['ban_tam_mo']['tru_ngay']['number']) {
                unset($results['ban_tam_hop']);
            } else {
                unset($results['ban_tam_hop']['tru_ngay']);
            }
            if (isset($results['ban_tam_hoi']['tru_ngay']) && $results['ban_tam_hoi']['tru_ngay']['number'] != $results['ban_tam_mo']['tru_ngay']['number']) {
                unset($results['ban_tam_hoi']);
            } else {
                unset($results['ban_tam_hoi']['tru_ngay']);
            }
        }

        return [
            'results' => $results,
            'daHoa' => $daHoa,
            'hop' => $hop,
        ];
    }

    public $diaChiLucXung = [
        'ti' => 'ngo',
        'ngo' => 'ti',
        'suu' => 'mui',
        'mui' => 'suu',
        'dan' => 'than',
        'than' => 'dan',
        'mao' => 'dau',
        'dau' => 'mao',
        'thin' => 'tuat',
        'tuat' => 'thin',
        'ty' => 'hoi',
        'hoi' => 'ty',
    ];

    function tinhDoVuong() {
        $canAmDuong = $this->canAmDuong;
        $canTang = $this->canTang;

        $canTangArr = array_merge($canTang[$this->chiNamSlug], $canTang[$this->chiThangSlug], $canTang[$this->chiNgaySlug], $canTang[$this->chiGioSlug]);

        $canTangArrUni = array_map(array($this, 'khongdau'), $canTangArr); // loai bo dau
        $canTangNguHanh = [];
        foreach ($canTangArrUni as $index => $ct) {
            if (isset($canAmDuong[$ct]['name'])) {
                $canTangNguHanh[] = $canAmDuong[$ct]['name'];
            }
        }
        $thienCanHopHoa = $this->tinhThienCanHopHoa();

        $doVuongThienCan = $doVuongDiaChi = [
            1 => [
                'title' => 'Kim',
                'name' => 'kim',
                'do' => 0,
            ],
            2 => [
                'title' => 'Thủy',
                'name' => 'thuy',
                'do' => 0
            ],
            3 => [
                'title' => 'Mộc',
                'name' => 'moc',
                'do' => 0
            ],
            4 => [
                'title' => 'Hỏa',
                'name' => 'hoa',
                'do' => 0
            ],
            5 => [
                'title' => 'Thổ',
                'name' => 'Thổ',
                'do' => 0
            ],
        ];

        /**
         * Độ vượng thiên can
         *
         *
         * * */
        $arrayThienCan = [
            'tru_nam' => ['can' => $this->canNamText, 'can_slug' => $this->canNamSlug, 'chi' => $this->chiNamText, 'chi_slug' => $this->chiNamSlug, 'khac_gan' => [$this->canThangSlug], 'khac_xa' => $this->canNgaySlug, 'ktsinh' => [$this->canNgaySlug, $this->canThangSlug]],
            'tru_thang' => ['can' => $this->canThangText, 'can_slug' => $this->canThangSlug, 'chi' => $this->chiThangText, 'chi_slug' => $this->chiThangSlug, 'khac_gan' => [$this->canNamSlug, $this->canNgaySlug], 'khac_xa' => $this->canGioSlug, 'ktsinh' => [$this->canGioSlug, $this->canGioSlug]],
            'tru_ngay' => ['can' => $this->canNgayText, 'can_slug' => $this->canNgaySlug, 'chi' => $this->chiNgayText, 'chi_slug' => $this->chiNgaySlug, 'khac_gan' => [$this->canThangSlug, $this->canGioSlug], 'khac_xa' => $this->canNamSlug, 'ktsinh' => [$this->canNamSlug, $this->canThangSlug]],
            'tru_gio' => ['can' => $this->canGioText, 'can_slug' => $this->canGioSlug, 'chi' => $this->chiGioText, 'chi_slug' => $this->chiGioSlug, 'khac_gan' => [$this->canNgaySlug], 'khac_xa' => $this->canThangSlug, 'ktsinh' => [$this->canThangSlug, $this->canNgaySlug]],
        ];
        $arrayInfo = [];
        foreach ($arrayThienCan as $index => $tc) {
            if (isset($thienCanHopHoa[$index])) { // nếu hợp hóa thì ko xét trụ đó nữa
                continue;
            }
            $truInfo = $canAmDuong[$tc['can_slug']];
            $truInfo['do'] = !in_array($truInfo['name'], $canTangNguHanh) ? 9 : $truInfo['do'];
            $truInfo['sinh'] = $this->tuongSinh($truInfo['name']);
            $truInfo['khac'] = $this->tuongKhac($truInfo['name']);
            $truInfo['bi_khac'] = $this->biKhac($truInfo['name']);
            $truInfo['khacThanhSinh'] = $this->khacThanhSinh($truInfo['name']);
            $truInfo['id'] = $this->getNguHanhId($truInfo['name']);
            if ($truInfo['do'] > 0) {
                // Đã update trụ tháng chi ngũ hành nên phải check lại trụ tháng
                $chiNguHanh = $index == 'tru_thang' ? $this->chiInfo['thang']['name'] : $this->chiAmDuong[$tc['chi_slug']]['name'];
                // Khắc địa chi cùng trụ - 12
                if ($chiNguHanh == $truInfo['khac']) {
                    $truInfo['do'] = ($truInfo['do'] - 12) > 0 ? $truInfo['do'] - 12 : 0;
                }
                // Tương sinh địa chi cùng trụ - 6
                if ($chiNguHanh == $truInfo['sinh']) {
                    $truInfo['do'] = ($truInfo['do'] - 6) > 0 ? $truInfo['do'] - 6 : 0;
                }
                // Bị địa chi khắc - 18
                if ($chiNguHanh == $truInfo['bi_khac']) {
                    $truInfo['do'] = ($truInfo['do'] - 18) > 0 ? $truInfo['do'] - 18 : 0;
                }
                // khac xa - 6
                if ($truInfo['bi_khac'] == $canAmDuong[$tc['khac_xa']]['name']) {
                    $truInfo['do'] = ($truInfo['do'] - 6) > 0 ? $truInfo['do'] - 6 : 0;
                }
                // khac gần - 12
                foreach ($tc['khac_gan'] as $khac) {
                    if ($canAmDuong[$khac]['name'] == $truInfo['bi_khac']) {
                        $truInfo['do'] = ($truInfo['do'] - 12) > 0 ? $truInfo['do'] - 12 : 0;
                    }
                }
                if ($canAmDuong[$tc['ktsinh'][0]]['name'] == $truInfo['bi_khac'] &&
                    $canAmDuong[$tc['ktsinh'][0]]['name'] != $truInfo['khacThanhSinh'] &&
                    $canAmDuong[$tc['ktsinh'][0]]['name'] != $truInfo['bi_khac']) {
                    $truInfo['do'] = ($truInfo['do'] - 6) > 0 ? $truInfo['do'] - 6 : 0;
                }
            }
            $arrayInfo[$index] = $truInfo;
        }
        if (!empty($arrayInfo)) {
            foreach ($arrayInfo as $key => $item) {
                $doVuongThienCan[$item['id']]['do'] += $item['do'];
            }
        }
        if (!empty($thienCanHopHoa)) {
            foreach ($thienCanHopHoa as $key => $item) {
                $doVuongThienCan[$item['number']]['do'] += 30;
            }
        }

        // Tính độ vượng địa chi
        $arrayDiachi = [
            'tru_nam' => ['can' => $this->canNamText, 'can_slug' => $this->canNamSlug, 'chi' => $this->chiNamText, 'chi_slug' => $this->chiNamSlug, 'xung_khac' => [$this->chiThangSlug]],
            'tru_thang' => ['can' => $this->canThangText, 'can_slug' => $this->canThangSlug, 'chi' => $this->chiThangText, 'chi_slug' => $this->chiThangSlug, 'xung_khac' => [$this->chiNamSlug, $this->chiNgaySlug]],
            'tru_ngay' => ['can' => $this->canNgayText, 'can_slug' => $this->canNgaySlug, 'chi' => $this->chiNgayText, 'chi_slug' => $this->chiNgaySlug, 'xung_khac' => [$this->chiThangSlug, $this->chiGioSlug]],
            'tru_gio' => ['can' => $this->canGioText, 'can_slug' => $this->canGioSlug, 'chi' => $this->chiGioText, 'chi_slug' => $this->chiGioSlug, 'xung_khac' => [$this->chiNgaySlug]],
        ];
        // ko chua hinh pha hai


        $diaChiHopHoa = $this->diaChiHopHoa();

        $arrayInfo = [];
        foreach ($arrayDiachi as $index => $tc) {
            if (isset($diaChiHopHoa['daHoa'][$index])) {
                continue;
            }
            $truInfo = $this->chiAmDuong[$tc['chi_slug']];
            $truInfo['sinh'] = $this->tuongSinh($truInfo['name']);
            $truInfo['khac'] = $this->tuongKhac($truInfo['name']);
            $truInfo['bi_khac'] = $this->biKhac($truInfo['name']);
            $truInfo['khacThanhSinh'] = $this->khacThanhSinh($truInfo['name']);
            $truInfo['id'] = $this->getNguHanhId($truInfo['name']);
            $truInfo['tru_xung'] = 0;
            $truInfo['index'] = $index;
            // bị thiên can cùng trụ khắc - 8
            if ($canAmDuong[$tc['can_slug']]['name'] == $truInfo['bi_khac']) {
                $truInfo['do_vuong'][0]['do'] = ($truInfo['do_vuong'][0]['do'] - 8) > 0 ? $truInfo['do_vuong'][0]['do'] - 8 : 0;
            }
            // xung
            foreach ($tc['xung_khac'] as $item) {
                if (isset($this->diaChiLucXung[$index]) && $this->diaChiLucXung[$index] == $item) {
                    $truInfo['tru_xung'] += 10;
                }
                if ($this->chiAmDuong[$item]['name'] == $truInfo['bi_khac']) {
                    $truInfo['tru_xung'] += 6;
                }
            }
            // hop ma ko hoa
            if ($diaChiHopHoa['hop'][$index]) {
                unset($truInfo['do_vuong'][1]);
                unset($truInfo['do_vuong'][2]);
                unset($truInfo['do_vuong'][3]);
            }
            $arrayInfo[$index] = $truInfo;
        }
        if (!empty($arrayInfo)) {
            foreach ($arrayInfo as $key => $item) {
                $total = array_sum(array_column($item['do_vuong'], 'do'));
                $total = ($total - $item['tru_xung']) > 0 ? $total - $item['tru_xung'] : 0;
                $doVuongDiaChi[$item['id']]['do'] += $total;
            }
        }

        if (!empty($diaChiHopHoa['results'])) {
            foreach ($diaChiHopHoa['results'] as $key => $item) {
                $number = 0;
                if ($key == 'tam_hoi') {
                    $number = 24;
                }
                if ($key == 'tam_hop') {
                    $number = 20;
                }
                if ($key == 'luc_hop') {
                    $number = 18;
                }
                if ($key == 'ban_tam_hop') {
                    $number = 20;
                }
                if ($key == 'ban_tam_mo') {
                    $number = 20;
                }
                foreach ($item as $li) {
                    $doVuongDiaChi[$li['number']]['do'] += $number;
                }
            }
        }
        return [
            'thien_can' => $doVuongThienCan,
            'thienCanHopHoa' => $thienCanHopHoa,
            'diaChiHopHoa' => $diaChiHopHoa,
            'dia_chi' => $doVuongDiaChi,
            'lenh_thang' => [
                'hanh' => $this->chiInfo['thang'],
                'tang' => $this->getNguHanhId($this->chiInfo['thang']['name']),
                'giam' => $this->getNguHanhId($this->tuongKhac($this->chiInfo['thang']['name'])),
            ]
        ];
    }

    function tinhDoVuongSuy($doVuong) {
        // 1: kim, 2: thủy, 3:mộc, 4:hỏa, 5:thổ
        $results['total'] = [1 => 0, 2 => 0, 3 => 0, 4 => 0, 5 => 0];
        //$results['thien_can'] = [1 => 0, 2=>0, 3=>0, 4=>0, 5=>0];
        //$results['diachi'] = [1 => 0, 2=>0, 3=>0, 4=>0, 5=>0];

        $chiThangInfo = $this->chiInfo['thang'];

        $chiThangInfo['id'] = $this->getNguHanhId($chiThangInfo['name']);
        $chiThangInfo['sinh'] = $this->getNguHanhId($this->ngSinh($chiThangInfo['name']));
        $chiThangInfo['khac'] = $this->tuongKhac($chiThangInfo['name']);
        $chiThangInfo['bi_khac'] = $this->biKhac($chiThangInfo['name']);
        //var_dump($chiThangInfo);die;

        $canNgayInfo = $this->canInfo['ngay'];
        $canNgayInfo['id'] = $this->getNguHanhId($canNgayInfo['name']);
        $nguHanhSinh = $this->ngSinh($canNgayInfo['name']);
        $canNgayInfo['sinh'] = $this->getNguHanhId($nguHanhSinh);
        $canNgayInfo['khac'] = $this->tuongKhac($canNgayInfo['name']);
        $canNgayInfo['bi_khac'] = $this->biKhac($canNgayInfo['name']);

        foreach ($doVuong['thien_can'] as $index => $thienCan) {
            $results['thien_can'][$index] = $thienCan;
            $results['total'][$index] += $thienCan['do'];
        }
        foreach ($doVuong['dia_chi'] as $index => $diaChi) {
            $results['dia_chi'][$index] = $diaChi;
            $results['total'][$index] += $diaChi['do'];
        }
        $results['cung_phe'] = $results['total'][$canNgayInfo['id']] + $results['total'][$canNgayInfo['sinh']];
        $khac = $this->getNguHanhId($this->biKhac($canNgayInfo['name']));
        $tuongsinhkhac = $this->khacThanhSinh($this->biKhac($canNgayInfo['name']));
        $khac2 = $this->getNguHanhId($tuongsinhkhac);
        $results['khac_phe'] = [
            'diem' => $results['total'][$khac] + $results['total'][$khac2],
            'ngu_hanh' => $this->khacThanhSinh($canNgayInfo['name'])
        ];
        $total = array_sum($results['total']);
        $soNguHanh = floor($total * 0.4);
        $dungHyThan = $this->tinhDungHyThan($results);
        if ($results['total'][$canNgayInfo['sinh']] > $results['total'][$canNgayInfo['id']] && $results['cung_phe'] > $soNguHanh) { // than vuong doi thanh ngu hanh sinh ra no
            $results['ban_menh'] = [
                'id' => $canNgayInfo['sinh'],
                'name' => $nguHanhSinh,
                'title' => $this->convertSlugToText($nguHanhSinh),
                'dung_than' => $dungHyThan['dung_than'],
                'hy_than' => $dungHyThan['hy_than'],
                'text' => $dungHyThan['text'],
            ];
        } else {
            $results['ban_menh'] = [
                'id' => $canNgayInfo['id'],
                'name' => $canNgayInfo['name'],
                'title' => $canNgayInfo['title'],
                'dung_than' => $dungHyThan['dung_than'],
                'hy_than' => $dungHyThan['hy_than'],
                'text' => $dungHyThan['text'],
            ];
        }


        return $results;
    }

    function tinhDungHyThan($doVuongSuy) {
        $nguHanhVuong = $this->nguHanhVuong($doVuongSuy);

//        echo "<pre>";
//        var_dump($nguHanhVuong);
        $array_do = $doVuongSuy['total'];
        $canNgayInfo = $this->canInfo['ngay'];
        $total = array_sum($array_do);
        $soNguHanh = floor($total * 0.4);
        $thanNhuoc = $doVuongSuy['cung_phe'] >= $soNguHanh && $doVuongSuy['cung_phe'] >= 50 ? false : true;
        $key = array_search(max($array_do), $array_do);

        if ($canNgayInfo['name'] == 'kim') {
            if (isset($nguHanhVuong[static::KIM])) {
                if (!$thanNhuoc && isset($nguHanhVuong[static::THUY]) && $nguHanhVuong[static::KIM] > $nguHanhVuong[static::THUY]) {
                    return [
                        'dung_than' => 'hoa',
                        'hy_than' => ['moc'],
                        'text' => 'Nhật chủ là Kim: Có thể thấy trong tứ trụ này có vượng Kim cường Thủy.'
                    ];
                }
                if (!$thanNhuoc && isset($nguHanhVuong[static::MOC]) && $nguHanhVuong[static::KIM] > $nguHanhVuong[static::MOC]) {
                    return [
                        'dung_than' => 'hoa',
                        'hy_than' => ['thuy', 'tho'],
                        'text' => 'Nhật chủ là Kim: Có thể thấy trong tứ trụ này có Mệnh vượng Kim cường Mộc.'
                    ];
                }
                if (!$thanNhuoc && isset($nguHanhVuong[static::HOA]) && $nguHanhVuong[static::KIM] > $nguHanhVuong[static::HOA]) {
                    return [
                        'dung_than' => 'thuy',
                        'hy_than' => ['moc', 'tho'],
                        'text' => 'Nhật chủ là Kim: Có thể thấy trong tứ trụ này có Mệnh vượng Kim cường Hỏa.'
                    ];
                }
                if (!$thanNhuoc && isset($nguHanhVuong[static::THO]) && $nguHanhVuong[static::KIM] > $nguHanhVuong[static::THO]) {
                    return [
                        'dung_than' => 'moc',
                        'hy_than' => ['thuy', 'hoa'],
                        'text'=> 'Nhật chủ là Kim: Có thể thấy trong tứ trụ này có Mệnh vượng Kim cường Thổ.'
                    ];
                }
                if (!$thanNhuoc && isset($nguHanhVuong[static::THUY]) && $nguHanhVuong[static::THUY] > $nguHanhVuong[static::KIM]) {
                    return [
                        'dung_than' => 'hoa',
                        'hy_than' => ['tho', 'moc'],
                        'text' => 'Nhật chủ là Kim: Có thể thấy trong tứ trụ này có Mệnh vượng Thủy cường Kim.'
                    ];
                }
                if (!$thanNhuoc && isset($nguHanhVuong[static::MOC]) && $nguHanhVuong[static::MOC] > $nguHanhVuong[static::KIM]) {
                    return [
                        'dung_than' => 'hoa',
                        'hy_than' => ['tho', 'thuy'],
                        'text' => 'Nhật chủ là Kim: Có thể thấy trong tứ trụ này có Mệnh vượng Mộc cường Kim.'
                    ];
                }
                if (!$thanNhuoc && isset($nguHanhVuong[static::HOA]) && $nguHanhVuong[static::HOA] > $nguHanhVuong[static::KIM]) {
                    return [
                        'dung_than' => 'thuy',
                        'hy_than' => ['tho'],
                        'text' => 'Nhật chủ là Kim: Có thể thấy trong tứ trụ này có Mệnh vượng Hỏa cường Kim.'
                    ];
                }
                if (!$thanNhuoc && isset($nguHanhVuong[static::THO]) && $nguHanhVuong[static::THO] > $nguHanhVuong[static::KIM]) {
                    return [
                        'dung_than' => 'thuy',
                        'hy_than' => ['moc'],
                        'text' => 'Nhật chủ là Kim: Có thể thấy trong tứ trụ này có Mệnh vượng Thổ cường Kim. '
                    ];
                }
                if ($thanNhuoc && isset($nguHanhVuong[static::THO]) && $nguHanhVuong[static::KIM] > $nguHanhVuong[static::THO]) {
                    return [
                        'dung_than' => 'moc',
                        'hy_than' => ['thuy', 'hoa'],
                        'text' => 'Nhật chủ là Kim: Có thể thấy trong tứ trụ này có Mệnh nhược Kim.'
                    ];
                }
            }

            // update
            if ($thanNhuoc && $key == static::THO) {
                if (isset($nguHanhVuong[static::THUY]) && $nguHanhVuong[static::THO] > $nguHanhVuong[static::THUY]) {
                    return [
                        'dung_than' => 'kim',
                        'hy_than' => ['moc', 'hoa'],
                        'text' => 'Nhật chủ là Kim: Có thể thấy trong tứ trụ này có Thân Cường Kim, Cường Thổ, Thủy',
                    ];
                }
                if (isset($nguHanhVuong[static::MOC]) && $nguHanhVuong[static::THO] > $nguHanhVuong[static::MOC]) {
                    return [
                        'dung_than' => 'tho',
                        'hy_than' => ['kim', 'thuy'],
                        'text' => 'Nhật chủ là Kim: Có thể thấy trong tứ trụ này có Thân Cường Kim Cường Thổ, Mộc',
                        'note' => '(Với Mệnh cục đặc biệt nên dùng Dụng Thần kép là Thổ Hỏa)'
                    ];
                }
                if (isset($nguHanhVuong[static::HOA]) && $nguHanhVuong[static::THO] > $nguHanhVuong[static::HOA]) {
                    return [
                        'dung_than' => 'thuy',
                        'hy_than' => ['moc', 'thuy'],
                        'text' => 'Nhật chủ là Kim: Có thể thấy trong tứ trụ này có Thân Cường Kim Vượng Thổ, Cường Hỏa',
                        'note' => '(Với Mệnh cục đặc biệt nên dùng Dụng Thần kép là Thổ Hỏa)'
                    ];
                }
            }
            // end update

            if ($thanNhuoc && $key == static::THUY) {
                return [
                    'dung_than' => 'kim',
                    'hy_than' => ['tho'],
                    'text' => 'Nhật chủ là Kim: Có thể thấy trong tứ trụ này có Mệnh nhược Kim cường Thủy.'
                ];
            }
            if ($thanNhuoc && $key == static::MOC) {
                return [
                    'dung_than' => 'kim',
                    'hy_than' => ['tho'],
                    'text' => 'Nhật chủ là Kim: Có thể thấy trong tứ trụ này có Mệnh nhược Kim cường Mộc.'
                ];
            }
            if ($thanNhuoc && $key == static::HOA) {
                return [
                    'dung_than' => 'kim',
                    'hy_than' => ['tho'],
                    'text' => 'Nhật chủ là Kim: Có thể thấy trong tứ trụ này có Mệnh nhược Kim cường Hỏa.'
                ];
            }
            if ($thanNhuoc && $key == static::THO) {
                return [
                    'dung_than' => 'kim',
                    'hy_than' => ['moc', 'tho'],
                    'text' => 'Nhật chủ là Kim: Có thể thấy trong tứ trụ này có Thân Cường Kim Vượng Thổ',
                    'note' => '(Với Mệnh cục đặc biệt nên dùng Dụng Thần kép là Kim, Thủy.)'
                ];
            }
            if (!$thanNhuoc) { // than vuong
                return [
                    'dung_than' => 'hoa',
                    'hy_than' => ['thuy', 'moc'],
                    'text' => 'Nhật chủ là Kim: Có thể thấy trong tứ trụ này Kim mạnh nhất và các ngũ hành khác yếu. Dụng Thần dự đoán là Hỏa, Hỷ Thần là Thủy, Mộc.'
                ];
            }
            if ($thanNhuoc) { // nhuoc
                return [
                    'dung_than' => 'kim',
                    'hy_than' => ['tho'],
                    'text' => 'Nhật chủ là Kim: Có thể thấy trong tứ trụ này có Mệnh nhược Kim. '
                ];
            }
        }
        if ($canNgayInfo['name'] == 'thuy') {
            if (isset($nguHanhVuong[static::THUY])) {
                if (!$thanNhuoc && isset($nguHanhVuong[static::KIM]) && $nguHanhVuong[static::THUY] > $nguHanhVuong[static::KIM]) {
                    return [
                        'dung_than' => 'hoa',
                        'hy_than' => ['moc', 'tho'],
                        'text' => 'Nhật chủ là Thủy: Có thể thấy trong tứ trụ này có Mệnh vượng Thủy cường Kim. '
                    ];
                }
                if (!$thanNhuoc && isset($nguHanhVuong[static::MOC]) && $nguHanhVuong[static::THUY] > $nguHanhVuong[static::MOC]) {
                    return [
                        'dung_than' => 'hoa',
                        'hy_than' => ['tho'],
                        'text' => 'Nhật chủ là Thủy: Có thể thấy trong tứ trụ này có Mệnh vượng Thủy cường Mộc.'
                    ];
                }
                if (!$thanNhuoc && isset($nguHanhVuong[static::HOA]) && $nguHanhVuong[static::THUY] > $nguHanhVuong[static::HOA]) {
                    return [
                        'dung_than' => 'tho',
                        'hy_than' => ['moc'],
                        'text' => 'Nhật chủ là Thủy: Có thể thấy trong tứ trụ này có Mệnh vượng Thủy cường Hỏa. '
                    ];
                }
                if (!$thanNhuoc && isset($nguHanhVuong[static::THO]) && $nguHanhVuong[static::THUY] > $nguHanhVuong[static::THO]) {
                    return [
                        'dung_than' => 'moc',
                        'hy_than' => ['hoa'],
                        'text' => 'Nhật chủ là Thủy: Có thể thấy trong tứ trụ này có Mệnh vượng Thủy cường Thổ. '
                    ];
                }
                if (!$thanNhuoc && isset($nguHanhVuong[static::KIM]) && $nguHanhVuong[static::KIM] > $nguHanhVuong[static::THUY]) {
                    return [
                        'dung_than' => 'moc',
                        'hy_than' => ['hoa', 'tho'],
                        'text'=> '-	Nhật chủ là Thủy: Có thể thấy trong tứ trụ này có Mệnh vượng Kim cường Thủy: '
                    ];
                }
                if (!$thanNhuoc && isset($nguHanhVuong[static::MOC]) && $nguHanhVuong[static::MOC] > $nguHanhVuong[static::THUY]) {
                    return [
                        'dung_than' => 'tho',
                        'hy_than' => ['hoa'],
                        'text'=> 'Nhật chủ là Thủy: Có thể thấy trong tứ trụ này có Mệnh vượng Mộc cường Thủy: '
                    ];
                }
                if (!$thanNhuoc && isset($nguHanhVuong[static::HOA]) && $nguHanhVuong[static::HOA] > $nguHanhVuong[static::THUY]) {
                    return [
                        'dung_than' => 'tho',
                        'hy_than' => ['kim', 'moc'],
                        'text'=> '-	Nhật chủ là Thủy: Có thể thấy trong tứ trụ này có Mệnh vượng Hỏa cường Thủy: '
                    ];
                }
                if (!$thanNhuoc && isset($nguHanhVuong[static::THO]) && $nguHanhVuong[static::THO] > $nguHanhVuong[static::THUY]) {
                    return [
                        'dung_than' => 'moc',
                        'hy_than' => ['thuy', 'kim'],
                        'text'=> '-	Nhật chủ là Thủy: Có thể thấy trong tứ trụ này có Mệnh vượng Thổ cường Thủy: '
                    ];
                }
            }
            // update
            if ($thanNhuoc && $key == static::KIM) {
                if (isset($nguHanhVuong[static::MOC]) && $nguHanhVuong[static::KIM] > $nguHanhVuong[static::MOC]) {
                    return [
                        'dung_than' => 'tho',
                        'hy_than' => ['hoa'],
                        'text' => 'Nhật chủ là Thủy: Có thể thấy trong tứ trụ này có Thân Cường Thủy, Cường Kim, Mộc',
                    ];
                }
                if (isset($nguHanhVuong[static::HOA]) && $nguHanhVuong[static::KIM] > $nguHanhVuong[static::HOA]) {
                    return [
                        'dung_than' => 'moc',
                        'hy_than' => ['tho', 'kim'],
                        'text' => 'Nhật chủ là Thủy: Có thể thấy trong tứ trụ này có Thân Cường Thủy, Cường Kim, Hỏa',
                    ];
                }
                if (isset($nguHanhVuong[static::THO]) && $nguHanhVuong[static::KIM] > $nguHanhVuong[static::THO]) {
                    return [
                        'dung_than' => 'moc',
                        'hy_than' => ['hoa'],
                        'text' => 'Nhật chủ là Thủy: Có thể thấy trong tứ trụ này có Thân Cường Thủy, Cường Kim, Thổ',
                    ];
                }

                return [
                    'dung_than' => 'moc',
                    'hy_than' => ['tho'],
                    'text' => 'Nhật chủ là Thủy: Có thể thấy trong tứ trụ này có Thân Cường Thủy, Vượng Kim',
                    'note' => ''
                ];
            }
            // end update

            if ($thanNhuoc && isset($nguHanhVuong[static::KIM])) {
                return [
                    'dung_than' => 'thuy',
                    'hy_than' => ['hoa', 'tho'],
                    'text' => 'Nhật chủ là Thủy: Có thể thấy trong tứ trụ này có Mệnh nhược Thủy cường Mộc.'
                ];
            }
            if ($thanNhuoc && $key == static::MOC) {
                return [
                    'dung_than' => 'kim',
                    'hy_than' => ['thuy'],
                    'text' => 'Nhật chủ là Thủy: Có thể thấy trong tứ trụ này có Mệnh nhược Thủy cường Mộc.'
                ];
            }
            if ($thanNhuoc && $key == static::HOA) {
                return [
                    'dung_than' => 'thuy',
                    'hy_than' => ['kim'],
                    'text' => 'Nhật chủ là Thủy: Có thể thấy trong tứ trụ này có Mệnh nhược Thủy cường Hỏa.'
                ];
            }
            if ($thanNhuoc && $key == static::THO) {
                return [
                    'dung_than' => 'kim',
                    'hy_than' => ['thuy'],
                    'text' => 'Nhật chủ là Thủy: Có thể thấy trong tứ trụ này có Mệnh nhược Thủy cường Thổ. '
                ];
            }

            if (!$thanNhuoc) { // than vuong
                return [
                    'dung_than' => 'tho',
                    'hy_than' => ['moc', 'hoa'],
                    'text' => 'Nhật chủ là Thủy: Có thể thấy trong tứ trụ này có Mệnh vượng Thủy. '
                ];
            }
            if ($thanNhuoc) { // nhuoc
                return [
                    'dung_than' => 'thuy',
                    'hy_than' => ['kim'],
                    'text' => 'Nhật chủ là Thủy: Có thể thấy trong tứ trụ này có Mệnh nhược Thủy. '
                ];
            }
        }
        if ($canNgayInfo['name'] == 'moc') {
            if (isset($nguHanhVuong[static::MOC])) {
                if (!$thanNhuoc && isset($nguHanhVuong[static::KIM]) && $nguHanhVuong[static::MOC] > $nguHanhVuong[static::KIM]) {
                    return [
                        'dung_than' => 'hoa',
                        'hy_than' => ['thuy', 'tho'],
                        'text' => 'Nhật chủ là Mộc: Có thể thấy trong tứ trụ này có Mệnh vượng Mộc cường Kim.'
                    ];
                }
                if (!$thanNhuoc && isset($nguHanhVuong[static::THUY]) && $nguHanhVuong[static::MOC] > $nguHanhVuong[static::THUY]) {
                    return [
                        'dung_than' => 'hoa',
                        'hy_than' => ['tho', 'kim'],
                        'text' => 'Nhật chủ là Mộc: Có thể thấy trong tứ trụ này có Mệnh vượng Mộc cường Thủy.'
                    ];
                }
                if (!$thanNhuoc && isset($nguHanhVuong[static::HOA]) && $nguHanhVuong[static::MOC] > $nguHanhVuong[static::HOA]) {
                    return [
                        'dung_than' => 'tho',
                        'hy_than' => ['kim', 'thuy'],
                        'text' => 'Nhật chủ là Mộc: Có thể thấy trong tứ trụ này có Mệnh vượng Mộc cường Hỏa.'
                    ];
                }
                if (!$thanNhuoc && isset($nguHanhVuong[static::THO]) && $nguHanhVuong[static::MOC] > $nguHanhVuong[static::THO]) {
                    return [
                        'dung_than' => 'hoa',
                        'hy_than' => ['kim'],
                        'text' => 'Nhật chủ là Mộc: Có thể thấy trong tứ trụ này có Mệnh vượng Mộc cường Thổ. '
                    ];
                }

                if (!$thanNhuoc && isset($nguHanhVuong[static::KIM]) && $nguHanhVuong[static::KIM] > $nguHanhVuong[static::MOC]) {
                    return [
                        'dung_than' => 'hoa',
                        'hy_than' => ['thuy'],
                        'text'=> 'Nhật chủ là Mộc: Có thể thấy trong tứ trụ này có Mệnh vượng Kim cường Mộc. '
                    ];
                }

                if (!$thanNhuoc && isset($nguHanhVuong[static::THUY]) && $nguHanhVuong[static::THUY] > $nguHanhVuong[static::MOC]) {
                    return [
                        'dung_than' => 'hoa',
                        'hy_than' => ['tho'],
                        'text'=> 'Nhật chủ là Mộc: Có thể thấy trong tứ trụ này có Mệnh vượng Thủy cường Mộc. '
                    ];
                }
                if (!$thanNhuoc && isset($nguHanhVuong[static::HOA]) && $nguHanhVuong[static::HOA] > $nguHanhVuong[static::MOC]) {
                    return [
                        'dung_than' => 'tho',
                        'hy_than' => ['thuy', 'kim'],
                        'text'=> 'Nhật chủ là Mộc: Có thể thấy trong tứ trụ này có Mệnh vượng Hỏa cường Mộc. '
                    ];
                }
                if (!$thanNhuoc && isset($nguHanhVuong[static::THO]) && $nguHanhVuong[static::THO] > $nguHanhVuong[static::MOC]) {
                    return [
                        'dung_than' => 'thuy',
                        'hy_than' => ['moc', 'hoa'],
                        'text'=> 'Nhật chủ là Mộc: Có thể thấy trong tứ trụ này có Mệnh vượng Thổ cường Mộc. '
                    ];
                }
            }

            // update
            if ($thanNhuoc && $key == static::THUY) {
                if (isset($nguHanhVuong[static::HOA]) && $nguHanhVuong[static::THUY] > $nguHanhVuong[static::HOA]) {
                    return [
                        'dung_than' => 'tho',
                        'hy_than' => ['tho', 'kim'],
                        'text' => 'Nhật chủ là Mộc: Có thể thấy trong tứ trụ này có Thân Cường Mộc, Cường Thủy, Hỏa',
                    ];
                }
                if (isset($nguHanhVuong[static::THO]) && $nguHanhVuong[static::THUY] > $nguHanhVuong[static::THO]) {
                    return [
                        'dung_than' => 'kim',
                        'hy_than' => ['hoa', 'kim'],
                        'text' => 'Nhật chủ là Mộc: Có thể thấy trong tứ trụ này có Thân Cường Mộc, Cường Thủy, Thổ',
                    ];
                }
                if (isset($nguHanhVuong[static::KIM]) && $nguHanhVuong[static::THUY] > $nguHanhVuong[static::KIM]) {
                    return [
                        'dung_than' => 'hoa',
                        'hy_than' => ['tho'],
                        'text' => 'Nhật chủ là Mộc: Có thể thấy trong tứ trụ này có Thân Cường Mộc, Cường Thủy, Kim',
                    ];
                }

                return [
                    'dung_than' => 'hoa',
                    'hy_than' => ['tho', 'kim'],
                    'text' => 'Nhật chủ là Mộc: Có thể thấy trong tứ trụ này có Thân Cường Mộc, Cường Thủy'
                ];
            }
            // end update

            if ($thanNhuoc && $key == static::KIM) {
                return [
                    'dung_than' => 'thuy',
                    'hy_than' => ['moc', 'hoa'],
                    'text' => 'Nhật chủ là Mộc: Có thể thấy trong tứ trụ này có Mệnh nhược Mộc cường Kim.'
                ];
            }
            if ($thanNhuoc && $key == static::HOA) {
                return [
                    'dung_than' => 'thuy',
                    'hy_than' => ['moc', 'tho'],
                    'text' => 'Nhật chủ là Mộc: Có thể thấy trong tứ trụ này có Mệnh nhược Mộc cường Hỏa. '
                ];
            }
            if ($thanNhuoc && $key == static::THO) {
                return [
                    'dung_than' => 'moc',
                    'hy_than' => ['hoa'],
                    'text' => 'Nhật chủ là Mộc: Có thể thấy trong tứ trụ này có Mệnh nhược Mộc cường Thổ. '
                ];
            }
            if (!$thanNhuoc) { // than vuong
                return [
                    'dung_than' => 'kim',
                    'hy_than' => ['hoa', 'tho'],
                    'text' => 'Nhật chủ là Mộc: Có thể thấy trong tứ trụ này có Mệnh vượng Mộc. '
                ];
            }
            if ($thanNhuoc) { // nhuoc
                return [
                    'dung_than' => 'moc',
                    'hy_than' => ['thuy'],
                    'text' => 'Nhật chủ là Mộc: Có thể thấy trong tứ trụ này có Mệnh nhược Mộc. '
                ];
            }
        }
        if ($canNgayInfo['name'] == 'hoa') {
            if (isset($nguHanhVuong[static::HOA])) {
                if (!$thanNhuoc && isset($nguHanhVuong[static::THUY]) && $nguHanhVuong[static::HOA] > $nguHanhVuong[static::THUY]) {
                    return [
                        'dung_than' => 'moc',
                        'hy_than' => ['tho', 'thuy'],
                        'text' => 'Nhật chủ là Hỏa: Có thể thấy trong tứ trụ này có Mệnh vượng Hỏa cường Thủy. '
                    ];
                }
                if (!$thanNhuoc && isset($nguHanhVuong[static::MOC]) && $nguHanhVuong[static::HOA] > $nguHanhVuong[static::MOC]) {
                    return [
                        'dung_than' => 'tho',
                        'hy_than' => ['kim', 'thuy'],
                        'text' => 'Nhật chủ là Hỏa: Có thể thấy trong tứ trụ này có Mệnh vượng Hỏa cường Mộc.'
                    ];
                }
                if (!$thanNhuoc && isset($nguHanhVuong[static::KIM]) && $nguHanhVuong[static::HOA] > $nguHanhVuong[static::KIM]) {
                    return [
                        'dung_than' => 'tho',
                        'hy_than' => ['thuy'],
                        'text' => 'Nhật chủ là Hỏa: Có thể thấy trong tứ trụ này có Mệnh vượng Hỏa cường Kim. '
                    ];
                }
                if (!$thanNhuoc && isset($nguHanhVuong[static::THO]) && $nguHanhVuong[static::HOA] > $nguHanhVuong[static::THO]) {
                    return [
                        'dung_than' => 'thuy',
                        'hy_than' => ['kim'],
                        'text' => 'Nhật chủ là Hỏa: Có thể thấy trong tứ trụ này có Mệnh vượng Hỏa cường THỔ. '
                    ];
                }
                if (!$thanNhuoc && isset($nguHanhVuong[static::THUY]) && $nguHanhVuong[static::THUY] > $nguHanhVuong[static::HOA]) {
                    return [
                        'dung_than' => 'moc',
                        'hy_than' => ['tho', 'kim'],
                        'text' => 'Nhật chủ là Hỏa: Có thể thấy trong tứ trụ này có Mệnh vượng Thủy cường Hỏa:'
                    ];
                }
                if (!$thanNhuoc && isset($nguHanhVuong[static::MOC]) && $nguHanhVuong[static::MOC] > $nguHanhVuong[static::HOA]) {
                    return [
                        'dung_than' => 'kim',
                        'hy_than' => ['tho', 'thuy'],
                        'text' => 'Nhật chủ là Hỏa: Có thể thấy trong tứ trụ này có Mệnh vượng Mộc cường Hỏa:'
                    ];
                }
                if (!$thanNhuoc && isset($nguHanhVuong[static::KIM]) && $nguHanhVuong[static::KIM] > $nguHanhVuong[static::HOA]) {
                    return [
                        'dung_than' => 'moc',
                        'hy_than' => ['hoa', 'thuy'],
                        'text' => 'Nhật chủ là Hỏa: Có thể thấy trong tứ trụ này có Mệnh vượng KIM cường Hỏa:'
                    ];
                }
                if (!$thanNhuoc && isset($nguHanhVuong[static::THO]) && $nguHanhVuong[static::THO] > $nguHanhVuong[static::HOA]) {
                    return [
                        'dung_than' => 'kim',
                        'hy_than' => ['moc', 'thuy'],
                        'text' => 'Nhật chủ là Hỏa: Có thể thấy trong tứ trụ này có Mệnh vượng Thổ cường Hỏa:'
                    ];
                }
            }
            // update
            if ($thanNhuoc && $key == static::MOC) {
                if (isset($nguHanhVuong[static::THO]) && $nguHanhVuong[static::MOC] > $nguHanhVuong[static::THO]) {
                    return [
                        'dung_than' => 'kim',
                        'hy_than' => ['thuy'],
                        'text' => 'Nhật chủ là Hỏa: Có thể thấy trong tứ trụ này có Thân Cường Hỏa, Cường Mộc, Thổ',
                    ];
                }
                if (isset($nguHanhVuong[static::KIM]) && $nguHanhVuong[static::MOC] > $nguHanhVuong[static::KIM]) {
                    return [
                        'dung_than' => 'tho',
                        'hy_than' => ['hoa'],
                        'text' => 'Nhật chủ là Hỏa: Có thể thấy trong tứ trụ này có Thân Cường Hỏa, Cường Mộc, Kim',
                    ];
                }
                if (isset($nguHanhVuong[static::THUY]) && $nguHanhVuong[static::MOC] > $nguHanhVuong[static::THUY]) {
                    return [
                        'dung_than' => 'kim',
                        'hy_than' => ['tho', 'thuy'],
                        'text' => 'Nhật chủ là Hỏa: Có thể thấy trong tứ trụ này có Thân Cường Hỏa, Cường Mộc, Thủy',
                    ];
                }
                return [
                    'dung_than' => 'tho',
                    'hy_than' => ['thuy'],
                    'text' => 'Nhật chủ là Hỏa: Có thể thấy trong tứ trụ này có Thân Cường Hỏa, Cường Mộc'
                ];
            }
            // end update

            if ($thanNhuoc && $key == static::THUY) {
                return [
                    'dung_than' => 'moc',
                    'hy_than' => ['hoa', 'tho'],
                    'text' => 'Nhật chủ là Hỏa: Có thể thấy trong tứ trụ này có Mệnh nhược Hỏa cường Thủy. '
                ];
            }

            if ($thanNhuoc && $key == static::KIM) {
                return [
                    'dung_than' => 'hoa',
                    'hy_than' => ['thuy', 'moc'],
                    'text' => 'Nhật chủ là Hỏa: Có thể thấy trong tứ trụ này có Mệnh nhược Hỏa cường Kim. '
                ];
            }
            if ($thanNhuoc && $key == static::THO) {
                return [
                    'dung_than' => 'hoa',
                    'hy_than' => ['moc', 'kim'],
                    'text' => 'Nhật chủ là Hỏa: Có thể thấy trong tứ trụ này có Mệnh nhược Hỏa cường Thổ. '
                ];
            }
            if (!$thanNhuoc) {
                return [
                    'dung_than' => 'thuy',
                    'hy_than' => ['tho', 'kim'],
                    'text' => 'Nhật chủ là Hỏa: Có thể thấy trong tứ trụ này có Mệnh vượng Hỏa. '
                ];
            }
            if ($thanNhuoc) {
                return [
                    'dung_than' => 'hoa',
                    'hy_than' => ['moc'],
                    'text' => 'Nhật chủ là Hỏa: Có thể thấy trong tứ trụ này có Mệnh nhược Hỏa.'
                ];
            }
        }
        if ($canNgayInfo['name'] == 'tho') {
            if (isset($nguHanhVuong[static::THO])) {
                if (!$thanNhuoc && isset($nguHanhVuong[static::THUY]) && $nguHanhVuong[static::THO] > $nguHanhVuong[static::THUY]) {
                    return [
                        'dung_than' => 'moc',
                        'hy_than' => ['kim', 'hoa'],
                        'text' => 'Nhật chủ là Thổ: Có thể thấy trong tứ trụ này có Mệnh vượng Thổ cường Thủy.'
                    ];
                }
                if (!$thanNhuoc && isset($nguHanhVuong[static::MOC]) && $nguHanhVuong[static::THO] > $nguHanhVuong[static::MOC]) {
                    return [
                        'dung_than' => 'kim',
                        'hy_than' => ['hoa', 'thuy'],
                        'text' => 'Nhật chủ là Thổ: Có thể thấy trong tứ trụ này có Mệnh vượng Thổ cường Mộc.'
                    ];
                }
                if (!$thanNhuoc && isset($nguHanhVuong[static::HOA]) && $nguHanhVuong[static::THO] > $nguHanhVuong[static::HOA]) {
                    return [
                        'dung_than' => 'moc',
                        'hy_than' => ['hoa', 'kim'],
                        'text' => 'Nhật chủ là Thổ: Có thể thấy trong tứ trụ này có Mệnh vượng Thổ cường Hỏa.'
                    ];
                }
                if (!$thanNhuoc && isset($nguHanhVuong[static::KIM]) && $nguHanhVuong[static::THO] > $nguHanhVuong[static::KIM]) {
                    return [
                        'dung_than' => 'thuy',
                        'hy_than' => ['moc'],
                        'text' => 'Nhật chủ là Thổ: Có thể thấy trong tứ trụ này có Mệnh vượng Thổ cường Kim.'
                    ];
                }
                if (!$thanNhuoc && isset($nguHanhVuong[static::THUY]) && $nguHanhVuong[static::THUY] > $nguHanhVuong[static::THO]) {
                    return [
                        'dung_than' => 'hoa',
                        'hy_than' => ['moc'],
                        'text' => 'Nhật chủ là Thổ: Có thể thấy trong tứ trụ này có Mệnh vượng Thủy cường Thổ.'
                    ];
                }
                if (!$thanNhuoc && isset($nguHanhVuong[static::MOC]) && $nguHanhVuong[static::MOC] > $nguHanhVuong[static::THO]) {
                    return [
                        'dung_than' => 'kim',
                        'hy_than' => ['hoa', 'thuy'],
                        'text' => 'Nhật chủ là Thổ: Có thể thấy trong tứ trụ này có Mệnh vượng Mộc cường Thổ.'
                    ];
                }
                if (!$thanNhuoc && isset($nguHanhVuong[static::HOA]) && $nguHanhVuong[static::HOA] > $nguHanhVuong[static::THO]) {
                    return [
                        'dung_than' => 'thuy',
                        'hy_than' => ['kim', 'moc'],
                        'text' => 'Nhật chủ là Thổ: Có thể thấy trong tứ trụ này có Mệnh vượng Hỏa cường Thổ.'
                    ];
                }
                if (!$thanNhuoc && isset($nguHanhVuong[static::KIM]) && $nguHanhVuong[static::KIM] > $nguHanhVuong[static::THO]) {
                    return [
                        'dung_than' => 'thuy',
                        'hy_than' => ['hoa'],
                        'text' => 'Nhật chủ là Thổ: Có thể thấy trong tứ trụ này có Mệnh vượng Kim cường Thổ.'
                    ];
                }
            }

            // update
            if ($thanNhuoc && $key == static::HOA) {
                if (isset($nguHanhVuong[static::KIM]) && $nguHanhVuong[static::HOA] > $nguHanhVuong[static::KIM]) {
                    return [
                        'dung_than' => 'thuy',
                        'hy_than' => ['moc', 'tho'],
                        'text' => 'Nhật chủ là Thổ: Có thể thấy trong tứ trụ này có Thân Cường Thổ, Cường Hỏa, Kim'
                    ];
                }
                if (isset($nguHanhVuong[static::THUY]) && $nguHanhVuong[static::HOA] > $nguHanhVuong[static::THUY]) {
                    return [
                        'dung_than' => 'moc',
                        'hy_than' => ['kim', 'thuy'],
                        'text' => 'Nhật chủ là Thổ: Có thể thấy trong tứ trụ này có Thân Cường Thổ, Cường Hỏa, Thủy'
                    ];
                }
                if (isset($nguHanhVuong[static::MOC]) && $nguHanhVuong[static::HOA] > $nguHanhVuong[static::MOC]) {
                    return [
                        'dung_than' => 'kim',
                        'hy_than' => ['thuy', 'tho'],
                        'text' => 'Nhật chủ là Thổ: Có thể thấy trong tứ trụ này có Thân Cường Thổ, Cường Hỏa, Mộc'
                    ];
                }
                return [
                    'dung_than' => 'thuy',
                    'hy_than' => ['moc'],
                    'text' => 'Nhật chủ là Thổ: Có thể thấy trong tứ trụ này có Thân Cường Thổ, Cường Hỏa'
                ];
            }
            // end update

            if ($thanNhuoc && $key == static::THUY) {
                return [
                    'dung_than' => 'tho',
                    'hy_than' => ['hoa', 'kim'],
                    'text' => 'Nhật chủ là Thổ: Có thể thấy trong tứ trụ này có Mệnh nhược Thổ cường Thủy. '
                ];
            }

            if ($thanNhuoc && $key == static::MOC) {
                return [
                    'dung_than' => 'hoa',
                    'hy_than' => ['tho', 'kim'],
                    'text' => 'Nhật chủ là Thổ: Có thể thấy trong tứ trụ này có Mệnh nhược Thổ cường Mộc. '
                ];
            }

            if ($thanNhuoc && $key == static::KIM) {
                return [
                    'dung_than' => 'tho',
                    'hy_than' => ['hoa', 'thuy'],
                    'text' => 'Nhật chủ là Thổ: Có thể thấy trong tứ trụ này có Mệnh nhược Thổ cường Kim. '
                ];
            }

            if (!$thanNhuoc) {
                return [
                    'dung_than' => 'moc',
                    'hy_than' => ['thuy', 'kim'],
                    'text' => 'Nhật chủ là Thổ: Có thể thấy trong tứ trụ này có Mệnh vượng Thổ.'
                ];
            }
            if ($thanNhuoc) {
                return [
                    'dung_than' => 'tho',
                    'hy_than' => ['hoa'],
                    'text' => 'Nhật chủ là Thổ: Có thể thấy trong tứ trụ này có Mệnh nhược Thổ.'
                ];
            }
        }
    }

    function tinhDiemTong($lenhThang, $idNguHanh, $diem) {
        $results = [
            'diem' => $diem,
            'title' => ''
        ];
        if ($idNguHanh == $lenhThang['tang']) {
            $results = [
                'diem' => round($diem + ($diem * 0.2), 1),
                'title' => '+1/5'
            ];
        }
        if ($idNguHanh == $lenhThang['giam']) {
            $results = [
                'diem' => round($diem - ($diem * 0.2), 1),
                'title' => '-1/5'
            ];
        }

        return $results;
    }

    function getMinus($text) {
        $minus = 0;
        if (mb_strlen($text) > 4) {
            $minus = ((mb_strlen($text) - 4) / 2) * 20;
        }
        if (mb_strlen($text) == 2) {
            $minus = -((4 - mb_strlen($text)) / 2) * 33;
        }
        if (mb_strlen($text) == 3) {
            $minus = -((4 - mb_strlen($text)) / 2) * 10;
        }
        return $minus;
    }

    function drawImage() {
        $batTu = $this->tinhBatTu();
        //$tietKhi = $this->getTietKhi();
        $cungMenhThaiNguyen = $this->tinhCungMenhThaiNguyen();
        $chuTinh = $this->tinhChuTinh();
        $canTang = $this->tinhCanTang();
        $nhatKien = $this->tinhNhatKien();
        $nguyetKien = $this->tinhNguyetKien();
        $vtsTru = $this->vongTrangSinhTru();
        $daiVan = $this->tinhDaiVan();
        $daiVanList = $this->tinhDaiVanTieuVan();
        $napAm = $this->tinhNapAm();
        $img_width = 1400;
        $img_height = 2150;
        $img = imagecreatetruecolor($img_width, $img_height);
        $black = imagecolorallocate($img, 0, 0, 0);
        $white = imagecolorallocate($img, 255, 255, 255);
        $blue = imagecolorallocate($img, 0, 0, 255);
        $orange = imagecolorallocate($img, 255, 200, 0);
        $borderLaso = imagecolorallocate($img, 153, 153, 153);
        $borderTable = imagecolorallocate($img, 105, 165, 224);
        $color555 = imagecolorallocate($img, 85, 85, 85);
        $mauBanQuyen = imagecolorallocate($img, 3, 105, 154);
        $kim = $canh = $tan = $than = $dau = imagecolorallocate($img, 128, 0, 128);
        $moc = $giap = $at = $dan = $mao = $green = imagecolorallocate($img, 0, 128, 0);
        $tho = $mau = $ky = $tuat = $suu = $thin = $mui = imagecolorallocate($img, 105, 105, 105);
        $thuy = $nham = $quy = $hoi = $ti = imagecolorallocate($img, 70, 130, 180);
        $red = $hoa = $binh = $dinh = $ty = $ngo = imagecolorallocate($img, 255, 0, 0);

        imagefill($img, 0, 0, $white);

//imagerectangle($img, $img_width*2/10, $img_height*5/10, $img_width*4/10, $img_height*8/10, $red);
        imagerectangle($img, 0, 0, $img_width, $img_height, $borderLaso);
        imagerectangle($img, 1, 1, $img_width - 1, $img_height - 1, $borderLaso);
        imagerectangle($img, 2, 2, $img_width - 2, $img_height - 2, $borderTable);

// HÀNG (height:90)
        imageline($img, 0, 195, $img_width, 195, $borderTable);
        imageline($img, 0, 295, $img_width, 295, $borderTable);
        imageline($img, 0, 365, $img_width, 365, $borderTable); // duong lich
        imageline($img, 0, 435, $img_width, 435, $borderTable); // chu tinh
        imageline($img, 0, 585, $img_width, 585, $borderTable); // bat tu
        imageline($img, 0, 725, $img_width, 725, $borderTable); // can tang
        imageline($img, 0, 795, $img_width, 795, $borderTable); // nhat kien
        imageline($img, 0, 865, $img_width, 865, $borderTable); // nguyet kien
        imageline($img, 0, 935, $img_width, 935, $borderTable); //tru
        imageline($img, 0, 1145, $img_width, 1145, $borderTable); // than sat
        imageline($img, 0, 1200, $img_width, 1200, $borderTable); // nap am
        imageline($img, 0, 1255, $img_width, 1255, $borderTable); // ban quyen
        imageline($img, 0, 1305, $img_width, 1305, $borderTable); // dai van
        imageline($img, 0, 2085, $img_width, 2085, $borderTable); // tieuvan
// CỘT
        imageline($img, 160, 195, 160, 1200, $borderTable);
        imageline($img, 470, 195, 470, 1200, $borderTable);
        imageline($img, 780, 195, 780, 1200, $borderTable);
        imageline($img, 1090, 195, 1090, 1200, $borderTable);

        $fontMedium = public_path('static/theme/fonts/RobotoSlab-Medium.ttf');
        $fontRegular = public_path('static/theme/fonts/RobotoSlab-Regular.ttf');
        $fontBold = public_path('static/theme/fonts/RobotoSlab-Bold.ttf');

// Header
        imagettftext($img, 30, 0, 110, 170, $black, $fontRegular, "Mệnh bàn");
        imagettftext($img, 30, 0, 315, 170, $black, $fontRegular, $this->sex == 1 ? 'càn Tạo' : 'khôn Tạo');
        imagettftext($img, 16, 0, 180, 190, $blue, $fontRegular, 'simthanglong.vn');
        imagettftext($img, 14, 0, 900, 50, $black, $fontRegular, $this->hoTen . " / " . $batTu['menh']);
        imagettftext($img, 14, 0, 600, 80, $black, $fontRegular, "Dương / Âm lịch(GMT+7):");
        imagettftext($img, 14, 0, 900, 80, $red, $fontRegular, $this->gioPhutSinh . ' ' . $this->ngayDuong . '/' . $this->thangDuong . '/' . $this->namDuong);
        imagettftext($img, 14, 0, 1055, 80, $black, $fontRegular, " - " . $this->gioPhutSinh . " " . $this->ngaythangAm[0] . '/' . $this->ngaythangAm[1] . '/' . $this->ngaythangAm[2]);
        imagettftext($img, 14, 0, 1220, 80, $black, $fontRegular, " - " . $this->tietKhiBySex['name']);
        imagefilledrectangle($img, 600, 112, 720, 112, $black);
        imagettftext($img, 14, 0, 600, 110, $black, $fontRegular, 'Thai Nguyên');
        imagettftext($img, 14, 0, 900, 110, $black, $fontRegular, $cungMenhThaiNguyen['thai_nguyen']['can'] . ' ' . $cungMenhThaiNguyen['thai_nguyen']['chi']);
        imagefilledrectangle($img, 600, 142, 705, 142, $black);
        imagettftext($img, 14, 0, 600, 140, $black, $fontRegular, 'Cung mệnh');
        imagettftext($img, 14, 0, 900, 140, $black, $fontRegular, $cungMenhThaiNguyen['cung_menh']['can'] . ' ' . $cungMenhThaiNguyen['cung_menh']['chi']);
        imagettftext($img, 14, 0, 600, 170, $black, $fontRegular, 'Mệnh quái');
        imagettftext($img, 14, 0, 900, 170, $green, $fontRegular, $this->menhQuaiArr['menhquai']['name'] . ',');
        imagettftext($img, 14, 0, 1065, 170, $red, $fontRegular, $this->menhQuaiArr['menh']);

// content
        imagettftext($img, 24, 0, 245, 240, $black, $fontRegular, "Năm sinh");
        imagettftext($img, 24, 0, 245, 270, $black, $fontRegular, "(Niên trụ)");

        imagettftext($img, 24, 0, 540, 240, $black, $fontRegular, "Tháng sinh");
        imagettftext($img, 24, 0, 540, 270, $black, $fontRegular, "(Nguyệt trụ)");


        imagettftext($img, 24, 0, 855, 240, $black, $fontRegular, "Ngày sinh");
        imagettftext($img, 24, 0, 860, 270, $black, $fontRegular, "(Nhật trụ)");

        imagettftext($img, 24, 0, 1175, 240, $black, $fontRegular, "Giờ sinh");
        imagettftext($img, 24, 0, 1170, 270, $black, $fontRegular, "(Thời trụ)");

// Dương lịch
        imagettftext($img, 16, 0, 15, 340, $black, $fontRegular, "DƯƠNG LỊCH");

        imagettftext($img, 24, 0, 270, 340, $black, $fontRegular, $this->namDuong);
        imagettftext($img, 24, 0, 600, 340, $black, $fontRegular, $this->thangDuong);
        imagettftext($img, 24, 0, 920, 340, $black, $fontRegular, $this->ngayDuong);
        imagettftext($img, 24, 0, 1200, 340, $black, $fontRegular, $this->gioPhutSinh);

// Chủ tinh
        imagettftext($img, 16, 0, 15, 410, $black, $fontRegular, "CHỦ TINH");
        imagettftext($img, 24, 0, 260 - $this->getMinus($chuTinh['nam']), 410, $black, $fontRegular, mb_strtoupper($chuTinh['nam']));
        imagettftext($img, 24, 0, 580 - $this->getMinus($chuTinh['thang']), 410, $black, $fontRegular, mb_strtoupper($chuTinh['thang']));
        imagettftext($img, 24, 0, 880 - $this->getMinus('NHẬT CHỦ'), 410, $black, $fontRegular, "NHẬT CHỦ");
        imagettftext($img, 24, 0, 1190 - $this->getMinus($chuTinh['gio']), 410, $black, $fontRegular, mb_strtoupper($chuTinh['gio']));

// Bát tự
        imagettftext($img, 16, 0, 15, 520, $black, $fontRegular, "BÁT TỰ");
        imagettftext($img, 28, 0, 240 - $this->getMinus($this->namAmlich['can']['title']), 500, ${$this->khongdau($this->namAmlich['can']['nguhanh'])}, $fontRegular, mb_strtoupper($this->namAmlich['can']['title']));
        imagettftext($img, 28, 0, 240 - $this->getMinus($this->namAmlich['chi']['title']), 560, ${$this->khongdau($this->namAmlich['chi']['nguhanh'])}, $fontRegular, mb_strtoupper($this->namAmlich['chi']['title']));

        imagettftext($img, 28, 0, 550 - $this->getMinus($this->canThangText), 500, ${$this->canThangSlug}, $fontRegular, mb_strtoupper($this->canThangText));
        imagettftext($img, 28, 0, 550 - $this->getMinus($this->chiThangText), 560, ${$this->chiThangSlug}, $fontRegular, mb_strtoupper($this->chiThangText));

        imagettftext($img, 28, 0, 880 - $this->getMinus($this->canNgayText), 500, ${$this->canNgaySlug}, $fontRegular, mb_strtoupper($this->canNgayText));
        imagettftext($img, 28, 0, 880 - $this->getMinus($this->chiNgayText), 560, ${$this->chiNgaySlug}, $fontRegular, mb_strtoupper($this->chiNgayText));

        imagettftext($img, 28, 0, 1190 - $this->getMinus($this->canGioText), 500, ${$this->canGioSlug}, $fontRegular, mb_strtoupper($this->canGioText));
        imagettftext($img, 28, 0, 1190 - $this->getMinus($this->chiGioText), 560, ${$this->chiGioSlug}, $fontRegular, mb_strtoupper($this->chiGioText));

// Can Tàng
        imagettftext($img, 16, 0, 15, 665, $black, $fontRegular, "CAN TÀNG");
// ---- nien
        if (!empty($canTang['nam'])) {
            foreach ($canTang['nam'] as $index => $canValue) {
                $tt = $this->tinhCanTangThapThan($canValue);
                $vts = $this->tinhCanTangVTS($canValue);
                $y1 = 620;
                $y2 = 670;
                $y3 = 700;
                $xx = 170;
                if ($index == 1) {
                    $xx = 270;
                }
                if ($index == 2) {
                    $xx = 370;
                }
                imagettftext($img, 18, 0, $xx, $y1, ${$this->khongdau($canValue)}, $fontRegular, $canValue);
                imagettftext($img, 16, 0, $xx, $y2, $blue, $fontRegular, $tt);
                imagettftext($img, 12, 0, $xx, $y3, $blue, $fontRegular, $vts);
            }
        }
// ---- thang
        if (!empty($canTang['thang'])) {
            foreach ($canTang['thang'] as $index => $canValue) {
                $tt = $this->tinhCanTangThapThan($canValue);
                $vts = $this->tinhCanTangVTS($canValue);
                $y1 = 620;
                $y2 = 670;
                $y3 = 700;
                $xx = 480;
                if ($index == 1) {
                    $xx = 580;
                }
                if ($index == 2) {
                    $xx = 680;
                }
                imagettftext($img, 18, 0, $xx, $y1, ${$this->khongdau($canValue)}, $fontRegular, $canValue);
                imagettftext($img, 16, 0, $xx, $y2, $blue, $fontRegular, $tt);
                imagettftext($img, 12, 0, $xx, $y3, $blue, $fontRegular, $vts);
            }
        }
// ---- NGÀY
        if (!empty($canTang['ngay'])) {
            foreach ($canTang['ngay'] as $index => $canValue) {
                $tt = $this->tinhCanTangThapThan($canValue);
                $vts = $this->tinhCanTangVTS($canValue);
                $y1 = 620;
                $y2 = 670;
                $y3 = 700;
                $xx = 790;
                if ($index == 1) {
                    $xx = 890;
                }
                if ($index == 2) {
                    $xx = 990;
                }
                imagettftext($img, 18, 0, $xx, $y1, ${$this->khongdau($canValue)}, $fontRegular, $canValue);
                imagettftext($img, 16, 0, $xx, $y2, $blue, $fontRegular, $tt);
                imagettftext($img, 12, 0, $xx, $y3, $blue, $fontRegular, $vts);
            }
        }
// ---- GIO
        if (!empty($canTang['gio'])) {
            foreach ($canTang['gio'] as $index => $canValue) {
                $tt = $this->tinhCanTangThapThan($canValue);
                $vts = $this->tinhCanTangVTS($canValue);
                $y1 = 620;
                $y2 = 670;
                $y3 = 700;
                $xx = 1100;
                if ($index == 1) {
                    $xx = 1200;
                }
                if ($index == 2) {
                    $xx = 1300;
                }
                imagettftext($img, 18, 0, $xx, $y1, ${$this->khongdau($canValue)}, $fontRegular, $canValue);
                imagettftext($img, 16, 0, $xx, $y2, $blue, $fontRegular, $tt);
                imagettftext($img, 12, 0, $xx, $y3, $blue, $fontRegular, $vts);
            }
        }
// Nhật kiến
        imagettftext($img, 16, 0, 15, 770, $black, $fontRegular, "NHẬT KIẾN");

        imagettftext($img, 24, 0, 260 - $this->getMinus($nhatKien['nam']), 770, $black, $fontRegular, mb_strtoupper($nhatKien['nam']));
        imagettftext($img, 24, 0, 580 - $this->getMinus($nhatKien['thang']), 770, $black, $fontRegular, mb_strtoupper($nhatKien['thang']));
        imagettftext($img, 24, 0, 880 - $this->getMinus($nhatKien['ngay']), 770, $black, $fontRegular, mb_strtoupper($nhatKien['ngay']));
        imagettftext($img, 24, 0, 1190 - $this->getMinus($nhatKien['gio']), 770, $black, $fontRegular, $nhatKien['gio']);


// Nguyệt kiến
        imagettftext($img, 16, 0, 15, 840, $black, $fontRegular, "NGUYỆT KIẾN");
        imagettftext($img, 24, 0, 260 - $this->getMinus($nguyetKien['nam']), 840, $black, $fontRegular, mb_strtoupper($nguyetKien['nam']));
        imagettftext($img, 24, 0, 580 - $this->getMinus($nguyetKien['thang']), 840, $black, $fontRegular, mb_strtoupper($nguyetKien['thang']));
        imagettftext($img, 24, 0, 880 - $this->getMinus($nguyetKien['ngay']), 840, $black, $fontRegular, mb_strtoupper($nguyetKien['ngay']));
        imagettftext($img, 24, 0, 1190 - $this->getMinus($nguyetKien['gio']), 840, $black, $fontRegular, mb_strtoupper($nguyetKien['gio']));

// TRỤ
        imagettftext($img, 16, 0, 20, 910, $black, $fontRegular, "TRỤ");
        imagettftext($img, 24, 0, 260 - $this->getMinus($vtsTru['nam']), 910, $black, $fontRegular, mb_strtoupper($vtsTru['nam']));
        imagettftext($img, 24, 0, 580 - $this->getMinus($vtsTru['thang']), 910, $black, $fontRegular, mb_strtoupper($vtsTru['thang']));
        imagettftext($img, 24, 0, 880 - $this->getMinus($vtsTru['ngay']), 910, $black, $fontRegular, mb_strtoupper($vtsTru['ngay']));
        imagettftext($img, 24, 0, 1190 - $this->getMinus($vtsTru['gio']), 910, $black, $fontRegular, mb_strtoupper($vtsTru['gio']));

// THAN SAT
        imagettftext($img, 16, 0, 20, 1050, $black, $fontRegular, "THẦN SÁT");
// -- nam
        $thanSatNam[] = $this->tinhThienDucQuyNhan('nam');
        $thanSatNam[] = $this->tinhNguyetDucQuyNhan('nam');
        $thanSatNam[] = $this->tinhThienAtQuyNhan('nam');
        $thanSatNam[] = $this->tinhKhongVong('nam');
        $ductuQuynhan = $this->tinhDucTuQuyNhan('nam');
        $listSao = $this->tinhSao('nam');
        $thanSatNam = array_merge($thanSatNam, $listSao, $ductuQuynhan);
        $thanSatNam = array_unique($thanSatNam);
        $y = 960;
        $x = 170;
        $cot2 = false;
        $ii = 0;
        foreach ($thanSatNam as $ts) {
            if (empty($ts)) {
                continue;
            }
            if ($ii > 5 && !$cot2) {
                $x = 320;
                $y = 960;
                $cot2 = true;
            }
            $color = in_array($this->khongdau($ts), $this->saoDepArr) ? $red : $black;
            imagettftext($img, 14, 0, $x, $y, $color, $fontRegular, mb_strtoupper($ts));
            $y += 30;
            if (!empty($ts)) {
                $ii++;
            }
        }

// -- Tháng
        $thanSatThang[] = $this->tinhThienDucQuyNhan('thang');
        $thanSatThang[] = $this->tinhNguyetDucQuyNhan('thang');
        $thanSatThang[] = $this->tinhThienAtQuyNhan('thang');
        $thanSatThang[] = $this->tinhKhongVong('thang');
        $ductuQuynhan = $this->tinhDucTuQuyNhan('thang');
        $listSao = $this->tinhSao('thang');
        $thanSatThang = array_merge($thanSatThang, $listSao, $ductuQuynhan);
        $thanSatThang = array_unique($thanSatThang);
        $y = 960;
        $x = 480;
        $cot2 = false;
        $ii = 0;
        foreach ($thanSatThang as $ts) {
            if (empty($ts)) {
                continue;
            }
            if ($ii > 5 && !$cot2) {
                $x = 630;
                $y = 960;
                $cot2 = true;
            }
            $color = in_array($this->khongdau($ts), $this->saoDepArr) ? $red : $black;
            imagettftext($img, 14, 0, $x, $y, $color, $fontRegular, mb_strtoupper($ts));
            $y += 30;
            if (!empty($ts)) {
                $ii++;
            }
        }

// -- Ngày

        $thanSatNgay[] = $this->tinhThienDucQuyNhan('ngay');
        $thanSatNgay[] = $this->tinhNguyetDucQuyNhan('ngay');
        $thanSatNgay[] = $this->tinhThienAtQuyNhan('ngay');
        $thanSatNgay[] = $this->tinhKhongVong('ngay');
        $ductuQuynhan = $this->tinhDucTuQuyNhan('ngay');
        $listSao = $this->tinhSao('ngay');
        $thanSatNgay = array_merge($thanSatNgay, $listSao, $ductuQuynhan);
        $thanSatNgay = array_unique($thanSatNgay);
        $y = 960;
        $x = 790;
        $cot2 = false;
        $ii = 0;
        foreach ($thanSatNgay as $ts) {
            if (empty($ts)) {
                continue;
            }
            if ($ii > 5 && !$cot2) {
                $x = 940;
                $y = 960;
                $cot2 = true;
            }
            $color = in_array($this->khongdau($ts), $this->saoDepArr) ? $red : $black;
            imagettftext($img, 14, 0, $x, $y, $color, $fontRegular, mb_strtoupper($ts));
            $y += 30;
            if (!empty($ts)) {
                $ii++;
            }
        }

// -- Giờ
        $thanSatGio[] = $this->tinhThienDucQuyNhan('gio');
        $thanSatGio[] = $this->tinhNguyetDucQuyNhan('gio');
        $thanSatGio[] = $this->tinhThienAtQuyNhan('gio');
        $thanSatGio[] = $this->tinhKhongVong('gio');
        $ductuQuynhan = $this->tinhDucTuQuyNhan('gio');
        $listSao = $this->tinhSao('gio');
        $thanSatGio = array_merge($thanSatGio, $listSao, $ductuQuynhan);
        $thanSatGio = array_unique($thanSatGio);
        $y = 960;
        $x = 1100;
        $cot2 = false;
        $ii = 0;
        foreach ($thanSatGio as $ts) {
            if (empty($ts)) {
                continue;
            }
            if ($ii > 5 && !$cot2) {
                $x = 1250;
                $y = 960;
                $cot2 = true;
            }
            $color = in_array($this->khongdau($ts), $this->saoDepArr) ? $red : $black;
            imagettftext($img, 14, 0, $x, $y, $color, $fontRegular, mb_strtoupper($ts));
            $y += 30;
            if (!empty($ts)) {
                $ii++;
            }
        }
        $logostl = imagecreatefrompng(public_path('images/logo-1.png'));
        $batquai = imagecreatefromjpeg(public_path('images/logo-bat-quai.jpg'));
        imagecopy($img, $logostl, 150, 0, 0, 0, imagesx($logostl), imagesy($logostl));
        imagecopy($img, $batquai, 220, 50, 0, 0, imagesx($batquai), imagesy($batquai));
// NAP ÂM
        imagettftext($img, 16, 0, 15, 1182, $black, $fontRegular, "NẠP ÂM");

        imagettftext($img, 24, 0, 170, 1182, $black, $fontRegular, $napAm['nam']['menh']);
        imagettftext($img, 24, 0, 480, 1182, $black, $fontRegular, $napAm['thang']['menh']);
        imagettftext($img, 24, 0, 790, 1182, $black, $fontRegular, $napAm['ngay']['menh']);
        imagettftext($img, 24, 0, 1100, 1182, $black, $fontRegular, $napAm['gio']['menh']);

        imagettftext($img, 22, 0, 20, 1238, $mauBanQuyen, $fontRegular, "Lá số bát tự (tứ trụ) theo Sim Thăng Long, Website: simthanglong.vn");
// dai van tieu van
        imagettftext($img, 24, 0, 20, 1290, $green, $fontRegular, "ĐẠI VẬN & TIỂU VẬN:");
        imagettftext($img, 16, 0, 370, 1290, $green, $fontRegular, "Đại vận bắt đầu lúc");
        imagettftext($img, 16, 0, 570, 1290, $green, $fontBold, $daiVan['tuoi'] . " tuổi " . $daiVan['thang'] . " tháng " . $daiVan['ngay'] . " ngày.");
        imagettftext($img, 16, 0, 802, 1290, $green, $fontRegular, "Năm bắt đầu đại vận:");
        imagettftext($img, 16, 0, 1017, 1290, $green, $fontBold, $daiVan['nam_bd_dai_van']);
        // ************************* đại vận **************************
        foreach ($daiVanList as $index => $daivan) {
            $i = 0;
            switch ($index) {
                case 0:
                case 4:
                    $x = 20;
                    break;
                case 1:
                case 5:
                    $x = 330;
                    break;
                case 2:
                case 6:
                    $x = 660;
                    break;
                case 3:
                case 7:
                    $x = 990;
                    break;
                default:
                    $x = 20;
            }
            if ($index > 7) {
                continue;
            }
            imagettftext($img, 18, 0, $x, ($index < 4 ? 1360 : 1720), $red, $fontBold, $daivan['daivan']['year'] . " - " . $daivan['daivan']['tuoi'] . "t");
            imagettftext($img, 18, 0, $x, ($index < 4 ? 1390 : 1750), $black, $fontBold, $daivan['daivan']['can'] . ' ' . $daivan['daivan']['chi'] . "-" . $daivan['daivan']['thapthan']);
            foreach ($daivan['nam'] as $keyDv => $dvn) {
                imagettftext($img, 16, 0, $x, ($index < 4 ? 1460 : 1820) + ($i - 1) * 25, $black, $fontRegular, $keyDv . '-' . $dvn['can_chi'] . '-' . $dvn['thapthan']);
                $i++;
            }
        }

        imagettftext($img, 18, 0, 20, 2125, $black, $fontRegular, "Lá số bát tự tử bình");

        imagefilledrectangle($img, 500, 2105, 530, 2125, $kim);
        imagettftext($img, 18, 0, 540, 2125, $black, $fontRegular, "Kim");

        imagefilledrectangle($img, 620, 2105, 650, 2125, $thuy);
        imagettftext($img, 18, 0, 660, 2125, $black, $fontRegular, "Thủy");

        imagefilledrectangle($img, 740, 2105, 770, 2125, $moc);
        imagettftext($img, 18, 0, 780, 2125, $black, $fontRegular, "Mộc");

        imagefilledrectangle($img, 840, 2105, 870, 2125, $hoa);
        imagettftext($img, 18, 0, 880, 2125, $black, $fontRegular, "Hỏa");

        imagefilledrectangle($img, 940, 2105, 970, 2125, $tho);
        imagettftext($img, 18, 0, 980, 2125, $black, $fontRegular, "Thổ");
        // $fileName = '/wp-content/uploads/laso_tutru/' . $this->khongdau($this->hoTen) . '_' . time() . '.png';
        // imagepng($img, $_SERVER["DOCUMENT_ROOT"] . $fileName);
        // return $fileName;

        ob_start();
        imagepng($img);
        $imagedata = ob_get_clean();

        return base64_encode($imagedata);
    }
}
