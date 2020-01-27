<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Task;
use GuzzleHttp\Client;

class SessionController extends Controller
{

    public function index(Request $request)
    {
        session_start();

        if(!isset($_SESSION["count1"])){
	       $rec = "初回表示時";
	       $_SESSION["count1"]=1;

        }else{
	       $rec = $_SESSION["count1"]++;
        }
    
        return $rec;
    }
    
}
