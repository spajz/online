<!DOCTYPE html>
<html lang="en">
<head>
    <title>ACMS</title>
    <meta charset="UTF-8"/>
    <meta name="viewport" content="width=device-width, initial-scale=1.0"/>

    <link rel="stylesheet" href="<?= url('packages/module/admin/assets/css/bootstrap.min.css') ?>"/>
    <link rel="stylesheet" href="<?= url('packages/module/admin/assets/css/font-awesome.css') ?>"/>
    <link rel="stylesheet" href="<?= url('packages/module/admin/assets/css/unicorn-login.css') ?>"/>

</head>
<body>
<div id="info-box">{{ Notification::showAll() }}</div>

<div id="container">

    <div id="loginbox">

        <div id="logo">
<!--            <img src="{{ admin_asset('img/fcbafirma-logo.jpg') }}" alt=""/>-->
        </div>

        {{ Form::open(array('route' => 'admin.login', 'id' => 'loginform')) }}

            <p>Enter username and password to continue.</p>

            <div class="input-group input-sm">
                <span class="input-group-addon">
                    <i class="fa fa-user"></i>
                </span>
                <input class="form-control" type="text" name="email" id="email" placeholder="Email" value="{{ Input::old('email') }}"/>
            </div>
            <div class="input-group">
                <span class="input-group-addon">
                    <i class="fa fa-lock"></i>
                </span>
                <input class="form-control" type="password" name="password" id="password" placeholder="Password" value="{{ Input::old('password') }}"/>
            </div>
            <div class="form-actions clearfix">
                <input type="submit" class="btn btn-block btn-primary btn-default" value="Login"/>
            </div>

            {{ Form::token() }}

        {{ Form::close() }}

    </div>
</div>

<script src="<?= url('packages/module/admin/assets/js/jquery.min.js') ?>"></script>
<script src="<?= url('packages/module/admin/assets/js/jquery-ui.custom.js') ?>"></script>
<script src="<?= url('packages/module/admin/assets/js/bootstrap.min.js') ?>"></script>
<script src="<?= url('packages/module/admin/assets/js/unicorn.login.js') ?>"></script>

</body>
</html>
