<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Movie;
use App\Models\Episode;
use App\Models\Genre;
use App\Http\Requests\Admin\MovieRequest;
use App\Http\Requests\Admin\EpisodeRequest;
use Illuminate\Support\Str;
use Carbon\Carbon;

class MovieController extends Controller
{
    protected $movie;
    protected $episode;
    protected $genre;

    public function __construct(){

        $this->movie = new Movie();
        $this->episode = new Episode();
        $this->genre = new Genre();
    }

    public function index(){
        // $movies = $this->movie->getall();
        // $norecord = 'Hiện tại chưa có bộ phim nào được quản lý!';
        // $currentYear = Carbon::now()->year;
        return view('admin.movie.movie');
    }
    public function add(Request $req){
        if(session('m_id')){
            $req->session()->forget('m_id');
        }
        $genres = $this->genre->getall();
        return view('admin.movie.addmovie', compact('genres'));
    }

    public function insert(MovieRequest $req){
        if($req->has('m_Image') && $req->has('m_Poster')){
            $file_img = $req->m_Image;
            $file_poster = $req->m_Poster;
            $name_img = $file_img->getClientOriginalName();
            $name_poster = $file_poster->getClientOriginalName();
            $file_img->move(public_path('images'), $name_img);
            $file_poster->move(public_path('images/poster'), $name_poster);
            $movie = [
                'm_Image'=>$name_img,
                'm_Title'=>$req->m_Title,
                'm_Director'=>$req->m_Director,
                'm_ReleaseYear'=>$req->m_ReleaseYear,
                'm_Description'=>$req->m_Description,
                'm_Poster'=>$name_poster,
                'm_Slug'=>Str::slug($req->m_Title)
            ];
            $genres = $req->genres;
            if($this->movie->insertMovie($movie, $genres)){
                return redirect(route('admin.movie.movie'))->with('success','Thêm bộ phim thành công');
            }
            else{
                return redirect()->route('admin.movie.movie')->with('error','Thêm bộ phim không thành công');
            }
        }

    }

    public function edit(Request $req, $id){
        $req->session()->put('m_id', $id);
        if(!empty($id)){
            $movieById = $this->movie->getMovieById($id);
            if(!empty($movieById)){
                $genres = $this->genre->getall();
                $genreIdByMovieIdStd = $this->movie->getGenreIdByMovieId($id);
                if(!empty($genreIdByMovieIdStd)){
                    foreach ($genreIdByMovieIdStd as $value) {
                        $genreIdByMovieIdInt[] = $value->g_id;
                    }
                }else{
                    $genreIdByMovieIdInt = [];
                }
                return view('admin.movie.editmovie', compact('movieById', 'genres', 'genreIdByMovieIdInt'));
            }
            return redirect()->back()->with('error','Bộ phim không tồn tại');
        }
        else{
            return redirect()->back()->with('error','Liên kết không tồn tại');
        }
        
    }

    public function update(MovieRequest $req){
        $id = $req->session()->pull('m_id');
        $movie = [
            'm_Title'=>$req->m_Title,
            'm_Director'=>$req->m_Director,
            'm_ReleaseYear'=>$req->m_ReleaseYear,
            'm_Description'=>$req->m_Description,
            'm_Slug'=>Str::slug($req->m_Title)
        ];
        if($req->has('m_Image')){
            $file_img = $req->m_Image;
            $name_img = $file_img->getClientOriginalName();
            $file_img->move(public_path('images'), $name_img);
            $movie['m_Image'] = $name_img;   
        }
        if($req->has('m_Poster')){
            $file_poster = $req->m_Poster;
            $name_poster = $file_poster->getClientOriginalName();
            $file_poster->move(public_path('images/poster'), $name_poster);
            $movie['m_Poster'] = $name_poster;   
        }
        $genres = $req->genres;
        if($this->movie->updateMovie($movie, $id, $genres)){
            return redirect(route('admin.movie.movie'))->with('success','Chỉnh sửa bộ phim thành công');
        }
        else{
            return redirect()->back()->with('error','Nếu không thay đổi gì vui lòng bấm quay lại.');
        }
    }

    public function delete($id){
        if(!empty($id)){
            $movieById = $this->movie->getMovieById($id);
            if(!empty($movieById)){
                if($this->movie->deleteMovie($id)){
                    return response()->json([
                        'error'=>'false',
                        'message'=>'Xóa bộ phim thành công'
                    ]);
                }
                return response()->json([
                    'error'=>'true',
                    'message'=>'Xóa bộ phim KHÔNG thành công'
        
                ]);
            }
            return redirect()->route('admin.movie.movie')->with('error','Bộ phim không tồn tại');
        }
        else{
            return redirect()->route('admin.movie.movie')->with('error','Liên kết không tồn tại');
        }
        
    }

    public function detail($id){
        if(!empty($id)){
            $detail = $this->movie->getMovieById($id);
            if(!empty($detail)){
                $episodeByMovieId = $this->episode->getEpisodeByMovieId($id);
                $genreNameByMovieId = $this->movie->getGenreNameByMovieId($id);
                return view('admin.movie.detail', compact('detail', 'episodeByMovieId', 'genreNameByMovieId'));
            }
            return redirect()->back()->with('error','Bộ phim không tồn tại');
        }
        else{
            return redirect()->back()->with('error','Liên kết không tồn tại');
        }
        
    }

    public function addEpisode(Request $req, $movieId){
        if(session('e_id')){
            $req->session()->forget('e_id');
        }
        return view('admin.movie.episode.addepisode', compact('movieId'));
    }

    public function insertEpisode(EpisodeRequest $req, $movieId){
        $file = $req->e_MovieVideo;
        $name = $file->getClientOriginalName();
        $file->move(public_path('videos'), $name);
        $episodes = [
            'e_m_id'=>$movieId,
            'e_Episode'=>$req->e_Episode,
            'e_MovieVideo'=>$name
        ];
        if($this->episode->insertEpisode($episodes)){
            return redirect(route('admin.movie.detail', ['id'=>$movieId]))->with('success','Thêm tập phim thành công');
        }
        else{
            return redirect()->route('admin.movie.detail', ['id'=>$movieId])->with('error','Thêm tập phim không thành công');
        }
    }

    public function editEpisode(Request $req, $movieId){
        $req->session()->put('e_id', $req->episodeId);
        if(!empty($req->episodeId)){
            $episode = $this->episode->getEpisodeById($req->episodeId);
            if(!empty($episode)){
                return view('admin.movie.episode.editepisode', compact('episode', 'movieId'));
            }
            return redirect()->back()->with('error', 'Tập phim không tồn tại');
        }else{
            return redirect()->back()->with('error', 'Tập phim không tồn tại');
        }
    }
    
    public function updateEpisode(EpisodeRequest $req, $movieId){
        $episodeId = $req->session()->pull('e_id');
        $episodes = [
            'e_m_id'=>$movieId,
            'e_Episode'=>$req->e_Episode,
        ];
        if($req->has('e_MovieVideo')){
            $file = $req->e_MovieVideo;
            $name = $file->getClientOriginalName();
            $file->move(public_path('videos'), $name);
            $episodes['e_MovieVideo'] = $name;   
        }
        if($this->episode->updateEpisode($episodes, $episodeId)){
            return redirect(route('admin.movie.detail', ['id'=>$movieId]))->with('success','Chỉnh sửa tập phim thành công');
        }
        else{
            return redirect()->back()->with('error','Nếu không thay đổi gì vui lòng bấm quay lại.');
        }
    }

    public function deleteEpisode(Request $req, $movieId){
       
        if($this->episode->deleteEpisode($req->episodeId)){
            return response()->json([
                'error'=>'false',
                'message'=>'Xóa tập phim thành công'
            ]);
        }
        return response()->json([
            'error'=>'true',
            'message'=>'Xóa tập phim KHÔNG thành công'

        ]);
            
        
    }

    
}
