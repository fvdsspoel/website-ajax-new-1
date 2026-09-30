<!DOCTYPE html>
<html>
    @section('styles')
    @endsection
        @include('layouts.head', ['title' => 'DASHBOARD'])
        <body class="body-bg">
            @section('content')
                <h5><strong>CONTENT MANAGEMENT SYSTEM</strong></h5>
                <form class="borderee geo-border-primaryee rounded p-3" id="add-cms">
                    @csrf
                    @include('homes.form')
                </form>
            @endsection
        @include('layouts.side-nav', ['title' => 'DASHBOARD'])
        @include('layouts.alert')
    </body>
    <script type="text/javascript" src="/js/homes/index.js" ></script>
    <script type="text/javascript" src="/js/homes/create.js" ></script>
    <script type="text/javascript" src="/js/layouts/editor.js"></script>
    <script type="text/javascript" src="/js/layouts/alert.js"></script>
</html>