<?php
namespace App\Http\Controllers;


class LogsController extends Controller
{

    public function index(){
        return view('logs');
    }
}