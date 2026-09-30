let final_image = null;
$( document ).ready(function() {

	//price 
	$('#final-price').val($('#price').val());

	/*default selected radio button*/
	// style
	$('#stylediv-0').addClass('style-div-active');
	$('#product-style-0').attr('checked', true);

	// view
	$('#radio-0').attr('checked', true);

	//basic sizes
	$('#basic-radio-0').attr('checked', true);
	$('#basicsizediv-0').addClass('basic-div-active');

	//color
	$(`#color-style-0`).prop('checked', true);
	$('#colordiv-0').addClass('color-div-active');
	$('#colorimage-0').addClass('color-image-active');

	//feature
	fnum = parseInt($('#feature-num').val());
	for(f=0; f < fnum; f++){

		$(`#feature-style${f}-0`).prop('checked', true);
		$(`#featurediv${f}-0`).addClass('feature-div-active');
		$(`#featureimage${f}-0`).addClass('feature-image-active');
	}

	//get default show card
	defaultDiv();

	//get width of custome size
	getSizes();

	//change image
	changeImagePreview();
});

function defaultDiv(){
	
	$('#final-summary').hide();
	$('#divrow-size').hide();
	$('#divrow-color').hide();
	fnum = parseInt($('#feature-num').val());
	for(f=0; f < fnum; f++){

		$(`#divrow-feature-${f}`).hide();
	}
}

function getSizes(){

	style_id = $("input:radio[name=product_style]:checked").val();
	product_id = $("#id").val();
	token = $('#subscribe-token').val();
	$.ajax({
	    type: "post",
	    url: "/products/style-sizes",
	    data: {
	    	style_id:style_id,
	    	product_id:product_id,
	     	_token:token
	    },
	    dataType: 'JSON',
	    success: function (res) {
	    	if(res){
	    		styleSize(res);
	    	}
	    },
	    error: function(error) {
	        showHttpErrorAlert(error);
	    } 
	});
}

function styleSize(arr){

	data = arr[0];
	len = parseInt(arr[1]);

	$('#size-img').attr("src", data.image);
	$('#div-size').empty();

	for(i= 1; i <= len; i++){

		elements = `
						<div class="size-div mt-4">
							<input type="number" id="width-${i}" name="width[]" placeholder="${i}) Enter Width (cm)" class="customsize form-control size-input mr-1" onChange="customSizeChange();">
						</div>
					`;

		$('#div-size').append(elements);
	}

	$('#custom-width-count').val(len);
}

//change value of custom size and remove selection in basic size
function customSizeChange(){
	$(".basic-radio").attr('checked', false);
	$(".basic-radio").prop('checked', false);
	$('.basic-size-div').removeClass('basic-div-active');
	$('#size-type').val('custom_size');

	len = $('#custom-width-count').val();
	sp = 0;
	for (var i = 1; i <= parseInt(len); i++) {
		size = $(`#width-${i}`).val();
		// check size price
		$.ajax({
	        type: "post",
	        url: "/size-prices/check",
	        data: {
	        	size: size,
	        	_token:token
	        },
	        dataType: 'JSON',
	        success: function (res) {
	            if(res){
	            	sp = sp + parseFloat(res.price);
	            }
	            $('#size-price').val(sp);
	            changePrice();
	        }, 
	        error: function(error) {
	            showHttpErrorAlert(error);
	        } 
	    });
	}
}

//change value of basic size and remove selection in custom size
$(".basic-size-div").on("click", function () {
    $(this).find('input.basic-radio').prop('checked', true);
    $('.basic-size-div').removeClass('basic-div-active');
    $(this).addClass('basic-div-active');
    $('.customsize').val(null);
    $('#size-type').val('basic_size');
    $('#size-price').val(0);
    changePrice();
});

//layout design
$(".layoutdesignradio").on("click", function () {

	$('#build-image-preview').removeClass('flipped');
	$('#size-img').removeClass('flipped');
	if(this.value == 'Mirrored'){
		$('#build-image-preview').addClass('flipped');
		$('#size-img').addClass('flipped');
	}
});

//onchange of radio button style
$(".style-div").on("click", function () {

	stylekey = parseFloat($(this).attr('key-count'));

	//css selected
    $(this).find('input.style-radio').prop('checked', true);
    $('.style-div').removeClass('style-div-active');
    $(this).addClass('style-div-active');

    //change price
    $('#style-price').val($(`#pricestyle-${stylekey}`).val());
    changePrice();

    //change custome size width
    getSizes();

    //change image
    changeImagePreview();
});

//onchange of radio button view
$("input:radio[name=radio_view]").click(function(){
 	changeImagePreview();
});

//onchange of radio button colors
$(".color-div").on("click", function () {

	//css selected
    $(this).find('input.color-radio').prop('checked', true);
    $('.color-div').removeClass('color-div-active');
    $(this).addClass('color-div-active');

    key = $(this).attr('key-count');
    $('.color-image').removeClass('color-image-active');
    $(`#colorimage-${key}`).addClass('color-image-active');
    // $('#finalcodecolor').val($(`#codecolor-${key}`).val());

    //change price
    $('#color-price').val($(`#pricecolor-${key}`).val());
    changePrice();

    //change image
    changeImagePreview();
});

//onchange of radio button features
$(`.feature-div`).on("click", function () {

	//css selected
	key = $(this).attr('key-count');
	key2 = $(this).attr('key2-count');
	$(`#feature-style${key}-${key2}`).prop('checked', true);

	$(`.featurediv-${key}`).removeClass('feature-div-active');
	$(this).addClass('feature-div-active');

	$(`.featureimage-${key}`).removeClass('feature-image-active');
	$(`#featureimage${key}-${key2}`).addClass('feature-image-active');

    //change price
    $(`#feature-price-${key}`).val($(`#pricefeature${key}-${key2}`).val());
    // $(`#finalcodefeature-${key}`).val($(`#codefeature${key}-${key2}`).val());
    changePrice();

    //change image
    changeImagePreview();
});

function changePrice(val){
	
	basic_price = $('#price').val();
	style_price = $('#style-price').val();
	size_price = $('#size-price').val();
	color_price = $('#color-price').val();
	feature_price = 0;

	fnum = parseInt($('#feature-num').val());
	for(f=0; f < fnum; f++){

		fprice = $(`#feature-price-${f}`).val();
		feature_price = parseFloat(feature_price) + parseFloat(fprice);
	}

	total_price = parseFloat(basic_price) + parseFloat(style_price) + parseFloat(size_price) + parseFloat(color_price) + parseFloat(feature_price);
	$('#final-price').val(total_price);

	let USDollar = new Intl.NumberFormat('fil-PH', {
	    style: 'currency',
	    currency: 'PHP',
	});
	$('#property-price-val').text(`${USDollar.format(total_price)}`);
}

// change pages
function pageChange(hidediv,showdiv){
	
	console.log({hide:hidediv,show:showdiv});
	if(hidediv == 'final-summary'){
		$('#product-order').show();
		$('.divrowfeature').hide();
	}
	$(`#${hidediv}`).hide();
	$(`#${showdiv}`).show();
}

//change image preview
function changeImagePreview(is_build){

	product_id = $('#id').val();
	style_id = $("input:radio[name=product_style]:checked").val();
	view_id = $("input:radio[name=radio_view]:checked").val();
	color_id = $("input:radio[name=color_style]:checked").val();

	feature_id = '';
	feature_detail_id = '';

	fnum = parseInt($('#feature-num').val());
	for(f=0; f < fnum; f++){

		fid = $(`#feature-id-${f}`).val();
		fdid = $(`input:radio[name=feature_style${f}]:checked`).val();

		feature_id = feature_id + ',' + fid;
		feature_detail_id = feature_detail_id + ',' + fdid;
	}

	// console.log({product_id,style_id,view_id,color_id,feature_id,feature_detail_id});

	$('#build-image-preview').attr("src", '/assets/images/default/image-loader.gif');
	$.ajax({
	    type: "post",
	    url: "/products/get-setting-detail",
	    data: {
	    	product_id:product_id,
	    	style_id:style_id,
	    	view_id:view_id,
	    	color_id:color_id,
	    	feature_id:feature_id,
	    	feature_detail_id:feature_detail_id,
	     	_token:token
	    },
	    dataType: 'JSON',
	    success: function (res) {
	    	if(res){
	    		final_image = res.image;
	    		$('#build-image-preview').attr("src", res.image);
	    	}
	    },
	    error: function(error) {
	        showHttpErrorAlert(error);
	    } 
	});
}

function showSummary(){

	final_price = 0;

	product_id = $('#id').val();
	style_id = $("input:radio[name=product_style]:checked").val();
	view_id = $("input:radio[name=radio_view]:checked").val();
	color_id = $("input:radio[name=color_style]:checked").val();
	layout_design = $("input:radio[name=layout_design]:checked").val();

	size_type = $('#size-type').val();
	size_id = $("input:radio[name=basic_radio]:checked").val();

	feature_id = [];
	feature_detail_id = [];

	fnum = parseInt($('#feature-num').val());
	for(f=0; f < fnum; f++){

		fid = $(`#feature-id-${f}`).val();
		fdid = $(`input:radio[name=feature_style${f}]:checked`).val();

		feature_id.push(fid);
		feature_detail_id.push(fdid);
	}

	$.ajax({
	    type: "post",
	    url: "/products/get-product-setting-detail",
	    data: {
	    	product_id:product_id,
	    	style_id:style_id,
	    	view_id:view_id,
	    	color_id:color_id,
	    	feature_id:feature_id,
	    	feature_detail_id:feature_detail_id,
	    	size_id:size_id,
	    	size_type:size_type,
	     	_token:token
	    },
	    dataType: 'JSON',
	    success: function (res) {
	    	if(res){
	    		
	    		//details 
	    		$('#summary-image-preview').removeClass('flipped');
	    		if(layout_design == 'Mirrored'){
	    			$('#summary-image-preview').addClass('flipped');
	    		}
	    		
	    		$('#summary-image-preview').attr("src", final_image);
	    		$('#summary-name').text($('#name').val());
	    		$('#summary-id').val($('#id').val());
	    		$('#summary-basic-price-txt').text($('#price').val());
	    		$('#summary-basic-price').val($('#price').val());
	    		final_price = parseFloat(final_price) + parseFloat($('#price').val());

	    		//style
	    		$('#summary-style').text(res.style_name);
	    		$('#summary-style-id').val(res.style_id);
	    		$('#summary-style-price-txt').text(res.style_price);
	    		$('#summary-style-price').val(res.style_price);
	    		final_price = parseFloat(final_price) + parseFloat(res.style_price);

	    		//layout design 
	    		$('#summary-layout-design-txt').text(layout_design);
	    		$('#summary-layout-design').val(layout_design);

	    		//size
	    		size_price = $('#size-price').val();
	    		$('#summary-size-type').val(size_type);
	    		$('#summary-size-price').val(size_price);
	    		$('#summary-size-price-txt').text(parseFloat(size_price));
	    		final_price = parseFloat(final_price) + parseFloat(size_price);
	    		//add size price

	    		if(size_type == 'basic_size'){
	    			$('#summary-size-id').val(res.size_id);
	    			$('#summary-size').val(res.size_name);
	    			$('#summary-size-txt').text(res.size_name);
	    		}else{
	    			$('#summary-size-id').val(null);
	    			width_len = $('#custom-width-count').val();
	    			size_name = '';
	    			for(a = 1; a <= parseInt(width_len); a++) {
	    				if(a == 1){
	    					size_name = $(`#width-${a}`).val() + 'cm';
	    				}else{
	    					size_name = size_name + ' x ' + $(`#width-${a}`).val() + 'cm';
	    				}
	    			}
	    			$('#summary-size').val(size_name);
	    			$('#summary-size-txt').text(size_name);
	    		}

	    		//color
	    		console.log(res);
	    		$('#summary-color-txt').text(res.color_name);
	    		$('#summary-color').val(res.color_name);
	    		$('#summary-color-code').text(res.color_code);
	    		$('#summary-color-id').val(res.color_id);
	    		$('#summary-color-price-txt').text(res.color_price);
	    		$('#summary-color-price').val(res.color_price);
	    		final_price = parseFloat(final_price) + parseFloat(res.color_price);
	    		console.log(final_price);

	    		//feature
	    		for(f=0; f < fnum; f++){

	    			fid = $(`#feature-id-${f}`).val();
	    			flabel = res[`feature_detail_${fid}`];
	    			fcode = res[`feature_detail_code_${fid}`];
	    			fidlabel = res[`feature_detail_id_${fid}`];
	    			fpricelabel = res[`feature_detail_price_${fid}`];

	    			final_price = parseFloat(final_price) + parseFloat(fpricelabel);

	    			$(`#summary-feature-${fid}-txt`).text(flabel);
	    			$(`#summary-feature-code-${fid}-txt`).text(fcode);
	    			$(`#summary-feature-${fid}`).val(flabel);
	    			$(`#summary-feature-id-${fid}`).val(fidlabel);
	    			$(`#summary-feature-price-${fid}`).val(fpricelabel);
	    			$(`#summary-feature-price-${fid}-txt`).text(fpricelabel);

	    		}
	    		$('#summary-total-price-txt').text(final_price);
	    		$('#summary-total-price').val(final_price);
	    	}
	    },
	    error: function(error) {
	        showHttpErrorAlert(error);
	    } 
	});

	$('#final-summary').show();
	$('#product-order').hide();
}

function viewPriceSize(){
	$.ajax({
        type: "get",
        url: "/size-prices/get-data",
        data: null,
        dataType: 'JSON',
        success: function (res) {
            console.log(res);
            $('#sizeprice-modal').modal('show');
            $('#price-tboday').empty();
            for (var i = 0; i < res.length; i++) {
            	if(res[i].max_size){
            		size = res[i].min_size + 'cm - ' + res[i].max_size + 'cm';
            	}else{
            		size = 'Greater Than ' + res[i].min_size + 'cm';
            	}
            	$('#price-tboday').append(`
            								<tr>
            									<td>${size}</td>
            									<td>${res[i].price_format}</td>
            								</tr>
            							`);
            }
        },
        error: function(error) {
            showHttpErrorAlert(error);
        } 
    });
}