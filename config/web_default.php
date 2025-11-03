<?php
    return [
        'frontend'=>[
            'noImage'=>'/frontend/images/noimage.jpg',
            'userNoImage'=>'/frontend/images/usernoimage.png',
            'logo'=>'/frontend/images/logo.jpg',
            'favicon'=>'/frontend/images/favicon.ico',
        ],
        'backend'=>[
            'noImage'=>'/admin_asset/images/noimage.png',
            'userNoImage'=>'/admin_asset/images/usernoimage.png',

        ],
		   'statusTransaction'=>[
            1 => [
                'status' => 1,
                'name' => 'Chưa sử lý',
            ],
            2 => [
                'status' => 2,
                'name' => 'Nhận đơn',
            ],
            3 => [
                'status' => 3,
                'name' => 'Đang vận chuyển',
            ],
            4 => [
                'status' => 4,
                'name' => 'Hoàn thành',
            ],
            -1 => [
                'status' => -1,
                'name' => 'Hủy bỏ',
            ],
        ],
        'nameAdminDefault'=>"admintk",

    ];
?>
