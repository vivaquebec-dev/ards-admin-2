<?php

namespace App\Exceptions;

use Throwable;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Symfony\Component\HttpKernel\Exception\HttpException;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;

class Handler extends ExceptionHandler
{
    /**
     * A list of the exception types that should not be reported.
     *
     * @var array
     */
    protected $dontReport = [
        ModelNotFoundException::class,
    ];

    /**
     * Report or log an exception.
     *
     * This is a great spot to send exceptions to Sentry, Bugsnag, etc.
     *
     * @param  \Exception  $e
     * @return void
     */
    public function report(Throwable $e)
    {
        return parent::report($e);
    }

    /**
     * Render an exception into an HTTP response.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Exception  $e
     * @return \Illuminate\Http\Response
     */
    public function render($request, Throwable $e)
    {
        //var_dump($e); exit;
        if ($e instanceof ModelNotFoundException) {
            $e = new NotFoundHttpException($e->getMessage(), $e);
        }
		/*
		if  (isset($e->errorInfo) && $e->errorInfo[1]==1062) {
			//echo $e->errorInfo[1];
			echo '<p>Veuillez entrer un autre <b>Nom d\'utilisateur</b> car celui entré existe déjà.</p>';
			echo '<p>Vous pouvez ajouter une lettre ou un nombre à côté du nom d\'utilisateur que vous avez choisi.<br>Exemple : Nom d\'utilisateur: simon12 / Mot de passe: 12<br>* Le mot de passe peut être le même pour tous les élèves.</p>';
			echo '<button onclick="history.go(-1);">Retour </button>';
			
			exit;
			//return redirect('licences_prof/create?erreur=username');
		}
		*/
        return parent::render($request, $e);
    }
}
/*

*/
