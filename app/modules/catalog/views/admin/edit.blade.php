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

    {{ Former::horizontal_open_for_files()->route("admin.{$moduleLower}.update", $item->id)->method('put') }}

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

                    {{ Former::text('title')}}

                    {{ Former::text('area')->prepend('m2')}}

                    {{ Former::select('region')->class('')->options(Config::get("{$moduleLower}::region")) }}

                    {{ Former::select('type')->class('')->options(Config::get("{$moduleLower}::type")) }}

                    {{ Former::textarea('description')->id('editor1') }}



                    {{ Former::actions(Former::button_submit('Save')->class('btn btn-success btn-sm'),
                    Former::button_reset('Reset')->class('btn btn-sm')) }}

                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-xs-12">
            <div class="widget-box">
                <div class="widget-title">
                        <span class="icon">
                            <i class="fa fa-th"></i>
                        </span>
                    <h5>Images</h5>
                </div>
                <div class="widget-content">

                    <table class="table table-bordered table-striped table-hover">
                        <thead>
                        <tr>
                            <th>Image</th>
                            <th>Alt</th>
                            <th>Actions</th>
                        </tr>
                        </thead>
                        <tbody>
                        @if(count($item->images))
                            @foreach($item->images as $image)
                                <tr>
                                    <td>
                                        <a href="{{ array_get($config, 'image.baseUrl') . 'large/' . $image->image }}" class="fancybox" rel="gallery">
                                            {{ HTML::image(
                                                    array_get($config, 'image.baseUrl') . 'thumb/' . $image->image,
                                                    $image->alt,
                                                    array(
                                                        'class' => 'img-responsive',
                                                    )
                                                )
                                            }}
                                        </a>
                                    </td>
                                    <td>{{ $image->alt }}</td>
                                    <td class="center">
                                        <a href="{{ route("admin.{$moduleLower}.image.destroy", $image->id)}}" class="btn btn-danger btn-xs" data-bb="confirm">
                                            <i class="fa fa-trash-o"></i> Delete
                                        </a>
                                    </td>
                                </tr>
                            @endforeach
                        @else
                            <tr>
                                <td colspan="3">There are no items.</td>
                            </tr>
                        @endif
                        </tbody>
                    </table>

                    <div class="form-group">
                        <label class="col-sm-3 col-md-3 col-lg-2 control-label">New image upload</label>

                        <div class="col-sm-9 col-md-9 col-lg-10">
                            <div class="row">
                                <div class="col-md-12">
                                    <input type="text" class="form-control" value="" name="alt[]" placeholder="Enter alt text..."/>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-12">
                                    <input type="file" name="files[]"/>
                                </div>
                            </div>
                        </div>
                    </div>

                    {{ Former::actions(Former::button_submit('Save')->class('btn btn-success btn-sm'),
                    Former::button_reset('Reset')->class('btn btn-sm')) }}

                </div>
            </div>
        </div>
    </div>

    {{ Former::close() }}

</div>

@section('scripts_bottom')
@parent
@stop