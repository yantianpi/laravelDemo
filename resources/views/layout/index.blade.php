<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
@include('common.header')
<body>
    <nav class="navbar navbar-default">
        <div class="container-fluid">
            {{-- Brand and toggle get grouped for better mobile display --}}
            <div class="navbar-header">
                <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1" aria-expanded="false">
                    <span class="sr-only">Toggle navigation</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>
                <a class="navbar-brand" href="">brand</a>
            </div>
            {{-- Collect the nav links, forms, and other content for toggling --}}
            <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
                <ul class="nav navbar-nav navbar-right">
                    <li class="dropdown">
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">
                            peteryan <span class="caret"></span>
                        </a>
                        <ul class="dropdown-menu">
                            <li><a href="#">Action</a></li>
                            <li><a href="#">Another action</a></li>
                            <li><a href="#">Something else here</a></li>
                            <li role="separator" class="divider"></li>
                            <li><a href="#">Separated link</a></li>
                        </ul>
                    </li>
                </ul>
            </div>{{-- /.navbar-collapse --}}
        </div>{{-- /.container-fluid --}}
    </nav>
    <main class="container-fluid">
        <div class="row">
            <div class="col-xs-4">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        <h3 class="panel-title">Navigation</h3>
                    </div>
                    <div class="list-group">
                        <a class="list-group-item" href="{{ route('homepage') }}" aria-expanded="false" aria-controls="collapse_1">
                            home
                        </a>
                        <a class="list-group-item" href="{{ route('categorypage') }}" aria-expanded="false" aria-controls="collapse_2">
                            category
                        </a>
                        <a class="list-group-item" href="{{ route('projectpage') }}" aria-expanded="false" aria-controls="collapse_2">
                            project
                        </a>
                        <a class="list-group-item" href="{{ route('attributepage') }}" aria-expanded="false" aria-controls="collapse_2">
                            attribute
                        </a>
                        <a class="list-group-item" href="{{ route('taskpage') }}" aria-expanded="false" aria-controls="collapse_2">
                            task
                        </a>
                        <a class="list-group-item" href="{{ route('mailpage') }}" aria-controls="collapse_1">
                            mail
                        </a>
                        <a class="list-group-item" href="{{ route('logpage') }}" aria-controls="collapse_1">
                            log
                        </a>
                    </div>
                </div>
            </div>
            <div class="col-xs-20">
                @section('pageContent')
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            <h3 class="panel-title">
                                {{ $pageName or 'Home' }}
                            </h3>
                        </div>
                        <div class="panel-body">
                            @section('pageContentDetail')
                                welcome!
                            @show
                        </div>
                    </div>
                @show
            </div>
        </div>
    </main>
    @include('common.footer')
</body>
</html>
