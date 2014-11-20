<div id="content-header" class="mini">
    <h1>Dashboard</h1>
</div>
<div id="breadcrumb">
    <a href="#" title="Go to Home" class="tip-bottom current"><i class="fa fa-home"></i> Home</a>
</div>
<div class="container-fluid">
    <div class="row">
        <div class="col-xs-12 center" style="text-align: center;">
            @if(count($modules))
            <ul class="quick-actions">
                @foreach($modules as $module => $array)
                    <li>
                        <a href="{{ route('admin.' . $array['module'] . '.index') }}">
                            <i class="fa {{ $array['icon'] }}"></i>
                            {{ $array['title'] or ucfirst($array['module']) }}
                        </a>
                    </li>
                @endforeach
            </ul>
            @endif
        </div>
    </div>
</div>
