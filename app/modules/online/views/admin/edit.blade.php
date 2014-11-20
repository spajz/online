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

                    <?php $i=0; ?>
                    @if($contentFiles)
                        @foreach($contentFiles as $file => $contentFile)
                            <div class="form-group">
                                <label class="col-sm-3 col-md-3 col-lg-2 control-label">{{ $file }}</label>
                                <div class="col-sm-9 col-md-9 col-lg-10">
                                    <div class="editor-box" id="editor-box-{{$i}}" style="min-height: 600px;"></div>
                                    <textarea style="display: none" name="{{ base64_encode($file) }}" rows="5" cols="70" id="editor-form-{{$i}}">{{ $contentFile }}</textarea>
                                </div>
                            </div>
                        <?php $i++; ?>
                        @endforeach
                    @endif

                    {{ Former::text('title') }}

                    {{ Former::text('slug') }}

                    {{ Former::text('tags')->class('tagsinput')->value($item->getTags()) }}

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

    {{ Former::close() }}

    </div>

</div>

@section('scripts_bottom')
@parent
<script type="text/javascript">

    var textarea = {};
    var editor = {};
    var initialContent = '';

    function initEditor(){
     $('.editor-box').each(function (index) {
            initialContent = $('#editor-form-' + index).val();

            textarea[index] = $('#editor-form-' + index);
    //        $('#editor-form-' + index).hide();

            editor[index] = ace.edit('editor-box-' + index);

            editor[index].setValue(initialContent);

            editor[index].setTheme("ace/theme/twilight");
            editor[index].getSession().setMode("ace/mode/php");

            editor[index].getSession().on('change', function () {
                textarea[index].val(editor[index].getSession().getValue());
            });

        });
    }

    initEditor();

    $("#toggletextarea-btn").on('click', function () {
        textarea.toggle();
        $(this).text(function (i, text) {
            return text === "Show Content" ? "Hide Content" : "Show Content";
        });
    });

    var citynames = new Bloodhound({
        datumTokenizer: Bloodhound.tokenizers.obj.whitespace('name'),
        queryTokenizer: Bloodhound.tokenizers.whitespace,
        prefetch: {
            url: baseUrlAdmin + '/api/online/tags',
            filter: function(list) {
                return $.map(list, function(cityname) {
                    return { name: cityname }; });
            }
        }
    });
    citynames.initialize();

    function initTags(){
    $('.tagsinput').tagsinput({
            typeaheadjs: {
                name: 'citynames',
                displayKey: 'name',
                valueKey: 'name',
                source: citynames.ttAdapter()
            }
        });
    }

    initTags();

    $(document).on('pjax:complete', function() {
        initEditor();
        initTags();
    })

</script>
@stop