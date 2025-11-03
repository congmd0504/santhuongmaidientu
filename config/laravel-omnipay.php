<?php

return [
    // Cấu hình cho các cổng thanh toán tại hệ thống của bạn, các cổng không xài có thể xóa cho gọn hoặc không điền.
    // Các thông số trên có được khi bạn đăng ký tích hợp.

    'gateways' => [
        'MoMoAIO' => [
            'driver' => 'MoMo_AllInOne',
            'options' => [
                'accessKey' => "klm05TvNBzhg7h7j",
                'secretKey' => "at67qH6mk8w5Y1nAyMoYKMWACiEi2bsa",
                'partnerCode' => "MOMOBKUN20180529",
                'testMode' => true,
                'link' => "https://test-payment.momo.vn/gw_payment/transactionProcessor",
            ],
        ],
    ],
];
