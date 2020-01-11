<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Task;
use Illuminate\Support\Str;

class LineLoginController extends Controller
{


    public function index()
    {
        $state = Str::random(40);
        \Cookie::queue('state', $state,100);
        
        $nonce  = Str::random(40);
        \Cookie::queue('nonce', $nonce,100);
        
       
        // LINE認証 
        $uri ="https://access.line.me/oauth2/v2.1/authorize?response_type=code";
        $client_id = "&client_id=".env('CLIENT_ID', false);
        $redirect_uri ="&redirect_uri=http://localhost/home&state=";
        $scope="&scope=openid%20profile&nonce=";
        
        
        return redirect($uri.$client_id.$redirect_uri.$state.$scope.$nonce);

        
    }
}
