<!DOCTYPE html>
<html>
    @section('styles')
    @endsection
        @include('layouts.head', ['title' => 'SIZE PRICE CMS'])
        <body class="body-bg">
            @section('content')
            <div class="card">
                <div class="card-header">
                    <h5><strong>PRODUCT SIZE PRICE CMS</strong></h5>
                </div>
                <form class="borderee geo-border-primaryee rounded p-3" id="add-price-size">
                    <div class="card-body">
                        <div style="overflow: auto;">
                            <button type="button" class="btn btn-sm btn-success" onclick="addRow()"><span class="glyphicon glyphicon-plus-sign"></span> Add</button>&nbsp;
                            <button type="button" class="btn btn-sm btn-danger" onclick="removeRow()"><span class="glyphicon glyphicon-remove-sign"></span> Delete</button>&nbsp;
                            <table id="table-size-price" class="table table-bordered" style="margin-top: 15px;">
                                <tr>
                                    <td width="3%"></td>
                                    <th>Min Size</th>
                                    <th>Max Size</th>
                                    <th>Price</th>
                                </tr>
                            </table>
                            <br>
                            <div class="right">
                                <button class="btn btn-success" value="{{Auth::user()->id ?? ''}}" id="eid"><i class="fa fa-save"></i>&nbsp;&nbsp;Save</button>
                                <button class="btn btn-danger" type="button" id="reset_btn"><i class="fa fa-eraser"></i>&nbsp;&nbsp;Reset</button>
                            </div>
                            <input type="hidden" name="current_user" id="current-user" class="form-control " required value="{{Auth::user()->id}}">
                        </div>
                    </div>
                </form>
            </div>
            @endsection
        @include('layouts.side-nav', ['title' => 'SIZE PRICE CMS'])
        @include('layouts.alert')
    </body>
    <script type="text/javascript" src="/js/size-prices/index.js" ></script>
    <script type="text/javascript" src="/js/layouts/alert.js"></script>
</html>