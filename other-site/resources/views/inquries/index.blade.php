<!DOCTYPE html>
<html>
    @section('styles')
    @endsection
        @include('layouts.head', ['title' => 'INQURIES'])
        <body class="body-bg">
            @section('content')
            <div class="card">
                <div class="card-header">
                    <h5><strong>INQURIES</strong></h5>
                </div>
                <div class="card-body">

                    <div class="row space-title">
                        <div class="col-6">
                            <form class="input-group" action="/inquries" autocomplete="off">
                                <div class="input-group-prepend">
                                    <button class="search-btn search-input-btn geo-primary" data-toggle="tooltip" title="Search">
                                        <i class="fa fa-search"></i>
                                    </button>
                                    <input type="text" class="search-input" name="keyword" placeholder="Search Name" value="{{$keyword}}">
                                </div>
                            </form>
                        </div>
                        <div class="col-6"></div>
                    </div>

                    <div style="overflow: auto;">
                        <table class="table text-center table-bordered">
                            <tr class="geo-secondary">
                                <th width="5%">No</th>
                                <th>Name</th>
                                <th>Phone Number</th>
                                <th>Email</th>
                                <th>Type</th>
                                <th>subject</th>
                                <th width="40%">message</th>
                            </tr>
                            @foreach($results as $key=> $result)
                                <tr>
                                    <td>
                                        {{$results->firstItem() + $key}}
                                    </td>
                                    <td>
                                        {{$result->name ?? ''}}
                                    </td>
                                    <td>
                                        {{$result->phone ?? ''}}
                                    </td>
                                    <td>
                                        {{$result->email ?? ''}}
                                    </td>
                                    <td>
                                        {{$result->type ?? ''}}
                                    </td>
                                    <td>
                                        {{$result->subject ?? ''}}
                                    </td>
                                    <td>
                                        {{$result->message ?? ''}}
                                    </td>
                                </tr>
                            @endforeach
                        </table>
                    </div>
                    <br>
                    <div id="page-nav" class="right"> {{$results->links()}} </div>
                </div>
            </div>
            @endsection
        @include('layouts.side-nav', ['title' => 'PRODUCTS'])
        @include('layouts.alert')
    </body>
    <script type="text/javascript" src="/js/products/index.js" ></script>
    <script type="text/javascript" src="/js/layouts/alert.js"></script>
</html>