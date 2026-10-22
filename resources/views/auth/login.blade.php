@extends('layouts.master')

@section('content')
    <div class="container">
        <div class="row justify-content-center align-item-center">
            <div class="col-md-8 col-lg-7">
                <div class="card">
                    <div class="card-header">
                    Identification
                    </div>
                    <div class="card-body">
                        @if (count($errors) > 0)
                        <div class="alert alert-danger">
                            <strong>Oups!</strong>
                            <ul>
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                        @endif
                        <form method="POST" action="/auth/login">
                            <input type="hidden" name="_token" value="{{ csrf_token() }}">
                            <div class="form-group">
                                <label for="email" >Nom d'usager</label>
                                <input type="text" class="form-control" name="email" id="email" value="{{ old('email') }}">
                            </div>
                            <div class="form-group">
                                <label for="password" >Mot de passe</label>
                                <input type="password" class="form-control" name="password" id="password">
                            </div>
                            <div class="form-group">
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" id="optin" name="optin">
                                    <label class="form-check-label" for="optin">
                                        Cochez cette case pour indiquer que vous avez lu et accepté les <a href="https://auroyaumedessons.com/conditionsutilisation.html" target="_blank">conditions d'utilisation</a> et la  <a href="https://auroyaumedessons.com/politique-confidentialite-produit.html" target="_blank">politique de confidentialité</a>.
                                    </label>
                                </div>
                            </div>
                            <div class="form-group">
                                <button type="submit" class="btn btn-primary" style="margin-right: 15px;">
                                    Se connecter
                                </button>
                                <!--<a href="/password/email">Forgot Your Password?</a>-->
                            </div>
                            <div class="form-group">
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" id="remember" name="remember">
                                    <label class="form-check-label" for="remember"> Se souvenir de moi</label>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection