<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Auth;

class AuthController extends Controller
{
    protected $user;
    public function __construct(){

        $this->user = new User();
    }

    public function register(){
        return view('register');
    }
    public function handleRegister(Request $req){
        $req->validate([
            'u_Email'=>'unique:users'
        ], [
            'u_Email.unique'=>'Email đã tồn tại trên hệ thống'
        ]);
        $user = [
            'u_r_id'=>2,
            'u_UserName'=>$req->u_UserName,
            'u_Email'=>$req->u_Email,
            'password'=>bcrypt($req->u_PassWord)
        ];
        if($this->user->insertUser($user)){
            return redirect(route('login'))->with('success', 'Đăng ký tài khoản thành công.');
        }
    }

    public function login(){
        return view('login');
    }

    public function handleLogin(Request $req){
        if(Auth::attempt([
            'u_Email' => $req->u_Email,
            'password' => $req->u_PassWord
        ])){
            $user = User::where('u_Email', $req->u_Email)->first();
            Auth::login($user);

            if($user->u_r_id == 3){
                return redirect()->back()->with('error', 'Tài khoản đã bị khóa');
            }else{

                if(isset($req->checkbox_admin)){
                    if(session('login')){
                        $req->session()->forget('login');
                    }
                    return redirect(route('admin.homeAdmin'));
                }else{
                    if(session('login')){
                        return redirect(session('login'));
                    }
                    return redirect(route('home.hh3d'));
                }
            }
        }
        else{
            return redirect()->back()->with('error', 'Sai email hoặc mật khẩu. Vui lòng thử lại.');
        }
    }

    public function logout(){
        Auth::logout();
        return redirect(route('login'));
    }

    public function logout_user(){
        Auth::logout();
        if(session('profile_logout')){
            return redirect(route('home.hh3d'));
        }
        return redirect()->back();
    }
}
