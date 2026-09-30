<!-- product style -->
<div class="row">
    <div class="col-md-12">
        <div class="row pl-3 pr-3">
        	<h5>Product View</h5>
        	<div class="col-md-12 p-1">
        	    <div class="row">
        	        <div class="col-md-12">
        	        	<button type="button" class="btn btn-sm btn-success" onclick="addView()"><span class="glyphicon glyphicon-plus-sign"></span> Add</button>&nbsp;
        	        	<button type="button" class="btn btn-sm btn-danger" onclick="removeView()"><span class="glyphicon glyphicon-remove-sign"></span> Delete</button>&nbsp;
        	        	<table id="table-view" class="table table-bordered" style="margin-top: 15px;">
        	        	    <tr class="text-center">
        	        	        <td width="3%"></td>
        	        	        <th>Name</th>
        	        	        @foreach($styles as $key => $style)
        	        	        	<th width="15%">
                                        {{$style->name ?? ''}}
                                        <input type="hidden" name="style_id[]" id="style-id{{$key + 1}}" class="form-control" required value="{{$style->id ?? ''}}" readonly>
                                    </th>
        	        	        @endforeach
        	        	    </tr>
        	        	</table>
        	        </div>
        	    </div>
        	</div>
        </div>
    </div>
</div>

<!-- product size -->
<div class="row mt-5">
    <div class="col-md-12">
        <div class="row pl-3 pr-3">
        	<h5>Product Sizes</h5>
        	<div class="col-md-12 p-1">
        		<div class="row">
        			<div class="col-md-12">
        				<table id="table-sizes" class="table table-bordered" style="margin-top: 15px;">
        				    <tr class="text-center">
        				        <th width="20%">Style</th>
        				        <th>Image</th>
        				        <th>Width</th>
        				        <th>Length</th>
        				        <th>Height</th>
        				        <th>Circumference</th>
        				    </tr>
        				    @foreach($styles as $key => $style)
        				    	<tr>
        				    		<td>
        				    			<input type="text" name="size_style[]" class="form-control" required value="{{$style->name ?? ''}}" readonly>
        				    			<input type="hidden" name="size_style_id[]" class="form-control" required value="{{$style->id ?? ''}}" readonly>
        				    			<input type="hidden" name="size_id[]" class="form-control" required value="{{$sizes[$key]->id ?? ''}}" readonly>
        				    		</td>
	    				    		<td>
	    				    			<img id="preview-size-{{$key}}" data-action="zoom" src="{{$sizes[$key]->image ?? ''}}" onerror="this.src='/assets/images/default/no_image.png'" alt="your image" height="80"/>
	        	                        <br>
	        	                        <input type="file" name="multi_view_size[]" id="multi-selected-size-{{$key}}"  autocomplete="off"  onchange="readSizeURL(this);" keyval="{{$key}}" class="mb-2 stylefileinput" required >
	        	                        <input type="hidden" id="multi-selected-id-size-{{$key}}" name="multi_style_id_size[]" value="old"  class="form-control input-sm style_input"  autocomplete="off"  />

	    				    		</td>
	    				    		<td>
	    				    			<input type="number" id="size-width-{{$key}}" name="size_width[]" class="form-control" placeholder="Insert width" min="1" step="any" value="{{$sizes[$key]->width ?? ''}}">
	    				    		</td>
	    				    		<td>
	    				    			<input type="number" id="size-length-{{$key}}" name="size_length[]" class="form-control" placeholder="Insert length" min="1" step="any" value="{{$sizes[$key]->length ?? ''}}">
	    				    		</td>
	    				    		<td>
	    				    			<input type="number" id="size-height-{{$key}}" name="size_height[]" class="form-control" placeholder="Insert height" min="1" step="any" value="{{$sizes[$key]->height ?? ''}}">
	    				    		</td>
	    				    		<td>
	    				    			<input type="number" id="size-circumference-{{$key}}" name="size_circumference[]" class="form-control" placeholder="Insert circumference" min="1" step="any" value="{{$sizes[$key]->circumference ?? ''}}">
	    				    		</td>
        				    	</tr>
        				    @endforeach
        				</table>
        			</div>
        		</div>
        	</div>
        </div>
    </div>
</div>

<!-- colors -->
<div class="row mt-5">
    <div class="col-md-12">
        <div class="row pl-3 pr-3">
            <div class="col-md-12 p-1">
                <div class="row">
                    <div class="col-md-12">
                        <h5>Product Colors</h5>
                        <button type="button" class="btn btn-sm btn-success" onclick="addColor()"><span class="glyphicon glyphicon-plus-sign"></span> Add</button>&nbsp;
                        <button type="button" class="btn btn-sm btn-danger" onclick="removeColor()"><span class="glyphicon glyphicon-remove-sign"></span> Delete</button>&nbsp;
                        <table id="table-color" class="table table-bordered" style="margin-top: 15px;">
                            <tr class="text-center">
                                <td width="3%"></td>
                                <th width="25%">Image</th>
                                <th width="25%">Name</th>
                                <th  width="15%">Price</th>
                                <th>Description</th>
                            </tr>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- other feature -->
<input type="hidden" id="total-other-feature" value="{{count($features) ?? 0}}" />
@foreach($features as $key => $feature)
    <div class="row mt-5">
        <div class="col-md-12">
            <div class="row pl-3 pr-3">
                <div class="col-md-12 p-1">
                    <div class="row">
                        <div class="col-md-12">
                            <h5>Product {{$feature->name}}</h5>
                            <button type="button" class="btn btn-sm btn-success" value="{{$key}}" onclick="addFeature(null,this.value)"><span class="glyphicon glyphicon-plus-sign"></span> Add</button>&nbsp;
                            <button type="button" class="btn btn-sm btn-danger" value="{{$key}}" onclick="removeFeature(this.value)"><span class="glyphicon glyphicon-remove-sign"></span> Delete</button>&nbsp;
                            <input type="hidden" id="featurekey-{{$key}}" value="0" />
                            <input type="hidden" id="featureidval-{{$key}}" value="{{$feature->id}}" />
                            <input type="hidden" id="fkey-{{$feature->id}}" value="{{$key}}" />
                            <table id="table-feature-{{$key}}" class="table table-bordered" style="margin-top: 15px;">
                                <tr class="text-center">
                                    <td width="3%"></td>
                                    <th width="25%">Image</th>
                                    <th width="25%">Name</th>
                                    <th  width="15%">Price</th>
                                    <th>Description</th>
                                </tr>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endforeach

<!-- product basic size & color-->
<div class="row mt-5">
    <div class="col-md-12">
        <div class="row pl-3 pr-3">
        	<div class="col-md-12 p-1">
        		<div class="row">
        			<!-- product basic size -->
        			<div class="col-md-6">
        				<h5>Product Basic Sizes</h5>
        				<button type="button" class="btn btn-sm btn-success" onclick="addBasicSize()"><span class="glyphicon glyphicon-plus-sign"></span> Add</button>&nbsp;
        				<button type="button" class="btn btn-sm btn-danger" onclick="removeBasicSize()"><span class="glyphicon glyphicon-remove-sign"></span> Delete</button>&nbsp;
        				<table id="table-basic-size" class="table table-bordered" style="margin-top: 15px;">
        				    <tr class="text-center">
        				        <td width="3%"></td>
        				        <th>Basic Size</th>
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
<input type="hidden" name="style_count" id="style-count" class="form-control " required value="{{count($styles) ?? 0}}">
<input type="hidden" name="view_count" id="view-count" class="form-control " required value="{{$view_count ?? 0}}">