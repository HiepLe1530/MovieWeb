@extends('admin.main')
@section('content')
    <div class="container">
        <div class="row mb-5">
            <div class="col-md-6 mt-5">
                <div class="card h-100 ">
                    <div class="card-header">
                        <h3 class="text-center">Thông tin cá nhân</h3>
                    </div>
                    <div class="card-body profile-card-body">
                        
                        <form action="{{ route('admin.profile.edit_yourself') }}" method="POST" enctype="multipart/form-data">
                            @csrf
                            @method('PUT')
                            @if (session('success'))
                                <div id="alert" class="alert alert-danger text-center">
                                    {{session('success')}}
                                </div>
                            @endif
                            @if (session('error'))
                                <div id="alert" class="alert alert-danger text-center">
                                    {{session('error')}}
                                </div>
                            @endif
                            <div class="text-center mb-2 position-relative">
                                <img id="admin_avatar" src="/images/{{ Auth::user()->u_Avatar }}" alt="Avatar" class="rounded-circle img-thumbnail " style="width: 150px;">
                                <div class="position-absolute icon_edit_image translate-middle">
                                    <label for="avatar-upload" class="btn btn-outline-warning">
                                        <i class="fa-regular fa-pen-to-square"></i> 
                                    </label>
                                    <input type="file" id="avatar-upload" name="u_Avatar" style="display: none" accept="image/*" onchange="displayAvatarName()">
                                </div>
                                
                            </div>
                            <div id="admin_avatarchange" class="d-flex justify-content-center mb-2">
                                <img id="admin_avatarchange-img" src="#" alt="Avatar" class="img-thumbnail" style="width: 150px; display: none;">
                            </div>

                            <div class="form-group">
                                <label for="username">Tên người dùng:</label>
                                <input type="text" class="form-control" id="username" name="u_UserName" value="{{ Auth::user()->u_UserName }}">
                                @error('u_UserName')
                                    <span style="color: red">{{$message}}</span>
                                @enderror
                            </div>
                            
                            <div class="form-group">
                                <label for="email">Email:</label>
                                <input type="email" class="form-control" id="email" value="{{ Auth::user()->u_Email }}" readonly>
                            </div>

                            <div class="d-flex justify-content-center">
                                <button type="submit" class="btn btn-primary mb-2">Lưu thay đổi</button>
                            </div>
                        </form> 
                        
                        
                    </div>
                </div>
            </div>
            <div class="col-md-6 mt-5">
                <div class="card h-100 ">
                    <div class="card-header">
                        <h3 class="text-center">Thay đổi mật khẩu</h3>
                    </div>
                    <div class="card-body profile-card-body">
                        <form action="{{ route('admin.profile.edit_password') }}" method="POST">
                            @if (session('change_password_success'))
                                <div id="alert" class="alert alert-danger text-center">
                                    {{session('change_password_success')}}
                                </div>
                            @endif
                            
                            <div class="form-group">
                                <label for="password">Mật khẩu hiện tại:</label>
                                <input type="password" name="current_password" class="form-control" id="current_password" required="">
                                @if (session('wrong_password'))
                                    <span style="color: red">{{session('wrong_password')}}</span>
                                @endif
                            </div>
    
                            <div class="form-group">
                                <label for="password">Mật khẩu mới:</label>
                                <input type="password" name="new_password" class="form-control" id="new_password" required="">
                                @if (session('duplicate_password'))
                                    <span style="color: red">{{session('duplicate_password')}}</span>
                                @endif
                            </div>
                            
                            <div class="form-group">
                                <label for="confirm-password">Xác nhận mật khẩu:</label>
                                <input type="password" class="form-control" id="confirm_new_password" required="">
                            </div>
                            <div class="text-center">
                                <button type="submit" class="btn btn-primary">Lưu thay đổi</button>
                            </div>
                            @csrf
                            @method('PUT')
                        </form>
                        
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('script')
    <script>
        window.onload = function () {
		document.getElementById("new_password").onchange = validatePassword;
		document.getElementById("confirm_new_password").onchange = validatePassword;
        }
        function validatePassword(){
            var confirm_new_password = document.getElementById("confirm_new_password").value;
            var new_password = document.getElementById("new_password").value;
            if(new_password != confirm_new_password)
                document.getElementById("confirm_new_password").setCustomValidity("Mật khẩu không khớp");
            else
                document.getElementById("confirm_new_password").setCustomValidity('');	 
                //empty string means no validation error
        }
    </script>
@endsection
