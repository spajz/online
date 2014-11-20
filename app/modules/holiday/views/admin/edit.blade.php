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

                        <?php
                            $status = '';
                            switch($item->status){
                                case -1:
                                    $status = 'Rejected';
                                    break;

                                case 1:
                                    $status = 'Approved';
                                    break;

                                case 0:
                                    $status = 'Pending';
                                    break;
                            }
                        ?>

                        <div class="form-group">
                            <label for="status" class="control-label col-lg-2 col-md-3 col-sm-3">Status</label>
                            <div class="col-lg-10 col-md-9 col-sm-9">
                                <input class="form-control" id="email" type="text" name="email" value="{{ $status }}" disabled="disabled">
                                @if($item->status == 1)
                                     <a target="_blank" href="{{url('/media/images/holiday/' . $item->photo) }}" class="btn btn-info btn-sm">Download Photo</a>
                                @endif
                            </div>
                        </div>

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

                        {{ Former::select('bg_transparency')->class('select2')->options(number_list(0, 100)) }}

                        {{ Former::select('font')->class('select2')->options(Config::get("{$moduleLower}::font")) }}

                        {{ Form::hidden('greyscale', 0) }}

                        {{ Former::checkbox('greyscale')->class('icheck') }}

                        {{ Form::hidden('id', $item->id) }}

                        <div class="form-group">
                            <div class="col-lg-offset-2 col-md-offset-3 col-sm-offset-3 col-lg-10 col-md-9 col-sm-9">
                                <input class="btn btn-success btn-sm" type="submit" value="Save" name="save[edit]" data-pjax="1">&nbsp;
                                <input class="btn btn-success btn-sm" type="submit" value="Save & Exit" name="save[exit]">&nbsp;
                                {{-- <input class="btn btn-success btn-sm" type="submit" value="Save & New" name="save[new]">&nbsp; --}}
                                <input class="btn btn-info btn-sm image-preview" type="button" value="Preview" name="save[edit]" data-pjax="1" data-href="{{ route("api.{$moduleLower}.image.preview") }}">&nbsp;
                                <input class="btn btn-warning btn-sm" type="submit" value="Approve & Publish" name="save[publish]" data-bb="submit">&nbsp;
                                <input class="btn btn-inverse btn-sm" type="submit" value="Reject" name="save[reject]" data-bb="submit">&nbsp;
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

                                            {{ Former::hidden("image[{$image->id}]")->value($image->image) }}
                                        </a>
                                    </td>
                                    <td>{{ $image->alt }}</td>
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

                        @if(!count($item->images) || (count($item->images) && array_get($config, 'image.multiple')))

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

                        @endif

                        <div class="form-group">
                            <div class="col-lg-offset-2 col-md-offset-3 col-sm-offset-3 col-lg-10 col-md-9 col-sm-9">
                                <input class="btn btn-success btn-sm" type="submit" value="Save" name="save[edit]" data-pjax="1">&nbsp;
                                <input class="btn btn-success btn-sm" type="submit" value="Save & Exit" name="save[exit]">&nbsp;
                                {{-- <input class="btn btn-success btn-sm" type="submit" value="Save & New" name="save[new]">&nbsp; --}}
                                <input class="btn btn-info btn-sm image-preview" type="button" value="Preview" name="preview" data-pjax="1" data-href="{{ route("api.{$moduleLower}.image.preview") }}">&nbsp;
                                <input class="btn btn-warning btn-sm" type="submit" value="Approve & Publish" name="save[publish]" data-bb="submit">&nbsp;
                                <input class="btn btn-inverse btn-sm" type="submit" value="Reject" name="save[reject]" data-bb="submit">&nbsp;
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