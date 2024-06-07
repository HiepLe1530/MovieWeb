<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Role;
use Illuminate\Support\Facades\Hash;
use Auth;


class UserController extends Controller
{
    protected $user;
    protected $role;

    public function __construct(){

        $this->user = new User();
        $this->role = new Role();
    }

    public function index(){
        return view('admin.user.user');
    }

    public function add(Request $req){
        if(session('r_id')){
            $req->session()->forget('r_id');
        }
        return view('admin.role.addrole');
    }

    public function insert(RoleRequest $req){
        
        $roles = [
            'r_Name'=>$req->r_Name,
            'r_Description'=>$req->r_Description
        ];
        if($this->role->insertRole($roles)){
            return redirect(route('admin.role.role'))->with('success','Thêm quyền thành công');
        }
        else{
            return redirect()->back()->with('error','Thêm quyền không thành công');
        }
        
    }

    public function edit(Request $req, $id){
        $req->session()->put('r_id', $id);
        if(!empty($id)){
            $roleById = $this->role->getRoleById($id);
            if(!empty($roleById)){
                return view('admin.role.editrole', compact('roleById'));
            }
            return redirect()->back()->with('error','Quyền không tồn tại');
        }
        else{
            return redirect()->back()->with('error','Liên kết không tồn tại');
        }
        
    }

    public function update(RoleRequest $req){
        $r_id = $req->session()->pull('r_id');
        $roles = [
            'r_Name'=>$req->r_Name,
            'r_Description'=>$req->r_Description
        ];
        
        if($this->role->updateRole($roles, $r_id)){
            return redirect(route('admin.role.role'))->with('success','Chỉnh sửa quyền thành công');
        }
        else{
            return redirect()->back()->with('error','Nếu không thay đổi gì vui lòng bấm quay lại.');
        }
    }

    public function delete($id){
       
        if($this->user->deleteUser($id)){
            return response()->json([
                'error'=>'false',
                'message'=>'Xóa người dùng thành công'
            ]);
        }
        return response()->json([
            'error'=>'true',
            'message'=>'Xóa người dùng KHÔNG thành công'

        ]);
            
        
    }

    public function profile(){
        return view('admin.profile');
    }

    public function edit_yourself(Request $req){
        $req->validate([
            'u_UserName'=>'required'
        ], [
            'u_UserName.required'=>'Tên người dùng không được để trống'
        ]);
        $userEdit = [
            'u_UserName'=>$req->u_UserName
        ];
        if($req->has('u_Avatar')){
            $file = $req->u_Avatar;
            $name = $file->getClientOriginalName();
            $file->move(public_path('images'), $name);
            $userEdit['u_Avatar'] = $name;   
        }
        if($this->user->editYourSelf($userEdit, Auth::id())){
            return redirect()->back()->with('success','Thay đổi thông tin thành công');
        }
        else{
            return redirect()->back()->with('error','Nếu không thay đổi gì vui lòng bấm quay lại.');
        }
    }

    public function edit_password(Request $req){
        if(Hash::check($req->current_password, Auth::user()->password)){
            if($req->current_password == $req->new_password){
                return redirect()->back()->with('duplicate_password','Mật khẩu mới bị trùng với mật khẩu hiện tại');
            }
            $userEditPassword['password'] = bcrypt($req->new_password);
            if($this->user->editYourSelf($userEditPassword, Auth::id())){
                return redirect()->back()->with('change_password_success','Thay đổi mật khẩu thành công');
            }
            
        }
        return redirect()->back()->with('wrong_password','Mật khẩu hiện tại không chính xác.');
    }

    public function updateRole(Request $req){
        if($this->user->updateRole($req->userId, $req->roleId)){
            return response()->json(['success' => 'Cập nhật thành công']);
        }
    }
}
