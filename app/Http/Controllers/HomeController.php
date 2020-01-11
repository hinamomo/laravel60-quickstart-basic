<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Task;

class HomeController extends Controller
{

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index(Request $request)
    {
        // state検証
        $state_line = $request->input('state');
        $state_cookie = \Cookie::get('state');
        
        // stateが異なる場合
        if($state_line !== $state_cookie){
            \Session::flash('flash_message', 'state検証エラー');
            return redirect('/');
        }
        
        // TODO エラーレスポンスが返って来た場合は適切に処理する必要がある
        $error_description = $request->input('error_description');
        if($error_description != ""){
            //if($error_description == "The+resource+owner+denied+the+request."){
                \Session::flash('flash_message', '権限拒否られたー');
                return redirect('/');
            //}
        }
        
        
//        return view('home');
        $tasks = Task::orderBy('created_at','asc')->get();
    
        return view('tasks',[
            'tasks' => $tasks
        ]);
    }
}
