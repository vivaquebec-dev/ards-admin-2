<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Licence;
use App\User;
use Auth;
use Illuminate\Support\Facades\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Validator;

class LicencesCommissionController extends Controller
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

		if (Auth::user()->id_type_usager ==3) {
        	return view('licences_commission.index', compact('licences'));
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

		if (Auth::user()->id_type_usager ==3) {
        	return view('licences_commission.create', compact('licence', 'availableLicences'));
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
            'type_licence' => 'required',
            'nom_organisation' => 'required',
            'nom' => 'required',
            'prenom' => 'required',
            'courriel' => 'required',
            'nombre_licences' => 'required',
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
            'id_type_licence' => $input['type_licence'],
            'master_id_licence' => Auth::user()->id_licence,
            'nom_organisation' => $input['nom_organisation'],
            'lien_description' => $input['lien_organisation'],
            'nom_contact' => $input['nom'],
            'prenom_contact' => $input['prenom'],
            'nombre_licence' => $input['nombre_licences'],
            'courriel' => $input['courriel'],
        );

        $licence_id = DB::table('licences')->insertGetId($data);
        if ($licence_id > 0)
        {
            $dataUser = array(
                'nom' => $input['nom'],
                'prenom' => $input['prenom'],
                'email' => $input['nom_utilisateur'],
                'password' => bcrypt($input['mot_de_passe']),
                'id_type_usager' => $input['type_licence'],
                'id_licence' => $licence_id,
            );

            $user_id = DB::table('users')->insertGetId($dataUser);

            if ($user_id > 0)
            {
                $input = Request::all();
                $licence = Licence::find($licence_id);

                $licence->id_usager = $user_id;

                $licence->save();

                $dataEmail = array(
                    'nom_utilisateur' => $input['nom_utilisateur'],
                    'mot_de_passe' => $input['mot_de_passe'],
                    'nombre_licence' => $input['nombre_licences'],
                    'courriel' => $input['courriel'],
                    'prenom' => $input['prenom'],
                    'type_licence' => $input['type_licence'],
                );

                $sent = Mail::send('email.bienvenue_commission', $dataEmail, function($message)  use ($data){
                    $message->from('info@auroyaumedessons.com');
                    $message->to($data['courriel'])->subject('Confirmation de votre achat - Au Royaume des sons');
                });

                return redirect('licences_commission');
            }
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

		if (Auth::user()->id_type_usager ==3) {
        	return view('licences_commission.show', compact('licence', 'availableLicences'));
		} else {
			return redirect('/');
		}
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
        $user = User::find($input['id_usager']);
        
        if ($input['mot_de_passe'] != "") {
            $user->password = bcrypt($input['mot_de_passe']);
        }

        $user->save();

        return redirect('licences_commission');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
		if (Auth::user()->id_type_usager ==3) {
        	$licence = Licence::find($id);
        	$licence->delete();
		}

        return redirect('licences_commission');
    }
}

