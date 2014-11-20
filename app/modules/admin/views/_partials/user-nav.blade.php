<ul class="btn-group">
    <li class="btn">
        <a title="" href="#">
            <i class="fa fa-user"></i>
            <span class="text">Profile</span>
        </a>
    </li>
    <li class="btn">
        <a title="" href="#">
            <i class="fa fa-cog"></i>
            <span class="text">Settings</span>
        </a>
    </li>
    <li class="btn">
        <a title="Logout" href="{{ route('admin.logout') }}">
            <i class="fa fa-share"></i>
            <span class="text">Logout</span>
        </a>
    </li>
</ul>
@if($fbUserProfile)
<span class="label label-info">
    <i class="fa fa-facebook"></i>
    <?php  echo $fbUserProfile->getName(); ?>
</span>
<a href="{{ route('fb.logout') }}" class="btn btn-warning btn-xs"><i class="fa fa-facebook"></i> Logout</a>
@else
<a href="{{ route('fb.connect') }}" class="btn btn-info btn-xs"><i class="fa fa-facebook"></i> Login</a>
@endif

