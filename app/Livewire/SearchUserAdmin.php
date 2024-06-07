<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\User;
use App\Models\Role;

class SearchUserAdmin extends Component
{
    protected $user;
    protected $role;

    public $userName = "";
    public $email = "";
    public $userRole = 0;

    public function __construct(){

        $this->user = new User();
        $this->role = new Role();
    }

    public function render()
    {
        $userName = $this->userName;
        $email = $this->email;
        $userRole = $this->userRole;
        $index = 1;
        $roles = $this->role->getall();
        $users = [];

        if(empty($userName) && empty($email) && $userRole == 0){

            $users = $this->user->getall();
            // $movies->withPath('/admin/movie');
        }elseif(!empty($userName) && !empty($email) && $userRole != 0){
            $users = $this->user->getUserByUserNameAndEmailAndUserRole($userName, $email, $userRole);
            // $movies->withPath('/admin/movie');
        }
        else{
            if(!empty($userName)){
                if(!empty($email)){
                    $users = $this->user->getUserByUserNameAndEmail($userName, $email);
                }
                elseif($userRole != 0){
                    $users = $this->user->getUserByUserNameAndUserRole($userName, $userRole);
                }else{
                    $users = $this->user->getUserByUserName($userName);
                }
            }elseif(!empty($email)){
                if($userRole != 0){
                    $users = $this->user->getUserByEmailAndUserRole($email, $userRole);
                }else{
                    $users = $this->user->getUserByEmail($email);
                }
            }elseif($userRole != 0){
                $users = $this->user->getUserByUserRole($userRole);
            }
        }
        
        
        $norecord = 'Hiện tại chưa có người dùng nào được quản lý!';
        return view('livewire.search-user-admin', compact('index', 'users', 'norecord', 'roles'));
    }
}
