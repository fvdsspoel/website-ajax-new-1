<div class="row">
    <div class="col-md-12">
    	<div class="row pl-3 pr-3">
    		<h5>Category Details</h5>
    		<div class="col-md-12 p-1">
    			<div class="row">
    				<div class="col-md-8">
    					<label>Name</label>
    					<input type="text" name="name" class="form-control" required  placeholder="Insert Title" value="{{$data->name ?? ''}}">
    					<br>
    					<label>Description</label>
    					<input type="text" name="description" class="form-control" required  placeholder="Insert Title" value="{{$data->description ?? ''}}">
                        <br>
                        <label>Description</label>
                        <select name="category_type" id="category-type" class="form-control" required>
                            <option value="Buildable">Buildable</option>
                            <option value="Non Buildable">Non Buildable</option>
                        </select>
                        <input type="hidden" id="category-type-val" value="{{$data->category_type ?? ''}}">

    				</div>
                    <div class="col-md-4">
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
    		<br>

    		<h5>Sub Category</h5>
    		<div class="col-md-12 p-1">
    			<div class="row">
    				<div class="col-md-12">
    					<div class="col-md-12 p-1 table-responsive">
    						<button type="button" class="btn btn-sm btn-success" onclick="addRow()"><span class="glyphicon glyphicon-plus-sign"></span> Add</button>&nbsp;
    						<button type="button" class="btn btn-sm btn-danger" onclick="removeRow()"><span class="glyphicon glyphicon-remove-sign"></span> Delete</button>&nbsp;
    						<table id="table-sub-category" class="table table-bordered" style="margin-top: 15px;">
    						    <tr>
    						        <td width="3%"></td>
    						        <th width="20%">Sub Category Image</th>
    						        <th>Sub Category Name</th>
    						    </tr>
    						</table>
    					</div>
    				</div>
    			</div>
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