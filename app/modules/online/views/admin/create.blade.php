<div id="content-header" class="mini">
    <h1>Create {{ $moduleUpper }} Item</h1>
</div>
<div id="breadcrumb">
    <a href="{{ route("admin") }}" title="Go to Home" class="tip-bottom"><i class="fa fa-home"></i> Home</a>
    <a href="{{ route("admin.{$moduleLower}.index") }}">{{ $moduleUpper }}</a>
    <a href="#" class="current">Create item</a>
</div>

<div class="container-fluid">

    <div id="pjax-container">

    {{ Former::horizontal_open_for_files()->route("admin.{$moduleLower}.store")->method('post') }}

    <div class="row">
        <div class="col-xs-12">
            <div class="widget-box">
                <div class="widget-title">
                        <span class="icon">
                            <i class="fa fa-align-justify"></i>
                        </span>
                    <h5>Base information</h5>
                </div>
                <div class="widget-content nopadding">

                    {{ Former::text('title') }}

                    {{ Former::text('slug') }}

                    {{ Form::hidden('status', 0) }}

                    {{ Former::checkbox('status')->class('icheck') }}

                    {{ Form::hidden('menu', 0) }}

                    {{ Former::checkbox('menu')->class('icheck') }}

                    {{ Form::hidden('featured', 0) }}

                    {{ Former::checkbox('featured')->class('icheck') }}

                    {{ Former::textarea('description')->id('editor1') }}

                    <div class="form-group">
                        <div class="col-lg-offset-2 col-md-offset-3 col-sm-offset-3 col-lg-10 col-md-9 col-sm-9">
                            <input class="btn btn-success btn-sm" type="submit" value="Save" name="save[edit]">&nbsp;
                            <input class="btn btn-success btn-sm" type="submit" value="Save & Exit" name="save[exit]">&nbsp;
                            <input class="btn btn-success btn-sm" type="submit" value="Save & New" name="save[new]">&nbsp;
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>

    {{ Former::close() }}

    </div>

</div>

@section('scripts_bottom')
@parent
@stop