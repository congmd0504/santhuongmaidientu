<?php

return [
    // Cấu hình cho các cổng thanh toán tại hệ thống của bạn, các cổng không xài có thể xóa cho gọn hoặc không điền.
    // Các thông số trên có được khi bạn đăng ký tích hợp.

    'RECEIVER' => "Dailylife Htc",
    'NGANLUONG_URL' => "https://www.nganluong.vn/checkout.php",
    'MERCHANT_ID' => "67240",
    'MERCHANT_PASS' => 'de6db1d898f73c1509f4c52d90c9a806',

    // 'CHECKSUM_KEY'=> 'Iy1JUroIqK41lfeP16H0Oisz1m5QMI',
    // 'TOKEN_KEY' => 'CGXAaqZMxKpyHKUnsCm19z8M6SuMLz',
    // 'ENCRYPT_KEY' => 'MIGfMA0GCSqGSIb3DQEBAQUAA4GNADCBiQKBgQCR1nf6/BR6v7F6YNJ+fuk7Drv0/Rt0YjBEVCg/7bYNzvtVGj7ATIY9q0AAGNtAoBzV/Ra9ufAYW0/bhxCzZl9cw57DmtlLpLb/53be5F7v11sQwUfyGJyNA9Ko0P6ZhZ7woDy8R2grEIuSdbGHrrU5BTZ8ccO/bZ9p65H5BqxGiQIDAQAB',
    // 'URL_API' => 'https://alepay-v3.nganluong.vn/api/v3/checkout',


    // live
    "apiKey" => "CGXAaqZMxKpyHKUnsCm19z8M6SuMLz", //Là key dùng để xác định tài khoản nào đang được sử dụng.
    "encryptKey" => "MIGfMA0GCSqGSIb3DQEBAQUAA4GNADCBiQKBgQCR1nf6/BR6v7F6YNJ+fuk7Drv0/Rt0YjBEVCg/7bYNzvtVGj7ATIY9q0AAGNtAoBzV/Ra9ufAYW0/bhxCzZl9cw57DmtlLpLb/53be5F7v11sQwUfyGJyNA9Ko0P6ZhZ7woDy8R2grEIuSdbGHrrU5BTZ8ccO/bZ9p65H5BqxGiQIDAQAB", //Là key dùng để mã hóa dữ liệu truyền tới Alepay.
    "checksumKey" => "Iy1JUroIqK41lfeP16H0Oisz1m5QMI", //Là key dùng để tạo checksum data.
    "env" => "live",
    "baseUrl" => "https://alepay-v3.nganluong.vn/api/v3/checkout/"

    // sanbox
    // "apiKey" => "3EoXvEj2V9CBogCGL2bKiTiOKRwJfy", //Là key dùng để xác định tài khoản nào đang được sử dụng.
    // "encryptKey" => "MIGfMA0GCSqGSIb3DQEBAQUAA4GNADCBiQKBgQCOdopgwn9wc6FhEPi5dz86b/ASzxmfTvDLIKxHxPRi//M/1fQAQTFS2g46Sexy4UJiKz4aBZhzTeHbWhZHXP2/+4KhADHcRPRJpH17mbQTfjVEDtIWaeZslZM3UAuPePY/hsUlS5lfh0VDfFqi+BHS44ejApH3J/WIvaeyjTYMVwIDAQAB", //Là key dùng để mã hóa dữ liệu truyền tới Alepay.
    // "checksumKey" => "m09WWMxNq3m8sMGOVBsYIldwRn7HNN", //Là key dùng để tạo checksum data.
    // "env" => "test",
    // "baseUrl" => "https://alepay-v3-sandbox.nganluong.vn/api/v3/checkout/"
];
