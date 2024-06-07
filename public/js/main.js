
$.ajaxSetup({
    headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    }
});
function deleteMovie(name, url){
    if(confirm('Bạn chắc chăn muốn xóa bộ phim ' + name + '?')){
        $.ajax({
            type:'DELETE',
            datatype:JSON,
            url: url,
        })
        .then(data=>{
            if(data.error == 'false'){

                location.reload();
                alert(data.message);
            }
            else {
                alert(data.message);
            }
        })
    }
}

function deleteEpisode(name, url){
    if(confirm('Bạn chắc chắn muốn xóa tập phim ' + name + '?')){
        $.ajax({
            type:'DELETE',
            datatype:JSON,
            url: url,
        })
        .then(data=>{
            if(data.error == 'false'){
                location.reload();
                alert(data.message);
                
            }
            else {
                alert(data.message);
            }
        })
    }
}

function Delete(name, url){
    if(confirm(name)){
        $.ajax({
            type:'DELETE',
            datatype:JSON,
            url: url,
        })
        .then(data=>{
            if(data.error == 'false'){
                location.reload();
                alert(data.message);
                
            }
            else {
                alert(data.message);
            }
        })
    }
}
// Tự động đóng thông báo sau 3 giây
setTimeout(function() {
    var alert = document.getElementById('alert');
    if (alert) {
        alert.style.display = 'none';
    }
}, 3000); // 3000 milliseconds = 3 seconds


function displayAvatarName() {
    // var input = document.getElementById('avatar-upload');
    // var filename = input.files[0];
    // var span = document.getElementById('avatar-upload-name');
    
    // if (filename) {
    //     span.textContent = filename.name;
    //     span.style.display = 'block';
    // } else {
    //     span.style.display = 'none';
    // }
        var input = document.getElementById('avatar-upload');
        var file = input.files[0];
        var admin_avatarchange_img = document.getElementById('admin_avatarchange-img');
        if (file) {
            var reader = new FileReader();
            reader.onload = function(e) {
                admin_avatarchange_img.src = e.target.result;
            }
            reader.readAsDataURL(file);
            admin_avatarchange_img.style.display = 'block';
        } else{
            admin_avatarchange_img.style.display = 'none';
        }
    
}
