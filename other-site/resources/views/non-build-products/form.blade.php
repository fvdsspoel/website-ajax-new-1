<div class="card mb-4">
    <div class="card-header">
        <div class="col-md-12 row">
            <h5><strong>PRODUCT DETAILS</strong></h5>
        </div>
    </div>
    <div class="card-body">
        <div class="col-md-12 p-1">
            <div class="row">
                <div class="col-md-4">
                    <label>Name</label>
                    <input type="text" name="category_name" class="form-control" required  placeholder="Insert Category Name" value="{{$data->name ?? ''}}">
                    <br>
                    <label>Category</label>
                    <select name="category_id" id="category-id" class="form-control">
                        @foreach($categories as $category)
                            <option value="{{$category->id}}">{{$category->name}}</option>
                        @endforeach
                        <input type="hidden" id="category-val" value="{{$data->category_id ?? ''}}" />
                    </select>
                </div>
                <div class="col-md-4">
                    <label>&nbsp;</label>
                    <div class="col-md-12 image-div">
                        <label title="Click for change image" style="cursor: pointer;width: 100%">
                            <img id="preview-0" src="{{$data->image ?? ''}}" onerror="this.src='/assets/images/default/up-img-1.png'" alt="your image" width="300px;" height="200px;" class="image-preview" />
                            <input type="file" name="image" style="display: none;" id="multi-selected-0"  autocomplete="off"  onchange="readURL(this,0);"  required readonly>
                        </label>
                        <input type="hidden" id="multi-selected-id-0" name="multi_selected_image" value="old"  class="form-control input-sm style_input"  autocomplete="off"  />
                        <p class="text-center image-label mt-1">Upload Image Thumbnail Here</p>
                    </div>
                </div>
                <div class="col-md-4">
                    <label>&nbsp;</label>
                    <div class="col-md-12 image-div">
                        <label title="Click for change image" style="cursor: pointer;width: 100%">
                            <img id="preview--1" src="{{$data->image_mobile ?? ''}}" onerror="this.src='/assets/images/default/up-img-1.png'" alt="your image" width="300px;" height="200px;" class="image-preview" />
                            <input type="file" name="image_mobile" style="display: none;" id="multi-selected--1"  autocomplete="off"  onchange="readURL(this,-1);"  required readonly>
                        </label>
                        <input type="hidden" id="multi-selected-id--1" name="multi_selected_image_mobile" value="old"  class="form-control input-sm style_input"  autocomplete="off"  />
                        <p class="text-center image-label mt-1">Upload Image MobileThumbnail Here</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="card mb-4">
    <div class="card-header">
        <div class="col-md-12 row">
            <h5><strong>SUB PRODUCT DETAILS</strong></h5>
        </div>
    </div>
    <div class="card-body">
        <div class="col-md-12 p-1">
            <div class="row pl-3 pr-3">
                <button type="button" class="btn btn-sm btn-success" onclick="addProduct()"><span class="glyphicon glyphicon-plus-sign"></span> Add</button>&nbsp;
                <button type="button" class="btn btn-sm btn-danger" onclick="removeProduct()"><span class="glyphicon glyphicon-remove-sign"></span> Delete</button>&nbsp;

                <table id="table-product" class="table table-bordered" style="margin-top: 15px;">
                    <tr class="text-center">
                        <td width="5%"></td>
                        <th width="15%">Image</th>
                        <th width="15%">Price</th>
                        <th>Name</th>
                        <th>Description</th>
                    </tr>
                </table>
            </div>
        </div>
    </div>
</div>

<div class="right">
    <button class="btn btn-success" value="{{Auth::user()->id ?? ''}}" id="eid"><i class="fa fa-save"></i>&nbsp;&nbsp;Save</button>
    <button class="btn btn-danger" type="button" id="reset_btn"><i class="fa fa-eraser"></i>&nbsp;&nbsp;Reset</button>
</div>
<input type="hidden" name="current_user" id="current-user" class="form-control " required value="{{Auth::user()->id}}">
<input type="hidden" name="id" id="id" class="form-control " required value="{{$data->id ?? ''}}">