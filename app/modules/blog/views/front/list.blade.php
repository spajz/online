<?php
$configSlider = Config::get('blog::config', array());
?>
<div class="sub-navbar">
    <div class="container clearfix">
        <div class="row clearfix">
            <div class="col-md-12 column">
                <h3>Inspiration</h3>
            </div>
        </div>
    </div>
</div>

<div class="container">
    <div class="row clearfix">
        <div class="col-md-3 column pad-t30">

            @if(count($items))
            <h4>Find Inspiration</h4>
            <ul class="navlist">
                @foreach($items as $value)
                    <li><a href="{{ route('blog.show', $value->slug) }}">{{ $value->title }}</a>
                    </li>
                @endforeach
            </ul>
            @endif

            <br><br><br>
            <img src="{{ front_asset('img/my ikea_badges 02.jpg') }}" class="pull-left"/>

        </div>
        <div class="col-md-9 column pad-t30">

        </div>
    </div>
</div>