<!-- summary -->
<form id="add-summary-form">
	@csrf
	<div class="col-lg-12 mb-5" id="final-summary">
		<div class="property-top-section">
		    <div class="row mb-3">
		        <div class="col-md-8 col-lg-8">
		            <div class="single__detail-title ">
		                <p class="text-primary mb-2" style="font-size: 25px;">{{ $data->category->name ?? '' }}</p>
		                <h2 class="text-capitalize">{{$data->name ?? ''}}</h2>
		            </div>
		        </div>
		        <div class="col-md-4 col-lg-4">
		            <div class="single__detail-price">
		                <h2 class="text-capitalize text-gray property-price" id="summary-price-display">₱{{number_format($data->price ?? 0, 2)}}</h2>
		            </div>
		        </div>
		    </div>

		    <div class="col-md-12 mb-5" style="padding-bottom: 17px !important;">
		        <img class="lazy" id="summary-image-preview" src="{{$data->image ?? ''}}" onerror="this.src='/assets/images/default/no_image.png'" width="100%" max-height="600px;" alt="">
		    </div>

		    <h3 class="text-capitalize text-gray"> ORDER SUMMARY</h3>
		    <table class="table text-center table-bordered table-summary" style="border-collapse: collapse; ">
		        <tr class="geo-secondary">
		            <th width="30%"></th>
		            <th>Details</th>
		            <th width="15%">Code</th>
		            <th>Price</th>
		        </tr>
		        <tr class="text-center">
		        	<td>Product Name</td>
		        	<td>
		        		<span id="summary-name" class="text-center"></span>
		        		<input type="hidden" id="summary-id" name="summary_id" class="form-control" readonly>
		        	</td>
		        	<td>-</td>
		        	<td class="text-right">
		        		<span id="summary-basic-price-txt"></span>
		        		<input type="hidden" id="summary-basic-price" class="form-control text-right" readonly>
		        	</td>
		        </tr>
		        <tr>
		        	<td>Product Style</td>
		        	<td>
		        		<span id="summary-style" class="text-center"></span>
		        		<input type="hidden" id="summary-style-id" name="summary_style_id" class="form-control" readonly>
		        	</td>
		        	<td>-</td>
		        	<td class="text-right">
		        		<span id="summary-style-price-txt" class="text-center"></span>
		        		<input type="hidden" id="summary-style-price" class="form-control text-right" readonly>
		        	</td>
		        </tr>
		        <tr>
		        	<td>Layout Design</td>
		        	<td>
		        		<span id="summary-layout-design-txt" class="text-center"></span>
		        		<input type="hidden" id="summary-layout-design" name="summary_layout_design" class="form-control text-center" readonly>
		        	</td>
		        	<td>-</td>
		        	<td class="text-right">
		        		-
		        	</td>
		        </tr>
		        <tr>
		        	<td>Product Size</td>
		        	<td>
		        		<span id="summary-size-txt" class="text-center"></span>
		        		<input type="hidden" id="summary-size" name="summary_size" class="form-control text-center" readonly>
		        		<input type="hidden" id="summary-size-id" name="summary_size_id" class="form-control text-center" readonly>
		        		<input type="hidden" id="summary-size-type" name="summary_size_type" class="form-control text-center" readonly>
		        	</td>
		        	<td>-</td>
		        	<td class="text-right">
		        		<span id="summary-size-price-txt"></span>
		        		<input type="hidden" id="summary-size-price" name="summary_size_price" class="form-control text-right" readonly>
		        	</td>
		        </tr>
		        <tr>
		        	<td>Product Color</td>
		        	<td>
		        		<span id="summary-color-txt" class="text-center"></span>
		        		<input type="hidden" id="summary-color" class="form-control text-center" readonly>
		        		<input type="hidden" id="summary-color-id" name="summary_color_id" class="form-control" readonly>
		        	</td>
		        	<td>
		        		<span id="summary-color-code" class="text-center"></span>
		        	</td>
		        	<td class="text-right">
		        		<span id="summary-color-price-txt"></span>
		        		<input type="hidden" id="summary-color-price" class="form-control text-right" readonly>
		        	</td>
		        </tr>
		        @foreach($features as $skey => $feature)
			        <tr>
			        	<td>Product {{$feature->name ?? ''}}</td>
			        	<td>
			        		<span id="summary-feature-{{$feature->id}}-txt" class="text-center"></span>
			        		<input type="hidden" id="summary-feature-{{$feature->id}}" class="form-control text-center" readonly>
			        		<input type="hidden" id="summary-feature-id-{{$feature->id}}" name="summary_feature_id_{{$feature->id}}" class="form-control" readonly>
			        		<input type="hidden" name="summary_fid_{{$feature->id}}" class="form-control" readonly value="{{$feature->id ?? ''}}">
			        	</td>
			        	<td>
			        		<span id="summary-feature-code-{{$feature->id}}-txt" class="text-center"></span>
			        	</td>
			        	<td class="text-right">
			        		<span id="summary-feature-price-{{$feature->id}}-txt"></span>
			        		<input type="hidden" id="summary-feature-price-{{$feature->id}}" class="form-control text-right" readonly>
			        	</td>
			        </tr>
			    @endforeach
			    <tr>
		        	<td>Total Price</td>
		        	<td colspan="3" class="text-right">
		        		<span id="summary-total-price-txt"></span>
		        		<input type="hidden" id="summary-total-price" name="summary_total_price" class="form-control text-right" readonly>
		        	</td>
		        </tr>
		    </table>
		    <br>
		    <h3 class="text-capitalize text-gray"> CUSTOMER INFORMATION</h3>
		    <div class="row">
		    	<div class="col-md-6 mb-3">
		    		<label>First Name</label>
		    		<input type="text" name="first_name" class="form-control" required  placeholder="Insert Customer First Name">
		    	</div>
		    	<div class="col-md-6 mb-3">
		    		<label>Last Name</label>
		    		<input type="text" name="last_name" class="form-control" required  placeholder="Insert Customer Last Name">
		    	</div>
		    	<div class="col-md-6 mb-3">
		    		<label>Phone Number</label>
		    		<input type="text" name="phone" class="form-control" required  placeholder="Insert Customer Number">
		    	</div>
		    	<div class="col-md-6 mb-3">
		    		<label>Email</label>
		    		<input type="text" name="email" class="form-control" required  placeholder="Insert Customer Email">
		    	</div>
		    	<div class="col-md-6 mb-3">
		    		<label>Appointment Date</label>
		    		<input type="date" name="appointment_date" class="form-control" required  placeholder="Insert Appointment Date">
		    	</div>
		    	<div class="col-md-6 mb-3">
		    		<label>Appointment Time</label>
		    		<input type="time" name="appointment_time" class="form-control" required  placeholder="Insert Appointment Time">
		    	</div>
		    	<div class="col-md-12 mb-3">
		    		<label>Remarks/Notes:</label>
		    		<input type="text" name="remarks" class="form-control" required  placeholder="Insert Additional Request/Features...">
		    	</div>
		    </div>
		    <p style="font-size: 14px;color: red; font-style: italic;">
		    	Note: Price indicated is only an estimate based on the features selected. Price will vary depending on the exact measurements done on-site and other additional features that the Client will opt to have.
		    </p>
		    <a id="generated-pdf-a" href="" download target="_blank" hidden></a>
		    <div class="col-md-12 text-right">
		    	@if(count($features) == 0)
		    		<button type="button" class="btn btn-outline-warning btn-sm-on-small" onclick="pageChange('final-summary','divrow-color')">
		    		    <i class="fa fa-chevron-left" aria-hidden="true"></i>
		    		    Back&emsp;
		    		</button>
		    	@else
		    		<button type="button" class="btn btn-outline-warning btn-sm-on-small" onclick="pageChange('final-summary','divrow-feature-{{count($features) - 1}}')">
		    		    <i class="fa fa-chevron-left" aria-hidden="true"></i>
		    		    Back&emsp;
		    		</button>
		    	@endif

			    <button class="btn btn-outline-success btn-sm-on-small" value="{{Auth::user()->id ?? ''}}" id="eid">
			        <i class="fa fa-calendar-check-o" aria-hidden="true"></i>
			        Book Appointment&emsp;
			    </button>
			</div>
		</div>
	</div>
</form>