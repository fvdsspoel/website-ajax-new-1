<!DOCTYPE html>
<html>
    @section('styles')
    @endsection
        @include('layouts.head', ['title' => 'PRODUCT'])
        <body class="body-bg">
            @section('content')
            <div class="row">
                <div class="col-md-6">
                    <h4>
                        @if($data)
                            UPDATE
                        @else
                            CREATE
                        @endif
                        PRODUCT
                    </h4>
                </div>
                <div class="col-md-6">
                    <a href="/products/index" class="right btn geo-primary mb-1 text-light" data-toggle="tooltip" title="Browse List">
                        <i class="fa fa-list"></i>&nbsp;&nbsp;Browse
                    </a>
                </div>
            </div>
            <form class="borderee geo-border-primaryee rounded p-3" id="add-product">
                @csrf
                @include('products.form')
            </form>
            @endsection
        @include('layouts.side-nav', ['title' => 'PRODUCT'])
        @include('layouts.alert')
    </body>
    <script type="text/javascript" src="/js/products/form.js" ></script>
    <script type="text/javascript" src="/js/products/create.js" ></script>
    <script type="text/javascript" src="/js/layouts/alert.js"></script>
</html>