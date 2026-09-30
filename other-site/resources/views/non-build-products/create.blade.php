<!DOCTYPE html>
<html>
    @section('styles')
    @endsection
        @include('layouts.head', ['title' => 'NON BUILD PRODUCTS'])
        <body class="body-bg">
            @section('content')
            <div class="card">
                <div class="card-header">
                    <div class="row">
                        <div class="col-md-6">
                            <h5><strong>NON BUILD PRODUCTS</strong></h5>
                        </div>
                        <div class="col-md-6">
                            <a href="/non-build-products/index" class="right btn geo-primary mb-1 text-light" data-toggle="tooltip" title="Browse List">
                                <i class="fa fa-list"></i>&nbsp;&nbsp;Browse
                            </a>
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <form class="borderee geo-border-primaryee rounded p-3" id="add-non-build-product">
                        @csrf
                        @include('non-build-products.form')
                    </form>
                </div>
            </div>
            @endsection
        @include('layouts.side-nav', ['title' => 'NON BUILD PRODUCTS'])
        @include('layouts.alert')
    </body>
    <script type="text/javascript" src="/js/non-build-products/form.js" ></script>
    <script type="text/javascript" src="/js/non-build-products/create.js" ></script>
    <script type="text/javascript" src="/js/layouts/alert.js"></script>
</html>