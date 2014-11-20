<?php
$config = Config::get($moduleLower . '::config', array());
$allCategories = $config['all_categories'];
$allCategories = $allCategories();
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

    <div id="pjax-container">

    {{ Former::horizontal_open_for_files()->route("admin.{$moduleLower}.update", $item->id)->method('put')->data_pjax() }}

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

                    {{ Former::text('slug')}}

                    {{ Former::text('url')}}

                    {{ Former::select('category_id')->class('select2')->options($allCategories)->label('Category') }}

                    {{ Form::hidden('status', 0) }}

                    {{ Former::checkbox('status')->class('icheck') }}

                    {{ Former::textarea('description')->id('editor1') }}

                    <div class="form-group">
                        <div class="col-lg-offset-2 col-md-offset-3 col-sm-offset-3 col-lg-10 col-md-9 col-sm-9">
                            <input class="btn btn-success btn-sm" type="submit" value="Save" name="save[edit]" data-pjax="1">&nbsp;
                            <input class="btn btn-success btn-sm" type="submit" value="Save & Exit" name="save[exit]">&nbsp;
                            <input class="btn btn-success btn-sm" type="submit" value="Save & New" name="save[new]">&nbsp;
                        </div>
                    </div>

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
                                    <td>{{ Form::text("images[{$image->id}][alt]", $image->alt) }}</td>
                                    <td class="center">
                                        <a href="{{ route("admin.{$moduleLower}.image.destroy", $image->id)}}" class="btn btn-danger btn-xs" data-bb="confirmPjax">
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
                        <label class="col-sm-3 col-md-3 col-lg-2 control-label">Image upload</label>

                        <div class="col-sm-9 col-md-9 col-lg-10">
                            <div class="row">
                                <div class="col-md-12">
                                    <input type="file" name="files[]"/>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-12">
                                    <input type="text" class="form-control" value="" name="alt[]" placeholder="Enter alt text."/>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="form-group">
                        <div class="col-lg-offset-2 col-md-offset-3 col-sm-offset-3 col-lg-10 col-md-9 col-sm-9">
                            <input class="btn btn-success btn-sm" type="submit" value="Save" name="save[edit]" data-pjax="1">&nbsp;
                            <input class="btn btn-success btn-sm" type="submit" value="Save & Exit" name="save[exit]">&nbsp;
                            <input class="btn btn-success btn-sm" type="submit" value="Save & New" name="save[new]">&nbsp;
                        </div>
                    </div>

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
                    <h5>Attributes</h5>
                </div>
                <div class="widget-content">

                    <table class="table table-bordered table-striped table-hover">
                        <thead>
                        <tr>
                            <th>Attribute</th>
                            <th>Value</th>
                            <th>Image</th>
                            <th>Actions</th>
                        </tr>
                        </thead>
                        <tbody>
                        @if(count($item->attribute))
                            @foreach($item->attribute as $attribute)
                            <tr>
                                <td>{{ $attribute->type }}</td>
                                <td>
                                    <div class="input-group w170">
                                        <div class="input-group-addon" style="background-color: {{ $attribute->hex_color  }}">&nbsp;</div>
                                        {{ Form::text("_attributes[{$attribute->id}][value]", $attribute->hex_color) }}
                                    </div>
                                </td>
                                <td style="min-width: 100px">
                                    @if(count($attribute->images))
                                        @foreach($attribute->images as $image)
                                            <a href="{{ array_get($config, 'image.baseUrl') . 'large/' . $image->image }}" class="fancybox" rel="gallery-attributes">
                                                {{ HTML::image(
                                                array_get($config, 'image.baseUrl') . 'thumb/' . $image->image,
                                                $image->alt,
                                                array(
                                                'class' => 'img-responsive',
                                                )
                                                )
                                                }}
                                            </a>
                                        @endforeach
                                    @endif
                                </td>
                                <td class="center">
                                    <a href="{{ route("admin.{$moduleLower}.attribute.destroy", $attribute->id)}}" class="btn btn-danger btn-xs" data-bb="confirmPjax">
                                    <i class="fa fa-trash-o"></i> Delete
                                    </a>
                                </td>
                            </tr>
                            @endforeach
                        @else
                            <tr>
                                <td colspan="4">There are no items.</td>
                            </tr>
                        @endif
                        </tbody>
                    </table>

                    <div class="form-group">
                        <div class="col-lg-offset-2 col-md-offset-3 col-sm-offset-3 col-lg-10 col-md-9 col-sm-9">
                            <input class="btn btn-success btn-sm" type="submit" value="Save" name="save[edit]" data-pjax="1">&nbsp;
                            <input class="btn btn-success btn-sm" type="submit" value="Save & Exit" name="save[exit]">&nbsp;
                            <input class="btn btn-success btn-sm" type="submit" value="Save & New" name="save[new]">&nbsp;
                            <button class="btn btn-info btn-sm add-attribute" type="button">Add New Attribute</button>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>

    {{ Former::close() }}

    </div>

</div>

{{ Former::horizontal_open()->style('display: none') }}
    <div id="templates" style="display: none">

        <div id="tpl-attribute">

            <div class="element-group" style="display: none">

                <div class="form-group">

                    <label for="bg_color" class="control-label col-lg-2 col-md-3 col-sm-3">Attribute</label>

                    <div class="col-lg-10 col-md-9 col-sm-9">

                        <div class="row">
                            <div class="col-md-4">
                                {{ Form::select('attributes[type][]', Config::get("{$moduleLower}::attributes", array()), null, array('class' => 'select2')) }}
                                <button type="button" class="btn btn-warning btn-sm btn-remove" data-remove=".element-group">Remove Attribute</button>
                            </div>
                            <div class="col-md-8">

                            </div>
                        </div>

                    </div>

                </div>

                {{ Former::text('attributes[value][]')->class('color-picker')->prepend('&nbsp;')->data_href('color')->label('Value') }}
                {{ Former::files('attributeImages[files]')->accept('image')->label('Image upload') }}
                {{ Former::text('attributeImages[alt][]')->label('Alt')->placeholder('Enter alt text.') }}

            </div>
        </div>

    </div>
{{ Former::close() }}

@section('scripts_bottom')
@parent
@stop