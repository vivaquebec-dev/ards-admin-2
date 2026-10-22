<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use Auth;
use App\Http\Controllers\Controller;

class WelcomeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

        //return Auth::user()->updated_at;



        if (Auth::user()->updated_at == '0000-00-00 00:00:00' || Auth::user()->updated_at == '-0001-11-30 00:00:00' ) {
            return view('auth.resetpassword');
        }
        else{
            return view('index');
        }


    }


}
