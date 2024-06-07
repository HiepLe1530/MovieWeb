
<!doctype html>
<html>
<head>
<title>Đăng ký tài khoản hh3D.tv</title>
<meta name="viewport" content="width=device-width, initial-scale=1">
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<!-- <meta name="keywords" content="Official Signup Form Responsive, Login form web template,Flat Pricing tables,Flat Drop downs  Sign up Web Templates, Flat Web Templates, Login signup Responsive web template, Smartphone Compatible web template, free webdesigns for Nokia, Samsung, LG, SonyEricsson, Motorola web design" /> -->
<script type="application/x-javascript"> 
    addEventListener("load", function() { 
        setTimeout(hideURLbar, 0); 
    }, false); 
    function hideURLbar(){ 
        window.scrollTo(0,1); 
    } 
</script>
<!-- fonts -->
<link href="//fonts.googleapis.com/css?family=Raleway:100,200,300,400,500,600,700,800,900" rel="stylesheet">
<link href="//fonts.googleapis.com/css?family=Monoton" rel="stylesheet">
<!-- /fonts -->
<!-- css -->
<link href="/css/font-awesome.min.css" rel="stylesheet" type="text/css" media="all" />
<link href="/css/login_register.css" rel='stylesheet' type='text/css' media="all" />
<!-- /css -->
</head>
<body>
<h1 class="w3ls">Đăng ký</h1>
<div class="content-w3ls">
	<div class="content-agile1">
		<h2 class="agileits1">hh3D.tv</h2>
	</div>
	<div class="content-agile2" >
		<form action="" method="POST">
			<div class="form-control w3layouts"> 
				<input type="text" id="firstname" name="u_UserName" placeholder="Tên người dùng" title="Vui lòng nhập tên người dùng" required="" value="{{ old('u_UserName') }}">
			</div>

			<div class="form-control w3layouts">	
				<input type="email" id="email" name="u_Email" placeholder="mail@example.com" title="Vui lòng nhập email hợp lệ" required="" value="{{ old('u_Email') }}">
                @error('u_Email')
                <span style="color: red">{{$message}}</span>
                @enderror
			</div>

			<div class="form-control agileinfo">	
				<input type="password" class="lock" name="u_PassWord" placeholder="Mật khẩu" id="password1" required="">
			</div>	

			<div class="form-control agileinfo">	
				<input type="password" class="lock" name="confirm-password" placeholder="Xác thực mật khẩu" id="password2" required="">
			</div>			
			
			<input type="submit" class="register" value="Đăng ký">
			<p style="color: lightcyan">Quay lại trang đăng nhập! <a href="{{ route('login') }}"><span>Bấm vào đây</span></a></p>
            @csrf
		</form>
		
		
	</div>
	<div class="clear"></div>
</div>
<p class="copyright w3l">Copyright &copy; 2024 hh3D.tv</p>

<script type="text/javascript">
	window.onload = function () {
		document.getElementById("password1").onchange = validatePassword;
		document.getElementById("password2").onchange = validatePassword;
	}
	function validatePassword(){
		var pass2=document.getElementById("password2").value;
		var pass1=document.getElementById("password1").value;
		if(pass1!=pass2)
			document.getElementById("password2").setCustomValidity("Mật khẩu không khớp");
		else
			document.getElementById("password2").setCustomValidity('');	 
			//empty string means no validation error
	}
</script>
</body>
</html>