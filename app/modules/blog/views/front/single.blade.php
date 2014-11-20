<?php
$config = Config::get('blog::config', array());
$configProduct = Config::get('product::config', array());
?>
<div class="sub-navbar">
    <div class="container clearfix">
        <div class="row clearfix">
            <div class="col-md-12 column">
                <h3>{{ $item->title }}</h3>
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
            {{ $item->description }}

            @if(count($products))

            <div class="row clearfix">

            @foreach($products as $product)

            @if(count($product->attribute) && count($product->attribute[0]->images))

            <?php $image = $product->attribute[0]->images[0] ?>

                <div class="col-md-4 column">

                    <a href="{{ $product->url }}" title="{{{  $product->title }}}">
                        {{ HTML::image(
                        array_get($configProduct, 'image.baseUrl') . 'large/' . $image->image,
                        $image->alt,
                        array(
                        'class' => 'img-responsive img-thumbnail',
                        )
                        )
                        }}
                    </a>
                    <p class="center">{{ $product->title }}</p>

                </div>


            @endif

            @endforeach

            </div>

            @endif

        </div>
    </div>



</div>