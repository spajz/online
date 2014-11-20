<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>Spajz</title>

    <!-- Bootstrap core CSS -->
    <link rel="stylesheet" href="{{ url('packages/module/front/assets/css/bootstrap.min.css') }}"/>
    <link rel="stylesheet" href="{{ url('packages/module/front/assets/css/added.css') }}"/>

    @section('scripts_top')
    @show

    <!-- IE10 viewport hack for Surface/desktop Windows 8 bug -->
    <script src="{{ url('packages/module/front/assets/js/ie10-viewport-bug-workaround.js') }}"></script>

    <!-- HTML5 shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
    <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->
</head>

<body>

<!-- Fixed navbar -->
<div class="navbar navbar-default navbar-fixed-top" role="navigation">
    <div class="container">
        <div class="navbar-header">
            <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
                <span class="sr-only">Toggle navigation</span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </button>
            <a class="navbar-brand" href="#">Spajz</a>
        </div>
        <div class="navbar-collapse collapse">
            <ul class="nav navbar-nav">
                <li class="active"><a href="#">Home</a></li>
                <li><a href="#about">About</a></li>
                <li><a href="#contact">Contact</a></li>
                <li class="dropdown">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown">Dropdown <span class="caret"></span></a>
                    <ul class="dropdown-menu" role="menu">
                        <li><a href="#">Action</a></li>
                        <li><a href="#">Another action</a></li>
                        <li><a href="#">Something else here</a></li>
                        <li class="divider"></li>
                        <li class="dropdown-header">Nav header</li>
                        <li><a href="#">Separated link</a></li>
                        <li><a href="#">One more separated link</a></li>
                    </ul>
                </li>
            </ul>
            <?php /*
            <ul class="nav navbar-nav navbar-right">
                <li><a href="../navbar/">Default</a></li>
                <li><a href="../navbar-static-top/">Static top</a></li>
                <li class="active"><a href="./">Fixed top</a></li>
            </ul>
            */ ?>
        </div>
        <!--/.nav-collapse -->
    </div>
</div>

<div class="container">

    {{ $content or '' }}


</div>
<!-- /container -->

<script src="{{ url('packages/module/front/assets/js/jquery-1.11.1.min.js') }}"></script>
<script src="{{ url('packages/module/front/assets/js/bootstrap.min.js') }}"></script>
<script src="{{ url('packages/module/front/assets/js/ZeroClipboard.js') }}"></script>
<script src="{{ url('packages/module/front/assets/js/added.js') }}"></script>

@section('scripts_bottom')
<script type="text/javascript">
    ZeroClipboard.config( { swfPath: '{{ url('packages/module/front/assets/js/ZeroClipboard.swf') }}' } );
</script>
@show

</body>
</html>
