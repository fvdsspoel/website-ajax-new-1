let rowIndex = 0;
let featureIndex = 0;

$(document).ready(function() {

	id = $('#id').val();
	if(id){
		//categories and su category
		getSubCategories($('#category-val').val(),id);
		$('#category-id').val($('#category-val').val());

		//styles
		getStyles(id);
		getFeatures(id);

	}else{
		addStyle();
	}

	$('#category-id').on('change', function() {
		category_id = this.value;
		getSubCategories(category_id,null);
	});

});

function getSubCategories(id,mainid){

	$.ajax({
	    type: "post",
	    url: "/categories/get-subcategory",
	    data: {
	      id:id
	    },
	    dataType: 'JSON',
	    success: function (res) {

	    	$("#sub-category-id").empty();
	    	for (var i = 0; i < res.length; i++) {
	    		$("#sub-category-id").append(`<option value="${res[i].id}">${res[i].name}</option>`);
	    	}

	    	if(mainid){
	    		$('#sub-category-id').val($('#subcategory-val').val());
	    	}
	    },
	    error: function(error) {
	        showHttpErrorAlert(error);
	    } 
	});
}

function getStyles(id){

	$.ajax({
	    type: "post",
	    url: "/products/styles",
	    data: {
	      id:id
	    },
	    dataType: 'JSON',
	    success: function (res) {
	    	console.log(res);
	    	for (var i = 0; i < res.length; i++) {
	    		addStyle(res[i]);
	    	}
	    },
	    error: function(error) {
	        showHttpErrorAlert(error);
	    } 
	});
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

function addStyle(data){

    rowIndex ++;
    let cells = generateTableRow('table-sytle', 'stylesheet_row', 5);

    if(rowIndex == 1){
    	cells[0].innerHTML  = `<input type="checkbox" class="worksheet-row-index" onclick="return false"/>`;
    }else{
    	cells[0].innerHTML  = `<input type="checkbox" class="worksheet-row-index"/>`;
    }

    if(data){
    	cells[1].innerHTML  = `<img id="preview-${rowIndex}" data-action="zoom" src="${data.image}" onerror="this.src='/assets/images/default/no_image.png'" alt="your image" height="80"/>
    	                         <br>
    	                        <input type="file"  name="multi_style[]" id="multi-selected-${rowIndex}"  autocomplete="off"  onchange="readURL(this,${rowIndex});" class="mb-2"  >
    	                        <input type="hidden" id="multi-selected-id-${rowIndex}" name="multi_style_id[]" value="old"  class="form-control input-sm style_input"  autocomplete="off"  />`;

    	cells[1].innerHTML  += `<input type="hidden" id="style-id" name="style_id[]" value="${data.id}" class="form-control input-sm"  autocomplete="off" />`;
    	cells[2].innerHTML  = `<input type="text" id="style-name" name="style_name[]" value="${data.name}" class="form-control border-only-bottom input-sm"  autocomplete="off"  />`;
    	cells[3].innerHTML  = `<input type="number" id="style-price" name="style_price[]"  min="0" step="any" value="${data.price}" class="form-control border-only-bottom input-sm"  autocomplete="off"  />`;
    	cells[4].innerHTML  = `<input type="text" id="style-description" name="style_description[]" value="${data.description}" class="form-control border-only-bottom input-sm"  autocomplete="off"  />`;

    }else{
        cells[1].innerHTML  = `<img id="preview-${rowIndex}" data-action="zoom" src="/assets/images/default/no_image.png" onerror="this.src='/assets/images/default/no_image.png'" alt="your image" height="80"/>
                                 <br>
                                <input type="file"  name="multi_style[]" id="multi-selected-${rowIndex}"  autocomplete="off"  onchange="readURL(this,${rowIndex});" class="mb-2" required >
                                <input type="hidden" id="multi-selected-id-${rowIndex}" name="multi_style_id[]" value="old"  class="form-control input-sm style_input"  autocomplete="off"  />`;

        cells[1].innerHTML  += `<input type="hidden" id="style-id" name="style_id[]" value="" class="form-control input-sm"  autocomplete="off" />`;
        cells[2].innerHTML  = `<input type="text" id="style-name" name="style_name[]" class="form-control border-only-bottom input-sm"  autocomplete="off" required placeholder="Insert Name"/>`;
        cells[3].innerHTML  = `<input type="number" id="style-price" name="style_price[]" min="0" step="any"  class="form-control border-only-bottom input-sm"  autocomplete="off"  placeholder="Insert Price"/>`;
        cells[4].innerHTML  = `<input type="text" id="style-description" name="style_description[]" class="form-control border-only-bottom input-sm"  autocomplete="off" required placeholder="Insert Description"/>`;
    }
}

function removeStyle()
{
    $('.worksheet-row-index:checkbox:checked').parents('tr.stylesheet_row').remove();
}

// other feature
function getFeatures(id){

	$.ajax({
	    type: "post",
	    url: "/products/features",
	    data: {
	      id:id
	    },
	    dataType: 'JSON',
	    success: function (res) {
	    	console.log(res);
	    	for (var i = 0; i < res.length; i++) {
	    		addFeature(res[i]);
	    	}
	    },
	    error: function(error) {
	        showHttpErrorAlert(error);
	    } 
	});
}

function addFeature(data){

    featureIndex ++;
    let cells = generateTableRow('table-feature', 'featuresheet_row', 2);

    cells[0].innerHTML  = `<input type="checkbox" class="worksheet-row-index"/>`;

    if(data){
    		cells[1].innerHTML  = `<input type="text" id="feature-name-${featureIndex}" name="feature_name[]" value="${data.name}" class="form-control border-only-bottom input-sm"  autocomplete="off" required placeholder="Insert Feature Name"/>`;
    	    cells[1].innerHTML  += `<input type="hidden" id="feature-id-${featureIndex}" name="feature_id[]" value="${data.id}" class="form-control input-sm"  autocomplete="off" />`;
    }else{
    	cells[1].innerHTML  = `<input type="text" id="feature-name-${featureIndex}" name="feature_name[]" class="form-control border-only-bottom input-sm"  autocomplete="off" required placeholder="Insert Feature Name"/>`;
        cells[1].innerHTML  += `<input type="hidden" id="feature-id-${featureIndex}" name="feature_id[]" value="" class="form-control input-sm"  autocomplete="off" />`;
    }
}

function removeFeature()
{
    $('.worksheet-row-index:checkbox:checked').parents('tr.featuresheet_row').remove();
}
