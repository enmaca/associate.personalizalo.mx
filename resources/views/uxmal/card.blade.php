<div class="row">
    <div class="col-lg-12">
        <div class="card">
            <div class="card-header">
                <h4 class="card-title mb-0">{!! $data['title'] !!}</h4>
            </div><!-- end card header -->
            <div class="card-body">
                @if(is_array( $data['body'] ))
                    @include('uxmal.content', ['content' => $data['body']])
                @else
                    {!! $data['body'] !!}
                @endif
            </div>
        </div>
        <!-- end col -->
    </div>
    <!-- end col -->
</div>