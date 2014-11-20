<?php
$config = Config::get($moduleLower . '::config', array());
?>
<div id="content-header" class="mini">
    <h1>Edit {{ $moduleUpper }} Item</h1>
</div>
<div id="breadcrumb">
    <a href="{{ route("admin") }}" title="Go to Home" class="tip-bottom"><i class="fa fa-home"></i> Home</a>
    <a href="{{ route("admin.{$moduleLower}.index") }}">{{ $moduleUpper }}</a>
    <a href="#" class="current">Edit item</a>
</div>


<div class="container-fluid">

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

                    {{ Former::text('full_name') }}

                    {{ Former::text('email') }}

                    {{ Former::text('phone') }}

                    {{ Former::text('place_of_payment') }}

                    {{ Former::select('card_type')->class('select2')->options(Config::get("{$moduleLower}::card_type")) }}

                    {{ Former::textarea('description') }}

                    {{ Former::select('text_position')->class('select2')->options(Config::get("{$moduleLower}::text_position")) }}

                    {{ Former::select('text_size')->class('select2')->options(number_list(14, 50)) }}

                    {{ Former::text('text_color')->class('color-picker')->prepend('&nbsp;')->data_href('bg-color') }}

                    {{ Former::text('bg_color')->class('color-picker')->prepend('&nbsp;')->data_href('bg-color') }}

                    {{ Former::select('bg_transparency')->class('select2')->options(number_list(0, 100, null)) }}

                    {{ Former::select('font')->class('select2')->options(Config::get("{$moduleLower}::font")) }}

                    {{ Form::hidden('greyscale', 0) }}

                    {{ Former::checkbox('greyscale')->class('icheck') }}

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

@section('scripts_bottom')
@parent
@stop