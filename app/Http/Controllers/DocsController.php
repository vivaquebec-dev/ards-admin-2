<?php



namespace App\Http\Controllers;



use Illuminate\Http\Request;



use App\Http\Requests;

use Auth;

use App\Http\Controllers\Controller;



class DocsController extends Controller

{
    public function index()
    {
        return view('docs-a-imprimer.index');

    }
}

