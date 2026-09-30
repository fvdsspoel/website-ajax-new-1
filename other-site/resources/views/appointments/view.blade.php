<!DOCTYPE html>
<html>
    @section('styles')
        <style>
            .pdf-a:link, .pdf-a:visited {
              background-color: #169fe4;
              color: white !important;
              width: 100%;
              padding: 14px 25px;
              text-align: center;
              text-decoration: none;
              display: inline-block;
            }

            .pdf-a:hover, .pdf-a:active {
              background-color: #2e4fc2;
              color: white !important;
            }
        </style>
    @endsection
        @include('layouts.head', ['title' => 'APPOINTMENTS'])
        <body class="body-bg">
            @section('content')
            <form class="borderee geo-border-primaryee rounded p-3">
                @csrf
                @include('appointments.form')
            </form>
            @endsection
        @include('layouts.side-nav', ['title' => 'APPOINTMENTS'])
        @include('layouts.alert')
    </body>
    <script type="text/javascript" src="/js/layouts/alert.js"></script>
</html>