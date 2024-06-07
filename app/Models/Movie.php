<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use DB;
use Illuminate\Support\Collection;
use App\Models\Episode;

class Movie extends Model
{
    use HasFactory;

    protected $episode;

    public function __construct(){

        $this->episode = new Episode();
        
    }


    public function getCountMovie(){
        return DB::table('movies')->count();
    }

    public function getall(){
        // return DB::select('select m_Image, m_Title, m_Director, m_ReleaseYear, m_Description from movies')->paginate(1);
        $movies = DB::table('movies')->orderBy('m_id', 'DESC')->get()->toArray();
        // $movies = DB::table('movies')->orderBy('m_id', 'DESC')->paginate(
        //     $perPage = 8, $columns = ['*'], $pageName = 'page'
        // );
        
        return $movies;
        
    }

    public function getMovieByMovieNameAndDirectorNameAndReleaseYear($movieName, $directorName, $releaseYear){
        return DB::table('movies')->orderBy('m_id', 'DESC')
        ->where('m_Title','LIKE','%'.$movieName.'%')
        ->where('m_Director','LIKE','%'.$directorName.'%')
        ->where('m_ReleaseYear',$releaseYear)->get()->toArray();
    }

    public function getMovieByMovieNameAndDirectorName($movieName, $directorName){
        return DB::table('movies')->orderBy('m_id', 'DESC')
        ->where('m_Title','LIKE','%'.$movieName.'%')
        ->where('m_Director','LIKE','%'.$directorName.'%')->get()->toArray();
    }

    public function getMovieByMovieNameAndReleaseYear($movieName, $releaseYear){
        return DB::table('movies')->orderBy('m_id', 'DESC')
        ->where('m_Title','LIKE','%'.$movieName.'%')
        ->where('m_ReleaseYear',$releaseYear)->get()->toArray();
    }

    public function getMovieByDirectorNameAndReleaseYear($directorName, $releaseYear){
        return DB::table('movies')->orderBy('m_id', 'DESC')
        ->where('m_Director','LIKE','%'.$directorName.'%')
        ->where('m_ReleaseYear',$releaseYear)->get()->toArray();
    }

    public function getMovieByMovieName($movieName){
        return DB::table('movies')->orderBy('m_id', 'DESC')
        ->where('m_Title','LIKE','%'.$movieName.'%')->get()->toArray();
    }

    public function getMovieByDirectorName($directorName){
        return DB::table('movies')->orderBy('m_id', 'DESC')
        ->where('m_Director','LIKE','%'.$directorName.'%')->get()->toArray();
    }

    public function getMovieByReleaseYear($releaseYear){
        return DB::table('movies')->orderBy('m_id', 'DESC')
        ->where('m_ReleaseYear',$releaseYear)->get()->toArray();
    }

    public function getMoviePoster(){
        // return DB::select('select m_Image, m_Title, m_Director, m_ReleaseYear, m_Description from movies')->paginate(1);
        return DB::table('movies')->limit(10)->get();
        
    }

    protected function handleMovieAndEpisodeNew($movies){
        foreach($movies as $movie){
            $episodeNewByMovieId = $this->episode->getEpisodeNewByMovieId($movie->m_id);
            if(!empty($episodeNewByMovieId)){
                $episodeNew[] = $this->episode->getEpisodeNewByMovieId($movie->m_id)->e_Episode;
            }
            else{
                $episodeNew[] = 'phim sắp công chiếu';
            }
            
        }
        // Sử dụng phương thức map để duyệt qua từng item trong mảng Collection và thêm trường 'episodeNew'
        $movies->map(function ($item, $key) use ($episodeNew) {
            // Kiểm tra xem có phần tử tương ứng trong mảng episodeNew không
            if (isset($episodeNew[$key])) {
                // Nếu có, thêm giá trị 'episodeNew' vào item
                $item->episodeNew = $episodeNew[$key];
            } else {
                // Nếu không, có thể xử lý tùy ý, ví dụ gán giá trị mặc định hoặc ném ra một ngoại lệ
                $item->episodeNew = null; // hoặc bất kỳ giá trị mặc định nào bạn muốn
            }
            
            return $item;
        });
        $movieAndEpisodeNew = $movies;
        return $movieAndEpisodeNew;
    }

    public function getAllMovieAndEpisodeNew($title = null){
        if(empty($title)){
            $movies = DB::table('movies')->orderBy('m_id', 'DESC')->paginate(12)->withQueryString();
        }
        else{
            $movies = DB::table('movies')->where('m_Title','LIKE','%'.$title.'%')->orderBy('m_id', 'DESC')->paginate(12)->withQueryString();
        }

        $tempArray = $movies->toArray();
        if(!empty($tempArray['data'])){
            return $this->handleMovieAndEpisodeNew($movies);
        }
        return $movies;
        
    }

    public function insertMovie($movies, $genres){
        $movieId = DB::table('movies')->insertGetId($movies);
        foreach ($genres as $genre) {
            $genre_has_movie = [
                'm_id'=>$movieId,
                'g_id'=>$genre
            ];
            DB::table('genre_has_movie')->insert($genre_has_movie);
        }
        return true;
    }

    public function getMovieById($id){
        return DB::table('movies')->where('m_id', $id)->first();
    }

    public function getGenreNameByMovieId($movieId){
        return DB::table('genre_has_movie')
        ->join('movies', 'movies.m_id', '=', 'genre_has_movie.m_id')
        ->join('genres', 'genres.id', '=', 'genre_has_movie.g_id')
        ->where('genre_has_movie.m_id', '=', $movieId)
        ->select('g_Name')
        ->distinct()
        ->get()->toArray();
    }

    public function getGenreByMovieId($movieId){
        return DB::table('genre_has_movie')
        ->join('movies', 'movies.m_id', '=', 'genre_has_movie.m_id')
        ->join('genres', 'genres.id', '=', 'genre_has_movie.g_id')
        ->where('genre_has_movie.m_id', '=', $movieId)
        ->distinct()
        ->get()->toArray();
    }

    public function getGenreIdByMovieId($movieId){
        return DB::table('genre_has_movie')
        ->where('m_id', $movieId)
        ->select('g_id')
        ->get()->toArray();
    }
    
    public function updateMovie($movie, $id, $genres){
        //Tìm g_id thể loại không thuộc mảng g_id thể loại ($genres) truyền vào theo movieId trên bảng  genre_has_movie
        $genreByMovieIdCurrentNotIn = DB::table('genre_has_movie')->where('m_id', $id)->whereNotIn('g_id', $genres)->get()->toArray();
        if(!empty($genreByMovieIdCurrentNotIn)){
            foreach ($genreByMovieIdCurrentNotIn as $key => $value) {
                DB::table('genre_has_movie')->where('m_id', $id)->where('g_id',$value->g_id)->delete();
            }
            //Tìm g_id thể loại thuộc mảng g_id thể loại ($genres) truyền vào theo movieId trên bảng  genre_has_movie
            $genreByMovieIdCurrentInStd = DB::table('genre_has_movie')->where('m_id', $id)->whereIn('g_id', $genres)->get()->toArray(); //Mảng Std class
            if(!empty($genreByMovieIdCurrentInStd)){
                foreach ($genreByMovieIdCurrentInStd as $key => $value) { //Convert mảng Std class sang mảng Int
                    $genreByMovieIdCurrentInInt[] = $value->g_id;
                }
            }
            else{
                $genreByMovieIdCurrentInInt = [];
            }

            // Lấy ra các phần tử của mảng $genres mà không có trong mảng $genreByMovieIdCurrentInInt
            $result = collect($genres)->diff(collect($genreByMovieIdCurrentInInt)); 

            // Chuyển kết quả về mảng
            $resultArray = $result->all(); // VD: $genres = [1, 2, 3], $genreByMovieIdCurrentInInt = [2] => $resultArray = [1,3]
            if(!empty($resultArray)){
                foreach ($resultArray as $key => $value) {
                    $genre_has_movie = [
                        'm_id' => $id,
                        'g_id' => $value
                    ];
                    DB::table('genre_has_movie')->insert($genre_has_movie);
                }
            }
        }else{
            //Tìm g_id thể loại thuộc mảng g_id thể loại ($genres) truyền vào theo movieId trên bảng  genre_has_movie
            $genreByMovieIdCurrentInStd = DB::table('genre_has_movie')->where('m_id', $id)->whereIn('g_id', $genres)->get()->toArray(); //Mảng Std class
            if(!empty($genreByMovieIdCurrentInStd)){
                foreach ($genreByMovieIdCurrentInStd as $key => $value) { //Convert mảng Std class sang mảng Int
                    $genreByMovieIdCurrentInInt[] = $value->g_id;
                }
            }
            else{
                $genreByMovieIdCurrentInInt = [];
            }

            // Lấy ra các phần tử của mảng $genres mà không có trong mảng $genreByMovieIdCurrentInInt
            $result = collect($genres)->diff(collect($genreByMovieIdCurrentInInt)); 

            // Chuyển kết quả về mảng
            $resultArray = $result->all(); // VD: $genres = [1, 2, 3], $genreByMovieIdCurrentInInt = [2] => $resultArray = [1,3]
            if(!empty($resultArray)){
                foreach ($resultArray as $key => $value) {
                    $genre_has_movie = [
                        'm_id' => $id,
                        'g_id' => $value
                    ];
                    DB::table('genre_has_movie')->insert($genre_has_movie);
                }
            }
        }
        
        DB::table('movies')->where('m_id', $id)->update($movie);
    
        return true;
    }

    public function deleteMovie($id){
        DB::table('episodes')->where('e_m_id', $id)->delete();
        DB::table('genre_has_movie')->where('m_id', $id)->delete();
        DB::table('comments')->where('m_id', $id)->delete();
        DB::table('follow')->where('m_id', $id)->delete();
        DB::table('rating')->where('m_id', $id)->delete();
        DB::table('watch_history')->where('m_id', $id)->delete();
        return DB::table('movies')->where('m_id', $id)->delete();
    }

    public function searchMovieByTitle($title){
        return DB::table('movies')->where('m_Title','LIKE','%'.$title.'%')->paginate(1)->toArray();
    }

    public function movieByGenre($genreId){
        $movieByGenre = DB::table('genre_has_movie')
        ->join('movies', 'movies.m_id', '=', 'genre_has_movie.m_id')
        ->join('genres', 'genres.id', '=', 'genre_has_movie.g_id')
        ->where('genre_has_movie.g_id', '=', $genreId)
        ->paginate(12);
        $tempArray = $movieByGenre->toArray();
        if(!empty($tempArray['data'])){
            return $this->handleMovieAndEpisodeNew($movieByGenre);
        }
        return $movieByGenre;
    }
}
