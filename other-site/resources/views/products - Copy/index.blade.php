<!DOCTYPE html>
<html>
    @section('styles')
    @endsection
        @include('layouts.head', ['title' => 'PRODUCTS'])
        <body class="body-bg">
            @section('content')
            <div class="card">
                <div class="card-header">
                    <h5><strong>PRODUCTS</strong></h5>
                </div>
                <div class="card-body">

                    <div class="row space-title">
                        <div class="col-6">
                            <form class="input-group" action="/products/index" autocomplete="off">
                                <div class="input-group-prepend">
                                    <button class="search-btn search-input-btn geo-primary" data-toggle="tooltip" title="Search">
                                        <i class="fa fa-search"></i>
                                    </button>
                                    <input type="text" class="search-input" name="keyword" placeholder="Search Name" value="{{$keyword}}">
                                </div>
                            </form>
                        </div>
                        <div class="col-6">
                            <a href="/products/create" class="right geo-primary mb-1 button-add" data-toggle="tooltip" title="Add Product">
                                New<i class="fa fa-plus"></i>
                            </a>
                        </div>
                    </div>

                    <div style="overflow: auto;">
                        <table class="table text-center table-bordered">
                            <tr class="geo-secondary">
                                <th width="5%">No</th>
                                <th width="20%">Image</th>
                                <th>Name</th>
                                <th>Price</th>
                                <th>Status</th>
                                <th width="20%">Action</th>
                            </tr>
                            @foreach($results as $key=> $result)
                                <tr>
                                    <td>
                                        {{$results->firstItem() + $key}}
                                    </td>
                                    <td>
                                        <img id="preview-1" data-action="zoom"  src="{{$result->image ?? ''}}" onerror="this.src='/assets/images/default/no_image.png'" alt="your image"  height="70px;"/>
                                    </td>
                                    <td>
                                        {{$result->name ?? ''}}
                                    </td>
                                    <td>
                                        ₱ {{number_format($result->price ?? 0, 2)}}
                                    </td>
                                    @if($result->active == 1)
                                        <td>
                                            Active
                                        </td>
                                    @else
                                        <td  style="color:red;" data-toggle="tooltip" title="Complete Product Settings Configuration to Activate this product">
                                            Inactive
                                        </td>
                                    @endif
                                    <td>
                                        @if($result->featured == 1)
                                            <button type="button" value="{{$result->id}}" onclick="featureList(this.value,0)" data-toggle="tooltip" title="Remove to Featured List" class="action-btn btn btn-success text-light delete-btn mb-1">
                                                <i class="fas fa-star"></i>
                                            </button>
                                        @else
                                            <button type="button" value="{{$result->id}}" onclick="featureList(this.value,1)" data-toggle="tooltip" title="Add to Featured List" class="action-btn btn btn-dark text-light delete-btn mb-1">
                                                <i class="far fa-star"></i>
                                            </button>
                                        @endif

                                        <a href="/products/edit/{{$result->id}}" data-toggle="tooltip" title="Edit Product" class="action-btn btn btn-primary text-light mb-1">
                                            <i class="fa fa-edit"></i>
                                        </a>

                                        <a href="/products/setting/{{$result->id}}" data-toggle="tooltip" title="Product Settings" class="action-btn btn btn-warning text-light mb-1">
                                            <i class="fas fa-cogs"></i>
                                        </a>

                                        <button type="button" value="{{$result->id}}" onclick="deleteData(this.value)" data-toggle="tooltip" title="Delete Team" class="action-btn btn btn-danger text-light delete-btn mb-1">
                                            <i class="fa fa-trash"></i>
                                        </button>
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