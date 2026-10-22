<?php

namespace App\Http\Controllers;
use App\User;
use Illuminate\Http\Request;
use Auth;

class projetRechercheController extends Controller {

   public function update(Request $request){
	   	$prefixe_activites = $request->prefixe_activites;
		$id_usager = Auth::user()->id_usager;
		
		$user = User::find($id_usager);
        $user->projetRechercheAct = $prefixe_activites;
        $user->save();
		
      	$response = array(
			'status' => 'success',
          	'prefixe_activites' => $prefixe_activites,
          	'id_usager' => $id_usager,
      	);
      	return response()->json($response); 
   }
}
