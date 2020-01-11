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
    public function index()
    {
//        return view('home');
        $tasks = Task::orderBy('created_at','asc')->get();
    
        return view('tasks',[
            'tasks' => $tasks
        ]);
    }
}
