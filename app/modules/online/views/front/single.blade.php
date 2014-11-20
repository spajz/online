<div class="row">

    <!-- Blog Post Content Column -->
    <div class="col-lg-8">

        <ol class="breadcrumb">
            <li><a href="#">Home</a></li>
            <li><a href="#">Library</a></li>
            <li class="active">Data</li>
        </ol>

        <!-- Blog Post -->

        <!-- Title -->
        <h1>{{ $item->title }}</h1>

        <?php /*
        <!-- Author -->
        <p class="lead">
            by <a href="#">Start Bootstrap</a>
        </p>

        <hr>
        */ ?>

        <?php /*
        <!-- Date/Time -->
        <p class="lead"><span class="glyphicon glyphicon-time"></span> Posted on August 24, 2013 at 9:00 PM</p>

        <hr>
        */ ?>

        <!-- Post Content -->
        <p class="lead">
        {{ $item->description }}
        </p>

        <p>
            {{ $form or '' }}
        </p>

        <hr>

    </div>

    @include('front::_partials.sidebar')

</div>