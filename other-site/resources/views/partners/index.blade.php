<!DOCTYPE html>
<html>
    @section('styles')
    @endsection
        @include('layouts.head', ['title' => 'OUR PARTNERS'])
        <body class="body-bg">
            @section('content')
            <div class="card">
                <div class="card-header">
                    <h5><strong>OUR PARTNERS</strong></h5>
                </div>
                <div class="card-body">

                    <div class="row space-title">
                        <div class="col-6">
                            <form class="input-group" action="/partners/index" autocomplete="off">
                                <div class="input-group-prepend">
                                    <button class="search-btn search-input-btn geo-primary" data-toggle="tooltip" title="Search">
                                        <i class="fa fa-search"></i>
                                    </button>
                                    <input type="text" class="search-input" name="keyword" placeholder="Search Name" value="{{$keyword}}">
                                </div>
                            </form>
                        </div>
                        <div class="col-6">
                            <a href="/partners/create" class="right geo-primary mb-1 button-add" data-toggle="tooltip" title="Add Partner">
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
                                        <a href="/partners/edit/{{$result->id}}" data-toggle="tooltip" title="Edit Partner" class="action-btn btn btn-dark text-light mb-1">
                                            <i class="fa fa-edit"></i>
                                        </a>
                                        <button type="button" value="{{$result->id}}" onclick="deleteData(this.value)" data-toggle="tooltip" title="Delete Partner" class="action-btn btn btn-danger text-light delete-btn mb-1">
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
        @include('layouts.side-nav', ['title' => 'OUR PARTNERS'])
        @include('layouts.alert')
    </body>
    <script type="text/javascript" src="/js/partners/index.js" ></script>
    <script type="text/javascript" src="/js/layouts/alert.js"></script>
</html>