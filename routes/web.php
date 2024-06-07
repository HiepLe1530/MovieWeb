<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\MovieController;
use App\Http\Controllers\Admin\GenreController;
use App\Http\Controllers\Admin\RoleController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Admin\AdminHomeController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\User\HomeController;
use App\Http\Controllers\User\CommentController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});
Route::get('/register', [AuthController::class, 'register'])->name('register');
Route::post('/register', [AuthController::class, 'handleRegister']);

Route::get('/login', [AuthController::class, 'login'])->name('login');
Route::post('/login', [AuthController::class, 'handleLogin']);

Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
Route::post('/logout_user', [AuthController::class, 'logout_user'])->name('logout_user');

Route::prefix('/admin')->name('admin.')->middleware(['auth','checkadmin'])->group(function(){

    Route::get('/', [AdminHomeController::class, 'homeAdmin'])->name('homeAdmin');

    Route::prefix('/movie')->name('movie.')->group(function(){
        Route::get('/', [MovieController::class, 'index'])->name('movie');
        Route::get('/add', [MovieController::class, 'add'])->name('add');
        Route::post('/add', [MovieController::class, 'insert']);
        Route::get('/edit/{id}', [MovieController::class, 'edit'])->name('edit');
        Route::put('/update', [MovieController::class, 'update'])->name('update');
        Route::delete('/delete/{id}', [MovieController::class, 'delete'])->name('delete');

        Route::get('/{id}/detail', [MovieController::class, 'detail'])->name('detail');
        Route::get('/{id}/addEpisode', [MovieController::class, 'addEpisode'])->name('addEpisode');
        Route::post('/{id}/addEpisode', [MovieController::class, 'insertEpisode']);
        Route::get('/{id}/editEpisode/', [MovieController::class, 'editEpisode'])->name('editEpisode');
        Route::put('/{id}/updateEpisode', [MovieController::class, 'updateEpisode'])->name('updateEpisode');
        Route::delete('/{id}/deleteEpisode/', [MovieController::class, 'deleteEpisode'])->name('deleteEpisode');
        Route::get('/search', [MovieController::class, 'search']);
    });
    
    Route::prefix('/genre')->name('genre.')->group(function(){
        Route::get('/', [GenreController::class, 'index'])->name('genre');
        Route::get('/add', [GenreController::class, 'add'])->name('add');
        Route::post('/add', [GenreController::class, 'insert']);
        Route::get('/edit/{id}', [GenreController::class, 'edit'])->name('edit');
        Route::put('/update', [GenreController::class, 'update'])->name('update');
        Route::delete('/delete/{id}', [GenreController::class, 'delete'])->name('delete');
    });

    Route::prefix('/role')->name('role.')->group(function(){
        Route::get('/', [RoleController::class, 'index'])->name('role');
        Route::get('/add', [RoleController::class, 'add'])->name('add');
        Route::post('/add', [RoleController::class, 'insert']);
        Route::get('/edit/{id}', [RoleController::class, 'edit'])->name('edit');
        Route::put('/update', [RoleController::class, 'update'])->name('update');
        Route::delete('/delete/{id}', [RoleController::class, 'delete'])->name('delete');
    });

    Route::prefix('/user')->name('user.')->group(function(){
        Route::get('/', [UserController::class, 'index'])->name('user');
        Route::get('/add', [UserController::class, 'add'])->name('add');
        Route::post('/add', [UserController::class, 'insert']);
        Route::get('/edit/{id}', [UserController::class, 'edit'])->name('edit');
        Route::put('/update', [UserController::class, 'update'])->name('update');
        Route::delete('/delete/{id}', [UserController::class, 'delete'])->name('delete');

        Route::post('/updateRole', [UserController::class, 'updateRole'])->name('updateRole');
        
    });

    Route::prefix('/profile')->name('profile.')->group(function(){
        Route::get('/', [UserController::class, 'profile'])->name('profile');
        Route::put('/edit_yourself', [UserController::class, 'edit_yourself'])->name('edit_yourself');
        Route::put('/edit_password', [UserController::class, 'edit_password'])->name('edit_password');
    });
    
});

Route::prefix('/hh3d')->name('home.')->group(function(){
    Route::get('/', [HomeController::class, 'index'])->name('hh3d');
    Route::get('/search', [HomeController::class, 'search_input'])->name('search');
    Route::get('/genre/{genreId}-{g_Slug}', [HomeController::class, 'movieByGenre'])->name('movieByGenre');
    Route::get('/{movieId}-{m_Slug}', [HomeController::class, 'movieDetail'])->name('movieDetail');

    Route::get('/{movieId}-{m_Slug}/episode-{e_Episode}', [HomeController::class, 'episodeDetail'])->name('episodeDetail');

    Route::post('/comment/{movieId}', [CommentController::class, 'addComment'])->name('addComment');
    Route::post('/editComment', [CommentController::class, 'editComment'])->name('editComment');
    Route::delete('/deleteComment', [CommentController::class, 'deleteComment'])->name('deleteComment');

    Route::get('/history', [HomeController::class, 'history'])->name('history');
    Route::post('/history', [HomeController::class, 'historyAjax'])->name('historyAjax');

    Route::delete('/delItemHistory/{movieId}', [HomeController::class, 'delItemHistory'])->name('delItemHistory');
    Route::delete('/delAllHistory', [HomeController::class, 'delAllHistory'])->name('delAllHistory');


    Route::get('/follow', [HomeController::class, 'listFollow'])->name('listFollow');
    Route::post('/follow', [HomeController::class, 'listFollowAjax'])->name('listFollowAjax');
    Route::post('/follow/{movieId}', [HomeController::class, 'follow'])->name('follow');
    Route::post('/unfollow/{movieId}', [HomeController::class, 'unFollow'])->name('unfollow');
    Route::delete('/delItemFollow/{movieId}', [HomeController::class, 'delItemFollow'])->name('delItemFollow');

    Route::post('/addRating', [HomeController::class, 'addRating'])->name('addRating');

    Route::post('/episodeSearch', [HomeController::class, 'episodeSearch'])->name('episodeSearch');

    Route::prefix('/profile')->name('profile.')->group(function(){
        Route::get('/', [HomeController::class, 'profile'])->name('profile');
        Route::put('/edit_yourself', [HomeController::class, 'edit_yourself'])->name('edit_yourself');
        Route::put('/edit_password', [HomeController::class, 'edit_password'])->name('edit_password');
    });
    
});


