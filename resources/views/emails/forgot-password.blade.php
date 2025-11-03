<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Mật khẩu của bạn</title>
</head>
<body>
    <div class="wrap-email">
        <div class="container">
            <div class="row">
                <div class="col-sm-12">
                    <h1>Quý khách vui lòng không cấp mật khẩu cho bất kỳ ai!</h1>
                    <ul>
                        <li>Tên đăng nhập: {{ $user->username }}</li>
                        <li>Mật khẩu: {{ $newPassword }}</li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</body>
</html>
