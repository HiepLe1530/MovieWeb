
<!doctype html>
<html>
<head>
<title>Đăng nhập hh3D.tv</title>
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
<link href="/user/bootstrap-5.3.3-dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
</head>
<body>
<h1 class="w3ls">Đăng nhập</h1>
<div class="content-w3ls">
	<div class="content-agile1">
		<h2 class="agileits1"><a href="{{ route('home.hh3d') }}" style="text-decoration: none; color:white">hh3D.tv</a></h2>
	</div>
	<div class="content-agile2 d-flex flex-column " >
        @if(session('success'))
            <div id="alert" class="alert alert-info text-center">
                {{session('success')}}
            </div>
        @endif
        @if(session('error'))
            <div id="alert" class="alert alert-danger  text-center">
                {{session('error')}}
            </div>
        @endif
		<form action="" method="POST">
			<div class="w3layouts">	
				<input type="email" id="email" name="u_Email" placeholder="mail@example.com" title="Vui lòng nhập email hợp lệ" required="" value="{{ old('u_Email') }}">
                
			</div>

			<div class="w3layouts">	
				<input type="password" class="lock" name="u_PassWord" placeholder="Mật khẩu" id="password1" required="">
			</div>
            <div class="ms-3 form-check form-switch ">	
				<input class=" form-check-input " id="checkbox_admin" type="checkbox" name="checkbox_admin">
                <label for="checkbox_admin" class="text-light ms-2">ADMIN</label>
			</div>		
            
			<input type="submit" class="register" value="Đăng nhập">

            <p class="text-light p-3">Bạn chưa có tài khoản? <a href="{{ route('register') }}"><span>Đăng ký ngay</span></a></p>
            @csrf
		</form>
		
		
	</div>
	<div class="clear"></div>
</div>
<p class="copyright w3l">Copyright &copy; 2024 hh3D.tv</p>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
<script>
    // Tự động đóng thông báo sau 3 giây
    setTimeout(function() {
        var alert = document.getElementById('alert');
        if (alert) {
            alert.style.display = 'none';
        }
    }, 3000); // 3000 milliseconds = 3 seconds
</script>
</body>
</html>