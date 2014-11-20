<div id="content-header" class="mini">
    <h1>Edit {{ $moduleUpper }} Item</h1>
</div>
<div id="breadcrumb">
    <a href="{{ route("admin") }}" title="Go to Home" class="tip-bottom"><i class="fa fa-home"></i> Home</a>
    <a href="{{ route("admin.{$moduleAdminRoute}.index") }}">{{ $moduleUpper }}</a>
    <a href="#" class="current">Edit item</a>
</div>

<div class="container-fluid">

    <div id="pjax-container">

    {{ Former::horizontal_open_for_files()->route("admin.{$moduleAdminRoute}.update", $item->id)->method('put')->data_pjax() }}

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


                    <div class="form-group">
                        <label for="title" class="control-label col-lg-2 col-md-3 col-sm-3">Parents</label>
                        <div class="col-lg-10 col-md-9 col-sm-9">


                            <?php
                           $t = $item->getRoot();

                            echo implode(', ', array_flatten($t->leaves()->lists('title')));
                            ?>
                        </div>
                    </div>


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
                                        <a href="{{ array_get($config, 'image.baseUrl') . 'large/' . $image->image }}" class="fancybox" rel="gal-images">
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
                                        <a href="{{ route("admin.{$moduleAdminRoute}.image.destroy", $image->id)}}" class="btn btn-danger btn-xs" data-bb="confirmPjax">
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
                                <i class="fa fa-align-justify"></i>
                            </span>
                        <h5>Seo information</h5>
                    </div>
                    <div class="widget-content nopadding">

                        {{ Former::text('seo_title') }}

                        {{ Former::text('seo_keywords') }}

                        {{ Former::text('seo_description') }}

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


    {{ Former::close() }}

    </div>

</div>

@section('scripts_bottom')
@parent
@stop