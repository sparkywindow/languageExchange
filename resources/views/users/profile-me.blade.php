
@extends('layouts.app')

@section('content')

<!-- Tab menus -->
<ul class="nav nav-tabs">
    <li><a href="/users/list">사람들</a></li>
    <li><a href="/posts/list">공부합시다</a></li>
    <li class="active"><a href="#">개인설정</a></li>
</ul>

<div class="tab-content" align="center">
    <div id="menu2" class="tab-pane fade in active">
        <div class="container">
            <div class="panel panel-primary">
                <div class="panel-body">
                    <img src= {{ $user->getProfilePictureUrl() }} class="img-thumbnail" alt="Cinque Terre" height="200" width="200">

                    @if (count($errors) > 0)
                        <div class="alert alert-danger">
                            <strong>Whoops!</strong> There were some problems with your input.
                            <ul>
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    @if ($message = Session::get('success'))
                        <div class="alert alert-success alert-block">
                            <button type="button" class="close" data-dismiss="alert">×</button>
                                <strong>{{ $message }}</strong>
                        </div>
                    @endif

                    {!! Form::open(['route' => 'users.update']) !!}

                        <h1>{!! $user->name !!}</h1> <br>
                        
                        Native Language : {{ Form::select('nativeLanguage', $user->languageList(), $user->nativeLanguage, ['class' => 'form-control m-bot15']) }} <br>
                        Learning Language : {{ Form::select('learningLanguage', $user->languageList(), $user->learningLanguage, ['class' => 'form-control m-bot15']) }} <br>
                        City : {{ Form::select('city', $user->cityList(), $user->city, ['class' => 'form-control m-bot15']) }} <br>

                       
                        {!! Form::submit('update') !!}
                        
                    {!! Form::close() !!}
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

