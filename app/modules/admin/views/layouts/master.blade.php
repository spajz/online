<!DOCTYPE html>
<html lang="en">
<head>
    <title>DiCMS</title>
    <meta charset="UTF-8"/>
    <meta name="viewport" content="width=device-width, initial-scale=1.0"/>

    <script type="text/javascript">
        var baseUrl = "{{ url('/') }}";
        var baseUrlAdmin = "{{ url('admin') }}";
        var adminAssets = "{{ admin_asset('') }}/";
    </script>

    <link rel="stylesheet" href="<?= url('packages/module/admin/assets/css/bootstrap.min.css') ?>"/>
    <link rel="stylesheet" href="<?= url('packages/module/admin/assets/css/font-awesome.css') ?>"/>
    <link rel="stylesheet" href="<?= url('packages/module/admin/assets/css/jquery-ui.css') ?>"/>
    <link rel="stylesheet" href="<?= url('packages/module/admin/assets/css/icheck/flat/blue.css') ?>"/>
    <link rel="stylesheet" href="<?= url('packages/module/admin/assets/css/select2.css') ?>"/>
    <link rel="stylesheet" href="<?= url('packages/module/admin/assets/css/unicorn.css') ?>"/>
    <link rel="stylesheet" href="<?= url('packages/module/admin/assets/css/dataTables.bootstrap.css') ?>"/>
    <link rel="stylesheet" href="<?= url('packages/module/admin/assets/css/fancybox/jquery.fancybox.css') ?>"/>
    <link rel="stylesheet" href="<?= url('packages/module/admin/assets/css/colpick.css') ?>"/>
    <link rel="stylesheet" href="<?= url('packages/module/admin/assets/css/skin-win8/ui.fancytree.min.css') ?>"/>
    <link rel="stylesheet" href="<?= url('packages/module/admin/assets/css/bootstrap-tagsinput.css') ?>"/>

    <link rel="stylesheet" href="<?= url('packages/module/admin/assets/css/added.css') ?>"/>
</head>
<body data-color="grey" class="flat">
<div id="info-box">{{ Notification::showAll() }}</div>

<div id="loader-box">
    <img src="{{ admin_asset('img/loader.gif') }}" class="ajax-loader"/>
</div>

<div id="wrapper">

    <div id="header">
        <h1><a href="index.html">ACMS</a></h1>
        <a id="menu-trigger" href="#"><i class="fa fa-align-justify"></i></a>
    </div>

    <div id="user-nav">
        @section('user-nav')
        @include('admin::_partials.user-nav')
        @show
    </div>

    <div id="sidebar">
        <ul>
            <?php echo(implode('', Helper::Collector('menu'))); ?>
        </ul>
    </div>

    <div id="content">
        {{ $content or '' }}
    </div>

    <div class="row">
        <div id="footer" class="col-xs-12">
            2014 &copy; DiCMS Admin
        </div>
    </div>
</div>

<script src="<?= url('packages/module/admin/assets/js/jquery.min.js') ?>"></script>
<script src="<?= url('packages/module/admin/assets/js/jquery-ui.custom.js') ?>"></script>
<script src="<?= url('packages/module/admin/assets/js/bootstrap.min.js') ?>"></script>
<script src="<?= url('packages/module/admin/assets/js/jquery.icheck.min.js') ?>"></script>
<script src="<?= url('packages/module/admin/assets/js/jquery.cookie.js') ?>"></script>
<script src="<?= url('packages/module/admin/assets/js/select2.min.js') ?>"></script>
<script src="<?= url('packages/module/admin/assets/js/jquery.dataTables.min.js') ?>"></script>
<script src="<?= url('packages/module/admin/assets/js/jquery.nicescroll.min.js') ?>"></script>
<script src="<?= url('packages/module/admin/assets/js/unicorn.js') ?>"></script>
<script src="<?= url('packages/module/admin/assets/js/unicorn.tables.js') ?>"></script>
<script src="<?= url('packages/module/admin/assets/js/dataTables.bootstrap.js') ?>"></script>
<script src="<?= url('packages/module/admin/assets/js/bootbox.min.js') ?>"></script>
<script src="<?= url('packages/module/admin/assets/js/jquery.fancybox.pack.js') ?>"></script>
<script src="<?= url('packages/module/admin/assets/rte/ckeditor/ckeditor.js') ?>"></script>
<script src="<?= url('packages/module/admin/assets/js/colpick.js') ?>"></script>
<script src="<?= url('packages/module/admin/assets/js/jquery.pjax.js') ?>"></script>
<script src="<?= url('packages/module/admin/assets/js/src-min-noconflict/ace.js') ?>"></script>
<script src="<?= url('packages/module/admin/assets/js/jquery.fancytree-all.js') ?>"></script>
<script src="<?= url('packages/module/admin/assets/js/bootstrap-tagsinput.min.js') ?>"></script>
<script src="<?= url('packages/module/admin/assets/js/typeahead.bundle.min.js') ?>"></script>
<script src="<?= url('packages/module/admin/assets/js/jquery.dataTables.columnFilter.js') ?>"></script>


<script src="<?= url('packages/module/admin/assets/js/added.js') ?>"></script>

@section('scripts_bottom')
@show

</body>
</html>
