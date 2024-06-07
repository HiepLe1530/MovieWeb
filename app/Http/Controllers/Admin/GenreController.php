<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Genre;
use App\Http\Requests\Admin\GenreRequest;
use Illuminate\Support\Str;

class GenreController extends Controller
{
    protected $genre;

    public function __construct(){

        $this->genre = new Genre();
    }

    public function index(){
        $index = 1;
        $genres = $this->genre->getall();
        $norecord = 'Hiện tại chưa có thể loại phim nào được quản lý!';
        return view('admin.genre.genre', compact('index', 'genres', 'norecord'));
    }

    public function add(Request $req){
        if(session('g_id')){
            $req->session()->forget('g_id');
        }
        return view('admin.genre.addgenre');
    }

    public function insert(GenreRequest $req){
        
        $genres = [
            'g_Name'=>$req->g_Name,
            'g_Slug'=>Str::slug($req->g_Name)
        ];
        if($this->genre->insertGenre($genres)){
            return redirect(route('admin.genre.genre'))->with('success','Thêm thể loại phim thành công');
        }
        else{
            return redirect()->back()->with('error','Thêm bộ phim không thành công');
        }
        
    }

    public function edit(Request $req, $id){
        $req->session()->put('g_id', $id);
        if(!empty($id)){
            $genresById = $this->genre->getGenreById($id);
            if(!empty($genresById)){
                return view('admin.genre.editgenre', compact('genresById'));
            }
            return redirect()->back()->with('error','Thể loại phim không tồn tại');
        }
        else{
            return redirect()->back()->with('error','Liên kết không tồn tại');
        }
        
    }

    public function update(GenreRequest $req){
        $g_id = $req->session()->pull('g_id');
        $genres = [
            'g_Name'=>$req->g_Name,
            'g_Slug'=>Str::slug($req->g_Name)
        ];
        
        if($this->genre->updateGenre($genres, $g_id)){
            return redirect(route('admin.genre.genre'))->with('success','Chỉnh sửa thể loại phim thành công');
        }
        else{
            return redirect()->back()->with('error','Nếu không thay đổi gì vui lòng bấm quay lại.');
        }
    }

    public function delete($id){
       
        if($this->genre->deleteGenre($id)){
            return response()->json([
                'error'=>'false',
                'message'=>'Xóa thể loại phim thành công'
            ]);
        }
        return response()->json([
            'error'=>'true',
            'message'=>'Xóa thể loại phim KHÔNG thành công'

        ]);
            
        
    }
}
