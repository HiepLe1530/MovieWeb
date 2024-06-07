<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use DB;

class Role extends Model
{
    use HasFactory;
    protected $table = 'roles';

    public function getCountRole(){
        return DB::table($this->table)->count();
    }

    public function getall(){
        // return DB::select('select m_Image, m_Title, m_Director, m_ReleaseYear, m_Description from movies')->paginate(1);
        return DB::table($this->table)->get()->toArray();
        
    }

    public function insertRole($roles){
        return DB::table($this->table)->insert($roles);
    }

    public function getRoleById($id){
        return DB::table($this->table)->where('id', $id)->first();
    }

    public function updateRole($roles, $id){
        return DB::table($this->table)->where('id', $id)->update($roles);
    }

    // public function deleteRole($id){
    //     return DB::table($this->table)->where('id', $id)->delete();
    // }
}
