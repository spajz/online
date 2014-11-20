<div class="container-bkt container-main container-img2">
    <div class="row clearfix">
        <div class="col-xs-6 col-xs-offset-1 column">
            <h3 class="b">Nda një selfie, fito një çmim!</h3>

            <div class="row clearfix">
                <div class="col-xs-11 col-xs-offset-1 column">

                    {{
                        Form::open(array('route' => 'holiday.photo.create',
                            'data-parsley-validate' => '1',
                            'class' => 'form-horizontal',
                            'enctype' => 'multipart/form-data'
                        ))
                    }}

                        <div class="form-group mar-b5">
                            <label class="col-sm-3 control-label label-box" for="files">Zgjidh foton</label>

                            <div class="col-sm-7">
                                <input type="file" class="form-control input-sm rc12" name="files[]" required>
                            </div>
                        </div>

                        <div class="form-group no-marb">
                            <label class="col-sm-3 control-label label-box" for="description">Teksti</label>

                            <div class="col-sm-7">
                                <textarea name="description" style="min-height: 80px;" class="form-control input-sm rc12"
                                          placeholder="Shkruaj dedikimin e kësaj fotografie." required></textarea>
                            </div>
                        </div>

                        <small class="subsmall"><i>Fotografia do të publikohet shumë shpejt në albumin "Selfie"</i>
                        </small>

                        <div class="form-group">
                            <div class="col-sm-3">
                                <button class="btn btn-danger btn-sm rc12 bw" onclick="history.go(-1);">
                                    <span class="glyphicon glyphicon-backward"></span> Kthehu
                                </button>
                            </div>
                            <div class="col-sm-3 col-sm-offset-4">
                                <button type="submit" class="btn btn-danger btn-sm rc12 bw">Dërgo foton tënde</button>
                            </div>
                        </div>
                    {{ Form::close() }}

                </div>
            </div>

        </div>
        <div class="col-md-5 column">
        </div>
    </div>

</div>
<div class="container-bkt bg">
    <div class="row clearfix">
        <div class="col-xs-12 column col-b text-center">
            <i>*Me dërgimin e kësaj fotografie, konfirmon se ke lexuar dhe pranuar</i> <a href="https://www.facebook.com/notes/banka-komb%C3%ABtare-tregtare/kushtet-e-fushat%C3%ABs-nda-nj%C3%AB-selfie-fito-nj%C3%AB-%C3%A7mim/640461342716439" target="_blank"><b><u>Kushtet e
                    Fushatës</u></b></a> <i> "Nda një selfie, fito një çmim".</i>
        </div>
    </div>
</div>