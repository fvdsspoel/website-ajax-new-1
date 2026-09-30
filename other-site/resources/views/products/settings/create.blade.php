<!DOCTYPE html>
<html>
    @section('styles')
    @endsection
        @include('layouts.head', ['title' => 'PRODUCT SETTINGS'])
        <body class="body-bg">
            @section('content')
            <div class="card">
                <div class="card-header">
                    <div class="row">
                        <div class="col-md-6">
                            <h5><strong>PRODUCT SETTINGS - {{strtoupper($product->name ?? '')}}</strong></h5>
                            
                        </div>
                        <div class="col-md-6">
                            <a href="/products/index" class="right btn geo-primary mb-1 text-light" data-toggle="tooltip" title="Browse List">
                                <i class="fa fa-list"></i>&nbsp;&nbsp;Browse
                            </a>
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <form class="borderee geo-border-primaryee rounded p-3" id="add-product-setting">
                        @csrf
                        @if($data)
                            @include('products.settings.form-update')
                        @else
                            @include('products.settings.form')
                        @endif
                    </form>
                </div>
            </div>
            @endsection
        @include('layouts.side-nav', ['title' => 'PRODUCT SETTINGS'])
        @include('layouts.alert')
    </body>
    <script type="text/javascript" src="/js/products/settings/form.js" ></script>
    <script type="text/javascript" src="/js/products/settings/create.js" ></script>
    <script type="text/javascript" src="/js/layouts/alert.js"></script>
</html>