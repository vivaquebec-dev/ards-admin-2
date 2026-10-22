<?php



namespace App\Http\Controllers;



//use Illuminate\Http\Request;



use App\Http\Requests;

use App\Http\Controllers\Controller;

use App\Licence;

use Illuminate\Support\Facades\Request;

use Illuminate\Support\Facades\DB;

use Illuminate\Support\Facades\Mail;



class suiviEmailController extends Controller

{

	public function send($id)

	{

		if ($id=='8e4665de5100f123af9e7f02e9c36bb7') {	

			$licences = DB::table('licences')

			->select('courriel')

			->whereRaw('date_achat_licence = DATE_ADD(CURDATE(), INTERVAL -14 DAY)')

			->get();

			

			/*

			echo $licences[0]->courriel;

			var_dump($licences);

			*/

			

			$data = array();

			$x = [];

			

			foreach($licences as $key=>$lic) {

				$data = array('courriel'=>$lic->courriel);

				//echo $data['courriel'].'<br>';

				
				Mail::send('email.suivi', $data, function ($message) use($data) {
					$message->from('info@auroyaumedessons.com', 'Au Royaume des Sons');
					$message->to($data['courriel'])->subject('Service après ventes');
				});

				

			}

		}

		

    }

}

