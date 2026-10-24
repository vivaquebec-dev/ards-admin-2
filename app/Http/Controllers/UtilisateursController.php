<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\User;
use App\UserType;
use Illuminate\Support\Facades\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

use Carbon;
use Auth;

class UtilisateursController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $utilisateurs = User::all();

		if (Auth::user()->id_type_usager ==1) {
			 return view('utilisateurs.index', compact('utilisateurs'));
		} else {
			return redirect('/');
		}
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $user_types = UserType::all();

		if (Auth::user()->id_type_usager ==1) {
			 return view('utilisateurs.create', compact('user_types'));
		} else {
			return redirect('/');
		}
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $rules = [
            'nom' => 'required',
            'prenom' => 'required',
            'nom_utilisateur' => 'required|unique:users,email',
            'mot_de_passe' => 'required',
            'ddlTypeUsager' => 'required',
        ];


        $input = Request::all();
        
        $validator = Validator::make($input, $rules);

        if ($validator->fails()) {
            return redirect()
                ->back()
                ->withErrors($validator)
                ->withInput();
        }

        $data = array(
            'nom' => $input['nom'],
            'prenom' => $input['prenom'],
            'email' => $input['nom_utilisateur'],
            'password' => bcrypt($input['mot_de_passe']),
            'id_type_usager' => $input['ddlTypeUsager'],
            'est_actif' => $input['ddlEstActif'],
        );

        $i = DB::table('users')->insert($data);

        if ($i > 0)
        {
            return redirect('utilisateurs');
        }

    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $utilisateur = User::findOrFail($id);
        $user_types = UserType::all();

		if (Auth::user()->id_type_usager ==1) {
			return view('utilisateurs.show', compact('utilisateur', 'user_types'));
		} else {
			return redirect('/');
		}
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {

    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $input = Request::all();
        
        $user = User::find($id);
        $user->nom = $input['nom'];
        $user->prenom = $input['prenom'];
        $user->email = $input['nom_utilisateur'];

        if ($input['mot_de_passe'] != "") {
            $user->password = bcrypt($input['mot_de_passe']);
        }
        
        $user->id_type_usager = $input['ddlTypeUsager'];
        $user->est_actif = $input['ddlEstActif'];

        $user->save();

        //Session::flash('message', 'Utilisateur mis à jour avec succcès');

        return redirect('utilisateurs');
    }

    public function updatePassword(Request $request, $id)
    {
        $input = Request::all();
        $user = User::find($id);
        $user->password = bcrypt($input['mot_de_passe']);
        $user->updated_at = Carbon\Carbon::now();

        $user->save();

        return redirect('/');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
		if (Auth::user()->id_type_usager ==1) {
        	$user = User::find($id);
        	$user->delete();
		}

        return redirect('utilisateurs');
    }
}
