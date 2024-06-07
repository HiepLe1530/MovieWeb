@extends('admin.main')
@section('content')
    
    <div class="container ">
        @if(session('success'))
            <div id="alert" class="alert alert-info text-center">
                {{session('success')}}
            </div>
        @endif
        @if(session('error'))
            <div id="alert" class="alert alert-danger text-center">
                {{session('error')}}
            </div>
        @endif
        
        <div class="pt-4 d-flex justify-content-between ">
            <h4 class="title">Quản lý người dùng</h4>
            {{-- <a href="{{ route('admin.role.add') }}" class="btn btn-info btnThem"><i class="fa-solid fa-plus"></i> Thêm người dùng</a> --}}
        </div>
        @livewire('search-user-admin')
    </div>
        
        
    
@endsection

@section('script')
    <script type="text/javascript">
        // let currentRole;

        // document.addEventListener("DOMContentLoaded", function() {
        //     // Lưu giá trị ban đầu của select
        //     currentRole = document.getElementById("mySelect").value;
        // });
        function updateRole(that, userId){
            var url = '{{ route("admin.user.updateRole") }}'
            var NewRoleId = $(that).val();
            var userId = $(that).data('user_id');
            var currentRoleId = $(that).data('role_id');
            Swal.fire({
                title: 'Bạn chắc chắn muốn cập nhật quyền của người dùng.',
                icon: 'warning',
                customClass: {
                    title: 'title-sweetalert', // Thêm class CSS cho tiêu đề
                },
                showCancelButton: true,
                confirmButtonText: 'Cập nhật',
                cancelButtonText: 'Hủy',
                
            }).then((result) => {
                if (result.isConfirmed) {
                    // Xử lý khi nhấn nút cập nhật
                    $.ajax({
                        url: url,
                        type: 'POST',
                        data: {
                            _token: '{{ csrf_token() }}', // Thêm token CSRF
                            userId: userId,
                            roleId: NewRoleId
                        },
                        success: function(res) {
                            // Xử lý phản hồi từ server
                            if(res.success){
                                Swal.fire({
                                    position: "center",
                                    icon: "success",
                                    title: res.success,
                                    showConfirmButton: false,
                                    timer: 1500
                                });
                                setTimeout(function() {
                                    location.reload();
                                }, 1500); 
                            }
                            // else{
                            //     Swal.fire({
                            //         position: "center",
                            //         icon: "error",
                            //         title: res.error,
                            //         showConfirmButton: false,
                            //         timer: 1500
                            //     });
                            // }
                        },
                        error: function(xhr, status, error) {
                            // Xử lý lỗi
                        }
                    });
                } else if (result.dismiss === SweetAlert.DismissReason.cancel) {
                    // Xử lý khi nhấn nút hủy
                    $('#role_'+userId).val(currentRoleId);
                }
            });
        }
    </script>
@endsection