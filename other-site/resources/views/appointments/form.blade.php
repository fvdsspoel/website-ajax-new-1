<div class="card">
    <div class="card-header">
        <div class="row">
            <div class="col-md-6">
                <h5><strong>PRODUCT DETAILS</strong></h5>
            </div>
            <div class="col-md-6">
                <a href="/appointments/index" class="right btn geo-primary mb-1 text-light" data-toggle="tooltip" title="Browse List">
                    <i class="fa fa-list"></i>&nbsp;&nbsp;Browse
                </a>
            </div>
        </div>
    </div>
    <div class="card-body">
    	<div class="col-md-12 p-1">
    		<div class="row">
    			<div class="col-md-6 mb-3">
    				<label>Product Name</label>
    				<input type="text" value="{{$data->product->name ?? ''}}" readonly class="form-control">
    			</div>

    			<div class="col-md-6  mb-3">
    				<label>Total Price</label>
    				<input type="text" value="{{number_format($data->final_price ?? 0,2)}}" readonly class="form-control">
    			</div>

    			<div class="col-md-6  mb-3">
    				<label>Style Name</label>
    				<input type="text" value="{{$data->productStyle->name ?? ''}}" readonly class="form-control">
    			</div>

    			<div class="col-md-6  mb-3">
    				<label>Style Price</label>
    				<input type="text" value="{{number_format($data->productStyle->price ?? 0,2)}}" readonly class="form-control">
    			</div>

    			<div class="col-md-6  mb-3">
    				<label>Layout Design</label>
    				<input type="text" value="{{$data->layout_design ?? ''}}" readonly class="form-control">
    			</div>

    			<div class="col-md-6  mb-3">
    				<label>Size Type</label>
    				<input type="text" value="{{$data->size_type ?? ''}}" readonly class="form-control">
    			</div>

    			<div class="col-md-6  mb-3">
    				<label>Size</label>
    				<input type="text" value="{{$data->size ?? ''}}" readonly class="form-control">
    			</div>

    			<div class="col-md-6  mb-3">
    				<label>Size Price</label>
    				<input type="text" value="{{number_format($data->size_price ?? 0,2)}}" readonly class="form-control">
    			</div>

    			<div class="col-md-6  mb-3">
    				<label>Color Name</label>
    				<input type="text" value="{{$data->productColor->name ?? ''}}" readonly class="form-control">
    			</div>

    			<div class="col-md-6  mb-3">
    				<label>Color Price</label>
    				<input type="text" value="{{number_format($data->productColor->price ?? 0,2)}}" readonly class="form-control">
    			</div>

    			@foreach($feature_details as $feature_detail)
    				<div class="col-md-6  mb-3">
	    				<label>{{$feature_detail->productFeature->name ?? ''}} Name</label>
	    				<input type="text" value="{{$feature_detail->name ?? ''}}" readonly class="form-control">
	    			</div>

	    			<div class="col-md-6  mb-3">
	    				<label>{{$feature_detail->productFeature->name ?? ''}} Price</label>
	    				<input type="text" value="{{number_format($feature_detail->price ?? 0,2)}}" readonly class="form-control">
	    			</div>
    			@endforeach

    		</div>
    	</div>
    </div>
</div>

<div class="card mt-5">
    <div class="card-header">
        <div class="row">
            <div class="col-md-6">
                <h5><strong>CUSTOMER DETAILS</strong></h5>
            </div>
        </div>
    </div>
    <div class="card-body">
    	<div class="col-md-12 p-1">
    		<div class="row">
    			<div class="col-md-6 mb-3">
    				<label>Customer Name</label>
    				<input type="text" value="{{$data->label ?? ''}}" readonly class="form-control">
    			</div>

    			<div class="col-md-6 mb-3">
    				<label>Customer Email</label>
    				<input type="text" value="{{$data->email ?? ''}}" readonly class="form-control">
    			</div>

    			<div class="col-md-6 mb-3">
    				<label>Customer Phone Number</label>
    				<input type="text" value="{{$data->phone_no ?? ''}}" readonly class="form-control">
    			</div>

    			@if($data->link)
	    			<div class="col-md-6 mb-3">
	    				<label>Order Summary PDF</label>
	    				<br>
	    				<a class="pdf-a" href="{{$data->link}}" target="_blank">VIEW FILE</a>
	    			</div>
	    		@endif
    		</div>
    	</div>
    </div>
</div>