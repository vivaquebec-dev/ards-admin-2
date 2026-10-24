<?php

namespace App\Http\Controllers;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Licence;
use App\User;
use Auth;
use Illuminate\Support\Facades\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Validator;

class LicencesEcoleController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $licences = Licence::where('master_id_licence', Auth::user()->id_licence)
            ->orderBy('nom_organisation', 'desc')
            ->get();

		if (Auth::user()->id_type_usager ==4) {
        	return view('licences_ecole.index', compact('licences'));
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
        $licence = Licence::where('id_licence', Auth::user()->id_licence)
            ->orderBy('nom_organisation', 'desc')
            ->first();

        $assignedLicences = Licence::where('master_id_licence', Auth::user()->id_licence)
            ->sum('nombre_licence');

        $availableLicences = $licence['nombre_licence'] - $assignedLicences;

		if (Auth::user()->id_type_usager ==4) {
        	return view('licences_ecole.create', compact('licence', 'availableLicences'));
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
            'nombre_licences' => 'required',
            'courriel' => 'required',
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

		// Ecriture dans la table users
		$dataUser = array(
			'nom' => $input['nom'],
            'prenom' => $input['prenom'],
            'email' => $input['nom_utilisateur'],
            'password' => bcrypt($input['mot_de_passe']),
            'id_type_usager' => $input['type_licence'],
		);

		$user_id = DB::table('users')->insertGetId($dataUser);

		if ($user_id > 0) 
		{
			$licence = DB::table('licences')->where('id_usager', Auth::user()->id_usager)->first();
			$nom_organisation = $licence->nom_organisation;

			$data = array(
				'id_type_licence' => $input['type_licence'],
				'master_id_licence' => Auth::user()->id_licence,
				'nom_organisation' => $nom_organisation,
				'id_usager' => $user_id,
				'lien_description' => $input['lien_organisation'],
				'nom_contact' => $input['nom'],
				'prenom_contact' => $input['prenom'],
				'nombre_licence' => $input['nombre_licences'],
				'courriel' => $input['courriel'],
			);

			$licence_id = DB::table('licences')->insertGetId($data);

			if ($licence_id > 0) 
			{
                $user = User::find($user_id);
                $user->id_licence = $licence_id;

                $user->save();

				$dataEmail = array(
                    'nom_utilisateur' => $input['nom_utilisateur'],
                    'mot_de_passe' => $input['mot_de_passe'],
                    'nombre_licence' => $input['nombre_licences'],
                    'courriel' => $input['courriel'],
                    'prenom' => $input['prenom'],
                    'type_licence' => $input['type_licence'],
                );

                $sent = Mail::send('email.bienvenue_commission', $dataEmail, function($message)  use ($data) {
                    $message->from('info@auroyaumedessons.com', 'Au Royaume des Sons');
					$message->attach('http://administration.auroyaumedessons.com/docs/guide-utilisateur.pdf');
                    $message->to($data['courriel'])->subject('Confirmation de votre achat - Au Royaume des sons');
                });
			}
		}

		return redirect('licences_ecole');
    }



    /**

     * Display the specified resource.

     *

     * @param  int  $id

     * @return \Illuminate\Http\Response

     */

    public function show($id)

    {



        $licence = DB::table('licences')

            ->join('users', 'users.id_usager', '=', 'licences.id_usager')

            ->where('licences.id_licence', '=', $id)

            ->select('licences.*', 'users.*')

            ->first();



        $licenceInfo = Licence::where('id_licence', Auth::user()->id_licence)

            ->orderBy('nom_organisation', 'desc')

            ->first();



        $assignedLicences = Licence::where('master_id_licence', Auth::user()->id_licence)

            ->sum('nombre_licence');



        $availableLicences = $licenceInfo['nombre_licence'] - $assignedLicences;



		if (Auth::user()->id_type_usager ==4) {

        	return view('licences_ecole.show', compact('licence', 'availableLicences'));

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

        //

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



        // store

        $licence = Licence::find($id);

        $licence->lien_description = $input['lien_organisation'];

        $licence->nombre_licence = $input['nombre_licence'];

        $licence->nom_contact = $input['nom'];

        $licence->prenom_contact = $input['prenom'];

        $licence->courriel = $input['courriel'];





        $licence->save();



        $user = User::find($input['id_usager']);

        $user->nom = $input['nom'];

        $user->prenom = $input['prenom'];

        $user->email = $input['nom_utilisateur'];

        if (!empty($input['mot_de_passe'])) {
            $user->password = bcrypt($input['mot_de_passe']);
        }



        $user->save();



        return redirect('licences_ecole');

    }



    /**

     * Remove the specified resource from storage.

     *

     * @param  int  $id

     * @return \Illuminate\Http\Response

     */

    public function destroy($id)

    {

		

		if (Auth::user()->id_type_usager ==4) {

        	$licence = Licence::find($id);

        	$licence->delete();

		}

        return redirect('licences_ecole');

    }

}

