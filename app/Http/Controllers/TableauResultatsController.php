<?php



namespace App\Http\Controllers;



use App\Http\Requests;

use App\Http\Controllers\Controller;

use App\Licence;

use App\Resultat;

use App\User;

use App\Eleve;

use App\Activite;

use App\ActiviteTheme;

use Illuminate\Support\Facades\Request;

use Illuminate\Support\Facades\DB;

use Auth;

class TableauResultatsController extends Controller
{
    public function index()
    {
		DB::disableQueryLog();

        $activitesThemes = ActiviteTheme::where('NOM_THEMES','<>','FIN')
            ->join('activites', 'activites_themes.ID_THEMES', '=', 'activites.ID_THEMES')
            ->groupBy('activites.ID_THEMES')
            ->get(['activites.*', 'activites_themes.*', DB::raw('count(activites.ID_THEMES) as items')]);

        $activites = Activite::where('PREFIXE_ACTIVITES','<>','fn1')->get();

        $eleves = User::where('id_licence', Auth::user()->id_licence)
            ->where('id_type_usager', 6)
            ->orderBy('nom', 'asc')
            ->get();

        $resultats = DB::table('resultats')
			->join('users', function ($users) {
				$users->on('users.id_usager', '=', 'resultats.id_usager')
				->where('users.id_licence', '=', Auth::user()->id_licence);
			})
            ->join('activites', 'activites.ID_ACTIVITES', '=', 'resultats.ID_ACTIVITES')
            ->orderBy('resultats.ID_ACTIVITES', 'ASC')
            ->orderBy('resultats.created_at', 'DESC')
            ->get(['activites.*', 'resultats.*', 'users.*']);

        $resultatsASC = DB::table('resultats')
			->join('users', function ($users) {
				$users->on('users.id_usager', '=', 'resultats.id_usager')
				->where('users.id_licence', '=', Auth::user()->id_licence);
			})
            ->join('activites', 'activites.ID_ACTIVITES', '=', 'resultats.ID_ACTIVITES')
            ->orderBy('resultats.ID_ACTIVITES', 'ASC')
            ->orderBy('resultats.created_at', 'ASC')
            ->get(['activites.*', 'resultats.*', 'users.*']);

        return view('tableau_resultats.index', compact('activitesThemes', 'activites', 'eleves', 'resultats', 'resultatsASC'));
    }


    public function test()

    {

		DB::disableQueryLog();

        //$utilisateurs = User::all();

		

        $activitesThemes = DB::table('activites_themes')

            ->join('activites', 'activites_themes.ID_THEMES', '=', 'activites.ID_THEMES')

            ->groupBy('activites.ID_THEMES')

            ->get(['activites.*', 'activites_themes.*', DB::raw('count(activites.ID_THEMES) as items')]);



        $activites = Activite::all();



        $eleves = User::where('id_licence', Auth::user()->id_licence)

            ->where('id_type_usager', 6)

            ->orderBy('nom', 'asc')

            ->get();



        $resultats = DB::table('resultats')

			->join('users', function ($users) {

				$users->on('users.id_usager', '=', 'resultats.id_usager')

				->where('users.id_licence', '=', Auth::user()->id_licence);

			})

            ->join('activites', 'activites.ID_ACTIVITES', '=', 'resultats.ID_ACTIVITES')

            ->orderBy('resultats.ID_ACTIVITES', 'ASC')

            //->orderBy('resultats.resultat', 'DESC')

            ->orderBy('resultats.created_at', 'DESC')

            ->get(['activites.*', 'resultats.*', 'users.*']);

		

        $resultatsASC = DB::table('resultats')

			->join('users', function ($users) {

				$users->on('users.id_usager', '=', 'resultats.id_usager')

				->where('users.id_licence', '=', Auth::user()->id_licence);

			})

            ->join('activites', 'activites.ID_ACTIVITES', '=', 'resultats.ID_ACTIVITES')

            ->orderBy('resultats.ID_ACTIVITES', 'ASC')

            //->orderBy('resultats.resultat', 'DESC')

            ->orderBy('resultats.created_at', 'ASC')

            ->get(['activites.*', 'resultats.*', 'users.*']);

			

        //return $resultats;



        //return view('tableau_resultats.index', compact('utilisateurs'));

        return view('tableau_resultats.test', compact('activitesThemes', 'activites', 'eleves', 'resultats', 'resultatsASC'));

    }

	

	

	



    public function show($id, $id_activite)

    {

        $activite = Activite::where('ID_ACTIVITES', $id_activite)

            ->first();



        $resultats = Resultat::where('ID_ACTIVITES', $id_activite)

            ->where('id_usager', $id)

            //->orderBy('resultat', 'asc')

			->orderBy('created_at', 'asc')

            ->get();



        $utilisateur = User::where('id_usager', $id)

            ->first();





        return view('tableau_resultats.show', compact('activite', 'resultats', 'utilisateur'));

    }

	



    public function bytheme($id_theme)

    {

		DB::disableQueryLog();

		

        $activitesThemes = ActiviteTheme::where('ID_THEMES', $id_theme)->first();

		

        $activites = Activite::where('ID_THEMES', $id_theme)->get();

		

        $eleves = User::where('id_licence', Auth::user()->id_licence)

            ->where('id_type_usager', 6)

            ->orderBy('nom', 'asc')

            ->get();



        $resultats = DB::table('resultats')

			->join('users', function ($users) {

				$users->on('users.id_usager', '=', 'resultats.id_usager')

				->where('users.id_licence', '=', Auth::user()->id_licence);

			})

            ->join('activites', 'activites.ID_ACTIVITES', '=', 'resultats.ID_ACTIVITES')

            ->orderBy('resultats.ID_ACTIVITES', 'ASC')

            ->orderBy('resultats.created_at', 'DESC')

            ->get(['activites.*', 'resultats.*', 'users.*']);

		

        $resultatsASC = DB::table('resultats')

			->join('users', function ($users) {

				$users->on('users.id_usager', '=', 'resultats.id_usager')

				->where('users.id_licence', '=', Auth::user()->id_licence);

			})

            ->join('activites', 'activites.ID_ACTIVITES', '=', 'resultats.ID_ACTIVITES')

            ->orderBy('resultats.ID_ACTIVITES', 'ASC')

            ->orderBy('resultats.created_at', 'ASC')

            ->get(['activites.*', 'resultats.*', 'users.*']);

		/*

		*/

        return view('tableau_resultats.bytheme', compact('activitesThemes', 'activites', 'eleves', 'resultats', 'resultatsASC'));

		

    }

}

