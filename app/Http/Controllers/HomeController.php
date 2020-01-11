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
                \Session::flash('flash_message', '権限拒否られたー');
                return redirect('/');
        }
        
        // アクセストークンを発行する
        basic_request(); 
        

        $tasks = Task::orderBy('created_at','asc')->get();
    
        return view('tasks',[
            'tasks' => $tasks
        ]);
    }
    
    // アクセストークン発行
    public function basic_request() {
        $base_url = 'http://example.com';
        $client = new \GuzzleHttp\Client( [
        'base_uri' => $base_url,
        ] );

        $path = '/index.html';
        $response = $client->request( 'GET', $path,
        [
            'allow_redirects' => true,
        ] );
        $response_body = (string) $response->getBody();
        echo $response_body;
    }
}
