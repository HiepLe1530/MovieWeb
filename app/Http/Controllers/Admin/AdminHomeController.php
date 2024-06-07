<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Movie;
use App\Models\Role;
use App\Models\Genre;
use App\Models\User;

class AdminHomeController extends Controller
{
    protected $movie;
    protected $user;
    protected $role;
    protected $genre;

    public function __construct(){

        $this->movie = new Movie();
        $this->user = new User();
        $this->role = new Role();
        $this->genre = new Genre();
    }

    public function homeAdmin(){
        $countMovie = $this->movie->getCountMovie();
        $countUser = $this->user->getCountUser();
        $countRole = $this->role->getCountRole();
        $countGenre = $this->genre->getCountGenre();
        return view('admin.home', compact('countMovie', 'countUser', 'countRole', 'countGenre'));
    }
}
