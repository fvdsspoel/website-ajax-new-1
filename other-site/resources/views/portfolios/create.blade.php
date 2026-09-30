<!DOCTYPE html>
<html>
    @section('styles')
    @endsection
        @include('layouts.head', ['title' => 'OUR PORTFOLIO'])
        <body class="body-bg">
            @section('content')
            <div class="card">
                <div class="card-header">
                    <div class="row">
                        <div class="col-md-6">
                            <h5><strong>OUR PORTFOLIO</strong></h5>
                        </div>
                        <div class="col-md-6">
                            <a href="/portfolios/index" class="right btn geo-primary mb-1 text-light" data-toggle="tooltip" title="Browse Portfolio">
                                <i class="fa fa-list"></i>&nbsp;&nbsp;Browse
                            </a>
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <form class="borderee geo-border-primaryee rounded p-3" id="add-portfolio">
                        @csrf
                        @include('portfolios.form')
                    </form>
                </div>
            </div>
            @endsection
        @include('layouts.side-nav', ['title' => 'OUR PORTFOLIO'])
        @include('layouts.alert')
    </body>
    <script type="text/javascript" src="/js/portfolios/form.js" ></script>
    <script type="text/javascript" src="/js/portfolios/create.js" ></script>
    <script type="text/javascript" src="/js/layouts/alert.js"></script>
</html>