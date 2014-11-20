<?php
$config = Config::get('holiday::config', array());
?>
<div class="container-bkt container-main container-img3">
    <div class="row clearfix">
        <div class="col-xs-6 col-xs-offset-1 column">
            <h3 class="b">Nda një selfie, fito një çmim!</h3>

            <div class="row clearfix">
                <div class="col-xs-12 column">

                    {{
                        Form::open(array('route' => 'holiday.details.create',
                        'data-parsley-validate' => '1',
                        'class' => 'form-horizontal'
                        ))
                    }}

                        <div class="form-group mar-b5" >
                            <label class="col-sm-4 control-label label-box" for="full_name">Emër Mbiemër</label>
                            <div class="col-sm-6">
                                <input type="text" name="full_name" class="form-control input-sm rc12" required>
                            </div>
                        </div>

                        <div class="form-group mar-b5" >
                            <label class="col-sm-4 control-label label-box" for="email">Email</label>
                            <div class="col-sm-6">
                                <input type="text" name="email" class="form-control input-sm rc12" required data-parsley-type="email">
                            </div>
                        </div>

                        <div class="form-group mar-b5" >
                            <label class="col-sm-4 control-label label-box" for="phone">Nr. telefonit</label>
                            <div class="col-sm-6">
                                <input type="text" name="phone" class="form-control input-sm rc12" required>
                            </div>
                        </div>

                        <div class="form-group mar-b5" >
                            <label class="col-sm-4 control-label label-box" for="place_of_payment">Vendi ku është kryer pagesa</label>
                            <div class="col-sm-6">
                                <input type="text" name="place_of_payment" class="form-control input-sm rc12" required>
                            </div>
                        </div>

                        <div class="form-group mar-b5" >
                            <label class="col-sm-4 control-label label-box" for="card_type">Karta e përdorur</label>
                            <div class="col-sm-6">
                                {{ Form::select('card_type', $config['card_type'], null, array('class' => 'form-control input-sm rc12')) }}
                            </div>
                        </div>

                        <div class="form-group">
                            <div class="col-sm-4 col-sm-offset-7">
                                <button type="submit" class="btn btn-danger btn-sm rc12 bw">Vazhdo</button>
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
          &nbsp;
        </div>
    </div>
</div>