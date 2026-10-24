<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Licence;
use App\User;
use Illuminate\Support\Facades\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Validator;

use Auth;

class LicencesController extends Controller
{

	private $cyberImpactToken;

    public function __construct()
    {
        $this->cyberImpactToken = config('services.cyberimpact.token');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

        $licences = Licence::all();
		
		if (isset($_GET['sort'])) {
			if (!isset($_GET['order'])) {
				$ordre = "asc";
			} else {
				$ordre = $_GET['order'];
			}

			if ($_GET['sort']=="org") {
        		$licences = Licence::orderBy('nom_organisation', $ordre)->orderBy('id_licence', "asc")->get();
			} elseif ($_GET['sort']=="nom") {
        		$licences = Licence::orderBy('nom_contact', $ordre)->orderBy('id_licence', "asc")->get();
			}
		}

		if (Auth::user()->id_type_usager ==1) {
			return view('licences.index', compact('licences'));
		} else {
			return redirect('/');
		}
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Respons
     */
    public function create()
    {
		if (Auth::user()->id_type_usager ==1) {
			return view('licences.create');
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
            'nom' => 'required',
            'prenom' => 'required',
            'courriel' => 'required',
            'nombre_licences' => 'required',
            'date_achat_licence' => 'required',
            'date_expiration_licence' => 'required',
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
			'nom' => trim($input['nom']),
            'prenom' => trim($input['prenom']),
            'email' => trim($input['nom_utilisateur']),
            'password' => bcrypt(trim($input['mot_de_passe'])),
            'id_type_usager' => $input['type_licence'],
		);

		$user_id = DB::table('users')->insertGetId($dataUser);

		if ($user_id > 0) 
		{	
			$data = array(
				'id_type_licence' => $input['type_licence'],
				'nom_organisation' => trim($input['nom_organisation']),
				'id_usager' => $user_id,
				'lien_description' => trim($input['lien_organisation']),
				'nom_contact' => trim($input['nom']),
				'prenom_contact' => trim($input['prenom']),
				'nombre_licence' => trim($input['nombre_licences']),
				'date_achat_licence' => trim($input['date_achat_licence']),
				'date_expiration_licence' => trim($input['date_expiration_licence']),
				'courriel' => trim($input['courriel']),
				'mailchimp_actif' => 1,
			);

			$licence_id = DB::table('licences')->insertGetId($data);

			if ($licence_id > 0) 
			{
                // store
                $user = User::find($user_id);
                $user->id_licence = $licence_id;

                $user->save();

				$courriel = trim($input['courriel']);
				$dataEmail = array(
                    'nom_utilisateur' => trim($input['nom_utilisateur']),
                    'mot_de_passe' => trim($input['mot_de_passe']),
                    'nombre_licence' => trim($input['nombre_licences']),
                    'courriel' => $courriel,
                    'prenom' => trim($input['prenom']),
                    'type_licence' => $input['type_licence'],
                );

                Mail::send('email.bienvenue_commission', $dataEmail, function($message)  use ($data){
                    $message->from('info@auroyaumedessons.com', 'Au Royaume des Sons');
					$message->attach('https://administration.auroyaumedessons.com/docs/guide-utilisateur.pdf');
					$message->attach('https://administration.auroyaumedessons.com/docs/informations-a-savoir.pdf');
                    $message->to($data['courriel'])->subject('Confirmation de votre achat - Au Royaume des sons');
                });

				$ch = curl_init();

				curl_setopt($ch, CURLOPT_URL, "https://api.cyberimpact.com/members/{$courriel}/groups");
				curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
				curl_setopt($ch, CURLOPT_HEADER, FALSE);

				curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "PUT");

				curl_setopt($ch, CURLOPT_POSTFIELDS, '{
					"groups": "1"
				}');

				curl_setopt($ch, CURLOPT_HTTPHEADER, array(
  					"Content-Type: application/json",
					"Authorization: Bearer " . $this->cyberImpactToken
				));

				$response = curl_exec($ch);
				$httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
				curl_close($ch);
				
				if ($httpCode !== 200) {
					$this->addToCyberImpact($data);
				}
			}
		}

		return redirect('licences');
    }

	public function addToCyberImpact($data) {
		$cyberImpactData = [
			'email' => $data['courriel'],
			'groups' => "1",
			'firstname' => $data['prenom_contact'],
			'lastname' => $data['nom_contact'],
			'company' => $data['nom_organisation']
		];

		$ch = curl_init();

		curl_setopt($ch, CURLOPT_URL, "https://api.cyberimpact.com/members");
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
		curl_setopt($ch, CURLOPT_HEADER, FALSE);

		curl_setopt($ch, CURLOPT_POST, TRUE);

		curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($cyberImpactData));

		curl_setopt($ch, CURLOPT_HTTPHEADER, array(
			"Content-Type: application/json",
			"Authorization: Bearer " . $this->cyberImpactToken
		));

		$response = curl_exec($ch);
		$httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
		curl_close($ch);

		$data = json_decode($response, true);
		
        return redirect('licences');
	}

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $licences = DB::table('licences')
        ->join('users', 'users.id_usager', '=', 'licences.id_usager')
        ->where('licences.id_licence', '=', $id)
        ->select('licences.*', 'users.*')
        ->get();


		if (Auth::user()->id_type_usager ==1) {
			 return view('licences.show', compact('licences'));
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
        $licence = Licence::find($id);

        $licence->id_type_licence = $input['type_licence'];
        $licence->nom_organisation = trim($input['nom_organisation']);
        $licence->lien_description = $input['lien_organisation'];
        $licence->nombre_licence = trim($input['nombre_licences']);
        $licence->date_achat_licence = trim($input['date_achat_licence']);
        $licence->date_expiration_licence = trim($input['date_expiration_licence']);
        $licence->nom_contact = trim($input['nom']);
        $licence->prenom_contact = trim($input['prenom']);
        $licence->courriel = trim($input['courriel']);
        $licence->mailchimp_actif = 1;

        $licence->save();

        $user = User::find($input['id_usager']);
        $user->nom = trim($input['nom']);
        $user->prenom = trim($input['prenom']);
        $user->email = trim($input['nom_utilisateur']);

		$nomMDP = mb_strtolower(trim($input['nom']), 'UTF-8');
		$nomMDP = str_replace("'","",$nomMDP);

		$user->password = bcrypt($nomMDP);
        $user->id_type_usager = $input['type_licence'];

        $user->save();

		$courriel = trim($input['courriel']);

		$data = array(
			'nom_organisation' => trim($input['nom_organisation']),
			'nom_contact' => trim($input['nom']),
			'prenom_contact' => trim($input['prenom']),
			'courriel' => trim($input['courriel']),
		);

		$dataEmail = array(
            'nom_utilisateur' => trim($input['nom_utilisateur']),
            'mot_de_passe' => $nomMDP,
            'nombre_licence' => trim($input['nombre_licences']),
            'courriel' => $courriel,
            'prenom' => trim($input['prenom']),
            'type_licence' => $input['type_licence'],
        );

        Mail::send('email.bienvenue_commission', $dataEmail, function($message) use ($dataEmail) {
			$message->from('info@auroyaumedessons.com', 'Au Royaume des Sons');
			$message->attach('https://administration.auroyaumedessons.com/docs/guide-utilisateur.pdf');
			$message->to($dataEmail['courriel'])->subject('Confirmation de votre achat - Au Royaume des sons');
		});

		$ch = curl_init();

		curl_setopt($ch, CURLOPT_URL, "https://api.cyberimpact.com/members/{$courriel}/groups");
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
		curl_setopt($ch, CURLOPT_HEADER, FALSE);

		curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "PUT");

		curl_setopt($ch, CURLOPT_POSTFIELDS, '{
			"groups": "1"
		}');

		curl_setopt($ch, CURLOPT_HTTPHEADER, array(
  			"Content-Type: application/json",
			"Authorization: Bearer " . $this->cyberImpactToken
		));

		$response = curl_exec($ch);
		$httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
		curl_close($ch);
		
		if ($httpCode !== 200) {
			$this->addToCyberImpact($data);
		}

        return redirect('licences');
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
			$licence = Licence::find($id);
			$licence->delete();
		}

        return redirect('licences');
    }
}
