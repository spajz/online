<div class="well">
    <h4>Online Services <small><a href="">(View All)</a></small></h4>
    <small>Main Categories</small>
    <div class="row">
        <div class="col-lg-6">
            <ul class="list-unstyled">
                @foreach($categories as $key => $category)
                    @if($key % 2 === 0)
                        <li><a href="#">{{ $category->title }}</a></li>
                    @endif
                @endforeach
            </ul>
        </div>
        <!-- /.col-lg-6 -->
        <div class="col-lg-6">
            <ul class="list-unstyled">
                @foreach($categories as $key => $category)
                    @if($key % 2 !== 0)
                        <li><a href="#">{{ $category->title }}</a></li>
                    @endif
                @endforeach
            </ul>
        </div>
        <!-- /.col-lg-6 -->
    </div>
    <!-- /.row -->
</div>

