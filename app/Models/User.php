<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use DB;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'u_UserName',
        'u_Email',
        'u_PassWord',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
    ];

    protected $table = 'users';

    public function getCountUser(){
        return DB::table($this->table)->count();
    }

    public function getall(){
        // return DB::select('select m_Image, m_Title, m_Director, m_ReleaseYear, m_Description from movies')->paginate(1);
        return DB::table($this->table)->get()->toArray();
        
    }

    public function getUserByUserNameAndEmailAndUserRole($userName, $email, $userRole){
        return DB::table($this->table)
        ->where('u_UserName','LIKE','%'.$userName.'%')
        ->where('u_Email','LIKE','%'.$email.'%')
        ->where('u_r_id',$userRole)->get()->toArray();
    }

    public function getUserByUserNameAndEmail($userName, $email){
        return DB::table($this->table)
        ->where('u_UserName','LIKE','%'.$userName.'%')
        ->where('u_Email','LIKE','%'.$email.'%')->get()->toArray();
    }

    public function getUserByUserNameAndUserRole($userName, $userRole){
        return DB::table($this->table)
        ->where('u_UserName','LIKE','%'.$userName.'%')
        ->where('u_r_id',$userRole)->get()->toArray();
    }

    public function getUserByEmailAndUserRole($email, $userRole){
        return DB::table($this->table)
        ->where('u_Email','LIKE','%'.$email.'%')
        ->where('u_r_id',$userRole)->get()->toArray();
    }

    public function getUserByUserName($userName){
        return DB::table($this->table)
        ->where('u_UserName','LIKE','%'.$userName.'%')->get()->toArray();
    }

    public function getUserByEmail_like($email){
        return DB::table($this->table)
        ->where('u_Email','LIKE','%'.$email.'%')->get()->toArray();
    }

    public function getUserByUserRole($userRole){
        return DB::table($this->table)
        ->where('u_r_id',$userRole)->get()->toArray();
    }
    
    public function getUserByEmail($email){
        return DB::table($this->table)->where('u_Email', $email)->first();
    }

    public function insertUser($user){
        return DB::table($this->table)->insert($user);
    }

    public function editYourSelf($user, $id){
        return DB::table($this->table)->where('id', $id)->update($user);
    }

    public function updateRole($userId, $roleId){
        return DB::table($this->table)->where('id', $userId)->update([
            'u_r_id' => $roleId
        ]);
    }
}
