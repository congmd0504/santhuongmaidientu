<?php
return [
    'listTypePointMH'=> [2, 3, 4, 5, 6, 9, 10, 12, 15, 16, 17, 18, 19, 20, 26,29,31], //Ví KTG
    'listTypePointRut'=> [4, 5, 6, 7, 8, 11, 13],
    'listTypePointDiemThuong'=> [1,4, 5, 6, 7, 8, 11, 13, 14, 21, 22, 23, 24, 25,27,28,30], //Nạp tiền, rút tiền và đổi sang KTG sẽ cộng trừ vào ví này
     'listTypePointDaMua'=> [1,4, 5, 6, 8, 11, 13, 14, 21, 22, 23, 24, 25,27,28,30], 
    'tonghoahongnhanduoc' => [4, 5, 6, 11, 13, 14, 21],
    'listTypePointDiemDaRut'=> [7, 8, 11],

    'listTypePointDiemDaMuaHang' => [22, 23, 24, 25], //Trừ tiền khi mua sản phẩm và hoàn tiền khi mua sản phẩm không thành công

    'listTypePointDiemMuaKhongTichLuy' => [22, 23], //Tính tiền ví vnđ khi mua sản phẩm không tích lũy

    'listTypePointDiemMuaHangTichLuy' => [24, 25], //Tính tiền ví vnđ khi mua sản phẩm tích lũy

    'typePoint' => [
        // start
        1 => [
            'type' => 1,
            'name' => 'Thành viên mua hàng (VNĐ)',
        ],
        2 => [
            'type' => 2,
            'name' => 'KTG thưởng KYC',
        ],
        3 => [
            'type' => 3,
            'name' => 'KTG thưởng khi nạp',
        ],
        4 => [
            'type' => 4,
            'name' => 'Điểm thưởng trực tiếp',
        ],
        5 => [
            'type' => 5,
            'name' => 'Doanh số nhóm thưởng theo tháng',
        ],
        6 => [
            'type' => 6,
            'name' => 'Doanh số nhóm thưởng theo năm',
        ],
        7 =>  [
            'type' => 7,
            'name' => 'Rút điểm',
        ],
        8 =>  [
            'type' => 8,
            'name' => 'Hoàn điểm',
        ],
        9 =>  [
            'type' => 9,
            'name' => 'KTG Đã sử dụng để mua hàng',
        ],
        10 =>  [
            'type' => 10,
            'name' => 'KTG được đổi từ điểm',
        ],
        11 =>  [
            'type' => 11,
            'name' => 'Điểm đã đổi sang KTG',
        ],
        12 =>  [
            'type' => 12,
            'name' => 'KTG được nhận từ admin',
        ],
        13 =>  [
            'type' => 13,
            'name' => 'Điểm được nhận từ admin',
        ],
        14 =>  [
            'type' => 14,
            'name' => 'Nạp tiền',
        ],
        15 =>  [
            'type' => 15,
            'name' => 'Trừ KTG user',
        ],
        16 =>  [
            'type' => 16,
            'name' => 'Cộng KTG user',
        ],
        17 =>  [
            'type' => 17,
            'name' => 'Thưởng KTG tái tiêu dùng',
        ],
        18 =>  [
            'type' => 18,
            'name' => 'Thưởng KTG doanh số nhóm tháng',
        ],
        19 =>  [
            'type' => 19,
            'name' => 'Thưởng KTG doanh số nhóm năm',
        ],
        20 =>  [
            'type' => 20,
            'name' => 'Thưởng KTG level',
        ],
        21 =>  [
            'type' => 21,
            'name' => 'Thưởng từ cấp dưới của sản phẩm không tích lũy',
        ],
        22 =>  [
            'type' => 22,
            'name' => 'Trừ điểm khi mua sản phẩm không tích lũy',
        ],
        23 =>  [
            'type' => 23,
            'name' => 'Hoàn lại điểm mua sản phẩm không tích lũy không thành công',
        ],
        24 =>  [
            'type' => 24,
            'name' => 'Trừ điểm khi mua sản phẩm',
        ],
        25 =>  [
            'type' => 25,
            'name' => 'Hoàn lại điểm mua sản phẩm không thành công',
        ],
        26 =>  [
            'type' => 26,
            'name' => 'Hoàn lại KTG mua sản phẩm không thành công',
        ],
        27 =>  [
            'type' => 27,
            'name' => 'Thưởng khi thành viên mua sản phẩm (VNĐ)',
        ],
        28 =>  [
            'type' => 28,
            'name' => 'Giải ngân ví đặt cọc hàng tháng (VNĐ)',
        ],
        29 =>  [
            'type' => 29,
            'name' => 'Tặng thêm ở gói khởi nghiệp (KTG)',
        ],
        30 =>  [
            'type' => 30,
            'name' => 'Mua gói khởi nghiệp (VNĐ)',
        ],
        31 =>  [
            'type' => 31,
            'name' => 'Thưởng mua sản phẩm (KTG)',
        ],


        'defaultPoint' => 100,
        'pointReward' => 1000, //1KTG = 1000
        'minMoney' => 10000, // số tiền tối thiểu trong tài khoản
        'minMoneyRut' => 200000, // số tiền tối thiểu rút

    ],
    'rose' => [
        1 => [
            'row' => 1,
            'percent' => 10,
        ],
        2 => [
            'row' => 2,
            'percent' => 5,
        ],
        3 => [
            'row' => 3,
            'percent' => 3,
        ],
        4 => [
            'row' => 4,
            'percent' => 2,
        ],
        5 => [
            'row' => 5,
            'percent' => 1,
        ],
        6 => [
            'row' => 6,
            'percent' => 1,
        ],
        7 => [
            'row' => 7,
            'percent' => 1,
        ],
        8 => [
            'row' => 8,
            'percent' => 0.5,
        ],
        9 => [
            'row' => 9,
            'percent' => 0.5,
        ],
        10 => [
            'row' => 11,
            'percent' => 0.5,
        ],
        11 => [
            'row' => 11,
            'percent' => 0.5,
        ],
        12 => [
            'row' => 12,
            'percent' => 0.5,
        ],
        13 => [
            'row' => 13,
            'percent' => 0.5,
        ],
        14 => [
            'row' => 14,
            'percent' => 0.5,
        ],
        15 => [
            'row' => 15,
            'percent' => 0.5,
        ],
        16 => [
            'row' => 16,
            'percent' => 0.3,
        ],
        17 => [
            'row' => 17,
            'percent' => 0.3,
        ],
        18 => [
            'row' => 18,
            'percent' => 0.3,
        ],
        19 => [
            'row' => 19,
            'percent' => 0.3,
        ],
        20 => [
            'row' => 20,
            'percent' => 0.3,
        ],
    ],

    // trạng thái pay
    'typePay' => [
        1 => [
            'type' => 1,
            'name' => 'Đang chờ xử lý',
        ],
        2 => [
            'type' => 2,
            'name' => 'Đã rút thành công',
        ],
        3 =>  [
            'type' => 3,
            'name' => 'Rút không thành công. Đã hoàn điểm lại',
        ],
    ],
    'typeStore' => [
        1 => [
            'type' => 1,
            'name' => 'Nhập kho',
        ],
        2 => [
            'type' => 2,
            'name' => 'Đã đặt hàng đang chờ xuất kho',
        ],
        3 =>  [
            'type' => 3,
            'name' => 'Xuất kho',
        ],
    ],
    'level' => [
        0 => "Khách hàng mới",
        1 => "Người tiêu dùng thông minh", // Khách hàng thân thiết
        2 => "Khởi nghiệp", // Hạng đồng
        3 => "Quản lý", // Hạng bạc
        // 4 => "Trưởng phòng KD", // Hạng vàng
        4 => "Giám đốc vùng", // Hạng kim cương
    ],
    // thời gian mở cổng rút điểm
    'datePay' => [
        'start' => 1,
        'end' => 31
    ],
    // số điểm bắn mắc định
    'transferPointDefault' => 1,
    // đơn vị của điểm
    'pointUnit' => 'KTG',
    'pointToMoney' => 1000,
    'namePointDefault' => "Phạm Văn Hưng",

];
