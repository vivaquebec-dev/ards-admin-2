@extends('layouts.master')

@section('content')
    <div class="container-fluid">
        <div class="row">

            <div class="col-md-8 col-md-offset-2">
                <div class="panel panel-default">
                    <div class="panel-heading">Modifier votre mot de passe</div>
                    <div class="panel-body">

                        @if (count($errors) > 0)
                            <div class="alert alert-danger">
                                <strong>Oups!</strong><br><br>
                                <ul>
                                    @foreach ($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif

                        <form class="form-horizontal" role="form" method="POST" action="/utilisateurs/updatepassword/{{ Auth::user()->id_usager }}">
                            <input type="hidden" name="_token" value="{{ csrf_token() }}">

                            <div class="form-group">
                                <div class="col-md-10">
                                    Vous pouvez modifier le mot de passe qui vous a été transmis.
                                </div>

                            </div>


                            <div class="form-group">
                                <label class="col-md-4 control-label">Mot de passe</label>
                                <div class="col-md-6">
                                    <input type="text" class="form-control" name="mot_de_passe">
                                </div>
                            </div>

                            <div class="form-group">
                                <div class="col-md-6 col-md-offset-4">
                                    <button type="submit" class="btn btn-primary" style="margin-right: 15px;">
                                        Modifier
                                    </button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>

        </div>
    </div>

@endsection