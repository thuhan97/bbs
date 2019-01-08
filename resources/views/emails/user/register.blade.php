<?php
$activateUrl = url("/activate/$user->email");
?>

Chào <strong>{{$user->name}}</strong>! <br/>
<br/>
Chúc mừng bạn đã đăng ký thành công tài khoản {{$user->email}} tại <a
        href="{{config('app.url')}}">{{config('app.name')}}.</a><br/>

Mã kích hoạt tài khoản của bạn là:<br/>
<br/>
<strong style="font-size: 22px; background: green; color: white;    padding: 10px;">
    {{$user->activate_code}}
</strong>
<br/><br/>
Trong vòng 24h từ khi nhận được email thông báo, vui lòng đi đến liên kết sau để kích hoạt tài khoản:<br/>
<a href="{{$activateUrl}}">{{$activateUrl}}</a>

@include('emails.signature')