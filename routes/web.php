<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\BoardController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\BoardUserController;
use App\Http\Controllers\CommentController;
use App\Http\Controllers\TaskController;
use App\Http\Controllers\TaskUserController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Models\User;
use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function(Request $request){
        if(!Auth::check()) return redirect()->route('login.login');
        else{
            $user = User::where('id', $request->session()->get('user_id'))->first();
            return view('home', ['user'=>$user]);
        } 
    }
);

//-- Les routes concernants les boards
Route::get('board/new', [BoardController::class, 'create'])->name('board.create');
Route::post('board/new', [BoardController::class, 'store'])->name('board.store');
Route::get('board/{board}', [BoardController::class, 'show'])->name('board.show');
Route::get('board/delete/{board}', [BoardController::class, 'destroy'])->name('board.destroy');
Route::post('board/{board}/update', [BoardController::class, 'update'])->name('board.update');


//-- Les routes concernants la table pivot BoardUser
Route::post('boarduser/new/{board}', [BoardUserController::class, 'store'])->name('boarduser.store');
Route::get('boarduser/destroy/{board}/{user}/{type}', [BoardUserController::class, 'destroy'])->name('boarduser.destroy');


//-- Les regles concernants la table pivot taskuser
Route::post('taskuser/new/{task}', [TaskUserController::class, 'store'])->name('taskuser.store');
Route::get('taskuser/destroy/{task}/{user}', [TaskUserController::class, 'destroy'])->name('taskuser.destroy');


//-- Les routes concernant les taches
Route::get('board/{board}/task/new', [TaskController::class, 'create'])->name('task.create');
Route::post('board/{board}/task/new', [TaskController::class, 'store'])->name('task.store');
Route::get('board/{board}/task/{task}', [TaskController::class, 'show'])->name('task.show');
Route::get('board/{board}/task/delete/{task}', [TaskController::class, 'destroy'])->name('task.destroy');
Route::post('board/{board}/task/{task}/update', [TaskController::class, 'update'])->name('task.update');


//-- les routes du système d'authentification
Route::get('/login', [LoginController::class, 'show'])->name('login.show');
Route::post('/login', [LoginController::class, 'login'])->name('login.login');
Route::get('/logout', [LoginController::class, 'logout'])->name('login.logout');
Route::post('/register', [RegisterController::class, 'register'])->name('register.create');
Route::get('/register', [RegisterController::class, 'show'])->name('register.show');


//-- les routes concernants les commentaires
Route::post('comment/{task}/new', [CommentController::class, 'store'])->name('comment.store');
Route::get('comment/delete/{comment}', [CommentController::class, 'destroy'])->name('comment.destroy');

