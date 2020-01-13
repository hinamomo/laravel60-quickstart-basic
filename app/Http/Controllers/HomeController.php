<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Task;
use GuzzleHttp\Client;

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
        $code = $request->input('code');
        $this->basic_request($code); 
        

        $tasks = Task::orderBy('created_at','asc')->get();
    
        return view('tasks',[
            'tasks' => $tasks
        ]);
    }
    
    // アクセストークン発行
    public function basic_request(String $code) {
        
        $client = new Client();
        $response = $client->request('POST', 'https://api.line.me/oauth2/v2.1/token', array(
            "headers" => array(
                "Content-Type" => "application/x-www-form-urlencoded",
            ),
            "form_params" => array(
                "grant_type" => "authorization_code",
                "code" => $code,
                "redirect_uri" => "http://localhost/home",
                "client_id" => env('CLIENT_ID', false),
                "client_secret" => env('CHANNEL_SECRET')
            )
        )); 
        
        $response_body = (string) $response->getBody();
        $access_token = $response_body;
        
//        echo $response_body;
        echo $access_token;
    }
}
