<div id="content-header" class="mini">
    <h1>{{ $moduleUpper }}</h1>
</div>
<div id="breadcrumb">
    <a href="{{ route('admin') }}" title="Go to Home" class="tip-bottom"><i class="fa fa-home"></i> Home</a>
    <a href="#" class="current">{{ $moduleUpper }}</a>
</div>
<div class="row">
    <div class="col-xs-12">

        <div class="widget-box">
            <div class="widget-title">
                    <span class="icon">
                        <i class="fa fa-th"></i>
                    </span>
                <h5>List</h5>
            </div>
            <div class="widget-content nopadding">

                {{ $table->render() }}

            </div>
        </div>

    </div>
</div>
@section('scripts_bottom')
@parent

{{ $table->script(); }}

@stop