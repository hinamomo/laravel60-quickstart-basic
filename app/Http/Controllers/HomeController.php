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
        
        if($state_line !== $state_cookie){
            \Session::flash('flash_message', 'state検証エラー');
            return redirect('/');
//            return redirect('/')->with('flash_message', 'state検証エラー');
        }
        
        
//        return view('home');
        $tasks = Task::orderBy('created_at','asc')->get();
    
        return view('tasks',[
            'tasks' => $tasks
        ]);
    }
}
