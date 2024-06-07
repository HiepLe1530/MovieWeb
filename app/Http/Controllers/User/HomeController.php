<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Illuminate\Support\Facades\Hash;
use Auth;
use App\Models\Genre;
use App\Models\Movie;
use App\Models\Episode;
use App\Models\Comment;
use App\Models\WatchHistory;
use App\Models\Follow;
use App\Models\Rating;
use App\Models\User;

class HomeController extends Controller
{
    protected $genre;
    protected $movie;
    protected $episode;
    protected $comment;
    protected $genres;
    protected $watchHistory;
    protected $follow;
    protected $rating;
    protected $user;

    protected $currentTime;


    public function __construct(){

        $this->genre = new Genre();
        $this->movie = new Movie();
        $this->episode = new Episode();
        $this->comment = new Comment();
        $this->watchHistory = new WatchHistory();
        $this->follow = new Follow();
        $this->rating = new Rating();
        $this->user = new User();

        $this->genres = $this->genre->getall();

        Carbon::setLocale('vi');
        // Thời gian hiện tại
        $this->currentTime = Carbon::now();
        
    }

    public function index(Request $req){
        if(session('profile_logout')){
            $req->session()->forget('profile_logout');
        }
        $norecord = "Phim ko ton tai";
        $req->session()->put('login', route('home.hh3d'));
        $genres = $this->genres;
        $movieAndEpisodeNew = $this->movie->getAllMovieAndEpisodeNew();
        $moviePoster = $this->movie->getMoviePoster();
        $title_content = "Mới cập nhật";
        $movieMaxFollow = $this->follow->getMovieMaxFollow();
        $rating = $this->rating;
        return view('user.home', compact('norecord','genres', 'movieAndEpisodeNew', 'moviePoster', 'title_content', 'movieMaxFollow', 'rating'));
    }

    public function search_input(Request $req){
        if(session('profile_logout')){
            $req->session()->forget('profile_logout');
        }
        $req->session()->put('login', route('home.search'));
        $genres = $this->genres;
        $movieAndEpisodeNew = $this->movie->getAllMovieAndEpisodeNew($req->title);
        $title_content = "Kết quả tìm kiếm ' ".$req->title." '";
        $norecord = 'Phim không tồn tại';
        $rating = $this->rating;
        return view('user.search', compact('genres', 'movieAndEpisodeNew', 'title_content', 'norecord', 'rating'));
    }

    public function movieByGenre(Request $req){
        if(session('profile_logout')){
            $req->session()->forget('profile_logout');
        }
        $req->session()->put('login', route('home.movieByGenre', ['g_Slug'=>$req->g_Slug, 'genreId'=>$req->genreId]));
        $genres = $this->genres;
        $movieAndEpisodeNew = $this->movie->movieByGenre($req->genreId);
        $genreName = $this->genre->getGenreById($req->genreId);
        $title_content = $genreName->g_Name;
        $norecord = 'Chưa có bộ phim nào thuộc thể loại '.$title_content;
        $rating = $this->rating;
        return view('user.movieByGenre', compact('genres', 'movieAndEpisodeNew', 'title_content', 'norecord', 'rating'));
    }

    public function movieDetail(Request $req, $movieId, $m_Slug){
        if(empty($this->movie->getMovieById($movieId))){
            return redirect()->back()->with(['error'=>'Bộ phim không còn tồn tại', 'movieId'=>$movieId]);
        }else{
            if(session('profile_logout')){
                $req->session()->forget('profile_logout');
            }
            $req->session()->put('login', route('home.movieDetail', ['movieId'=>$movieId, 'm_Slug'=>$m_Slug]));
            $genres = $this->genres;
            $movieDetail = $this->movie->getMovieById($movieId);
            $genreByMovieId = $this->movie->getGenreByMovieId($movieId);
            $episodeByMovieId = $this->episode->getEpisodeByMovieId($movieId);
            $episodeNewByMovieId = $this->episode->getEpisodeNewByMovieId($movieId);
            $comment = $this->comment;
            $follow = $this->follow->getFollow(Auth::id(), $movieId);
            $movieMaxFollow = $this->follow->getMovieMaxFollow($movieId);
            $rating = $this->rating;
            return view('user.movieDetail', compact('genres', 'movieDetail', 'genreByMovieId', 'episodeByMovieId', 'episodeNewByMovieId', 'comment', 'follow', 'movieMaxFollow', 'rating'));
        }
    }

    public function episodeDetail(Request $req, $movieId, $m_Slug, $e_Episode){

        if(empty($this->movie->getMovieById($movieId))){
            return redirect()->back()->with(['error'=>'Bộ phim không còn tồn tại', 'movieId'=>$movieId]);
        }else{
            if(session('profile_logout')){
                $req->session()->forget('profile_logout');
            }
            $req->session()->put('login', route('home.episodeDetail', ['movieId'=>$movieId, 'm_Slug'=>$m_Slug, 'e_Episode'=>$e_Episode]));
            if(Auth::check()){
                if(empty($this->watchHistory->getHistoryByUserIdAndMovieId(Auth::id(), $movieId))){
                    $this->watchHistory->insert(Auth::id(), $movieId, $e_Episode);
                }else{
                    $this->watchHistory->updateTimestamp(Auth::id(), $movieId, $e_Episode);
                }
            }
            $genres = $this->genres;
            $movieDetail = $this->movie->getMovieById($movieId);
            $episodeByMovieId = $this->episode->getEpisodeByMovieId($movieId);
            $comment = $this->comment;
    
            $episodeOneByMovieId = $this->episode->getOneEpisodeByMovieId($movieId, $e_Episode);
    
            $movieMaxFollow = $this->follow->getMovieMaxFollow($movieId);
            $rating = $this->rating;
            return view('user.episodeDetail', compact('genres', 'movieDetail', 'episodeByMovieId', 'comment', 'episodeOneByMovieId', 'movieMaxFollow', 'rating'));
        }
    }

    public function history(Request $req){
        if(session('profile_logout')){
            $req->session()->forget('profile_logout');
        }
        $req->session()->put('login', route('home.history'));
        $genres = $this->genres;
        if(Auth::check()){
            $history = $this->watchHistory->getHistoryByUserId(Auth::id());
        }else{
            $history = [];
        }

        for($i = 0; $i < count($history); $i++){
            // Chuyển chuỗi thời gian thành đối tượng Carbon
            $timestamp = Carbon::parse($history[$i]->wh_Timestamp);
             // So sánh thời gian
            $timeDiff = $timestamp->diffForHumans($this->currentTime);
            $history[$i]->wh_Timestamp = $timeDiff;
        }
        return view('user.history', compact('genres', 'history'));
        
    }

    public function historyAjax(Request $req){
        
        //Lấy dữ liệu từ ajax gửi lên
        $histories = $req->histories;

        if(!empty($histories)){
            for($i = 0; $i < count($histories); $i++){
                // Chuyển chuỗi thời gian thành đối tượng Carbon
                $timestamp = Carbon::parse($histories[$i][3]);
                 // So sánh thời gian
                $timeDiff = $timestamp->diffForHumans($this->currentTime);
                $histories[$i][3] = $timeDiff;
            }
        }

        return response()->json(['view' => view('user.historyAjax', compact('histories'))->render()]);
        
    }

    public function delItemHistory($movieId){
        if($this->watchHistory->deleteHistory(Auth::id(), $movieId)){
            return response()->json(['success' => 'Xóa thành công']);
        }
        return response()->json(['error' => 'Xóa không thành công']);
    }

    public function delAllHistory(){
        if($this->watchHistory->deleteAllHistoryByUserId(Auth::id())){
            return response()->json(['success' => 'Xóa thành công']);
        }
        return response()->json(['error' => 'Xóa không thành công']);
    }

    public function follow($movieId){
        if($this->follow->insertFollow(Auth::id(), $movieId)){
            return response()->json(['btn_unfollow' => view('layout.user.btn_unfollow', compact('movieId'))->render()]);
        }
    }

    public function unFollow($movieId){
        if($this->follow->deleteFollow(Auth::id(), $movieId)){
            return response()->json(['btn_follow' => view('layout.user.btn_follow', compact('movieId'))->render()]);
        }
    }

    public function listFollow(Request $req){
        if(session('profile_logout')){
            $req->session()->forget('profile_logout');
        }
        $req->session()->put('login', route('home.listFollow'));
        $genres = $this->genres;
        if(Auth::check()){
            $followByUserId = $this->follow->getFollowByUserId(Auth::id());
        }else{
            $followByUserId = [];
        }
        
        return view('user.follow', compact('genres', 'followByUserId'));
    }

    public function listFollowAjax(Request $req){
        
        //Lấy dữ liệu từ ajax gửi lên
        $follows = $req->follows;

        return response()->json(['view' => view('user.followAjax', compact('follows'))->render()]);
        
    }

    public function delItemFollow($movieId){
        if($this->follow->deleteFollow(Auth::id(), $movieId)){
            return response()->json(['success' => 'Xóa thành công']);
        }
        return response()->json(['error' => 'Xóa không thành công']);
    }

    public function addRating(Request $req){
        $ipAddress = $req->ip();
        $rating = [
            'm_id' => $req->movieId,
            'r_Rating' => $req->rating,
            'r_IpAddress' => $ipAddress
        ];
        if(empty($this->rating->getRatingByMovieIdAndIpAddress($req->movieId, $ipAddress))){
            $this->rating->insertRating($rating);
            return response()->json(['success' => 'Cảm ơn bạn đã đánh giá']);
        }
    }


    public function episodeSearch(Request $req){
        if(empty($req->episode)){
            return response()->json(['view' => '<div></div>']);
        }
        $episodeSearch = $this->episode->getEpisodeByMovieIdAndEpisode($req->episode, $req->movieId);
        return response()->json(['view' => view('user.episodeAjax', compact('episodeSearch'))->render()]);
    }

    public function profile(Request $req){
        $req->session()->put('profile_logout', 'temp');
        $genres = $this->genres;
        return view('user.profile', compact('genres'));
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
}
