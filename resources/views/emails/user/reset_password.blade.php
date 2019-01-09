<b>Chào {{$name}}!</b>
<br/>
Dưới đây là link reset mật khẩu của bạn!<br/><br/>
<a href="{{config('app.url').'/password/reset/'.$token.'?email='.$email}}"
   style="background: #00B393; color: white; text-decoration: none; padding: 15px 10px;">Reset mật khẩu</a>
<br/><br/>
Vui lòng thực hiện đổi mật khẩu trong vòng 24h.<br/>
Nếu có bất kỳ thắc mắc nào, vui lòng liên hệ ban quản trị.<br/>

Xin chân thành cảm ơn!<br/>
@include('emails.signature')