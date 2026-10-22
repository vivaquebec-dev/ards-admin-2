<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Licence;
use App\User;
use App\Eleve;
use App\activites;
use App\UserProgression;
use Illuminate\Support\Facades\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

use Auth;

class LicencesProfController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $users = User::where('id_licence', Auth::user()->id_licence)
        ->where('id_type_usager', 6)
        ->orderBy('nom', 'desc')
        ->get();

        $licence = Licence::where('id_usager', Auth::user()->id_usager)
        ->first();
        
        $assignedLicences = $users->count();
        $availableLicences = $licence['nombre_licence'] - $assignedLicences;

		return view('licences_prof.index', compact('users','availableLicences'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
		$availableLicences = $this->index()->availableLicences;

		if (Auth::user()->id_type_usager ==5) {
			if ($availableLicences > 0) {
				return view('licences_prof.create');
			} else {
        		return redirect('licences_prof');
			}
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
            'ddlSexe' => 'required',
            'nom_utilisateur' => 'required|unique:users,email',
            'mot_de_passe' => 'required',
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
            'id_licence' => Auth::user()->id_licence,
            'id_type_usager' => 6,
            'email' => $input['nom_utilisateur'],
            'password' => bcrypt($input['mot_de_passe'])
        );

        $user_id = DB::table('users')->insertGetId($data);

        if ($user_id > 0)
        {
            // Ecriture dans la table users
            $eleve = array(
                'id_usager' => $user_id,
                'sexe' => $input['ddlSexe']
            );

            DB::table('eleves')->insertGetId($eleve);

            return redirect('licences_prof');
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
        $users = DB::table('eleves')
            ->join('users', 'users.id_usager', '=', 'eleves.id_usager')
            ->where('users.id_usager', '=', $id)
            ->select('eleves.*', 'users.*')
            ->get();

		$activites = activites::all();

        return view('licences_prof.show', compact('users','activites'));
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

		if ($input['mot_de_passe'] != $user->password) {
        	$user->password = bcrypt($input['mot_de_passe']);
		}

		$user->projetRechercheAct = $input['activites'];

        $user->save();

		$up = UserProgression::find($id);

		if ($up) {
			$up->num_exercice_sel = 1;
			$up->nb_erreur_exercice_sel = 0;
			$up->save();
		}

        return redirect('licences_prof');
    }



    /**

     * Remove the specified resource from storage.

     *

     * @param  int  $id

     * @return \Illuminate\Http\Response

     */

    public function destroy($id)

    {

        $user = User::find($id);

        $user->delete();



        $eleve = Eleve::where('id_usager', $id);

        $eleve->delete();



        return redirect('licences_prof');

    }



}

