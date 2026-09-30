<div class="row">
    <div class="col-md-12">
    	<div class="row pl-3 pr-3">
    		<h5>Partner Details</h5>
    		<div class="col-md-12 p-1">
    			<div class="row">

    				<div class="col-md-8">
    					<label>Name</label>
    					<input type="text" name="name" class="form-control" required  placeholder="Insert Name" value="{{$data->name ?? ''}}">
    				</div>
                    <div class="col-md-4">
                        <label>&nbsp;</label>
                        <div class="col-md-12 image-div">
                            <label title="Click for change image" style="cursor: pointer;width: 100%">
                                <img id="preview-0" src="{{$data->image ?? ''}}" onerror="this.src='/assets/images/default/up-img-1.png'" alt="your image" width="250px;" height="200px;" class="image-preview" />
                                <input type="file" name="image" style="display: none;" id="multi-selected-0"  autocomplete="off"  onchange="readURL(this,0);"  required readonly>
                            </label>
                            <input type="hidden" id="multi-selected-id-0" name="multi_selected_image" value="old"  class="form-control input-sm style_input"  autocomplete="off"  />
                            <p class="text-center image-label mt-1">Upload Partner Image Thumbnail Here</p>
                        </div>
                    </div>

    			</div>
    		</div>
    	</div>
    </div>
</div>
<br>

<div class="right">
    <button class="btn btn-success" value="{{Auth::user()->id ?? ''}}" id="eid"><i class="fa fa-save"></i>&nbsp;&nbsp;Save</button>
    <button class="btn btn-danger" type="button" id="reset_btn"><i class="fa fa-eraser"></i>&nbsp;&nbsp;Reset</button>
</div>
<input type="hidden" name="current_user" id="current-user" class="form-control " required value="{{Auth::user()->id}}">
<input type="hidden" name="id" id="id" class="form-control " required value="{{$data->id ?? ''}}">