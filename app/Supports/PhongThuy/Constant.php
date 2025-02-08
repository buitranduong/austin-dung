<?php

namespace App\Supports\PhongThuy;

class Constant
{
    public static array $gioSinh = [
        23=>'Tý (23-12h)',
        0=>'Tý (12-01h)',
        2=>'Sửu (1h-3h)',
        4=>'Dần (3h-5h)',
        6=>'Mão (5h-7h)',
        8=>'Thìn (7h-9h)',
        10=>'Tỵ (9h-11h)',
        12=>'Ngọ (11h-13h)',
        14=>'Mùi (13h-15h)',
        16=>'Thân (15h-17h)',
        18=>'Dậu (17h-19h)',
        20=>'Tuất (19h-21h)',
        22=>'Hợi (21h-23h)'
    ];
    public static array $nguHanhId = [
        1=>'kim',
        2=>'thuy',
        3=>'moc',
        4=>'hoa',
        5=>'tho'
    ];
    public static array $iconConGiap = [
        'Tý' => '/static/theme/images/phongthuy/congiap/ti.png',
        'Sửu' => '/static/theme/images/phongthuy/congiap/suu.png',
        'Dần' => '/static/theme/images/phongthuy/congiap/dan.png',
        'Mão' => '/static/theme/images/phongthuy/congiap/mao.png',
        'Thìn' => '/static/theme/images/phongthuy/congiap/thin.png',
        'Tỵ' => '/static/theme/images/phongthuy/congiap/ty.png',
        'Ngọ' => '/static/theme/images/phongthuy/congiap/ngo.png',
        'Mùi' => '/static/theme/images/phongthuy/congiap/mui.png',
        'Thân' => '/static/theme/images/phongthuy/congiap/than.png',
        'Dậu' => '/static/theme/images/phongthuy/congiap/dau.png',
        'Tuất' => '/static/theme/images/phongthuy/congiap/tuat.png',
        'Hợi' => '/static/theme/images/phongthuy/congiap/hoi.png'
    ];
    public static array $nguHanh = [
        'kim' => 'Kim',
        'thuy' => 'Thủy',
        'moc' => 'Mộc',
        'hoa' => 'Hỏa',
        'tho' => 'Thổ'
    ];
    public static array $thienCanLuanGiai = [
        'Canh'=>[
            'ngu-hanh' => 'Kim',
            'luan-giai' => '<b>Luận theo Dương cách:</b> Gia chủ có tài về về văn học, khá cứng rắn, mạnh mẽ, kiên cường nhưng đôi lúc hay chống đối, tranh giành, hiếu thắng. Có tài làm kinh tế dễ phát tài vào những năm thuộc tài thần.',
            'uu-diem' => 'Bản thân khá mạnh mẽ, kiên cường',
            'khuyet-diem' => 'Đôi khi dễ hiếu thắng, bảo thủ'
        ],
        'Tân'=>[
            'ngu-hanh' => 'Kim',
            'luan-giai' => '<b>Luận theo Dương cách:</b> Bản thân luôn khắc phục mọi khó khăn để hoàn thành mọi việc, thông minh, trí tuệ, tinh tế, thanh lịch nhưng đôi lúc khá ngoan cố. Nhưng tài lộc sẽ phát khi biết và thấu hiểu về bản thân và thời vận.',
            'uu-diem' => 'Bản thân thông minh',
            'khuyet-diem' => 'Lúc thế suy dễ ngon cố, cố chấp'
        ],
        'Nhâm'=>[
            'ngu-hanh' => 'Thủy',
            'luan-giai' => '<b>Luận theo Dương cách:</b> Gia chủ có bản tính khoan dung, hào phóng, luôn thích đùm bọc và bao dung, nhưng đôi khi có chút ỷ lại hoặc chậm chạp, không lo lắng. Bản thân dễ phát tài vào những năm dụng thần và tài thần.',
            'uu-diem' => 'Bản Thân đôn hậu, tốt bụng',
            'khuyet-diem' => 'Khi vận thế xuống dễ chậm chạp, tới đâu thì tới'
        ],
        'Quý'=>[
            'ngu-hanh' => 'Thủy',
            'luan-giai' => '<b>Luận theo Dương cách:</b> Tính cách khá chính trực, cần mẫn, dù gặp hoàn cảnh khó khăn cũng cố gắng vươn lên, có trí tuệ và chí tiến thủ, nếu biết nắm bắt thời vận ắt phất như diều gặp gió.',
            'uu-diem' => 'Bản thân cần kiệm liêm chính',
            'khuyet-diem' => 'Đôi khi khá vưởn vông, mơ mộng'
        ],
        'Giáp'=>[
            'ngu-hanh' => 'Mộc',
            'luan-giai' => '<b>Luận theo Dương cách:</b> Gia chủ có tính cách khá cương trực và ý thức kỷ luật. Nhưng những lúc khí vượng cao lại dễ có sự cố chấp. Nếu biết nắm bắt thời vận mọi sự sẽ như mong.',
            'uu-diem' => 'Bản thân chính trực',
            'khuyet-diem' => 'Đôi lúc dễ cố chấp'
        ],
        'Ất'=>[
            'ngu-hanh' => 'Mộc',
            'luan-giai' => '<b>Luận theo Dương cách:</b> Gia chủ có tính cách đôi khi hay mềm yếu, cẩn thận, nhưng cũng có lúc khá cố chấp nên dễ bỏ qua cơ hội. Nếu bản thân nắm bắt thời vận, điểm mạnh của bản thân thì sẽ phát tài.',
            'uu-diem' => 'Bản thân chu đáo, cẩn thận',
            'khuyet-diem' => 'Đôi khi dễ cố chấp bảo thủ'
        ],
        'Bính'=>[
            'ngu-hanh' => 'Hỏa',
            'luan-giai' => '<b>Luận theo Dương cách:</b> Gia chủ có tính cách nhiệt tình, hào phóng, cương trực nhưng đôi khi dễ nóng tính, nóng vội, dễ thô thẳng thật, hợp với những hoạt động xã giao, nhưng cũng dễ bị hiểu lầm là thích phóng đại, thích sự khen ninh. Khi gia chủ thấu hiểu được bản thân sẽ dễ phát tài vào những năm tài thần.',
            'uu-diem' => 'Tính cách nhiệt tình',
            'khuyet-diem' => 'Dễ hay nóng tính, vội'
        ],
        'Đinh'=>[
            'ngu-hanh' => 'Hỏa',
            'luan-giai' => '<b>Luận theo Dương cách:</b> Gia chủ có tính cách dễ bên ngoài trầm tĩnh, bên trong sôi nổi, cẩn trọng, bí mật nhưng lại hay đa nghi và mưu tính nhiều nên sẽ tạo thành khuyết điểm. Nếu bản thân nắm bắt được thời vận kiểm soát được ưu khuyết điểm ắt vạn sự hanh thông.',
            'uu-diem' => 'Bản thân luôn cẩn trọng, mạnh mẽ',
            'khuyet-diem' => 'Đôi khi hay đa nghi, nóng tính'
        ],
        'Mậu'=>[
            'ngu-hanh' => 'Thổ',
            'luan-giai' => '<b>Luận theo Dương cách:</b> Đôi lúc bản thân hơi coi trọng bề ngoài nhưng giỏi giao thiệp, có năng lực xã giao. Nhưng đôi lúc cũng dễ bị mất chính kiến mà thường hay chìm lẫn trong số đông. Bản thân biết nắm bắt thời vận, nghành nghề và làm ăn sẽ phát tài, đắc lộc.',
            'uu-diem' => 'Bản thân biết nhìn bao quát, giỏi ngoại giao',
            'khuyet-diem' => 'Lúc vận suy dễ nhu nhược'
        ],
        'Kỷ'=>[
            'ngu-hanh' => 'Thổ',
            'luan-giai' => '<b>Luận theo Dương cách:</b> Bản thân hay để ý tới chi tiết, cẩn thận, làm việc có trật tự đầu đuôi, nhưng có thể ít sự độ lượng. Khi bản thân biết nắm bắt thời vận, nghành nghề sẽ dễ phát tài lộc tiềm ẩn.',
            'uu-diem' => 'Bản thân khá cẩn thận',
            'khuyet-diem' => 'Đôi lúc dễ trì trệ, chấp vặt'
        ],
    ];

    public static array $diaChiLuanGiai = [
        'Thân'=>[
            'menh' => 'Dương',
            'ngu-hanh' => 'Kim',
            'luan-giai' => '<b>Luận theo Âm cách:</b> Bản thân có tính tò mò, tinh quái, khôn khéo, thông minh nhạy bén học hỏi nhanh, có sự hài hước biết giao tiếp, giỏi xoay sở nhưng đôi khi dễ cố chấp nên khó tiến thủ, hay đoán biết được ý nghĩ của người khác nên cũng khá đa nghi. Bản thân có sự quyến rũ và sức hút với đối phương, tính khá vui vẻ, tinh nghịch. Dễ thành công trong mọi lĩnh vực mà họ yêu thích và có hứng thú, nhưng hay có tư duy đến đâu thì đến nên đôi lúc cuộc sống vất vả. Hoài bão lớn nhưng nếu không thắng được bản thân thì khó phát triển.',
            'uu-diem' => 'khôn khéo',
            'khuyet-diem' => 'dễ cố chấp'
        ],
        'Dậu'=>[
            'menh' => 'Âm',
            'ngu-hanh' => 'Kim',
            'luan-giai' => '<b>Luận theo Âm cách:</b> Gia chủ biết đối nhân xử thế, hòa nhã, thân thiện. Biết tính trước tình sau, có thể sẳn sàng chịu thiệt để làm vui lòng hoặc được việc của mình, có đầu óc nhanh nhạy, linh hoạt nhưng dễ vì sự nóng vội, hấp tấp mà không thể làm tốt một việc lớn. Nhiều lúc dễ có sự tùy tiện, hỗn loạn, thích trang điểm, ăn diện.',
            'uu-diem' => 'nhanh nhậy, linh hoạt',
            'khuyet-diem' => 'hấp tấp'
        ],
        'Tuất'=>[
            'menh' => 'Dương',
            'ngu-hanh' => 'Thổ',
            'luan-giai' => '<b>Luận theo Âm cách:</b> Bản thân chính trực, thành thật và thẳng thắn, giàu lòng chính nghĩa, trượng nghĩa, sống có sự công bằng, đôi khi dễ bốc đồng, tính ngay thẳng chân thành, rất hay thích bênh vực kẻ yếu, có sự đồng cảm có thể sẵn sàng chia sẻ nỗi buồn với họ, phong cách sống ai tốt tốt lại, còn ai phận ý, chơi xấu thì có thể bỏ luôn, sống có trách nhiệm, kiên trì, chính vì vậy gia chủ luôn đạt được thành tích tốt trong công việc.',
            'uu-diem' => 'thẳng thắn, trượng nghĩa',
            'khuyet-diem' => 'nóng tính'
        ],
        'Hợi'=>[
            'menh' => 'Âm',
            'ngu-hanh' => 'Thủy',
            'luan-giai' => '<b>Luận theo Âm cách:</b> Bản tính khá trầm lặng, chắc chắn, kiên trì và cương nghị, dũng cảm có lòng dạ hiền lương, nhẫn nhịn, đôn hậu. Nhận lời là hết mình sẽ dốc toàn bộ sức lực để hoàn thành, khá chất phác nhưng ít màu mè, Tính tình họ ôn hòa, tha thứ không hại người mà còn thương và đồng cảm. Sống thẳng thắn và chân thành, không nhiều chuyện mô kích, không để bụng và tranh giành tới sống chết căng quá thì cho mọi người về nhất.',
            'uu-diem' => 'chắc chắn, kiên trì',
            'khuyet-diem' => 'dễ trì trệ, chậm chạp'
        ],
        'Tý'=>[
            'menh' => 'Dương',
            'ngu-hanh' => 'Thủy',
            'luan-giai' => '<b>Luận theo Âm cách:</b> Gia chủ có trí thông minh, duyên dáng và có sức hấp dẫn, luôn là người đứng đầu, tiên phong trong mọi hoạt động, thích sự trải nghiệm phiêu lưu mạo hiểm, quyền lực và tiền bạc. Sống khá sôi nổi, vui vẻ, lạc quan, dễ gần, dễ mến, giỏi giao thiệp, thích kết bạn, hội hè những nơi đông vui náo nhiệt.',
            'uu-diem' => 'luôn tích cực, mạnh dạn',
            'khuyet-diem' => 'dễ buông thả'
        ],
        'Sửu'=>[
            'menh' => 'Âm',
            'ngu-hanh' => 'Thổ',
            'luan-giai' => '<b>Luận theo Âm cách:</b> Gia chủ tính cách mạnh mẽ và nổi trội, có sự kiên gan, bền bỉ, trung thực, thẳng thắn nhưng đôi khi hơi cố chấp nhưng sức chịu đựng cao, ý chí vững vàng nói là làm, có tài lãnh đạo, biết nhìn xa trông rộng sống thực tế, không viển vông. Gia chủ thích sống khép kín, quyết đoán, dứt khoát không dễ dàng bị cám dỗ, thích tự do.',
            'uu-diem' => 'trung thực',
            'khuyet-diem' => 'ích kỷ'
        ],
        'Dần'=>[
            'menh' => 'Dương',
            'ngu-hanh' => 'Mộc',
            'luan-giai' => '<b>Luận theo Âm cách:</b> Gia chủ có lòng nhân ái, dũng cảm, mạnh mẽ, thẳng thắng, trung thực, công bằng có thể đứng ra bảo vệ kẻ yếu, thích độc lập, khá liều lĩnh, mạo hiểm, luôn cởi mở và chân thành với bạn bè. Có trí sáng tạo, ý tưởng phong phú, quyết đoán không sợ khó khăn, nhưng đôi khi dễ khoe khoang.',
            'uu-diem' => 'công tâm',
            'khuyet-diem' => 'khoe khoang'
        ],
        'Mão'=>[
            'menh' => 'Âm',
            'ngu-hanh' => 'Mộc',
            'luan-giai' => '<b>Luận theo Âm cách:</b> Với tâm tính chân thành, tốt bụng, dịu dàng, ghét bạo lực, tinh tế, có con mẳt thẩm mỹ, có sự nhân ái thich giúp người nên đôi khi dễ bị lợi dụng, thích an phận hơn là bon chen tranh đấu thị phi, ăn nói lưu loát, có tài, có lòng tự trọng biết khiêm nhường, biết giữ gìn ý tứ, có đức hạnh, khi gặp sự cố giữ được bình tĩnh, mát tính. Bản thân có ý chí mạnh mẽ nên có thể làm kinh doanh, biết yêu gia đình. Nhưng hay bị phụ thuộc.',
            'uu-diem' => 'chân thành',
            'khuyet-diem' => 'dễ bị lợi dụng'
        ],
        'Thìn'=>[
            'menh' => 'Dương',
            'ngu-hanh' => 'Thổ',
            'luan-giai' => '<b>Luận theo Âm cách:</b> Gia chủ có tham vọng lớn và muốn thống trị nắm quyền cao, có sức quyến rũ, khoan dung đại lượng và tỏa sáng, có tính thương người. Bản thân vận vượng luôn tràn trề sinh lực và sức khỏe dồi dào nên khi gặp thời sẽ lên làm sếp nhưng chú ý nhược điểm, nóng vội làm xong mới nghĩ nên dễ nợ lần lao lý. Lúc vận thế suy dễ có tính kiêu ngạo, thanh cao, thẳng thắn nên đôi lúc hơi thiệt thòi, bản tính khó khăn không chịu khuất phục, công việc chưa xong khó chịu làm bằng được nên trong cuộc sống có nhiều thành quả.',
            'uu-diem' => 'có trí',
            'khuyet-diem' => 'kiêu ngạo'
        ],
        'Tỵ'=>[
            'menh' => 'Âm',
            'ngu-hanh' => 'Hỏa',
            'luan-giai' => '<b>Luận theo Âm cách:</b> Bản thân khá khôn ngoan, có tính kiên nhẫn, có sự quan sát và bao quát, phán đoán đúng đắn tìm sự rõ ràng, kín đáo, bình tĩnh biết chờ đợi và sống nội tâm chỉ có tri kỷ mới sẻ chia mở lòng. Khi vận vượng dễ bốc đồng, bảo thủ, bí ẩn tinh tế luôn cẩn trọng, tìm cách gánh vác mọi chuyện ổn thỏa mói thôi. Lý luận như nhà triết học, tư duy sâu sắc, nho nhã, lịch sự, rất thích đọc sách nghe nhạc, nợ ai là nóng lòng trả bằng hết. Sống nhiệt tình, chăm chỉ lại rất đa nghi dù bề ngoài luôn tỏ vẻ tin tưởng tuyệt đối.',
            'uu-diem' => 'kiên cường',
            'khuyet-diem' => 'bốc đồng'
        ],
        'Ngọ'=>[
            'menh' => 'Dương',
            'ngu-hanh' => 'Hỏa',
            'luan-giai' => '<b>Luận theo Âm cách:</b> Bản thân thich sự đổi mới, ham hoạt động, thích độc lập, đôi khi hay cả thèm chóng chán, số khá đào hao, nhiều khi chuyện tình duyên như gió cuốn mây trôi, Tính rộng rãi, hào phóng, giỏi đối đáp, ngoại giao, có sự quan sát tốt, đầu óc nhanh nhẹn, cởi mở, dí dỏm, thích tự do đi đây đi đó, không chịu sự ràng buộc vào bất cứ cái gì, thích làm việc theo sở thích, đôi khi khá nóng nảy, nhưng không để bụng. Có thể làm nhiều việc 1 lúc, tâm lý.',
            'uu-diem' => 'đầu óc nhanh nhẹn',
            'khuyet-diem' => 'cả thèm chóng chán'
        ],
        'Mùi'=>[
            'menh' => 'Âm',
            'ngu-hanh' => 'Thổ',
            'luan-giai' => '<b>Luận theo Âm cách:</b> Bản thân luôn vui cười nhưng cũng khá nội tâm hay nghĩ nhiều thích sự khép kín, sống chân thực, thân thiệt hòa đồng, cảm thông. hiền lành, dễ xấu hổ, bẽn lẽn. Có con mắt nghệ thuật, sáng tạo, lúc không được việc bi quan, chán nản, buồn bã. Điệu đà nghệ sĩ, có mắt thẩm mỹ, văn hoa phong phú. Hay thích chống đối, không thích bị ép buộc, suy nghĩ sâu sắc, tốt bụng hay giúp đỡ và quan tâm đến người khác. Khá chu đáo, không muốn tổn thương bất kỳ ai và muốn giữ hòa khí.',
            'uu-diem' => 'hiền lành, sáng tạo',
            'khuyet-diem' => 'hay bi quan'
        ],
    ];

    public static array $cungMenhLuanGiai = [
        'Tý' => '<b>Cung mệnh Thiên quý tinh:</b> Gia chủ có chí khí lớn lao và giàu có cao quý, làm ăn buôn bán may mắn, có trí có tài.',

        'Sửu' => '<b>Cung mệnh Thiên ách tinh:</b> Gia chủ dễ phải xa quê Cha đất tổ lập nghiệp mới lên, vất vả, gian nan trước sau mới cát, tiền trung vận buôn ba sau 38 tuổi cuộc sống sẽ an nhàn thảnh thơi',

        'Dần' => '<b>Cung mệnh Thiên quyền tinh:</b> Gia chủ thông minh có triển vọng, thời trung niên có quyền chức hoặc làm chủ, sếp cán bộ lãnh đạo, chú ý giữ đức, tu tâm để tránh lao lý.',

        'Mão' => '<b>Cung mệnh Thiên xá tịnh:</b> Gia chủ dễ trọng nghĩa khinh tài, sống cao thượng nhưng kiêu ngạo, có trí có tài nhưng cần cảm thông và hòa đồng để có cuộc sống an nhiên bình an.',

        'Thìn' => '<b>Cung mệnh Thiên như tinh:</b> Công việc, cuộc sống của Gia chủ hay có sự thay đổi, lắm mưu nhiều kế nhưng chưa đâu vào đâu, cần chính kiến, hãy lấy tâm làm móng để mọi sự hanh thông.',

        'Tỵ' => '<b>Cung mệnh Thiên văn tinh:</b> Gia chủ có sự nghiệp văn chương sáng lạng, yêu và có năng khiếu nghệ thuật, chú ý giữ đạo để tránh mắc sai lầm trong tửu sắc, trí vững ắt vận thông.',

        'Ngọ' => '<b>Cung mệnh Thiên phúc tinh:</b> Mệnh thuộc vinh hoa phú quý, thanh nhàn yên vui, nên tu tâm hướng thiện bao dung độ lượng, biết cảm thông để giữ phúc báu lâu dài.',

        'Mùi' => '<b>Cung mệnh Thiên dịch:</b> Tuổi trẻ buôn ba vất vả, rời quê tổ lập nhiệp mới lên, vất vả, gian nan trước sau mới có, tiền trung vận buôn ba cần kiệm liêm chính ắt về sau hiển vinh.',

        'Thân' => '<b>Cung mệnh Thiên cô tinh:</b> Bản thân dễ tự thân vận đông, cô quạnh một phần do bản thân muốn sống khép kín, tâm lành dễ tu đắc đạo, nên tạo phúc trợ duyên để sau có cuộc sống thanh cao viên mãn',

        'Dậu' => '<b>Cung mệnh Thiên bí tinh:</b> Gia chủ tính tình thẳng thắn nên dễ gặp vạ chuyện thị phi, có chút nóng vội, hay lo chuyện bao đồng và thích giúp người khác nhưng dễ nhiều chuyện, tu khẩu tu tâm mới tốt.',

        'Tuất' => '<b>Cung mệnh Thiên nghệ tinh:</b> Bản thân đa tài đa nghệ nhưng dễ dãi hùa theo, có thể cái gì cũng biết nhưng không giỏi, nếu không có sự thay đổi thì dễ khó thành danh, nên chính kiến tập trung theo năng khiếu, về sau mới có cuộc sống như mong',

        'Hợi' => '<b>Cung mệnh Thiên thọ tinh:</b> Gia chủ có lòng nhân từ, tính nhanh nhẹn, lấy giúp người làm vui, có cuộc sống bình bình, ghét xô sát trang dành. Không giầu và cũng không nghèo.',
    ];

    public static array $napAmLuanGiai = [
        'Kim' => '<b>Luận theo Âm/Dương cách: </b> Bản thân có tính cách mạnh mẽ, tự tin, cương quyết. Lúc vượng khí cao dễ độc đoán, cứng nhắc nên dễ sầu muộn, bản thân muốn có được gì sẽ dốc hết lòng để đạt cho bằng được. Có tư duy tổ chức giỏi, có sự quyết đoán tuy nhiên đôi lúc vì tin vào khả năng của bản thân quá dễ kém linh động. Tính khá nghiêm túc khái tính nên không dễ nhận sự giúp đỡ.',

        'Thủy' => '<b>Luận theo Âm/Dương cách: </b> Gia chủ khá thông minh, tính cách thẳng thắn và dí dỏm. Có trí nhớ tốt, hay cân nhắc nặng nhẹ và khá cẩn thận, khép kín, thâm ý. Cũng khá hòa đồng, cởi mở, luôn có sự tích cực và năng động, đôi lúc cảm giác khá bận rộn kiểu người của công việc, bản thân thích cuộc sống thanh bình, không thích đối đầu',

        'Mộc' => '<b>Luận theo Âm/Dương cách: </b> Gia chủ tính cách khá hài hòa, linh hoạt, phóng khoáng, điềm đạn, giàu tình cảm và có trái tim nhân hậu, biết trước biết sau, luôn lạc quan yêu đời, thích kết bạn với mọi người. Bản thân có sự tự tin vào chính mình, có thể sẵn sàng thể hiện bản thân, tác phong nhanh nhẹn, xong cũng dễ thay đổi, đôi khi khá cố chấp, bảo thủ, cứng rắn, nóng giận vội vàng, không dễ dàng giao động, đã quyết việc gì là không từ bỏ, chăm chỉ, gan dạ sống có tham vọng.',

        'Hỏa' => '<b>Luận theo Âm/Dương cách: </b> Bản tính dũng cảm, nói là làm rất khái tính, thẳng thắn, bộc trực nhưng thật thà sống có quy tắc, không nhất thì bét luôn sẵn sàng chiến đấu, mạo hiểm chấp nhận rủi ro. Tư duy chủ động có tham vọng. Không thích sự dối trá, đôi khi khá khô khan dễ nóng vội dễ bốc đồng, thô thẳng thật, ý chí mạnh mẽ, kiên cường, luôn tràn đầy năng lượng.',

        'Thổ' => '<b>Luận theo Âm/Dương cách: </b> Tính cách khá dễ thương, dễ gần, hòa đồng, điềm đạm, cần kiệm rất giữ chữ tín nói là làm. Nhưng cái tôi, tự trọng, tự ái cao, bản thân hay tự ti, biết nhìn thẳng sự việc để nhìn nhận, chấp nhận cái sai, họ dám làm dám chịu. Đôi lúc khá nhu nhược, mềm lòng và bao dung, độ lượng. Bản thân có khả năng tổ chức, giỏi sắp xếp, sống kỷ luật, tự giác, luôn nỗ lực hoàn thành công việc, nội tâm sống động hay suy tư, đôi khi bảo thủ nên dễ nhàm chán, khi làm gì cố làm cho bằng được về sau thành công từ từ.',
    ];

    public static array $dungHyThan = [
        'Kim'=>[
            'so-vi-du'=>'(6-7) (07*67.67.67 – 08*66.7777 – 09*666666 - 07*258.777 – 07*226.667 ...)',
            'so-tong-quan'=>'<li>Có nhiều số 6-7 xuất hiện trong 10 số sim</li>
                                <li>Có 2 đến 3 số cuối thuộc ngũ hành kim và những số đứng trước là ngũ hành tương sinh ra kim – (thổ)</li>
                                <li>Sim ngũ hành kim là thân thuộc kim trong khi được sinh trợ từ các ngũ hành như thổ (sinh), kim (trợ)
                                    và không bị khắc (hỏa) hao (thủy) hoặc bị nhưng nhẹ</li>',
            'y-nghia'=>'Sim mệnh kim dùng cho chủ sự có dụng thần hoặc hỷ thần là KIM. (chủ sự thân vượng là MỘC – hoặc THỔ và dùng cho chủ sự khuyết nhược KIM)'
        ],
        'Thủy'=>[
            'so-vi-du'=>'(0-1) (07*00.11.00 – 08*11.0000 – 09*1111 – 09*11111 – 08*. 00000 - 07*660.111 – 07*670.1111, vv...)',
            'so-tong-quan'=>'<li>Có nhiều số 0 -1  xuất hiện trong 10 số sim</li>
                                <li>Có 2 đến 3 số cuối thuộc ngũ hành THỦY và những số đứng trước là ngũ hành tương sinh ra THỦY (KIM)</li>
                                <li>Sim ngũ hành THỦY là thân thuộc THỦY trong khi được sinh trợ từ các ngũ hành như KIM (sinh), THỦY (trợ) và không bị khắc (THỔ) hao (MỘC) hoặc bị nhưng nhẹ</li>',
            'y-nghia'=>'Sim mệnh THỦY dùng cho chủ sự có dụng thần hoặc hỷ thần là THỦY. (chủ sự thân vượng là HỎA – hoặc KIM và dùng cho chủ sự khuyết nhược THỦY)',
        ],
        'Mộc'=>[
            'so-vi-du'=>'(3-4) (07*.343434. – 08*.333333. – 09*.444444 - 07*11.33.44 – 07*11.3333, vv...)',
            'so-tong-quan'=>'<li>Có nhiều số 0 -1  xuất hiện trong 10 số sim</li>
                                <li>Có 2 đến 3 số cuối thuộc ngũ hành MỘC</li>
                                <li>Sim ngũ hành MỘC là thân thuộc MỘC trong khi được sinh trợ từ các ngũ hành như THỦY (sinh), MỘC(trợ) và không bị khắc (KIM), hao (HỎA) hoặc bị nhưng nhẹ</li>',
            'y-nghia'=>'Sim mệnh MỘC dùng cho chủ sự có dụng thần hoặc hỷ thần là MỘC. (chủ sự thân vượng là THỔ – hoặc THỦY và dùng cho chủ sự khuyết nhược MỘC)',
        ],
        'Hỏa'=>[
            'so-vi-du'=>'(9) (07*.339999. – 08*.393999. – 09*.999999, 087*.33.44.99 – 07**11.33.99, vv...)',
            'so-tong-quan'=>'<li>Có nhiều số 9  xuất hiện trong 10 số sim</li>
                                <li>Có 2 đến 3 số cuối thuộc ngũ hành HỎA và những số đứng trước là ngũ hành tương sinh ra HỎA (MỘC)</li>
                                <li>Sim ngũ hành HỎA là thân thuộc HỎA trong khi được sinh trợ từ các ngũ hành như MỘC (sinh), HỎA (trợ). Và không bị khắc (THỦY), hao (THỔ) hoặc bị nhưng nhẹ</li>',
            'y-nghia'=>'Sim mệnh HỎA dùng cho chủ sự có dụng thần hoặc hỷ thần là HỎA. (chủ sự thân vượng là KIM hoặc MỘC và dùng cho chủ sự khuyết nhược HỎA)',
        ],
        'Thổ'=>[
            'so-vi-du'=>'(2-5-8) (07*22.55.88. – 08*22.5555. – 09*55.8888 - 087*.33.44.99  – 07*11.33.99, vv...)',
            'so-tong-quan'=>'<li>Có nhiều số 2 5 8 xuất hiện trong 10 số sim</li>
                                <li>Có 2 đến 3 số cuối thuộc ngũ hành THỔ và những số đứng trước là ngũ hành tương sinh ra HỎA (MỘC)
                                </li>
                                <li>Sim ngũ hành THỔ là thân thuộc THỔ trong khi được sinh trợ từ các ngũ hành như HỎA (sinh),THỔ MỘC (trợ) và
                                    không bị khắc (MỘC), hao (KIM) hoặc bị nhưng nhẹ</li>',
            'y-nghia'=>'Sim mệnh THỔ dùng cho chủ sự có dụng thần hoặc hỷ thần là THỔ. (chủ sự thân vượng là THỦY hoặc MỘC và dùng cho chủ sự khuyết nhược THỔ)',
        ]
    ];

    public static string $gioiThieuChung = '<p>Mỗi chúng ta, khi Sinh Thần đều mang trong mình Bản Mệnh riêng biệt, Chân Mệnh ấy là tiếng nói dõng dạc về một Kiếp nhân sinh bí ẩn. Trên thì có Thiên duyên định, dưới thì bản mệnh có ngày tháng năm sinh, Can, Chi, Mệnh, Vận. Số mệnh của một người là do Trời định, là thứ bất biến, không thể thay đổi. Nhưng phúc họa của một người lại là do bản thân tự chiêu mời. Một người có số mệnh không may mắn nhưng vẫn có thể cải biến được, tại sao lại thế? Đó là do Vận. Vận mà Hỷ, Mệnh ắt Thông. Vận mà tốt thì Mệnh cũng sẽ tốt lên.</p><p>Phúc Lộc có được tại Nhân, theo lẽ thường, một người muốn giàu có thì phải có nhân tướng tốt hoặc số mệnh tốt. Vậy nên muốn cải Vận may mắn, cách nhanh nhất là con người cần thay đổi các thông số của mình theo các hướng có lợi để kích tài vận, kích công danh, tài lộc, gia đạo tình duyên hay đơn giản là muốn thuận lợi, cầu sức khỏe. </p><p>Kính thưa quý vị,
    Chào mừng quý vị, đã đến với phần Bình giải cụ thể với số SIM mà quý vị đã ưu tiên và dành thời gian lựa chọn. Hy vọng rằng, sim Phong thủy sẽ là một bộ công cụ hiệu quả hỗ trợ đắc lực cho sự thành công trong cuộc sống, tình duyên và đặc biệt là lộ trình vươn lên đỉnh cao về danh vọng và sự viên mãn của quý vị. Những tham chiếu dưới đây sẽ là bộ kiến giải cụ thể và xác đáng nhất cho sự lựa chọn của quý vị.</p>';

    public static string $textDungThanVuongNhuoc = '<p>Sau khi xét các mối tương tác sự,  xung, khắc, trợ, sinh, hao, hợp, hóa, tám thiên can địa chi của bốn trụ năm, tháng, ngày, giờ sinh. Qua công thức tính độ vượng của ngũ hành. Có thể thấy trong Tứ Trụ này có Thân <strong>=?</strong> thuộc hành <strong>=?</strong></p>
                                                <p class="bold">Dụng Thần dự đoán là <strong>=?</strong>, Hỷ Thần là <strong>=?</strong> tùy vận</p>';

    public static array $menhChuTextVuong = [
        'Kim' => '<p>Mệnh này dễ có tính Độc đoán, cương quyết, dốc lòng để đạt được mục tiêu, có sự Tổ chức giỏi, quyết đoán, nhưng có thể kém linh động, trong cuộc sống cũng như công việc rất nghiêm túc và không dễ nhận sự giúp đỡ, tính cách mạnh mẽ, cứng nhắc, nội tâm hay sầu muộn. Đôi lúc rất Bướng bỉnh, nhất bét, cứng ngoài mềm trong. Mệnh này muốn tốt lên dùng sim phong thủy hoặc những vật phẩm phong thủy có ngũ hành thuộc HỎA hoặc THỦY để trợ mệnh giúp mệnh có sự cân bằng để phát triển. Cộng thêm phương vị và nghành nghề, nỗ lực dưỡng ưu sửa khuyết, tâm an trí vững để vận thông.</p>',

        'Thủy' => '<p>Mệnh này có trí thông minh, tháo vát, nhưng đôi lúc dễ xảo quyệt, có cuộc sống phức tạp. đời sống tình cảm phong phú, nhiều ước mơ nên mục tiêu dễ cả thèm chóng chán. Làm gần được lại mất do bỏ qua. Dễ bao la bồng bềnh, nhưng năm suy càng làm càng mất do tính cách và tư duy, như dòng nước lũ quẩn chôi mọi thứ. Mệnh này muốn tốt lên dùng sim phong thủy hoặc những vật phẩm phong thủy có ngũ hành thuộc THỔ hoặc MỘC để trợ mệnh giúp mệnh có sự cân bằng để phát triển. Cộng thêm phương vị và nghành nghề, nỗ lực dưỡng ưu sửa khuyết, tâm an trí vững để vận thông.</p>',

        'Mộc' => '<p>Mệnh này dễ cố chấp, bảo thủ, cứng rắn, đã quyết việc gì là không từ bỏ, tham vọng, nóng giận vội vàng, nói xong mới nghĩ hay bị mất lòng, làm ăn không lắm bắt được cơ hội, khái tính, sinh sôi nhiều nhưng yếu, ví như 1 m2 trồng 1 cây là đủ, đây lại trồng tận 10 cây. Mệnh này muốn tốt lên dùng sim phong thủy hoặc những vật phẩm phong thủy có ngũ hành thuộc THỦY hoặc KIM để trợ mệnh giúp mệnh có sự cân bằng để phát triển. Cộng thêm phương vị và nghành nghề, nỗ lực dưỡng ưu sửa khuyết, tâm an trí vững để vận thông.</p>',

        'Hỏa' => '<p>Mệnh này dễ nói là làm khái tính, quy tắc, không nhất thì bét luôn sẵn lòng chấp nhận rủi ro, dấn thân và mạo hiểm. Chủ động và tham vọng. thẳng thắn, bộc trực và thật thà. Không nói dối, khô khan dễ nóng vội, thẳng thắn, thô thẳng thật, sáng tạo, nhưng dễ bốc đồng, chí mạnh mẽ, kiên cường, luôn tràn đầy năng lượng.Cũng do đó nếu thân vượng hỏa quá thì nhưng đức tính đó cũng sẽ hại họ, dấn thân và mạo hiểm, khô khan dễ nóng vội, thẳng thắn, thô thẳng thật, dễ bốc đồng. Nên gần được lại mất vì cái tôi mà bỏ qua cơ hội, cũng vẫn biết không nên nhưng vẫn có làm, bảo thủ gia trưởng. Mệnh này muốn tốt lên dùng sim phong thủy hoặc những vật phẩm phong thủy có ngũ hành thuộc THỦY hoặc THỔ để trợ mệnh giúp mệnh có sự cân bằng để phát triển. Cộng thêm phương vị và nghành nghề, nỗ lực dưỡng ưu sửa khuyết, tâm an trí vững để vận thông.</p>',

        'Thổ' => '<p>Mệnh này dễ Có cái tôi, tự trọng, tự ái, tinh thần vững chắc. Thành chậm chạp, ỉ lại, trì trệ, bảo thủ cố chấp, khô cằn và cô quạnh, nhu nhược, hay bỏ qua cơ hội và tư duy quá suy tư, Mệnh này muốn tốt lên dùng sim phong thủy hoặc những vật phẩm phong thủy có ngũ hành thuộc MỘC hoặc KIM để trợ mệnh giúp mệnh có sự cân bằng để phát triển. Cộng thêm phương vị và nghành nghề, nỗ lực dưỡng ưu sửa khuyết, tâm an trí vững để vận thông.</p>',
    ];

    public static array $menhChuTextNhuoc = [
        'Kim' => '<p>Mệnh này dễ Mền yếu, nhiều khi hay cà nể thành nhu nhược, xong cái gì cũng từ từ thành ỉ lại, khi gặp khó khăn thì dễ nhanh nản trí, cũng hay có tính dụt dè, lúc vui vượng thế cũng linh động nhưng hiệu quả hơi thấp chính vì vậy, Mệnh này muốn tốt lên dùng sim phong thủy hoặc những vật phẩm phong thủy có ngũ hành thuộc KIM hoặc THỔ để trợ mệnh giúp mệnh có sự cân bằng để phát triển. Cộng thêm phương vị và nghành nghề, nỗ lực dưỡng ưu sửa khuyết, tâm an trí vững để vận thông.</p>',

        'Thủy' => '<p>Mệnh này dễ có tư duy chậm chạp, đời sống khô cằn, trí nhớ khá kém, hay vội vàng thiếu sự cận thận, hay qua loa, dễ buông xuôi, đôi lúc có tất xấu dễ nham hiểm, và khi gặp sự cố dễ hay mất bình tĩnh. Đôi lúc khi bị dồn vào đường cùng hay có tâm địa xấu sẽ rất mưu mô, nhưng sau khi có lại công tâm trả lại những gì bản thân đã làm sai, và thích tranh giành quyền lực, và kết quả không được gi? Mệnh này muốn tốt lên dùng sim phong thủy hoặc những vật phẩm phong thủy có ngũ hành thuộc THỦY hoặc KIM để trợ mệnh giúp mệnh có sự cân bằng để phát triển. Cộng thêm phương vị và nghành nghề, nỗ lực dưỡng ưu sửa khuyết, tâm an trí vững để vận thông.</p>',

        'Mộc' => '<p>Mệnh này dễ Thiếu sự phát triểm và nghị lực, gắp khó khăn lùi bước, ý chí kém, vội vàng và buông xuôi, cuộc sống mất phương hướng và định hướng. Mệnh này muốn tốt lên dùng sim phong thủy hoặc những vật phẩm phong thủy có ngũ hành thuộc MỘC hoặc THỦY để trợ mệnh giúp mệnh có sự cân bằng để phát triển. Cộng thêm phương vị và nghành nghề, nỗ lực dưỡng ưu sửa khuyết, tâm an trí vững để vận thông.</p>',

        'Hỏa' => '<p>Mệnh này dễ Thiếu sự quyết đoán, trần trừ, nhút nhát, chậm chạp, suy nghĩ thấu đáo tới mức cơ hội qua mới có quyết định, thiếu sự chủ động nhu nhược. Mệnh này muốn tốt lên dùng sim phong thủy hoặc những vật phẩm phong thủy có ngũ hành thuộc HỎA hoặc MỘC để trợ mệnh giúp mệnh có sự cân bằng để phát triển. Cộng thêm phương vị và nghành nghề, nỗ lực dưỡng ưu sửa khuyết, tâm an trí vững để vận thông.</p>',

        'Thổ' => '<p>Mệnh này dễ lay động, không có sự quyết đoán do dự và tự ti, bảo thủ, nhu nhược, thiếu chứng kiếm, nửa vời cả thèm chóng chán, không có lập trường. Mệnh này muốn tốt lên dùng sim phong thủy hoặc những vật phẩm phong thủy có ngũ hành thuộc THỔ hoặc HỎA để trợ mệnh giúp mệnh có sự cân bằng để phát triển. Cộng thêm phương vị và nghành nghề, nỗ lực dưỡng ưu sửa khuyết, tâm an trí vững để vận thông.</p>',
    ];

    public static array $nguHanhSim = [
        'Kim' => '<p><strong>- Sim =? mệnh KIM dùng cho chủ sự có dụng thần hoặc hỷ thần là KIM. (chủ sự thân vượng là MỘC – hoặc THỔ và dùng cho chủ sự khuyết nhược KIM)</strong></p>',

        'Thủy' => '<p><strong>- Sim =? mệnh THỦY dùng cho chủ sự có dụng thần hoặc hỷ thần là THỦY. (chủ sự thân vượng là HỎA – hoặc KIM và dùng cho chủ sự khuyết nhược THỦY)</strong></p>',

        'Mộc' => '<p><strong>- Sim =? mệnh MỘC dùng cho chủ sự có dụng thần hoặc hỷ thần là MỘC. (chủ sự thân vượng là THỔ – hoặc THỦY và dùng cho chủ sự khuyết nhược MỘC)</strong></p>',

        'Hỏa' => '<p><strong>- Sim =? mệnh HỎA dùng cho chủ sự có dụng thần hoặc hỷ thần là HỎA. (chủ sự thân vượng là KIM – hoặc MỘC và dùng cho chủ sự khuyết nhược HỎA)</strong></p>',

        'Thổ' => '<p><strong>- Sim =? mệnh THỔ dùng cho chủ sự có dụng thần hoặc hỷ thần là THỔ. (chủ sự thân vượng là THỦY – hoặc HỎA và dùng cho chủ sự khuyết nhược THỔ)</strong></p>',
    ];

    public static string $duNienText = '<p>Sim của bạn có <strong>=?</strong> cặp số (<strong>=?</strong>) thuộc du niên</p>';
    public static string $nguHanhText = '<ul>
				<li>Hành của bản mệnh: =? (Năm sinh: =?)</li>
				<li>Hành của số sim: =?</li>
				<li>Hành =?</li>
			</ul>';
    public static string $simAmDuongText = '<p>- Dãy số có <span style="color:#CF4040;font-weight:bold">=?</span> số mang vận âm, <span style="color:#CF4040;font-weight:bold">=?</span> số mang vận dương.</p>';
    public static string $dangSoText = '<p>Dạng số thuộc <strong>=?</strong> =?</p>';
    public static string $simSoText = '<p>Sim ngũ hành <strong>=?</strong> cơ bản là:</p>=?';
    public static string $hopMenhText = '<p>Ý nghĩa hợp mệnh</p>=?<p>SIM SỐ sim phong thủy như 1 ID của mỗi chúng ta, giúp chúng ta kết nới với lục thân, đối tác, vv... tai sao lại goi là ID ví sím số thay mặt chủ sử để tiếp cận gián tiếp với người mình cần gặp và người muốn gặp mình, thông qua những năng lương và tần sóng- số- nếu năng lượng tốt, hợp mệnh cục của chủ sự, thì vạn sự hanh thông trôi chảy, đạt được ước muốn hoan hỷ thịnh cầu. Ngược lại gặp năng lượng xấu gặp chuyện gần được lại mất, ức chế tiền mất tật mạng, vướng vào thì phi phiền toái</p>
                        <p>Nhưng quý vị cũng lên lưu ý:</p>
                        <ul class="list-number">
                            <li>Sim phong thủy không thể giúp chủ sự tự nhiên mà giầu có</li>
                            <li>Sim phong thủy không thể giúp chủ sự không làm mà cũng có ăn</li>
                            <li>Sim phong thủy không thể giúp chủ sự làm ắc gặp thiện</li>
                        </ul>
                        <p>Sim phong thủy có nguồn năng lượng tốt hỗ trợ gia chủ khỏe mạnh, may mắn, trí tuệ thông, gặp ông có đức gặp bà có nhân, gặp người gặp duyên. Việc gặp với cả việc thành là khác nhau xin quý vị lưu ý. Phúc lộc tại nhân – thành sự tại trí - tâm an trí vững ắt vận thông, sim phong thủy hay tất cả nhưng vật phẩm phong thủy trợ mệnh chỉ giúp quý vị được 25% - còn 20% là do phong thủy chỗ quý vị ở. Quý vị làm việc, ngành nghề quý vị làm và kinh doanh. Và 55% còn lại là do chính bản thân của quý vị biết điểm yếu điểm mạnh, của bản thân, biết sai thiêu sót phải sửa. Biết điểm mạnh để phát huy. Thành công chỉ đếm khi quý phát huy được điểm mạnh, niềm đam mê, sự nỗ lực phấn đấu, Và cần kiệm liêm chính, trông cây nào thì hái quả đó, và nắm được thời thể vượng suy lên đầu tư hay thủ thân. Tất cả là do bản thân mỗi chúng ta. Các vật phẩm phong thủy hay các thuật toán chỉ trợ mệnh hỗ trợ quý vị mà thôi.</p>';

    public static array $nangLuongText = [
        'sinh-thien-dien'=>'<p>- Số Sim này có chứa những cặp số thuộc Năng lượng Sinh Diên Niên, nên mệnh sim được Đắc đại cát, ngoài việc bổ trợ về kinh doanh phát đạt và có những mối quan hệ cát lành, thì năg lượng sinh diên niên còn hóa giải được những chủ sự phạm phải ngũ quỷ trong bát trạch, kết hôn, số CMTND số nhà, số xe bị phạm ngũ quỷ.</p>',
        'sinh-dien'=>'<p>- Số Sim này có chứa những cặp số thuộc Năng lượng Sinh Diên, nên mệnh sim được Đắc đại cát, ngoài việc bổ trợ về kinh doanh phát đạt và có những mối quan hệ cát lành, thì năg lượng sinh diên còn hóa giải được, những chủ sự phạm phải họa hại (thị phi phiền toái) trong bát trạch, kết hôn, số CMTND số nhà, số xe bị phạm họa hại (thị phi phiền toái).</p>',
        'sinh-khi'=>'<p>- Sim này có chứa những cặp số thuộc năng lượng sinh khí, nên mệnh sim được Đắc Sinh Khí bảo trợ Sức khỏe, Thúc đẩy quan hệ hợp tác, gặp gỡ được Qúy nhân.</p>',
        'dien-nien'=>'<p>- Số Sim này có chứa những cặp số thuộc năng lượng sinh khí, nên mệnh sim được Tọa Phúc Đức Ân Duệ thúc đẩy Công danh để Thăng quan tiến chức, tinh thần thoải mái và gia đạo được êm ấm.</p>',
        'thien-y'=>'<p>- Số Sim này có chứa những cặp số thuộc năng lượng sinh khí, nên mệnh sim được Vượng Thiên Y kích Tài sinh Lộc, Củng cố Địa vị và gia tăng May mắn.</p>',
        'phuc-vi'=>'<p>- Số Sim này có chứa những cặp số thuộc năng lượng sinh khí, nên mệnh sim được Trợ Phục Vị Viên Mãn giúp Sự nghiệp, Tiền Bạc và Tình cảm được bền vững,Gia đình bình an, tính toán thuận lợi.</p>'
    ];

    public static string $soSimNguHanhText = '<span class="span_nh">=? ( <span style="color: =?">=?</span>) </span>';

    public static array $soNguHanh = [
        0=>[
            'ngu-hanh'=>'Thổ',
            'color'=>'#666',
            'am-duong'=>'-'
        ],
        1=>[
            'ngu-hanh'=>'Thủy',
            'color'=>'#2F7BFF',
            'am-duong'=>'+'
        ],
        2=>[
            'ngu-hanh'=>'Thổ',
            'color'=>'#666',
            'am-duong'=>'-'
        ],
        3=>[
            'ngu-hanh'=>'Mộc',
            'color'=>'#29DF53',
            'am-duong'=>'+'
        ],
        4=>[
            'ngu-hanh'=>'Mộc',
            'color'=>'#29DF53',
            'am-duong'=>'-'
        ],
        5=>[
            'ngu-hanh'=>'Thổ',
            'color'=>'#666',
            'am-duong'=>'+'
        ],
        6=>[
            'ngu-hanh'=>'Kim',
            'color'=>'#FFE900',
            'am-duong'=>'-'
        ],
        7=>[
            'ngu-hanh'=>'Kim',
            'color'=>'#FFE900',
            'am-duong'=>'+'
        ],
        8=>[
            'ngu-hanh'=>'Thổ',
            'color'=>'#666',
            'am-duong'=>'-'
        ],
        9=>[
            'ngu-hanh'=>'Hỏa',
            'color'=>'#FF0064',
            'am-duong'=>'+'
        ]
    ];

    public static array $arrquedich = array(
        1 => array(
            1 => array(
                'diem' => 2,
                'status' => 'Cát',
                'name' => "thuankien",
                'tengoi' => "Thuần KIỀN",
                'ynghia' => "Kiện dã. Chính yếu. Cứng mạnh, khô, lớn, khỏe mạnh, đức không nghỉ. Nguyên Hanh Lợi Trinh chi tượng: Tượng vạn vật có khởi đầu, lớn lên, toại chí, hóa thành; chính mình, chính diện, trước mặt."
            ),
            2 => array(
                'diem' => 1.5,
                'status' => 'Bình',
                'name' => "trachthienquai",
                'tengoi' => "Trạch Thiên QUẢI",
                'ynghia' => "Đây là quẻ số 43 trong kinh dịch. Quẻ được kết hợp bởi nội quái là Càn và ngoại quái là Đoài.<br/><br/>
<b>Giải Nghĩa</b>: Quyết dã. Dứt khoát. Dứt hết, biên cương, ranh giới, thành phần, thành khoảnh, quyết định, quyết nghị, cổ phần, thôi, khai lề lối. Ích chi cực tắc quyết chi tượng: lợi đã cùng ắt thôi.<br/><br/>
Tượng quẻ là nước đầm đã dâng cao đến tận trời, nghĩa là âm hào đã gần tàn lực còn hống hách đè nén quần dương, nên quần dương phải quyết liệt (quải là quyết liệt) trừ bỏ nó. Vậy quẻ này tượng trưng cho thời kỳ quần hào xúm lại trừ diệt đạo tiểu nhân tuy đã suy tàn nhưng còn ngự trị, quyết liệt chống đối cho tới toàn thắng."
            ),
            3 => array(
                'diem' => 2,
                'status' => 'Cát',
                'name' => "hoathiendaihuu",
                'tengoi' => "Hỏa Thiên ĐẠI HỮU",
                'ynghia' => "Đây là quẻ số 14 trong kinh dịch. Quẻ được kết hợp bởi nội quái là Càn và ngoại quái là Ly.<br/><br/>
<b>Giải Nghĩa</b>: Khoan dã. Cả có. Thong dong, dung dưỡng nhiều, độ lượng rộng, có đức dày, chiếu sáng lớn. Kim ngọc mãn đường chi tượng: vàng bạc đầy nhà.
Tượng hình bằng trên Ly dưới Càn, nghĩa là ánh sáng đã lên cao tột bực, hoặc trong có đức cương kiện của Càn, ngoài có đức văn minh của Ly. Ở đây phe cầm quyền (thượng quái) không có sức mạnh của Càn mà có tài trí của Ly, còn phe quần chúng (hạ quái) thì trái lại có sức mạnh hợp quần đáng kể. <br/><br/>Do đó quẻ Đại Hữu không ở giai đoạn đoàn kết nữa, mà đã tiến đến giai đoạn gặt hái kết quả của sự cấp trên văn minh, sáng sủa, biết điều khiển cấp dưới mạnh mẽ. Kết quả tất nhiên của sự trạng đó là giàu mạnh, đại hữu.Quẻ này là một quẻ: Cát."
            ),
            4 => array(
                'diem' => 2,
                'status' => 'Cát',
                'name' => "loithiendaitrang",
                'tengoi' => "Lôi Thiên ĐẠI TRÁNG",
                'ynghia' => "Đây là quẻ số 34 trong kinh dịch. Quẻ được kết hợp bởi nội quái là Càn và ngoại quái là Chấn.<br/><br/>
<b>Giải Nghĩa</b>: Chí dã. Tự cường. Ý chí riêng, bụng nghĩ, hướng thượng, ý định, vượng sức, thịnh đại, trên cao, chót vót, lên trên, chí khí, có lập trường. Phượng tập đăng sơn chi tượng: tượng phượng đậu trên núi.<br/><br/>
Theo tượng quẻ thì trên Chấn dưới Càn, sấm động trên trời. Hai hào âm đang lui, 4 hào dương đang lên, vậy nên thịnh. Lớn mạnh thì dĩ nhiên là tốt rồi, nhưng thường tình, gặp thời thịnh, người ta kiêu căng, làm điều bất chính, cho nên thoán từ phải dặn: giữ điều chính, lúc đắc ý nghĩ đến lúc thất ý, thì mới có lợi."
            ),
            5 => array(
                'diem' => 0,
                'status' => 'Hung',
                'name' => "phongthientieusuc",
                'tengoi' => "Phong Thiên TIỂU SÚC",
                'ynghia' => "Đây là quẻ số 08 trong kinh dịch. Quẻ được kết hợp bởi nội quái là Càn và ngoại quái là Tốn.<br/><br/>
<b>Giải Nghĩa</b>: Tắc dã. Dị đồng. Lúc bế tắc, không đồng ý nhau, cô quả, súc oán, chứa mọi oán giận, có ý trái lại, không hòa hợp, nhỏ nhen. Cầm sắt bất điệu chi tượng: tiếng đàn không hòa điệu.<br/><br/>
Tượng hình bằng trên Tốn dưới Càn. Tại sao lại gọi là Tiểu Súc? Vì ngoài nghĩa là nuôi dưỡng, súc còn có nghĩa là ngăn cản, súc chỉ. Tốn lại nằm trên Càn, tức là âm ngăn được dương, nhỏ ngăn được lớn. Nhưng vì nó nhỏ mà sức ngăn cản nhỏ, nên chưa phát triển hết được, như đám mây đóng kịt ở phương Tây mà chưa tan, chưa mưa được. Tuy có hanh nhưng chỉ là tạm thời."
            ),
            6 => array(
                'diem' => 2,
                'status' => 'Cát',
                'name' => "thuythiennhu",
                'tengoi' => "Thủy Thiên NHU",
                'ynghia' => "Đây là quẻ số 05 trong kinh dịch. Quẻ được kết hợp bởi nội quái là Càn và ngoại quái là Khảm.<br/><br/>
<b>Giải Nghĩa</b>: Thuận dã. Tương hội. Chờ đợi vì hiểm đằng trước, thuận theo, quây quần, tụ hội, vui hội, cứu xét, chầu về. Quân tử hoan hội chi tượng: quân tử vui vẻ hội họp, ăn uống chờ thời.<br/><br/>
Quẻ Nhu có tới 2 ý nghĩa: một là nuôi dưỡng yến lạc (theo Đại Tượng truyện), hai là chờ đợi (theo Soán truyện). Nhưng hai ý nghĩa đó bổ túc cho nhau chứ không mâu thuẫn nhau: Trước một hiểm họa(Khảm ở ngoại quái), ta không nên vội xông xáo, phải chờ thời cơ thuận tiện để thắng nó, và trong khi chờ đợi phải bồi dưỡng thân thể và tinh thần."
            ),
            7 => array(
                'diem' => 2,
                'status' => 'Cát',
                'name' => "sonthiendaisuc",
                'tengoi' => "Sơn Thiên ĐẠI SÚC",
                'ynghia' => "Đây là quẻ số 26 trong kinh dịch. Quẻ được kết hợp bởi nội quái là Càn và ngoại quái là Cấn.<br/><br/>
<b>Giải Nghĩa</b>: Tụ dã. Tích tụ. Chứa tụ, súc tích, lắng tụ một chỗ, dự trữ, đựng, để dành. Đồng loại hoan hội chi tượng: đồng loại hội họp vui vẻ, cục bộ.<br/><br/>
Trên là núi, dưới là trời, núi mà chứa được trời thì sức chứa của nó thật lớn, cho nên gọi là Đại súc. Nói về bậc quân tử thì phải “chứa” tài đức, nghĩa là tu luyện cho tài đức uẩn súc; trước hết phải cương kiện như quẻ Càn, phải rất thành thực, rực rỡ (có văn vẻ) như quẻ Cấn, mà những đức đó phải mỗi ngày một mới, nhật tân kì đức (Thoán truyện); phải biết cho đến nơi đến chốn, làm cho đến nơi đến chốn, đủ cả tri lẫn hành (đại tượng truyện)."
            ),
            8 => array(
                'diem' => 2,
                'status' => 'Cát',
                'name' => "diathienthai",
                'tengoi' => "Địa Thiên THÁI",
                'ynghia' => "Đây là quẻ số 11 trong kinh dịch. Quẻ được kết hợp bởi nội quái là Càn và ngoại quái là Khôn.<br/><br/>
<b>Giải Nghĩa</b>: Thông dã. Điều hòa. Thông hiểu, am tường, hiểu biết, thông suốt, quen biết, quen thuộc. Thiên địa hòa xướng chi tượng: tượng trời đất giao hòa.<br/><br/>
Tượng quẻ trên Khôn dưới Càn, tức là khí âm trọng trọc hạ xuống và khí dương khinh thanh bay lên, như vậy hai khí âm dương giao hòa, khiến cho vạn vật được hanh thông."
            )
        ),
        2 => array(
            1 => array(
                'diem' => 2,
                'status' => 'Cát',
                'name' => "thientrachly",
                'tengoi' => 'Thiên Trạch LÝ',
                'ynghia' => "Đây là quẻ số 10 trong kinh dịch. Quẻ được kết hợp bởi nội quái là Đoài và ngoại quái là Càn.<br/><br/>
<b>Giải Nghĩa</b>: Lễ dã. Lộ hành. Nghi lễ, có chừng mực, khuôn phép, dẫm lên, không cho đi sai, có ý chặn đường thái quá, hệ thống, pháp lý. Hổ lang đang đạo chi tượng: tượng hổ lang đón đường.<br/><br/>
Quẻ này có Càn là dương cương ở trên, Đoài là âm nhu ở dưới. Đó chính là hợp với lẽ thường của Vũ trụ và nhân loại. Lẽ thường đó là Lễ. Duyệt nhi ứng hồ Càn, thị dĩ Lý hổ vĩ, bất điệt nhân, hanh. Nghĩa là nội Đoài có đức hòa duyệt, vui vẻ mà ứng phó với đức cương của Càn, cũng cảm hóa được, tượng trưng như dẫm phải đuôi cọp mà cọp chẳng cắn người."
            ),
            2 => array(
                'diem' => 2,
                'status' => 'Cát',
                'name' => "thuandoai",
                'tengoi' => 'Thuần ĐOÀI',
                'ynghia' => "Đây là quẻ số 58 trong kinh dịch. Quẻ được kết hợp bởi nội quái là Đoài và ngoại quái là Đoài.<br/><br/>
<b>Giải Nghĩa</b>: Duyệt dã. Hiện đẹp. Đẹp đẽ, ưa thích, vui hiện trên mặt, không buồn chán, cười nói, khuyết mẻ. Hỉ dật mi tu chi tượng: tượng vui hiện trên mặt, khẩu khí.<br/><br/>
Tượng quẻ là hai đầm nước nương tựa nhau, đã mát mẻ còn thêm mát mẻ, gợi ý sự hòa duyệt chung sống với nhau. Quẻ này ý nghĩa cũng gần tương tự như quẻ Tốn, cả hai cùng có mục đích giao hảo với đối thủ. Nhưng hơi khác ở đường lối để đạt tới mục đích. ở Tốn thì chú trọng đến sự khiêm nhường của người trên hoặc người có tài. ở Đoài thì chú trọng đến sự lấy lòng đối thủ bằng mọi phương tiện khác như tiệc tùng, tiền bạc, mỹ sắc, v . v . Quẻ này là một quẻ: Cát."
            ),
            3 => array(
                'diem' => 0,
                'status' => 'Hung',
                'name' => "hoatrachkhue",
                'tengoi' => 'Hỏa Trạch KHUÊ',
                'ynghia' => "Đây là quẻ số 38 trong kinh dịch. Quẻ được kết hợp bởi nội quái là Đoài và ngoại quái là Ly.<br/><br/>
<b>Giải Nghĩa</b>: Quai dã. Hỗ trợ. Trái lìa, lìa xa, hai bên lợi dụng lẫn nhau, cơ biến quai xảo, như cung tên. Hồ giả hổ oai chi tượng: con hồ (cáo) nhờ oai con hổ.<br/><br/>
Theo tượng quẻ Đoài (chằm) ở dưới Ly (lửa). Chằm có tính thấm xuống, lửa có tính bốc lên, trên dưới không thông với nhau mà càng ngày càng cách xa nhau. Quẻ này xấu nhất trong Kinh dịch, ngược hẳn lại với quẻ Cách. Chỉ làm những việc nhỏ cá nhân thì hoạ may được tốt."
            ),
            4 => array(
                'diem' => 0,
                'status' => 'Hung',
                'name' => "loitrachquymuoi",
                'tengoi' => 'Lôi Trạch QUY MUỘI',
                'ynghia' => "Đây là quẻ số 54 trong kinh dịch. Quẻ được kết hợp bởi nội quái là Đoài và ngoại quái là Chấn.<br/><br/>
<b>Giải Nghĩa</b>: Tai dã. Xôn xao. Tai nạn, rối ren, lôi thôi, nữ chinh hung, gái lấy chồng. Ác quỷ vi sủng chi tượng: tượng ma quái làm rối.<br/><br/>
Tượng hình bằng trên Chấn (trưởng nam) dưới Đoài (thiếu nữ), là gái ve vãn trai để được kết hôn, do đó đặt tên quẻ là Qui-Muội. Trai gái phối hợp nhau vốn là cái nghĩa lớn của trời đất, vậy mà thoán từ nói chinh hung vì lẽ: Một là 4 hào ở giữa đều bất chính; Hai là âm Tam cưỡi lên dương Nhị, và âm Ngũ cưỡi lên dương Tứ, có nghĩa là gái áp chế trai, tiểu nhân áp chế quân tử, là hỏng việc. Quẻ này là một quẻ: Hung."
            ),
            5 => array(
                'diem' => 2,
                'status' => 'Cát',
                'name' => "phongtrachtrungphu",
                'tengoi' => 'Phong Trạch TRUNG PHU',
                'ynghia' => "Đây là quẻ số 61 trong kinh dịch. Quẻ được kết hợp bởi nội quái là Đoài và ngoại quái là Tốn.<br/><br/>
<b>Giải Nghĩa</b>: Tín dã. Trung thật. Tín thật, không ngờ vực, có uy tín cho người tin tưởng, tín ngưỡng, ở trong. Nhu tại nội nhi đắc trung chi tượng: tượng âm ở bên trong mà được giữa.<br/><br/>
Tượng hình bằng trên Tốn dưới Đoài. Theo đức quẻ, trên khiêm tốn, dưới vui vẻ, tất sẽ tin yêu lẫn nhau. Theo tượng quẻ, thì có 2 vạch đứt ở giữa biểu hiệu cho lòng trống rỗng, không có tư tà. Quẻ này là một quẻ: Cát."
            ),
            6 => array(
                'diem' => 2,
                'status' => 'Cát',
                'name' => "thuytrachtiet",
                'tengoi' => 'Thủy Trạch TIẾT',
                'ynghia' => "Đây là quẻ số 60 trong kinh dịch. Quẻ được kết hợp bởi nội quái là Đoài và ngoại quái là Khảm.<br/><br/>
<b>Giải Nghĩa</b>: Chỉ dã. Giảm chế. Ngăn ngừa, tiết độ, kiềm chế, giảm bớt, chừng mực, nhiều thì tràn. Trạch thượng hữu thủy chi tượng: trên đầm có nước.<br/><br/>
Tượng hình bằng trên Khảm dưới Đoài, trên đầm có nước, nước ở trong đầm có chừng mực, không khô cạn và cũng không tràn ra ngoài. Còn có nghĩa là ngoại Khảm tức hiểm, nội Đoài tức duyệt, là dùng hòa duyệt tự nhiên mà đi giữa hiểm thì được bình an. Thánh nhân xem tượng quẻ, biết rằng tiết là tốt, hanh, nhưng không nên khổ tiết một cách quá đáng."
            ),
            7 => array(
                'diem' => 0,
                'status' => 'Hung',
                'name' => "sontrachton",
                'tengoi' => 'Sơn Trạch TỐN',
                'ynghia' => "Đây là quẻ số 41 trong kinh dịch. Quẻ được kết hợp bởi nội quái là Đoài và ngoại quái là Cấn.<br/><br/>
<b>Giải Nghĩa</b>: Thất dã. Tổn hại. Hao mất, thua thiệt, bớt kém, bớt phần dưới cho phần trên là tổn hại. Phòng nhân ám toán chi tượng: tượng đề phòng sự ngầm hại, hao tổn.<br/><br/>
Quẻ này nguyên là quẻ Thái, bớt ở nội quái Càn hào dương thứ 3 đưa lên thêm vào hào cuối cùng của quẻ khôn ở trên, nên gọi là Tổn: bớt đi. Lại có thể hiểu: khoét đất ở dưới(quẻ Đoài) đắp lên trên cao cho thành núi, chằm càng sâu, núi càng cao, càng không vững phải đổ, nên gọi là Tổn(thiệt hại)."
            ),
            8 => array(
                'diem' => 2,
                'status' => 'Cát',
                'name' => "diatrachlam",
                'tengoi' => 'Địa Trạch LÂM',
                'ynghia' => "Đây là quẻ số 19 trong kinh dịch. Quẻ được kết hợp bởi nội quái là Đoài và ngoại quái là Khôn.<br/><br/>
<b>Giải Nghĩa</b>: Đại dã. Bao quản. Việc lớn, người lớn, cha nuôi, vú nuôi, giáo học, nhà sư, kẻ cả, dạy dân, nhà thầu. Quân tử dĩ giáo tư chi tượng: người quân tử dạy dân, che chở, bảo bọc cho dân vô bờ bến.<br/><br/>
Tượng hình bằng trên Khôn dưới Đoài. Quẻ Đoài là quẻ Khôn mà Sơ và Nhị đã từ âm biến sang dương, tức là gần đến ngày thịnh lớn. Ngoài ra, trên đầm có đất, tức là đất gần với nước, nội Đoài hòa duyệt tiến gần đến ngoại Khôn nhu thuận."
            )
        ),
        3 => array(
            1 => array(
                'diem' => 2,
                'status' => 'Cát',
                'name' => "thienhoadongnhan",
                'tengoi' => 'Thiên Hỏa ĐỒNG NHÂN',
                'ynghia' => "Đây là quẻ số 13 trong kinh dịch. Quẻ được kết hợp bởi nội quái là Ly và ngoại quái là Càn.<br/><br/>
<b>Giải Nghĩa</b>: Thân dã. Thân thiện. Trên dưới cùng lòng, cùng người ưa thích, cùng một bọn người. Hiệp lực đồng tâm chi tượng: tượng cùng người hiệp lực.<br/><br/>
Tượng hình bằng trên Càn dũng dược, dưới Ly sáng sủa, nghĩa là lửa chiếu sáng tới trời, soi khắp thế giới. Vậy chẳng cứ chốn láng giềng, dù xa lạ đến đâu cũng đồng hết thẩy, nên Hanh."
            ),
            2 => array(
                'diem' => 2,
                'status' => 'Cát',
                'name' => "trachhoacach",
                'tengoi' => 'Trạch Hỏa CÁCH',
                'ynghia' => "Đây là quẻ số 49 trong kinh dịch. Quẻ được kết hợp bởi nội quái là Ly và ngoại quái là Đoài.<br/><br/>
<b>Giải Nghĩa</b>: Cải dã. Cải biến. Bỏ lối cũ, cải cách, hoán cải, cách tuyệt, cánh chim thay lông. Thiên uyên huyền cách chi tượng: tượng vực trời xa thẳm.<br/><br/>
Tượng hình bằng trên Đoài dưới Li, nước và lửa khó dung nhau vì nước làm tắt lửa và lửa làm cạn nước. Vậy nên có mâu thuẫn phải Cách. Nhưng sự cải cách có thể gây ra xáo trộn nên phải làm một cách sáng suốt (nội Ly) mới được dân chúng vui theo (ngoại Đoài)."
            ),
            3 => array(
                'diem' => 1.5,
                'status' => 'Bình',
                'name' => "thuanly",
                'tengoi' => 'Thuần LY',
                'ynghia' => "Đây là quẻ số 30 trong kinh dịch. Quẻ được kết hợp bởi nội quái là Ly và ngoại quái cũng là Ly.<br/><br/>
<b>Giải Nghĩa</b>: Lệ dã. Sáng chói. Sáng sủa, trống trải, trống trơn, tỏa ra, bám vào, phụ bám, phô trương ra ngoài. Môn hộ bất ninh chi tượng: tượng nhà cửa không yên.<br/><br/>
Quẻ này là biến thể của quẻ Bát Thuần Khảm. Thay vì tượng trưng cho tình trạng hung hiểm và đức tính cương quyết giữ vững chính đạo qua cơn thử thách, thì quẻ Li tượng trưng cho tình trạng nương tựa vào nhau để qua hiểm, và đức tính sáng suốt nhận nương tựa vào người khi cần, tuy rằng bản thân mình vẫn phải cố gắng."
            ),
            4 => array(
                'diem' => 2,
                'status' => 'Cát',
                'name' => "loihoaphong",
                'tengoi' => 'Lôi Hỏa PHONG',
                'ynghia' => "Đây là quẻ số 55 trong kinh dịch. Quẻ được kết hợp bởi nội quái là Ly và ngoại quái là Chấn.<br/><br/>
<b>Giải Nghĩa</b>: Thịnh dã. Hòa mỹ. Thịnh đại, được mùa, nhiều người góp sức. Chí đồng đạo hợp chi tượng: tượng cùng đồng tâm hiệp lực. Hình ảnh: Bắn pháo hoa, nét đẹp mỹ thuật hoàn hảo. Con người: Huynh đệ đồng đạo cùng môn phái.<br/><br/>
Tượng hình bằng trên Chấn dưới Li, động và minh. Quân tử xem tượng ấy biết rằng mình muốn cho thịnh trị được lâu bền, phải lấy sức mình mà hành động. Vậy quẻ này ứng vào thời kỳ thịnh trị hoặc cảnh ngộ vinh hoa, nhưng phải nhớ rằng thịnh rồi phải suy, phú quý rồi bần tiện là lẽ thường, nên trong cảnh thịnh trị phú quý nên lo lắng cho nó được bền. Nhưng chớ có lo suông phải giữ gìn như mặt trời đóng ở giữa trời, chiếu khắp thiên hạ. Quẻ này là một quẻ: Cát."
            ),
            5 => array(
                'diem' => 2,
                'status' => 'Cát',
                'name' => "phonghoagianhan",
                'tengoi' => 'Phong Hỏa GIA NHÂN',
                'ynghia' => "Đây là quẻ số 37 trong kinh dịch. Quẻ được kết hợp bởi nội quái là Ly và ngoại quái là Tốn.<br/><br/>
<b>Giải Nghĩa</b>: Đồng dã. Nảy nở. Người nhà, gia đinh, cùng gia đình, đồng chủng, đồng nghiệp, cùng xóm, sinh sôi, khai thác mở mang thêm. Khai hoa kết tử chi tượng: trổ bông sinh trái, nẩy mầm.<br/><br/>
Tượng hình bằng ngoại Tốn nội Li, ở ngoài thuận, ở trong lại công minh, tất đạo tề gia được hoàn tất. Rất tốt. Quân tử xem tượng quẻ, mở rộng ý nghĩa nó ra, là: Muốn trị quốc phải tề gia. Và muốn tề gia thì trước hết phải tu thân, vừa sáng suốt vừa khoan hòa. Trong quẻ này, hai hào đắc trung là Cửu Ngũ và Lục Nhị đều đắc chính, có nghĩa là người nào ở địa vị người ấy, trên ra trên, dưới ra dưới, nên được Cát."
            ),
            6 => array(
                'diem' => 2,
                'status' => 'Cát',
                'name' => "thuyhoakyte",
                'tengoi' => 'Thủy Hỏa KÝ TẾ',
                'ynghia' => "Đây là quẻ số 63 trong kinh dịch. Quẻ được kết hợp bởi nội quái là Ly và ngoại quái là Khảm.<br/><br/>
<b>Giải Nghĩa</b>: Hợp dã. Hiện hợp. Gặp nhau, cùng nhau, đã xong, việc xong, hiện thực, ích lợi nhỏ. Hanh tiểu giả chi tượng: việc nhỏ thì thành.<br/><br/>
Tượng hình bằng trên Khảm dưới Li, nước để trên lửa tức là thủy hỏa tương giao, tất thành công. Thêm nữa, cả 6 hào đều đắc chính, và đều có chính ứng, tượng như một xã hội hoàn toàn trong đó mỗi người ở địa vị đáng với tài đức của mình. Quẻ này là một quẻ: Cát."
            ),
            7 => array(
                'diem' => 2,
                'status' => 'Cát',
                'name' => "sonhoabi",
                'tengoi' => 'Sơn Hỏa BÍ',
                'ynghia' => "Đây là quẻ số 22 trong kinh dịch. Quẻ được kết hợp bởi nội quái là Ly và ngoại quái là Cấn.<br/><br/>
<b>Giải Nghĩa</b>: Sức dã. Quang minh. Trang sức, sửa sang, trang điểm, thấu suốt, rõ ràng. Quang minh thông đạt chi tượng: quang minh, sáng sủa, thấu suốt.<br/><br/>
Trên là núi, dưới là lửa; lửa chiếu sáng mọi vật ở trên núi, như vậy làm cho núi đẹp lên, trang sức cho núi. Vật gì cũng vậy: có chất, tinh thần; mà lại thêm văn, hình thức, thì tốt (hanh thông), nhưng nếu chỉ nhờ ở trang sức mà thành công thì lợi ít thôi."
            ),
            8 => array(
                'diem' => 0,
                'status' => 'Hung',
                'name' => "diahoaminhdi",
                'tengoi' => 'Địa Hỏa MINH DI',
                'ynghia' => "Đây là quẻ số 36 trong kinh dịch. Quẻ được kết hợp bởi nội quái là Ly và ngoại quái là Khôn.<br/><br/>
<b>Giải Nghĩa</b>: Thương dã. Hại đau. Thương tích, bệnh hoạn, buồn lo, đau lòng, ánh sáng bị tổn thương. Kinh cức mãn đồ chi tượng: gai góc đầy đường.<br/><br/>
Tượng hình bằng trên Khôn dưới Li, tức là quẻ Tấn lộn ngược. Ý nghĩa: mặt trời lặn xuống dưới đất, ánh sáng bị che lấp, người hiền có khi phải dấu tài mình để thoát nạn."
            )
        ),
        4 => array(
            1 => array(
                'diem' => 0,
                'status' => 'Hung',
                'name' => "thienloivovong",
                'tengoi' => 'Thiên Lôi VÔ VỌNG',
                'ynghia' => "Đây là quẻ số 25 trong kinh dịch. Quẻ được kết hợp bởi nội quái là Chấn và ngoại quái là Càn.<br/><br/>
<b>Giải Nghĩa</b>: Thiên tai dã. Xâm lấn. Tai vạ, lỗi bậy bạ, không lề lối, không quy củ, càn đại, chống đối, hứng chịu. Cương tự ngoại lai chi tượng: tượng kẻ mạnh từ ngoài đến.<br/><br/>
Nội quái nguyên là quẻ Khôn, mà hào 1, âm biến thành dương, thành quẻ Chấn. Thế là dương ở ngoài tới làm chủ nội quái, mà cũng làm chủ cả quẻ vô vọng, vì ý chính trong Vô vọng là: động, hành động. Động mà cương kiên như ngoại quái Càn, tức là không càn bậy; không càn bậy thì rất hanh thông, hợp với chính đạo thì có lợi. Cái gì không hợp với chính đạo thì có hại, có lỗi, hành động thì không có lợi."
            ),
            2 => array(
                'diem' => 0,
                'status' => 'Hung',
                'name' => "trachloituy",
                'tengoi' => 'Trạch Lôi TÙY',
                'ynghia' => "Đây là quẻ số 17 trong kinh dịch. Quẻ được kết hợp bởi nội quái là Chấn và ngoại quái là Đoài.<br/><br/>
<b>Giải Nghĩa</b>: Thuận dã. Di động. Cùng theo, mặc lòng, không có chí hướng, chỉ chiều theo, đại thể chủ việc di động, thuyên chuyển như chiếc xe. Phản phúc bất định chi tượng: loại không ở cố định bao giờ.<br/><br/>
Tượng hình bằng ngoại Đoài nội Chấn, tức là khi Sấm động thì nước trong đầm cũng động theo. Hào dương quái Chấn ở dưới cùng, nhường cho hào âm quái Đoài ở trên hết như vậy là động mà hòa duyệt, nên gọi là Tùy."
            ),
            3 => array(
                'diem' => 0,
                'status' => 'Hung',
                'name' => "hoaloiphehap",
                'tengoi' => 'Hỏa Lôi PHỆ HẠP',
                'ynghia' => "Đây là quẻ số 21 trong kinh dịch. Quẻ được kết hợp bởi nội quái là Chấn và ngoại quái là Ly.<br/><br/>
<b>Giải Nghĩa</b>: Khiết dã. Cấn hợp. Cẩu hợp, bấu víu, bấu quào, dày xéo, đay nghiến, phỏng vấn, hỏi han (học hỏi). Ủy mị bất chấn chi tượng: tượng yếu đuối không chạy được.<br/><br/>
Nương theo tượng quẻ hình dung một hàm răng (Thượng Cửu và Sơ Cửu), giữa là cái mồm bị vật gì ngáng (Cửu Tứ), cổ nhân cho rằng quẻ này ứng với một tình thế bị một yếu tố ngang trở khiến nó không được thông suốt, phải trừ bỏ cái yếu tố ngăn trở đó đi. Bởi thế nên đặt cho quẻ này cái tên Phệ Hạp, là cắn đứt cái ngang trở đó đi, tức là vấn đề trừng trị, hình phạt."
            ),
            4 => array(
                'diem' => 1.5,
                'status' => 'Bình',
                'name' => "thuanchan",
                'tengoi' => 'Thuần CHẤN',
                'ynghia' => "Đây là quẻ số 51 trong kinh dịch. Quẻ được kết hợp bởi nội quái là Chấn và ngoại quái là Chấn.<br/><br/>
<b>Giải Nghĩa</b>: Động dã. Động dụng. Rung động, sợ hãi do chấn động, phấn phát, nổ vang, phấn khởi, chấn kinh. Trùng trùng chấn kinh chi tượng: khắp cùng dấy động.<br/><br/>
Tượng quẻ là tiếng sấm rền khắp nơi, báo động liên tiếp. Tức là thời kỳ tổng phản công, vì ở cả hạ quái và thượng quái, nhất dương ở dưới sẽ nổi lên chống nhị âm ở trên."
            ),
            5 => array(
                'diem' => 2,
                'status' => 'Cát',
                'name' => "phongloiich",
                'tengoi' => 'Phong Lôi ÍCH',
                'ynghia' => "Đây là quẻ số 42 trong kinh dịch. Quẻ được kết hợp bởi nội quái là Chấn và ngoại quái là Tốn.<br/><br/>
<b>Giải Nghĩa</b>: Ích dã. Tiến ích. Thêm được lợi, giúp dùm, tiếng dội xa, vượt lên, phóng mình tới. Hồng hộc xung tiêu chi tượng: chim hồng, chim hộc bay qua mây mù.<br/><br/>
Tượng hình bằng trên Tốn dưới Chấn, gió và sấm làm lợi cho nhau. Tổn là Càn bớt đi một hào dương được thay thế bằng hào âm. Và Chấn là Khôn thêm một hào dương thay thế cho một hào âm, có nghĩa là bớt người trên thay thế cho người dưới, nên gọi là ích."
            ),
            6 => array(
                'diem' => 0,
                'status' => 'Hung',
                'name' => "thuyloitruan",
                'tengoi' => 'Thủy Lôi TRUÂN',
                'ynghia' => "Đây là quẻ số 03 trong kinh dịch. Quẻ được kết hợp bởi nội quái là Chấn và ngoại quái là Khảm.<br/><br/>
<b>Giải Nghĩa</b>: Nạn dã. Gian lao. Yếu đuối, chưa đủ sức, ngần ngại, do dự, vất vả, phải nhờ sự giúp đỡ. Tiền hung hậu kiết chi tượng: trước dữ sau lành.<br/><br/>
Truân nghĩa là đầy, tức là lúc vạn vật mới sinh ra. Vì lúc đầu vạn vật mới sinh, chưa lấy gì làm hanh thái, nên truân còn có nghĩa là khốn nạn, gian truân. Trong quẻ này, Khảm là mây, thời chỉ mới thấy mây, nghe sấm mà chưa thấy mưa, nên gọi bằng Truân. Áp dụng vào nhân sự, thì là đời truân nạn, người quân tử phải đem tài kinh luân ra giúp đời, tức là bậc quân tử phải hành động (Chấn) để cứu đời qua hiểm (Khảm)."
            ),
            7 => array(
                'diem' => 2,
                'status' => 'Cát',
                'name' => "sonloidi",
                'tengoi' => 'Sơn Lôi DI',
                'ynghia' => "Đây là quẻ số 27 trong kinh dịch. Quẻ được kết hợp bởi nội quái là Chấn và ngoại quái là Cấn.<br/><br/>
<b>Giải Nghĩa</b>: Dưỡng dã. Dung dưỡng. Chăm lo, tu bổ, thêm, ăn uống, bổ dưỡng, bồi dưỡng, ví như trời nuôi muôn vật, thánh nhân nuôi người. Phi long nhập uyên chi tượng: rồng vào vực nghỉ ngơi.<br/><br/>
Theo cái tượng của quẻ, thì dưới núi có tiếng sấm, dương khí bắt đầu phát mà vạn vật trong núi được phát triển như vậy là trời đất nuôi vật. Người quân tử tự nuôi mình thì phải cẩn thận về lời nói để nuôi cái đức, và tiết độ về ăn uống để nuôi thân thể."
            ),
            8 => array(
                'diem' => 1.5,
                'status' => 'Bình',
                'name' => "dialoiphuc",
                'tengoi' => 'Địa Lôi PHỤC',
                'ynghia' => "Đây là quẻ số 24 trong kinh dịch. Quẻ được kết hợp bởi nội quái là Chấn và ngoại quái là Khôn.<br/><br/>
<b>Giải Nghĩa</b>: Phản dã. Tái hồi. Lại có, trở về, bên ngoài, phản phục. Sơn ngoại thanh sơn chi tượng: tượng ngoài núi lại còn có núi nữa.<br/><br/>
Theo tượng quẻ nội quái Chấn là động, ngoại quái Khôn là thuận; hoạt động mà thuận theo đạo trời thì tốt. Cái đạo của trời đó là tĩnh lâu rồi thì động, ác nhiều rồi thì thiện, có vậy vạn vật mới sinh sôi nẩy nở. Xem quẻ Phục này thấy một hào dương bắt đầu trở lại, tức là thấy cái lòng yêu, nuôi dưỡng vạn vật của trời đất."
            )
        ),
        5 => array(
            1 => array(
                'diem' => 1.5,
                'status' => 'Bình',
                'name' => "thienphongcau",
                'tengoi' => 'Thiên Phong CẤU',
                'ynghia' => "Đây là quẻ số 44 trong kinh dịch. Quẻ được kết hợp bởi nội quái là Tốn và ngoại quái là Càn.<br/><br/>
<b>Giải Nghĩa</b>: Ngộ dã. Tương ngộ. Gặp gỡ, cấu kết, liên kết, kết hợp, móc nối, mềm gặp cứng. Phong vân bất trắc chi tượng: gặp gỡ thình lình, ít khi.<br/><br/>
Tượng quẻ là gió thổi dưới trời, gặp đâu đụng nấy, nên đặt tên quẻ là Cấu (gặp bất thình lình). Tại sao lại bất thình lình? vì khi quẻ Quải kết liễu, tưởng là âm khí đã tiêu tan, nhưng lại thấy một hào âm xuất hiện ở dưới, đội 5 hào dương ở trên. Gợi ý thời kỳ đạo quân tử đang thịnh hành nhưng đạo tiểu nhân đã bắt đầu xuất hiện để cám dỗ. Phải cẩn thận coi chừng."
            ),
            2 => array(
                'diem' => 1.5,
                'status' => 'Bình',
                'name' => "trachphongdaiqua",
                'tengoi' => 'Trạch Phong ĐẠI QUẢ',
                'ynghia' => "Đây là quẻ số 28 trong kinh dịch. Quẻ được kết hợp bởi nội quái là Tốn và ngoại quái là Đoài.<br/><br/>
<b>Giải Nghĩa</b>: Họa dã. Cả quá. Cả quá ắt tai họa, quá mực thường, quá nhiều, giàu cương nghị ở trong. Nộn thảo kinh sương chi tượng: tượng cỏ non bị sương tuyết.<br/><br/>
Theo tượng của quẻ, bốn hào dương ở giữa, 2 hào âm hai đầu, như cây cột, khúc giữa lớn quá, ngọn và chân nhỏ quá, chống không nổi, phải cong đi. Tuy vậy, hai hào dương 2 và 5 đều đắc trung, thế là cương mà vẫn trung; lại thêm quẻ Tốn ở dưới có nghĩa là thuận, quẻ Đoài ở trên có nghĩa là hòa, vui, thế là hòa thuận, vui vẻ làm việc, cho nên bảo là tiến đi (hành động) thì được hanh thông."
            ),
            3 => array(
                'diem' => 2,
                'status' => 'Cát',
                'name' => "hoaphongdinh",
                'tengoi' => 'Hỏa Phong ĐỈNH',
                'ynghia' => "Đây là quẻ số 50 trong kinh dịch. Quẻ được kết hợp bởi nội quái là Tốn và ngoại quái là Ly.<br/><br/>
<b>Giải Nghĩa</b>: Định dã. Nung đúc. Đứng được, chậm đứng, trồng, nung nấu, rèn luyện, vững chắc, ước hẹn. Luyện dược thành đơn chi tượng: tượng luyện thuốc thành linh đan, có rèn luyện mới nên người. Kết hợp quẻ này vào cung vợ chồng là tốt, con cái mạnh khoẻ, gia đình yên ấm bền lâu.<br/><br/>
Tượng hình bằng trên Li dưới Tốn, lấy lửa để đốt gỗ, nấu đồ ăn trong nồi. Quẻ Đỉnh ứng vào một tình thế ổn định, công việc Cách đã xong rồi, bây giờ đến lúc kiến thiết, giữ cho đỉnh được vững chắc. Quẻ này là một quẻ: Cát."
            ),
            4 => array(
                'diem' => 2,
                'status' => 'Cát',
                'name' => "loiphonghang",
                'tengoi' => 'Lôi Phong HẰNG',
                'ynghia' => "Đây là quẻ số 32 trong kinh dịch. Quẻ được kết hợp bởi nội quái là Tốn và ngoại quái là Chấn.<br/><br/>
<b>Giải Nghĩa</b>: Cửu dã. Trường cửu. Lâu dài, chậm chạp, đạo lâu bền như vợ chồng, kéo dài câu chuyện, thâm giao, nghĩa cố tri, xưa, cũ.<br/><br/>
Cương (Chấn) ở trên, nhu (Tốn) ở dưới, sấm gió giúp sức nhau, Chấn động trước, Tốn theo sau, thế là thuận đạo. Lại thêm ba hào âm đều ứng với ba hào dương, cũng là nghĩa thuận nữa, cả hai bên đều giữ được đạo chính lâu dài. Lâu dài thì hanh thông, không có lỗi; giữ được chính đạo thì có lợi, tiến hành việc gì cũng thành công."
            ),
            5 => array(
                'diem' => 1.5,
                'status' => 'Bình',
                'name' => "thuanton",
                'tengoi' => 'Thuần TỐN',
                'ynghia' => "Đây là quẻ số 57 trong kinh dịch. Quẻ được kết hợp bởi nội quái là Tốn và ngoại quái là Tốn.<br/><br/>
<b>Giải Nghĩa</b>: Thuận dã. Thuận nhập. Theo lên theo xuống, theo tới theo lui, có sự giấu diếm ở trong. Âm dương thăng giáng chi tượng: khí âm dương lên xuống giao hợp.<br/><br/>
Tượng hình bằng hai quái đều là Tốn, mỗi quái gồm 2 dương hào ở trên âm hào, nghĩa là âm phải thuận theo dương, do đó chỉ được tiểu hanh mà thôi. Cùng nghĩa đó, 2 tốn là 2 luồng gió tiếp nhau, tượng cho trên thuận đạo và dưới thuận tùng (tiểu nhân lợi kiến đại nhân) Tốn vốn là thuận, nhưng cũng phải dương cương như Nhị, Ngũ, thuận bằng đạo trung chính thì chímới phát triển được. Quẻ này là một quẻ: Bình."
            ),
            6 => array(
                'diem' => 1.5,
                'status' => 'Bình',
                'name' => "thuyphongtinh",
                'tengoi' => 'Thủy Phong TĨNH',
                'ynghia' => "Đây là quẻ số 48 trong kinh dịch. Quẻ được kết hợp bởi nội quái là Tốn và ngoại quái là Khảm.<br/><br/>
<b>Giải Nghĩa</b>: Tịnh dã. Trầm lặng. Ở chỗ nào cứ ở yên chỗ đó, xuống sâu, vực thẳm có nước, dưới sâu, cái giếng. Càn Khôn sát phối chi tượng: Trời Đất phối hợp lại.<br/><br/>
Tượng hình bằng trên Khảm dưới Tốn, giống hình cái giếng: Sơ là mạch nước chẩy lên, Nhị Tam là thành giếng giữ nước, Tứ là lòng trống để múc nước, Ngũ là miếng gỗ đậy miệng giếng, và Thượng là miệng giếng. Giếng tượng trưng cho cái nuôi dân làng mãi mãi, mặc dầu tình thế đổi thay."
            ),
            7 => array(
                'diem' => 0,
                'status' => 'Hung',
                'name' => "sonphongco",
                'tengoi' => 'Sơn Phong CỔ',
                'ynghia' => "Đây là quẻ số 18 trong kinh dịch. Quẻ được kết hợp bởi nội quái là Tốn và ngoại quái là Cấn.<br/><br/>
<b>Giải Nghĩa</b>: Sự dã. Sự biến. Có sự không yên trong lòng, làm ngờ vực, khua, đánh, mua chuốc lấy cái hại, đánh trống, làm cho sợ sệt, sửa lại cái lỗi trước đã làm. Âm hại tương liên chi tượng: điều hại cùng có liên hệ.<br/><br/>
Quẻ này trên là núi, dưới là gió, gió đụng núi, quật lại, đó là tượng loạn, không yên, tất phải có công việc. Cũng có thể giảng như sau: tốn ở dưới là thuận, mà Cấn ở trên là ngưng; người dưới thì thuận mà người trên cứ ngồi im; hoặc người dưới một mực nhu, người trên một mực cương (Tốn thuộc âm, mà hào 1 cùng là âm, còn Cấn thuộc dương, mà hào cuối cùng thuộc dương ), đè nén người dưới, như vậy mọi sự sẽ đổ nát, phải làm lại."
            ),
            8 => array(
                'diem' => 2,
                'status' => 'Cát',
                'name' => "diaphongthang",
                'tengoi' => 'Địa Phong THĂNG',
                'ynghia' => "Đây là quẻ số 46 trong kinh dịch. Quẻ được kết hợp bởi nội quái là Tốn và ngoại quái là Khôn.<br/><br/>
<b>Giải Nghĩa</b>: Tiến dã. Tiến thủ. Thăng tiến, trực chỉ, tiến mau, bay lên, vọt tới trước, bay lên không trung, thăng chức, thăng hà. Phù giao trực thượng chi tượng: chà đạp để ngoi lên trên.<br/><br/>
Tượng hình bằng trên Khôn (hành Thổ) dưới Tốn (hành Mộc), nghĩa là cây mọc ở trong đất, lớn lên dần dần. Còn có nghĩa là nội quái có đức khiêm, ngoại quái có đức thuận, người khác thuận cho mình tiến lên, Cát. Quẻ này là một quẻ: Cát."
            )
        ),
        6 => array(
            1 => array(
                'diem' => 0,
                'status' => 'Hung',
                'name' => "thienthuytung",
                'tengoi' => 'Thiên Thủy TỤNG',
                'ynghia' => "Đây là quẻ số 06 trong kinh dịch. Quẻ được kết hợp bởi nội quái là Khảm và ngoại quái là Càn.<br/><br/>
<b>Giải Nghĩa</b>: Luận dã. Bất hòa. Bàn cãi, kiện tụng, bàn tính, cãi vã, tranh luận, bàn luận. Đại tiểu bất hòa chi tượng: tượng lớn nhỏ không hòa.<br/><br/>
Theo tượng quẻ này có thể giảng: người trên (quẻ Càn) là dương cương, áp chế người dưới, mà người dưới (quẻ Khảm) thì âm hiểm, tất sinh ra kiện cáo, hoặc cho cả trùng quái chỉ là một người, trong lòng thì nham hiểm (nội quái là Khảm), mà ngoài thì cương cường (ngoại quái là Càn), tất sinh sự gây ra kiện cáo. Vì vậy làm việc gì cũng nên cẩn thận từ lúc đầu để tránh kiện cáo."
            ),
            2 => array(
                'diem' => 0,
                'status' => 'Hung',
                'name' => "trachthuykhon",
                'tengoi' => 'Trạch Thủy KHỐN',
                'ynghia' => "Đây là quẻ số 47 trong kinh dịch. Quẻ được kết hợp bởi nội quái là Khảm và ngoại quái là Đoài.<br/><br/>
<b>Giải Nghĩa</b>: Nguy dã. Nguy lo. Cùng quẫn, bị người làm ác, lo lắng, cùng khổ, mệt mỏi, nguy cấp, lo hiểm nạn. Thủ kỷ đãi thời chi tượng: tượng giữ mình đợi thời.<br/><br/>
Tượng hình bằng trên Đoài dưới Khảm, nước ở trạch chảy xuống sông, phải cạn đi nên khốn. Hơn nữa, trong quẻ này các hào dương đều bị các hào âm vây hãm, nên khốn."
            ),
            3 => array(
                'diem' => 0,
                'status' => 'Hung',
                'name' => "hoathuyvite",
                'tengoi' => 'Hỏa Thủy VỊ TẾ',
                'ynghia' => "Đây là quẻ số 64 trong kinh dịch. Quẻ được kết hợp bởi nội quái là Khảm và ngoại quái là Ly.<br/><br/>
<b>Giải Nghĩa</b>: Thất dã. Thất cách. Thất bát, mất, thất bại, dở dang, chưa xong, nửa chừng. Ưu trung vọng hỷ chi tượng: tượng trong cái lo có cái mừng.<br/><br/>
Tượng hình bằng trên Ly dưới Khảm, trái ngược với quẻ Ký-Tế. Ở đây lửa đặt trên nước, thủy hỏa bất giao, việc không thành. Thêm nữa, cả 6 hào đều bất chính, hoặc dương hào cư âm vị, hoặc âm hào cư dương vị. Tuy nhiên, cương nhu vẫn ứng chính, có thể làm được công việc Tế. Tuy hiện tại là Vị-Tế, nhưng tương lai có thể hanh."
            ),
            4 => array(
                'diem' => 2,
                'status' => 'Cát',
                'name' => "loithuygiai",
                'tengoi' => 'Lôi Thủy GIẢI',
                'ynghia' => "Đây là quẻ số 40 trong kinh dịch. Quẻ được kết hợp bởi nội quái là Khảm và ngoại quái là Chấn.<br/><br/>
<b>Giải Nghĩa</b>: Tán dã. Nơi nơi. Làm cho tan đi, như làm tan sự nguy hiểm, giải phóng, giải tán, loan truyền, tuyên truyền, phân phát, lưu thông, ban rải, ân xá. Lôi vũ tác giải chi tượng: tượng sấm động mưa bay.<br/><br/>
Tượng quẻ là âm dương giao hòa với nhau, sấm (Chấn) động và mưa (Khảm) đổ, bao nhiêu khí u uất tan hết, cho nên gọi là Giải. Cũng có thể giảng: Hiểm (Khảm) sinh ra nạn, nhờ động (Chấn) mà thoát nạn nên gọi là Giải."
            ),
            5 => array(
                'diem' => 0,
                'status' => 'Hung',
                'name' => "phongthuyhoan",
                'tengoi' => 'Phong Thủy HOÁN',
                'ynghia' => "Đây là quẻ số 59 trong kinh dịch. Quẻ được kết hợp bởi nội quái là Khảm và ngoại quái là Tốn.<br/><br/>
<b>Giải Nghĩa</b>: Tán dã. Ly tán. Lan ra tràn lan, tán thất, trốn đi xa, lánh xa, thất nhân tâm, hao bớt. Thủy ngộ phong tắc hoán tán chi tượng: tượng nước gặp gió thì phải tan, phải chạy.<br/><br/>
Tượng hình bằng trên Tốn dưới Khảm, gió thổi trên mặt nước khiến cho nước bắn tứ tung. Quẻ Hoán có 3 hào dương và 3 hào âm, không nhất thiết cương mà cũng không nhất thiết nhu. Nhưng tất phải cương ở trong và nhu ở ngoài, nghĩa là quân tử chủ sự ở trong, tiểu nhân phụng lệnh ở ngoài, thì làm việc Hoán (thay đổi) mới tốt. Quẻ này là một quẻ: Hung."
            ),
            6 => array(
                'diem' => 1.5,
                'status' => 'Bình',
                'name' => "thuankham",
                'tengoi' => 'Thuần KHẢM',
                'ynghia' => "Đây là quẻ số 29 trong kinh dịch. Quẻ được kết hợp bởi nội quái là Khảm và ngoại quái cũng là Khảm.<br/><br/>
<b>Giải Nghĩa</b>: Hãm dã. Hãm hiểm. Hãm vào ở trong, xuyên sâu vào trong, đóng cửa lại, gập ghềnh, trắc trở, bắt buộc, kìm hãm, thắng. Khổ tận cam lai chi tượng: tượng hết khổ mới đến sướng.<br/><br/>
Hai lớp khảm (hai lớp hiểm), có đức tin, chỉ trong lòng là hanh thông, tiến đi (hành động) thì được trọng mà có công. Xét theo ý nghĩa thì hào dương ở giữa, dương là thực, thành tín, vì vậy bảo là Khảm có đức tin, chí thành ở trong lòng, nhờ vậy mà hanh thông. Gặp thời hiểm, có lòng chí thành thì không bị tai nạn, hành động thì được trọng mà còn có công nữa."
            ),
            7 => array(
                'diem' => 0,
                'status' => 'Hung',
                'name' => "sonthuymong",
                'tengoi' => 'Sơn Thủy MÔNG',
                'ynghia' => "Đây là quẻ số 04 trong kinh dịch. Quẻ được kết hợp bởi nội quái là Khảm và ngoại quái là Cấn.<br/><br/>
<b>Giải Nghĩa</b>: Muội dã. Bất minh. Tối tăm, mờ ám, không minh bạch, che lấp, bao trùm, phủ chụp, ngu dại, ngờ nghệch. Thiên võng tứ trương chi tượng: tượng lưới trời giăng bốn mặt.<br/><br/>
Tượng quẻ là trước mặt có núi chặn, sau lưng có sông ngăn, hoặc một mặt bị lực lượng bảo thủ lôi kéo và một mặt bị lực lượng cấp tiến thúc đẩy, phân vân khó nghĩ, mù mờ do đó cần có sự giáo dục."
            ),
            8 => array(
                'diem' => 2,
                'status' => 'Cát',
                'name' => "diathuysu",
                'tengoi' => 'Địa Thủy SƯ',
                'ynghia' => "Đây là quẻ số 07 trong kinh dịch. Quẻ được kết hợp bởi nội quái là Khảm và ngoại quái là Khôn.<br/><br/>
<b>Giải Nghĩa</b>: Chúng dã. Chúng trợ. Đông chúng, vừa làm thầy, vừa làm bạn, học hỏi lẫn nhau, nắm tay nhau qua truông, nâng đỡ. Sĩ chúng ủng tòng chi tượng: tượng quần chúng ủng hộ nhau.<br/><br/>
Tượng quẻ là đất trên nước dưới, ở giữa đất có nước nhóm, tức là quần chúng. Lại có tượng nội quái là Khảm hiểm, ngoại quái Khôn là thuận, giữa đường hiểm mà đi bằng cách thuận, gợi ý đem quân đi đánh giặc. Trong quẻ, hào Cửu Nhị sai khiến được 5 âm. Cửu Nhị xử được đạo trung, ứng với Lục Ngũ, tượng như Chính phủ tín nhiệm một ông Tướng. Được vậy thì dù đi giữa đường hiểm mà cứ thản thuận được."
            )
        ),
        7 => array(
            1 => array(
                'diem' => 2,
                'status' => 'Cát',
                'name' => "thientrachdon",
                'tengoi' => 'Thiên Sơn ĐỘN',
                'ynghia' => "Đây là quẻ số 33 trong kinh dịch. Quẻ được kết hợp bởi nội quái là Cấn và ngoại quái là Càn.<br/><br/>
<b>Giải Nghĩa</b>: Thoái dã. Ẩn trá. Lui, ẩn khuất, tránh đời, lừa dối, trá hình, có ý trốn tránh, trốn cái mặt thấy cái lưng. Báo ẩn nam sơn chi tượng: tượng con báo ẩn ở núi nam.<br/><br/>
Quẻ này có 2 hào âm ở dưới xông lên, 4 hào dương ở trên đang phải lui tránh, tức là ở thời tiểu nhân đang bành trướng, quân tử phải tránh nó. Độn ở đây nhẹ mục đích tránh nguy hiểm, mà nặng về chủ trương xa lánh tiểu nhân để duy trì đạo quân tử. Nếu nghiên cứu biến thể của quẻ Độn là quẻ Địa Trạch Lâm số 19, ta sẽ thấy rằng Độn có thể đưa tới sự thành công to lớn. Vậy Độn không hẳn là điềm xấu, mà chỉ là một phương pháp tự cứu."
            ),
            2 => array(
                'diem' => 2,
                'status' => 'Cát',
                'name' => "trachsonham",
                'tengoi' => 'Trạch Sơn HÀM',
                'ynghia' => "Đây là quẻ số 31 trong kinh dịch. Quẻ được kết hợp bởi nội quái là Cấn và ngoại quái là Đoài.<br/><br/>
<b>Giải Nghĩa</b>: Cảm dã. Thụ cảm. Cảm xúc, thọ nhận, cảm ứng, nghĩ đến, nghe thấy, xúc động. Nam nữ giao cảm chi tượng: tượng nam nữ có tình ý, tình yêu.<br/><br/>
Tượng quẻ là cái hồ trên đỉnh núi, hồ trang điểm cho cảnh núi thêm xinh, và núi nâng cao giá trị của cảnh hồ thêm hùng vĩ. Cũng ví như cặp trai tài gái sắc, tài cao của kẻ sĩ xây được nhà vàng để chứa người ngọc, và sắc đẹp của giai nhân tô điểm nhà vàng thành bồng lai tiên cảnh. Vậy quẻ Hàm có nghĩa là sự cảm ứng giữa nam nữ, giữa sức đẹp hào hùng và vẻ đẹp quyến rũ, giữa ý chí sắt đá và tình cảm thắm thiết."
            ),
            3 => array(
                'diem' => 0,
                'status' => 'Hung',
                'name' => "hoasonlu",
                'tengoi' => 'Hỏa Sơn LỮ',
                'ynghia' => "Đây là quẻ số 56 trong kinh dịch. Quẻ được kết hợp bởi nội quái là Cấn và ngoại quái là Ly.<br/><br/>
<b>Giải Nghĩa</b>: Khách dã. Thứ yếu. Đỗ nhờ, khách, ở đậu, tạm trú, kê vào, gá vào, ký ngụ bên ngoài, tính cách lang thang, ít người thân, không chính. Ỷ nhân tác giá chi tượng: nhờ người mai mối.<br/><br/>
Tượng hình bằng trên Li dưới Cấn. Núi thì ở một chổ, còn lửa thì không nhất định ở chổ nào, có thể lan tới đồng bằng. Lửa còn ở núi thì mới được sáng chiếu ra xa, hễ đi nơi khác thì bị lu tối. Vậy quẻ Lữ ứng vào nghịch cảnh phải bỏ quê hương ra đi, chịu tự hạ thì mắc nhục, mà làm cao thì vướng lấy họa. Cho nên ở thời Lữ nên sáng suốt, nhập gia tùy tục. Quẻ này là một quẻ: Hung."
            ),
            4 => array(
                'diem' => 0,
                'status' => 'Hung',
                'name' => "loisontieuqua",
                'tengoi' => 'Lôi Sơn TIỂU QUÁ',
                'ynghia' => "Đây là quẻ số 62 trong kinh dịch. Quẻ được kết hợp bởi nội quái là Cấn và ngoại quái là Chấn.<br/><br/>
<b>Giải Nghĩa</b>: Quá dã. Bất túc. Thiểu lý, thiểu não, hèn mọn, nhỏ nhặt, bẩn thỉu, thiếu cường lực. Thượng hạ truân chuyên chi tượng: trên dưới gian nan, vất vả, buồn thảm.<br/><br/>
Vì tượng hình bằng trên Chấn dưới Cấn, là tiếng sấm bị nghẹt với núi, không lan rộng được. thêm nữa, trong quẻ này hai hào đắc trung là Nhị, Ngũ, đều âm nhu, còn hai hào dương là Tam, Tứ, đều thất vị, nghĩa là thời có thể làm được việc nhỏ mà không làm được việc lớn. Quẻ này là một quẻ: Hung."
            ),
            5 => array(
                'diem' => 2,
                'status' => 'Cát',
                'name' => "phongsontiem",
                'tengoi' => 'Phong Sơn TIỆM',
                'ynghia' => "Đây là quẻ số 53 trong kinh dịch. Quẻ được kết hợp bởi nội quái là Cấn và ngoại quái là Tốn.<br/><br/>
<b>Giải Nghĩa</b>: Tiến dã. Tuần tự. Từ từ, thong thả đến, lần lần, bò tới, chậm chạp, nhai nhỏ nuốt vào. Phúc lộc đồng lâm chi tượng: phúc lộc cùng đến.<br/><br/>
Theo tượng quẻ, trên Tốn dưới Cấn là trên núi có cây lớn lên dần dần. Theo thể quẻ bốn hào ở giữa (Nhị, Tam, Tứ, Ngũ) đều đắc chính, tiến lên mà được chính vị như thế là có thể yên được nước. Theo đức quẻ, ngoại quái Tốn (khiêm cung), nội quái Cấn (an tịnh), như vậy an tịnh tiến mà không táo cấp."
            ),
            6 => array(
                'diem' => 0,
                'status' => 'Hung',
                'name' => "thuysonkien",
                'tengoi' => 'Thủy Sơn KIỂN',
                'ynghia' => "Đây là quẻ số 39 trong kinh dịch. Quẻ được kết hợp bởi nội quái là Cấn và ngoại quái là Khảm.<br/><br/>
<b>Giải Nghĩa</b>: Nạn dã. Trở ngại. Cản ngăn, chặn lại, chậm chạp, què, khó khăn. Bất năng tiến giả chi tượng: không năng đi.<br/><br/>
Tượng hình bằng trên Khảm dưới Cấn, trước mặt bị sông ngăn, sau lưng bị núi chặn. Còn một nghĩa nữa là dù gặp cảnh ngộ nguy hiểm (Khảm), cứ bền lòng không nao núng (Cấn), sẽ được Cát. Quẻ này ứng vào thời kỳ đầy nguy hiểm, vấn đề tiến lui vô cùng quan trọng."
            ),
            7 => array(
                'diem' => 1.5,
                'status' => 'Bình',
                'name' => "thuancan",
                'tengoi' => 'Thuần CẤN',
                'ynghia' => "Đây là quẻ số 52 trong kinh dịch. Quẻ được kết hợp bởi nội quái là Cấn và ngoại quái là Cấn.<br/><br/>
<b>Giải Nghĩa</b>: Chỉ dã. Ngưng nghỉ. Ngăn giữ, ở, thôi, dừng lại, đậy lại, gói ghém, ngăn cấm, vừa đúng chỗ. Thủ cựu đợi thời chi tượng: giữ mức cũ đợi thời.<br/><br/>
Tượng quẻ là núi im lìm, tức là dừng, không tiến lên nữa. Nhưng dừng không phải là buông bỏ hoạt động một cách thụ động vì áp lực, mà là dừng chủ động vì đó là con đường hợp lý. Khi nên hành thì hành, khi nên chỉ thì chỉ, đó là ý nghĩa của quẻ Cấn. Quẻ này biểu lộ triết lý biết tự kiềm chế, thuận theo thời vận, không xuẩn động khi thời thế không cho phép. Quẻ này là một quẻ: Bình."
            ),
            8 => array(
                'diem' => 1.5,
                'status' => 'Bình',
                'name' => "diasonkhiem",
                'tengoi' => 'Địa Sơn KHIÊM',
                'ynghia' => "Đây là quẻ số 15 trong kinh dịch. Quẻ được kết hợp bởi nội quái là Cấn và ngoại quái là Khôn.<br/><br/>
<b>Giải Nghĩa</b>: Thoái dã. Cáo thoái. Khiêm tốn, nhún nhường, khiêm từ, cáo thoái, từ giã, lui vào trong, giữ gìn, nhốt vào trong, đóng cửa. Vì vậy mới được hanh thông. Thượng hạ mông lung chi tượng: tượng trên dưới hoang mang.<br/><br/>
Tượng hình bằng trên Khôn dưới Cấn, nghĩa là núi cao mà chịu lún ở dưới đất là cái tượng nhún nhường, khiêm hạ. Vì vậy mà được hanh thông."
            )
        ),
        8 => array(
            1 => array(
                'diem' => 0,
                'status' => 'Hung',
                'name' => "thiendiabi",
                'tengoi' => 'Thiên Địa BĨ',
                'ynghia' => "Đây là quẻ số 12 trong kinh dịch. Quẻ được kết hợp bởi nội quái là Khôn và ngoại quái là Càn.<br/><br/>
<b>Giải Nghĩa</b>: Tắc dã. Gián cách. Bế tắc, không thông, không tương cảm nhau, xui xẻo, dèm pha, chê bai lẫn nhau, mạnh ai nấy theo ý riêng. Thượng hạ tiếm loạn chi tượng: trên dưới lôi thôi.
<br/><br/>
Việc đời không cái gì lâu bền mãi mãi, nên sau quẻ Thái hanh thông, tiếp đến quẻ Bĩ là ngưng trệ. Tượng hình ngược lại quẻ Thái, trên Càn dưới Khôn, khí dương ở trên đi lên, khí âm ở dưới đi xuống, không giao hòa với nhau, vạn vật ngưng trệ, bế tắc."
            ),
            2 => array(
                'diem' => 1.5,
                'status' => 'Bình',
                'name' => "trachdiatuy",
                'tengoi' => 'Trạch Địa TỤY',
                'ynghia' => "Đây là quẻ số 45 trong kinh dịch. Quẻ được kết hợp bởi nội quái là Khôn và ngoại quái là Đoài.<br/><br/>
<b>Giải Nghĩa</b>: Tụ dã. Trưng tập. Nhóm họp, biểu tình, dồn đống, quần tụ nhau lại, kéo đến, kéo thành bầy. Long vân tế hội chi tượng: tượng rồng mây giao hội.<br/><br/>
Tượng hình bằng trên Đoài dưới Khôn, nước tụ ở trên mặt đất. Quẻ này ứng vào nhóm họp đồng chí, phải lấy lòng thành thực (hoà duyệt và thuận thụ) thì mới xong. Và tụ nhóm người đông thường sinh ra việc tranh nhau, nghi kỵ nhau, do đó phải đề phòng. Quẻ này là một quẻ: Bình."
            ),
            3 => array(
                'diem' => 2,
                'status' => 'Cát',
                'name' => "hoadiatan",
                'tengoi' => 'Hỏa Địa TẤN',
                'ynghia' => "Đây là quẻ số 35 trong kinh dịch. Quẻ được kết hợp bởi nội quái là Khôn và ngoại quái là Ly.<br/><br/>
<b>Giải Nghĩa</b>: Tiến dã. Hiển hiện. Đi hoặc tới, tiến tới gần, theo mực thường, lửa đã hiện trên đất, trưng bày. Long kiến trình tường chi tượng: tượng rồng hiện điềm lành.<br/><br/>
Quẻ này có tượng mặt trời (Ly) lên khỏi mặt đất (Khôn), càng lên cao càng sáng, tiến mạnh. Lại có thể hiểu là người dưới có đức thuận (Khôn) dựa vào bậc trên có đức rất sáng suốt (Ly); cho nên ví với một vị hầu có tài trị dân được vua tín nhiệm, thưởng ngựa nhiều lần, nội một ngày mà được vua tiếp tới ba lần."
            ),
            4 => array(
                'diem' => 2,
                'status' => 'Cát',
                'name' => "loidiadu",
                'tengoi' => 'Lôi Địa DỰ',
                'ynghia' => "Đây là quẻ số 16 trong kinh dịch. Quẻ được kết hợp bởi nội quái là Khôn và ngoại quái là Chấn.<br/><br/>
<b>Giải Nghĩa</b>: Duyệt dã. Thuận động. Dự bị, dự phòng, canh chừng, sớm, vui vầy. Thượng hạ duyệt dịch chi tượng: tượng trên dưới vui vẻ.<br/><br/>
Quẻ này Chấn có tính động ở trên, Khôn có tính thuận ở dưới. Hành động mà hoà thuận, bởi vậy vui vẻ, nên đặt tên quẻ là Dự. Hoặc còn có nghĩa là sấm nổ ở trên đất, khí dương phát động thì muôn vật nở sinh."
            ),
            5 => array(
                'diem' => 1.5,
                'status' => 'Bình',
                'name' => "phongdiaquan",
                'tengoi' => 'Phong Địa QUÁN',
                'ynghia' => "Đây là quẻ số 20 trong kinh dịch. Quẻ được kết hợp bởi nội quái là Khôn và ngoại quái là Tốn.<br/><br/>
<b>Giải Nghĩa</b>: Quan dã. Quan sát. Xem xét, trông coi, cảnh tượng xem thấy, thanh tra, lướt qua, sơ qua, sơn phết, quét nhà. Vân bình tụ tán chi tượng: tượng bèo mây tan hợp.<br/><br/>
Theo tượng quẻ, Tốn ở trên, Khôn ở dưới là gió thổi trên đất, tượng trưng cho sự cổ động khắp mọi loài, hoặc xem xét (quan) khắp mọi loài. Lại thêm: hai hào dương ở trên, bốn hào âm ở dưới, là dương biểu thị (quán) cho âm; âm trông (quan) vào dương mà theo."
            ),
            6 => array(
                'diem' => 2,
                'status' => 'Cát',
                'name' => "thuydiaty",
                'tengoi' => 'Thủy Địa TỶ',
                'ynghia' => "Đây là quẻ số 08 trong kinh dịch. Quẻ được kết hợp bởi nội quái là Khôn và ngoại quái là Khảm.<br/><br/>
<b>Giải Nghĩa</b>: Tư dã. Chọn lọc. Thân liền, gạn lọc, mật thiết, tư hữu riêng, trưởng đoàn, trưởng toán, chọn lựa. Khứ xàm nhiệm hiền chi tượng: bỏ nịnh dụng trung.<br/><br/>
Tượng quẻ là trên Khảm dưới Khôn, nước trên đất nên dễ thấm, gợi ý sự nước thấm nhuần các hạt đất thành một khối: thống nhất. Hơn nữa, Ngũ ở trên mà bao nhiêu người dưới đều thuận theo, vì Cửu Ngũ có đức dương cương mà lại đắc trung, nên được Cát."
            ),
            7 => array(
                'diem' => 0,
                'status' => 'Hung',
                'name' => "sondiabac",
                'tengoi' => 'Sơn Địa BÁC',
                'ynghia' => "Đây là quẻ số 23 trong kinh dịch. Quẻ được kết hợp bởi nội quái là Khôn và ngoại quái là Cấn.<br/><br/>
<b>Giải Nghĩa</b>: Lạc dã. Tiêu điều. Đẽo gọt, lột cướp đi, không có lợi, rụng rớt, đến rồi lại đi, tản lạc, lạt lẽo nhau, xa lìa nhau, hoang vắng, buồn thảm. Lục thân băng thán chi tượng: tượng bà con thân thích xa lìa nhau.<br/><br/>
Theo tượng quẻ, năm hào âm chiếm chỗ của dương, âm tới lúc cực thịnh, dương chỉ còn có một hào, sắp đến lúc tiêu hết. Ở thời tiểu nhân đắc chí hoành hành, quân tử (hào dương ở trên cùng) chỉ nên chờ thời, không nên hành động. Chờ thời vì theo luật tự nhiên, âm thịnh cực rồi sẽ suy, mà dương suy cực rồi sẽ thịnh."
            ),
            8 => array(
                'diem' => 2,
                'status' => 'Cát',
                'name' => "thuankhon",
                'tengoi' => 'Thuần KHÔN',
                'ynghia' => "Đây là quẻ số 02 trong kinh dịch. Quẻ được kết hợp bởi nội quái là Khôn và ngoại quái cũng là Khôn.<br/><br/>
<b>Giải Nghĩa</b>: Quẻ Khôn có sức sáng tạo lớn lao (nguyên), thông suốt và thuận tiện (hanh), lợi ích thích đáng (lợi), ngay thẳng và có đức chính và bền(trinh) của con ngựa cái. Nguyên, hanh, lợi, tẫn mã chi trinh, nghĩa là thuần âm cực thuận như đức Khôn, vẫn đủ nguyên khí được vạn vật là Nguyên, và cũng có công dụng khiến cho vạn vật phát đạt là Hanh. Nhưng vì bản chất Khôn là âm, thuận, nên chỉ theo đức kiện hành của Càn mà tiến hành, như ngựa cái thừa thuận với ngựa đực.<br/><br/>
Địa thế Khôn, quân tử dĩ hậu đức tải vật, nghĩa là quẻ Khôn này, 6 hào đều âm, tầng lớp chồng chất, tượng như đất dầy mà lại thuận, nên chở được muôn vật. Quân tử nên học lấy sức rộng lớn sâu dầy của Khôn mà dung chở loài người."
            )
        )
    );
}
