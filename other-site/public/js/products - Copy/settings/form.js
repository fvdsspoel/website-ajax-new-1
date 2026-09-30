let styleCount = 0;
let viewCount = 0;
let rowIndex = 0;
let basicIndex = 0;
let colorIndex = 0;
let fd = -1;

$(document).ready(function() {
	
	styleCount = parseInt($('#style-count').val());
	viewCount = parseInt($('#view-count').val());
    total_otherfeature = $('#total-other-feature').val();
	id = $('#id').val();

	if(viewCount == 0){
		addView();
		addBasicSize();
		addColor();

        for(f=0; f < parseInt(total_otherfeature); f++){
            addFeature(null,f)
        }

	}else{
		getView(id);
		getBasicSize(id);
		getColor(id);
        getFeature(id);
        $('.stylefileinput').attr('required',false);
	}
});

// product view
function getView(id){

	$.ajax({
	    type: "post",
	    url: "/products/views",
	    data: {
	      id:id
	    },
	    dataType: 'JSON',
	    success: function (res) {
	    	for(i=0; i < res.length; i++){
	    		addView(res[i]);
	    	}
	    },
	    error: function(error) {
	        showHttpErrorAlert(error);
	    } 
	});
}

function addView(data){

    rowIndex ++;
    len = styleCount + 2;
    let cells = generateTableRow('table-view', 'viewsheet_row', len);

    if(rowIndex == 1){
    	cells[0].innerHTML  = `<input type="checkbox" class="worksheet-row-index" onclick="return false"/>`;
    }else{
    	cells[0].innerHTML  = `<input type="checkbox" class="worksheet-row-index"/>`;
    }

    if(data){
    	cells[1].innerHTML  = `<input type="text" id="view-name-${rowIndex}" name="view_name[]" value="${data.name}" class="form-control border-only-bottom input-sm"  autocomplete="off" required placeholder="Insert View Name"/>`;

    	for(a = 1; a <= styleCount; a++){

    		cells[a+1].innerHTML  = `<img id="preview${a}-${rowIndex}" data-action="zoom" src="${data.val[a-1].style_image}" onerror="this.src='/assets/images/default/no_image.png'" alt="your image" height="80"/>
        	                         <br>
        	                        <input type="file"  name="multi_view${a}[]" id="multi-selected${a}-${rowIndex}"  autocomplete="off"  onchange="readViewURL(this,${a},${rowIndex});" class="mb-2"  >
        	                        <input type="hidden" id="multi-selected-id${a}-${rowIndex}" name="multi_style_id${a}[]" value="old"  class="form-control input-sm style_input"  autocomplete="off"  />`;
    		
    		cells[a+1].innerHTML  += `<input type="hidden" id="view-style-id-${rowIndex}" name="view_style_id[]" value="${data.val[a-1].style_id}" />`;
    		cells[a+1].innerHTML  += `<input type="hidden" id="view-id-${rowIndex}" name="view_id${a}[]" value="${data.val[a-1].view_id}" />`;
    	}
    	
    }else{

    	cells[1].innerHTML  = `<input type="text" id="view-name-${rowIndex}" name="view_name[]" class="form-control border-only-bottom input-sm"  autocomplete="off" required placeholder="Insert View Name"/>`;
        
        for(i = 1; i <= styleCount; i++){

        	cells[i+1].innerHTML  = `<img id="preview${i}-${rowIndex}" data-action="zoom" src="/assets/images/default/no_image.png" onerror="this.src='/assets/images/default/no_image.png'" alt="your image" height="80"/>
        	                         <br>
        	                        <input type="file"  name="multi_view${i}[]" id="multi-selected${i}-${rowIndex}"  autocomplete="off"  onchange="readViewURL(this,${i},${rowIndex});" class="mb-2" required >
        	                        <input type="hidden" id="multi-selected-id${i}-${rowIndex}" name="multi_style_id${i}[]" value="old"  class="form-control input-sm style_input"  autocomplete="off"  />`;
            cells[i+1].innerHTML  += `<input type="hidden" id="view-id-${rowIndex}" name="view_id${i}[]" />`;
        }
    }
}

function removeView()
{
    $('.worksheet-row-index:checkbox:checked').parents('tr.viewsheet_row').remove();
}

function readViewURL(input,a,i) {

    if (input.files && input.files[0]) {
        var reader = new FileReader();

        reader.onload = function (e) {
            $(`#preview${a}-${i}`)
                .attr('src', e.target.result);
            $(`#multi-selected-id${a}-${i}`).val('change');
        };

        reader.readAsDataURL(input.files[0]);
    }
}

//product size 
function readSizeURL(input) {

	index = input.getAttribute('keyval');
    if (input.files && input.files[0]) {
        var reader = new FileReader();

        reader.onload = function (e) {
            $(`#preview-size-${index}`).attr('src', e.target.result);
            $(`#multi-selected-id-size-${index}`).val('change');
        };

        reader.readAsDataURL(input.files[0]);
    }
}

// basic size
function getBasicSize(id){

	$.ajax({
	    type: "post",
	    url: "/products/basic-sizes",
	    data: {
	      id:id
	    },
	    dataType: 'JSON',
	    success: function (res) {
	    	for(i=0; i < res.length; i++){
	    		addBasicSize(res[i]);
	    	}
	    },
	    error: function(error) {
	        showHttpErrorAlert(error);
	    } 
	});
}

function addBasicSize(data){

    basicIndex ++;
    let cells = generateTableRow('table-basic-size', 'basicsizesheet_row', 2);

    if(basicIndex == 1){
    	cells[0].innerHTML  = `<input type="checkbox" class="worksheet-row-index" onclick="return false"/>`;
    }else{
    	cells[0].innerHTML  = `<input type="checkbox" class="worksheet-row-index"/>`;
    }

    if(data){
    	cells[1].innerHTML  = `<input type="text" id="basic-size-name-${basicIndex}" name="basic_size_name[]" value="${data.size}" class="form-control border-only-bottom input-sm"  autocomplete="off" required placeholder="Insert Basic Size"/>`;
        cells[1].innerHTML  += `<input type="hidden" id="basic-size-id-${basicIndex}" name="basic_size_id[]" value="${data.id}" class="form-control input-sm"  autocomplete="off" />`;
    }else{
    	cells[1].innerHTML  = `<input type="text" id="basic-size-name-${basicIndex}" name="basic_size_name[]" class="form-control border-only-bottom input-sm"  autocomplete="off" required placeholder="Insert Basic Size"/>`;
        cells[1].innerHTML  += `<input type="hidden" id="basic-size-id-${basicIndex}" name="basic_size_id[]" value="" class="form-control input-sm"  autocomplete="off" />`;
    }
}

function removeBasicSize()
{
    $('.worksheet-row-index:checkbox:checked').parents('tr.basicsizesheet_row').remove();
}

// colors
function getColor(id){

	$.ajax({
	    type: "post",
	    url: "/products/colors",
	    data: {
	      id:id
	    },
	    dataType: 'JSON',
	    success: function (res) {
	    	for(i=0; i < res.length; i++){
	    		addColor(res[i]);
	    	}
	    },
	    error: function(error) {
	        showHttpErrorAlert(error);
	    } 
	});
}

function addColor(data){

    colorIndex ++;
    let cells = generateTableRow('table-color', 'basicsizesheet_row', 5);

    if(colorIndex == 1){
    	cells[0].innerHTML  = `<input type="checkbox" class="worksheet-row-index" onclick="return false"/>`;
    }else{
    	cells[0].innerHTML  = `<input type="checkbox" class="worksheet-row-index"/>`;
    }

    if(data){	
    	cells[1].innerHTML  = `<img id="preview-${colorIndex}" data-action="zoom" src="${data.image}" onerror="this.src='/assets/images/default/no_image.png'" alt="your image" height="80"/>
                                 <br>
                                <input type="file"  name="multi_selected[]" id="multi-selected-${colorIndex}"  autocomplete="off"  onchange="readURL(this,${colorIndex});" class="mb-2"  >
                                <input type="hidden" id="multi-selected-id-${colorIndex}" name="multi_selected_id[]" value="old"  class="form-control input-sm style_input"  autocomplete="off"  />`;

        cells[2].innerHTML  = `<input type="text" id="color-name-${colorIndex}" name="color_name[]" value="${data.name}" class="form-control border-only-bottom input-sm"  autocomplete="off" required placeholder="Insert Color Name"/>`;
        cells[2].innerHTML  += `<input type="hidden" id="color-id-${colorIndex}" name="color_id[]" value="${data.id}" class="form-control input-sm"  autocomplete="off" />`;
        cells[3].innerHTML = `<input type="number" id="color-price-${colorIndex}" name="color_price[]" value="${data.price}" class="form-control" placeholder="Insert Price" min="0" step="any">`;
        cells[4].innerHTML  = `<input type="text" id="color-description-${colorIndex}" name="color_description[]" value="${data.description}" class="form-control border-only-bottom input-sm"  autocomplete="off" required placeholder="Insert Color Description"/>`;
    }else{
    	cells[1].innerHTML  = `<img id="preview-${colorIndex}" data-action="zoom" src="/assets/images/default/no_image.png" onerror="this.src='/assets/images/default/no_image.png'" alt="your image" height="80"/>
                                 <br>
                                <input type="file"  name="multi_selected[]" id="multi-selected-${colorIndex}"  autocomplete="off"  onchange="readURL(this,${colorIndex});" class="mb-2" required >
                                <input type="hidden" id="multi-selected-id-${colorIndex}" name="multi_selected_id[]" value="old"  class="form-control input-sm style_input"  autocomplete="off"  />`;

        cells[2].innerHTML  = `<input type="text" id="color-name-${colorIndex}" name="color_name[]" class="form-control border-only-bottom input-sm"  autocomplete="off" required placeholder="Insert Color Name"/>`;
        cells[2].innerHTML  += `<input type="hidden" id="color-id-${colorIndex}" name="color_id[]" value="" class="form-control input-sm"  autocomplete="off" />`;
        cells[3].innerHTML = `<input type="number" id="color-price-${colorIndex}" name="color_price[]" class="form-control" placeholder="Insert Price" min="1" step="any">`;
        cells[4].innerHTML  = `<input type="text" id="color-description-${colorIndex}" name="color_description[]" class="form-control border-only-bottom input-sm"  autocomplete="off" required placeholder="Insert Color Description"/>`;
    }
}

function removeColor()
{
    $('.worksheet-row-index:checkbox:checked').parents('tr.basicsizesheet_row').remove();
}

function readURL(input,i) {
    if (input.files && input.files[0]) {
        var reader = new FileReader();

        reader.onload = function (e) {
            $(`#preview-${i}`)
                .attr('src', e.target.result);
            $(`#multi-selected-id-${i}`).val('change');
        };

        reader.readAsDataURL(input.files[0]);
    }
}

//product features
function getFeature(id){

    $.ajax({
        type: "post",
        url: "/products/features",
        data: {
          id:id
        },
        dataType: 'JSON',
        success: function (res) {
            for(i=0; i < res.length; i++){
                getFeatureDetail(id,res[i].id);
            }
        },
        error: function(error) {
            showHttpErrorAlert(error);
        } 
    });
}

function getFeatureDetail(product_id,id){

    $.ajax({
        type: "post",
        url: "/products/feature-details",
        data: {
          id:id,
          product_id:product_id
        },
        dataType: 'JSON',
        success: function (res) {

            f_id = null;
            for(i=0; i < res.length; i++){
                if(f_id != res[i].feature_id){
                    f_id = res[i].feature_id;
                    fd = $(`#fkey-${f_id}`).val();
                }
                // console.log(fd,f_id,res[i]);
                addFeature(res[i],fd);
            }
        },
        error: function(error) {
            showHttpErrorAlert(error);
        } 
    });
}

function addFeature(data,key){

    fk = $(`#featurekey-${key}`).val();
    index = parseInt(fk) + 1;
    $(`#featurekey-${key}`).val(index);
    feature_id = $(`#featureidval-${key}`).val();


    let cells = generateTableRow(`table-feature-${key}`, `feature${key}sheet_row`, 5);

    if(index == 1){
        cells[0].innerHTML  = `<input type="checkbox" class="worksheet-row-index" onclick="return false"/>`;
    }else{
        cells[0].innerHTML  = `<input type="checkbox" class="worksheet-row-index"/>`;
    }

    if(data){    

        cells[1].innerHTML  = `<img id="preview-key${key}-${index}" data-action="zoom" src="${data.image}" onerror="this.src='/assets/images/default/no_image.png'" alt="your image" height="80"/>
                                     <br>
                                    <input type="file" id=featuredetail${key}-selected-${index}" name="featuredetail_selected[]" autocomplete="off"  onchange="featureURL(this,${index},${key});" class="mb-2" >
                                    <input type="hidden" id="featuredetail${key}-selected-id-${index}" name="featuredetail_selected_id[]" value="old"  class="form-control input-sm style_input"  autocomplete="off"  />`;

        cells[2].innerHTML  = `<input type="text" id="featuredetail${key}-name-${index}" name="featuredetail_name[]" value="${data.name}" class="form-control border-only-bottom input-sm"  autocomplete="off" required placeholder="Insert Feature Name"/>`;
        cells[2].innerHTML  += `<input type="hidden" id="featuredetail${key}-id-${index}" name="featuredetail_id[]" value="${data.id}" class="form-control input-sm"  autocomplete="off" />`;
        cells[3].innerHTML = `<input type="number" id="featuredetail${key}-price-${index}" name="featuredetail_price[]" value="${data.price}" class="form-control" placeholder="Insert Price" min="0" step="any">`;
        cells[3].innerHTML  += `<input type="hidden" id="feature${key}-id-${index}" name="feature_id[]" value="${feature_id}" class="form-control input-sm"  autocomplete="off" />`;
        cells[4].innerHTML  = `<input type="text" id="featuredetail${key}-description-${index}" name="featuredetail_description[]" value="${data.description}" class="form-control border-only-bottom input-sm"  autocomplete="off" required placeholder="Insert Feature Description"/>`;

    }else{
        cells[1].innerHTML  = `<img id="preview-key${key}-${index}" data-action="zoom" src="/assets/images/default/no_image.png" onerror="this.src='/assets/images/default/no_image.png'" alt="your image" height="80"/>
                                 <br>
                                <input type="file" id=featuredetail${key}-selected-${index}" name="featuredetail_selected[]" autocomplete="off"  onchange="featureURL(this,${index},${key});" class="mb-2" required >
                                <input type="hidden" id="featuredetail${key}-selected-id-${index}" name="featuredetail_selected_id[]" value="old"  class="form-control input-sm style_input"  autocomplete="off"  />`;

        cells[2].innerHTML  = `<input type="text" id="featuredetail${key}-name-${index}" name="featuredetail_name[]" class="form-control border-only-bottom input-sm"  autocomplete="off" required placeholder="Insert Feature Name"/>`;
        cells[2].innerHTML  += `<input type="hidden" id="featuredetail${key}-id-${index}" name="featuredetail_id[]" value="" class="form-control input-sm"  autocomplete="off" />`;
        cells[3].innerHTML = `<input type="number" id="featuredetail${key}-price-${index}" name="featuredetail_price[]" class="form-control" placeholder="Insert Price" min="1" step="any">`;
        cells[3].innerHTML  += `<input type="hidden" id="feature${key}-id-${index}" name="feature_id[]" value="${feature_id}" class="form-control input-sm"  autocomplete="off" />`;
        cells[4].innerHTML  = `<input type="text" id="featuredetail${key}-description-${index}" name="featuredetail_description[]" class="form-control border-only-bottom input-sm"  autocomplete="off" required placeholder="Insert Feature Description"/>`;
    }
}

function removeFeature(key)
{
    $('.worksheet-row-index:checkbox:checked').parents(`tr.feature${key}sheet_row`).remove();
}

function featureURL(input,i,key) {

    if (input.files && input.files[0]) {
        var reader = new FileReader();

        reader.onload = function (e) {
            $(`#preview-key${key}-${i}`)
                .attr('src', e.target.result);
            $(`#featuredetail${key}-selected-id-${i}`).val('change');
        };

        reader.readAsDataURL(input.files[0]);
    }
}