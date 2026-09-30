
@foreach($styles as $key_index => $style)
<h5>Style: {{$style->name ?? ''}}</h5>
<input type="hidden" name="feature_count" value="{{count($features)}}">
<input type="hidden" name="style_id[]" value="{{$style->id ?? ''}}">
<table id="table-sytle" class="table table-bordered mb-5" style="margin-top: 15px;">
    <tr>
        <th width="15%">Image</th>
        <th>View</th>
        <th>Color</th>
        @foreach($features as $feature)
        	<th>{{$feature->name ?? ''}}</th>
        @endforeach
    </tr>
    @foreach($image_combinations as $key => $image_combination)
    	<tr>
    		<td>
    			<img id="preview-{{$key_index}}{{$key}}" data-action="zoom" src="" onerror="this.src='/assets/images/default/no_image.png'" alt="your image" height="80"/>
                <br>
                <input type="file" name="image_{{$key_index}}[]" id="multi-selected-setting-{{$key_index}}{{$key}}"  autocomplete="off"  onchange="readURL(this,{{$key_index}},{{$key}});" keyval="{{$key}}" class="mb-2 stylefileinput"  >
                <input type="hidden" id="multi-selected-image-{{$key_index}}{{$key}}" name="multi_image_setting_{{$key_index}}[]" value="old"  class="form-control input-sm style_input"  autocomplete="off"  />
    		</td>
    		<td>
    			{{$image_combination['view_name']}}
    			<input type="hidden" name="view_id_{{$key_index}}[]" value="{{$image_combination['view_id']}}">
    		</td>
    		<td>
    			{{$image_combination['color_name']}}
    			<input type="hidden" name="color_id_{{$key_index}}[]" value="{{$image_combination['color_id']}}">
    		</td>
    		@foreach($features as $k => $feature)
    			<td>
    				{{$image_combination['feature_name_'.$k]}}
    				<input type="hidden" name="feature_detail_id_{{$key_index}}{{$key}}[]" value="{{$image_combination['feature_id_'.$k]}}">
    				<input type="hidden" name="feature_id_{{$key_index}}{{$key}}[]" value="{{$feature->id}}">
    			</td>
    		@endforeach
    	</tr>
    @endforeach
</table>
@endforeach

<div class="right pt-4">
    <button class="btn btn-success" value="{{Auth::user()->id ?? ''}}" id="eid"><i class="fa fa-save"></i>&nbsp;&nbsp;Save</button>
    <button class="btn btn-danger" type="button" id="reset_btn"><i class="fa fa-eraser"></i>&nbsp;&nbsp;Reset</button>
</div>
<input type="hidden" name="current_user" id="current-user" class="form-control " required value="{{Auth::user()->id}}">
<input type="hidden" name="product_id" id="product-id" class="form-control " required value="{{$id ?? ''}}">
<input type="hidden" name="id" id="id" class="form-control" value="{{$data->id ?? ''}}">