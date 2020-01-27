<?php

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

use App\Task;
use Illuminate\Http\Request;

/**
* タスクダッシュボード表示
*/
Route::get('/', function () {
    return view('welcome');
});

Route::get('/home', 'HomeController@index')->name('home');

Route::get('/line_login', 'LineLoginController@index')->name('line_login');

Route::get('/session', 'SessionController@index')->name('session');



/**
* 新タスク追加
*/
Route::post('/task', function(Request $request){
    $validator = Validator::make($request->all(), [
        'name' => 'required|max:255',
    ]);

    if ($validator->fails()) {
        return redirect('/')
            ->withInput()
            ->withErrors($validator);
    }

    // タスク作成処理…
    $task = new Task();
    $task->name = $request->name;
    $task->save();

    return redirect('/home');
    
});

/**
* タスク削除
*/
Route::delete('/task/{task}', function (Task $task){
    $task->delete();
    
    return redirect('/home');

});