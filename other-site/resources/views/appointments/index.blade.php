<!DOCTYPE html>
<html>
    @section('styles')
    @endsection
        @include('layouts.head', ['title' => 'APPOINTMENTS'])
        <body class="body-bg">
            @section('content')
            <div class="card">
                <div class="card-header">
                    <h5><strong>APPOINTMENTS</strong></h5>
                </div>
                <div class="card-body">

                    <div class="row space-title">
                        <div class="col-6">
                            <form class="input-group" action="/appointments/index" autocomplete="off">
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
                                <th>Order Reference Number</th>
                                <th>Product Name</th>
                                <th>Product Style</th>
                                <th>Product Price</th>
                                <th>Customer Name</th>
                                <th>Customer Email</th>
                                <th>Customer Phone No</th>
                                <th width="10%">Action</th>
                            </tr>
                            @foreach($results as $key=> $result)
                                <tr>
                                    <td>
                                        {{$results->firstItem() + $key}}
                                    </td>
                                    <td>
                                        {{$result->order_number ?? ''}}
                                    </td>
                                    <td>
                                        {{$result->product->name ?? ''}}
                                    </td>
                                    <td>
                                        {{$result->productStyle->name ?? ''}}
                                    </td>
                                    <td>
                                        ₱ {{number_format($result->final_price ?? 0, 2)}}
                                    </td>
                                    <td>
                                        {{$result->first_name ?? ''}} {{$result->last_name ?? ''}}
                                    </td>
                                    <td>
                                        {{$result->email ?? ''}}
                                    </td>
                                    <td>
                                        {{$result->phone_no ?? ''}}
                                    </td>
                                    <td>
                                        <a href="/appointments/view/{{$result->id}}" data-toggle="tooltip" title="View Appointment" class="action-btn btn btn-dark text-light mb-1">
                                            <i class="fa fa-eye"></i>
                                        </a>
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