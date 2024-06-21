<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Send User Info</title>
    </head>
    <body>
        <p>Xin chào {{ $name }}</p>
        <p>Anh/chị đã đăng ký thành công tài khoản trên hệ thống, chúng tôi gửi cho bạn thông tin đăng nhập hệ thống: </p>
        <p>Email: <strong>{{ $email }}</strong></p>
        <p>Password: <strong>{{ $password }}</strong></p>
        {{-- <p>Địa chỉ: {{$address}} {{$district}} {{$city}}</p> --}}
        <p>Vui lòng đăng nhập hệ thống.</p>
        <p>Trân trọng</p>
        <p><strong>Training Team</strong></p>
    </body>
</html>
