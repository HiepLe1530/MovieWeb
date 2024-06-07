<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Role;
use App\Http\Requests\Admin\RoleRequest;

class RoleController extends Controller
{
    protected $role;

    public function __construct(){

        $this->role = new Role();
    }

    public function index(){
        $index = 1;
        $roles = $this->role->getall();
        $norecord = 'Hiện tại chưa có loại quyền nào được quản lý!';
        return view('admin.role.role', compact('index', 'roles', 'norecord'));
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
       
        if($this->role->deleteRole($id)){
            return response()->json([
                'error'=>'false',
                'message'=>'Xóa quyền thành công'
            ]);
        }
        return response()->json([
            'error'=>'true',
            'message'=>'Xóa quyền KHÔNG thành công'

        ]);
            
        
    }
}
