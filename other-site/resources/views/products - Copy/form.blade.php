<div class="row">
    <div class="col-md-12">
    	<div class="row pl-3 pr-3">
    		<h5>Product Information</h5>
    		<div class="col-md-12 p-1">
    			<div class="row">
    				<div class="col-md-7">
    					<label>Name</label>
    					<input type="text" name="name" class="form-control" required  placeholder="Insert Name" value="{{$data->name ?? ''}}">

                        <label class="pt-3">Price</label>
                        <input type="number" name="price" class="form-control" required  placeholder="Insert Price" value="{{$data->price ?? ''}}" min="1" step="any">

                        <label class="pt-3">Category</label>
                        <select class="form-control" name="category_id" id="category-id">
                            @foreach($categories as $category)
                                <option value="{{$category->id}}">{{$category->name}}</option>
                            @endforeach
                        </select>
                        <input type="hidden" id="category-val" value="{{$data->category_id ?? ''}}">

                        <label class="pt-3">Sub Category</label>
                        <select class="form-control" name="sub_category_id" id="sub-category-id">
                            @foreach($sub_categories as $sub_category)
                                <option value="{{$sub_category->id}}">{{$sub_category->name}}</option>
                            @endforeach
                        </select>
                        <input type="hidden" id="subcategory-val" value="{{$data->sub_category_id ?? ''}}">
    				</div>
    				<div class="col-md-5">
                        <label>&nbsp;</label>
                        <div class="col-md-12 image-div">
                            <label title="Click for change image" style="cursor: pointer;width: 100%">
                                <img id="preview-0" src="{{$data->image ?? ''}}" onerror="this.src='/assets/images/default/up-img-1.png'" alt="your image" width="300px;" height="200px;" class="image-preview" />
                                <input type="file" name="image" style="display: none;" id="multi-selected-0"  autocomplete="off"  onchange="readURL(this,0);"  required readonly>
                            </label>
                            <input type="hidden" id="multi-selected-id-0" name="multi_selected_image" value="old"  class="form-control input-sm style_input"  autocomplete="off"  />
                            <p class="text-center image-label mt-1">Upload Product Image Thumbnail Here</p>
                        </div>
    				</div>
                </div>
    		</div>
    	</div>
    </div>
</div>

<!-- proiduct description -->
<div class="row pt-4 pt-5">
    <div class="col-md-12">
        <div class="row pl-3 pr-3">
            <h5>Product Description</h5>
            <div class="col-md-12 p-1">
                <div class="row">
                    <div class="col-md-12">
                        @include('layouts.editor')
                        <input type="hidden" name="product_detail" id="product-detail" class="form-control " required  placeholder="Insert Detail" value="{{$data->product_detail ?? ''}}">
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- product style -->
<div class="row pt-4 pt-5">
    <div class="col-md-12">
        <div class="row pl-3 pr-3">
            <h5>Product Styles</h5>
            <div class="col-md-12 p-1">
                <div class="row">
                    <div class="col-md-12">
                        <button type="button" class="btn btn-sm btn-success" onclick="addStyle()"><span class="glyphicon glyphicon-plus-sign"></span> Add</button>&nbsp;
                        <button type="button" class="btn btn-sm btn-danger" onclick="removeStyle()"><span class="glyphicon glyphicon-remove-sign"></span> Delete</button>&nbsp;
                        <table id="table-sytle" class="table table-bordered" style="margin-top: 15px;">
                            <tr>
                                <td width="3%"></td>
                                <th width="15%">Image</th>
                                <th>Name</th>
                                <th width="15%">Price</th>
                                <th>Description</th>
                            </tr>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- other Feature -->
<div class="row pt-4 pt-5">
    <div class="col-md-12">
        <div class="row pl-3 pr-3">
            <h5>Other Features</h5>
            <div class="col-md-12 p-1">
                <div class="row">
                    <div class="col-md-6">
                        <button type="button" class="btn btn-sm btn-success" onclick="addFeature()"><span class="glyphicon glyphicon-plus-sign"></span> Add</button>&nbsp;
                        <button type="button" class="btn btn-sm btn-danger" onclick="removeFeature()"><span class="glyphicon glyphicon-remove-sign"></span> Delete</button>&nbsp;
                        <table id="table-feature" class="table table-bordered" style="margin-top: 15px;">
                            <tr class="text-center">
                                <td width="3%"></td>
                                <th>Name</th>
                            </tr>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="right pt-4">
    <button class="btn btn-success" value="{{Auth::user()->id ?? ''}}" id="eid"><i class="fa fa-save"></i>&nbsp;&nbsp;Save</button>
    <button class="btn btn-danger" type="button" id="reset_btn"><i class="fa fa-eraser"></i>&nbsp;&nbsp;Reset</button>
</div>
<input type="hidden" name="current_user" id="current-user" class="form-control " required value="{{Auth::user()->id}}">
<input type="hidden" name="id" id="id" class="form-control " required value="{{$data->id ?? ''}}">