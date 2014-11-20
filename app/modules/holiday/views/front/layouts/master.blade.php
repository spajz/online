<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="description" content="BKT Holiday">
    <title>BKT Holiday</title>
    <link rel="stylesheet" href="{{ url('packages/module/holiday/assets/css/bootstrap.min.css') }}"/>
    <link rel="stylesheet" href="{{ url('packages/module/holiday/assets/css/bootstrap-theme.min.css') }}"/>
    <link rel="stylesheet" href="{{ url('packages/module/holiday/assets/css/added.css') }}"/>
    @section('scripts_top')
    @show
    <script src="{{ url('packages/module/front/assets/js/ie10-viewport-bug-workaround.js') }}"></script>
    <!-- HTML5 shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
    <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->
</head>
<body>
<div id="info-box">{{ Notification::showAll() }}</div>
{{ $content or ''}}

<script src="<?= url('packages/module/holiday/assets/js/jquery-1.11.1.min.js') ?>"></script>
<script src="<?= url('packages/module/holiday/assets/js/bootstrap.min.js') ?>"></script>
<script src="<?= url('packages/module/holiday/assets/js/i18n/sq.js') ?>"></script>
<script src="<?= url('packages/module/holiday/assets/js/parsley.js') ?>"></script>
<script src="<?= url('packages/module/holiday/assets/js/added.js') ?>"></script>

@section('scripts_bottom')
@show

</body>
</html>
