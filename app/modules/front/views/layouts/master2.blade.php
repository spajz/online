<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>Ikea</title>

    <link rel="stylesheet" href="{{ url('packages/module/front/assets/css/bootstrap.min.css') }}"/>
    <link rel="stylesheet" href="{{ url('packages/module/front/assets/css/jquery.bxslider.css') }}"/>

    @section('scripts_top')
    @show

    <link rel="stylesheet" href="{{ url('packages/module/front/assets/css/added.css') }}"/>

    <!-- IE10 viewport hack for Surface/desktop Windows 8 bug -->
    <script src="{{ url('packages/module/front/assets/js/ie10-viewport-bug-workaround.js') }}"></script>

    <!-- HTML5 shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
    <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->
</head>

<body>

<div class="container">
    <div class="row">
        <div class="col-md-12 column pad-tb10 clearfix">
            <img src="{{ front_asset('img/ikea-logo.gif') }}" class="pull-left"/>
            <span class="pull-right sub-title">
                Welcome to My IKEA!
            </span>
        </div>
    </div>
</div>

<!-- Static navbar -->
<div class="navbar navbar-default navbar-static-top main-menu" role="navigation">
    <div class="container">
        <div class="navbar-header">
            <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
                <span class="sr-only">Toggle navigation</span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </button>
        </div>
        <div class="navbar-collapse collapse">
            <ul class="nav navbar-nav">
                <li {{ active_url(route('home')) }}>
                    <a href="{{ route('home') }}">Home</a>
                </li>
                <li {{ active_url(route('page.show', 'about-my-ikea')) }}>
                    <a href="{{ route('page.show', 'about-my-ikea') }}">About My IKEA</a>
                </li>
                <li>
                    <a href="#">Match The Color</a>
                </li>
                <li {{ active_url(route('blog.index'), true) }}>
                    <a href="{{ route('blog.index') }}">Inspiration</a>
                </li>
                <li {{ active_url(route('game.index'), true) }}>
                    <a href="{{ route('game.index') }}">Kid's Corner</a>
                </li>
                <li>
                    <a href="#">Eco Quiz</a>
                </li>
                <li {{ active_url(route('page.show', 'ask-us')) }}>
                    <a href="{{ route('page.show', 'ask-us') }}">Ask Us</a>
                </li>
                <li {{ active_url(route('page.show', 'whats-new')) }}>
                    <a href="{{ route('page.show', 'whats-new') }}">What's New</a>
                </li>
            </ul>
            <ul class="nav navbar-nav navbar-right">
                <li><a href="#">IKEA.hr</a></li>
            </ul>
        </div>
        <!--/.nav-collapse -->
    </div>
</div>

{{ $content or '' }}

<script src="{{ url('packages/module/front/assets/js/jquery-1.11.1.min.js') }}"></script>
<script src="{{ url('packages/module/front/assets/js/bootstrap.min.js') }}"></script>
<script src="{{ url('packages/module/front/assets/js/jquery.bxslider.min.js') }}"></script>
<script src="{{ url('packages/module/front/assets/js/added.js') }}"></script>

@section('scripts_bottom')
@show

</body>
</html>
