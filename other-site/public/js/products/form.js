let styleIndex = 0;
let colorIndex = 0;
let basicIndex= 0;
let viewIndex= 0;
let featureIndex= 0;
let subrowIndexArr = [];

$(document).ready(function() {

	id = $('#id').val();
	if(id){
		//categories and su category
		getSubCategories($('#category-val').val(),id);
		$('#category-id').val($('#category-val').val());
        getColor(id);
        getStyles(id);
        getBasicSize(id);
		getView(id);
        getFeatures(id);

	}else{
		addStyle(null,null);
		addColor();
		addBasicSize();
        addView();
	}

	$('#category-id').on('change', function() {
		category_id = this.value;
		getSubCategories(category_id,null);
	});

});

/*CATEGORIES*/
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

/*COLORS*/
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
    let cells = generateTableRow('table-color', 'colorsheet_row', 6);

    if(colorIndex == 1){
        cells[0].innerHTML  = `<input type="checkbox" class="color-worksheet-row-index" onclick="return false"/>`;
    }else{
        cells[0].innerHTML  = `<input type="checkbox" class="color-worksheet-row-index"/>`;
    }

    if(data){    
        cells[1].innerHTML  = `<img id="color-preview-${colorIndex}" data-action="zoom" src="${data.image}" onerror="this.src='/assets/images/default/no_image.png'" alt="your image" height="80"/>
                                 <br>
                                <input type="file"  name="multi_color[]" id="multi-color-${colorIndex}"  autocomplete="off"  onchange="readColorURL(this,${colorIndex});" class="mb-2"  >
                                <input type="hidden" id="multi-color-selected-id-${colorIndex}" name="multi_color_selected_id[]" value="old"  class="form-control input-sm style_input"  autocomplete="off"  />`;

        cells[2].innerHTML  = `<input type="text" id="color-code-${colorIndex}" name="color_code[]" value="${data.color_code}" class="form-control border-only-bottom input-sm"  autocomplete="off" placeholder="Insert Color Code"/>`;
        cells[3].innerHTML  = `<input type="text" id="color-name-${colorIndex}" name="color_name[]" value="${data.name}" class="form-control border-only-bottom input-sm"  autocomplete="off" required placeholder="Insert Color Name"/>`;
        cells[3].innerHTML  += `<input type="hidden" id="color-id-${colorIndex}" name="color_id[]" value="${data.id}" class="form-control input-sm"  autocomplete="off" />`;
        cells[4].innerHTML = `<input type="number" id="color-price-${colorIndex}" name="color_price[]" value="${data.price}" class="form-control" placeholder="Insert Price" min="0" step="any">`;
        cells[5].innerHTML  = `<input type="text" id="color-description-${colorIndex}" name="color_description[]" value="${data.description}" class="form-control border-only-bottom input-sm"  autocomplete="off" required placeholder="Insert Color Description"/>`;
    }else{
        cells[1].innerHTML  = `<img id="color-preview-${colorIndex}" data-action="zoom" src="/assets/images/default/no_image.png" onerror="this.src='/assets/images/default/no_image.png'" alt="your image" height="80"/>
                                 <br>
                                <input type="file"  name="multi_color[]" id="multi-color-${colorIndex}"  autocomplete="off"  onchange="readColorURL(this,${colorIndex});" class="mb-2" required >
                                <input type="hidden" id="multi-color-selected-id-${colorIndex}" name="multi_color_selected_id[]" value="old"  class="form-control input-sm style_input"  autocomplete="off"  />`;

        cells[2].innerHTML  = `<input type="text" id="color-code-${colorIndex}" name="color_code[]" class="form-control border-only-bottom input-sm"  autocomplete="off" placeholder="Insert Color Code"/>`;
        cells[3].innerHTML  = `<input type="text" id="color-name-${colorIndex}" name="color_name[]" class="form-control border-only-bottom input-sm"  autocomplete="off" required placeholder="Insert Color Name"/>`;
        cells[3].innerHTML  += `<input type="hidden" id="color-id-${colorIndex}" name="color_id[]" value="" class="form-control input-sm"  autocomplete="off" />`;
        cells[4].innerHTML = `<input type="number" id="color-price-${colorIndex}" name="color_price[]" class="form-control" placeholder="Insert Price" min="1" step="any">`;
        cells[5].innerHTML  = `<input type="text" id="color-description-${colorIndex}" name="color_description[]" class="form-control border-only-bottom input-sm"  autocomplete="off" required placeholder="Insert Color Description"/>`;
    }
}

function removeColor()
{
    $('.color-worksheet-row-index:checkbox:checked').parents('tr.colorsheet_row').remove();
}

function readColorURL(input,i) {
    if (input.files && input.files[0]) {
        var reader = new FileReader();

        reader.onload = function (e) {
            $(`#color-preview-${i}`)
                .attr('src', e.target.result);
            $(`#multi-color-selected-id-${i}`).val('change');
        };

        reader.readAsDataURL(input.files[0]);
    }
}

/*STYLES*/
function getStyles(id){

    $.ajax({
        type: "post",
        url: "/products/styles",
        data: {
          id:id
        },
        dataType: 'JSON',
        success: function (res) {
            for (var i = 0; i < res.length; i++) {
                addStyle(res[i],id);
            }
        },
        error: function(error) {
            showHttpErrorAlert(error);
        } 
    });
}

function addStyle(data,id){

    styleIndex ++;
    let cells = generateTableRow('table-sytle', 'stylesheet_row', 5);

    if(styleIndex == 1){
    	cells[0].innerHTML  = `<input type="checkbox" class="style-worksheet-row-index" onclick="return false" value="${styleIndex}"/>`;
    }else{
    	cells[0].innerHTML  = `<input type="checkbox" class="style-worksheet-row-index" value="${styleIndex}"/>`;
    }

    if(data){
    	cells[1].innerHTML  = `<img id="preview-${styleIndex}" data-action="zoom" src="${data.image}" onerror="this.src='/assets/images/default/no_image.png'" alt="your image" height="80"/>
    	                         <br>
    	                        <input type="file"  name="multi_style[]" id="multi-selected-${styleIndex}"  autocomplete="off"  onchange="readURL(this,${styleIndex});" class="mb-2"  >
    	                        <input type="hidden" id="multi-selected-id-${styleIndex}" name="multi_style_id[]" value="old"  class="form-control input-sm style_input"  autocomplete="off"  />`;

    	cells[1].innerHTML  += `<input type="hidden" id="style-id" name="style_id[]" value="${data.id}" class="form-control input-sm"  autocomplete="off" />`;
    	cells[2].innerHTML  = `<input type="text" id="style-name" name="style_name[]" value="${data.name}" class="form-control border-only-bottom input-sm"  autocomplete="off"  />`;
    	cells[3].innerHTML  = `<input type="number" id="style-price" name="style_price[]"  min="0" step="any" value="${data.price}" class="form-control border-only-bottom input-sm"  autocomplete="off"  />`;
    	cells[4].innerHTML  = `<input type="text" id="style-description" name="style_description[]" value="${data.description}" class="form-control border-only-bottom input-sm"  autocomplete="off"  />`;

    }else{
        cells[1].innerHTML  = `<img id="preview-${styleIndex}" data-action="zoom" src="/assets/images/default/no_image.png" onerror="this.src='/assets/images/default/no_image.png'" alt="your image" height="80"/>
                                 <br>
                                <input type="file"  name="multi_style[]" id="multi-selected-${styleIndex}"  autocomplete="off"  onchange="readURL(this,${styleIndex});" class="mb-2" required >
                                <input type="hidden" id="multi-selected-id-${styleIndex}" name="multi_style_id[]" value="old"  class="form-control input-sm style_input"  autocomplete="off"  />`;

        cells[1].innerHTML  += `<input type="hidden" id="style-id-${styleIndex}" name="style_id[]" value="" class="form-control input-sm"  autocomplete="off" />`;
        cells[2].innerHTML  = `<input type="text" id="style-name-${styleIndex}" name="style_name[]" class="form-control border-only-bottom input-sm"  autocomplete="off" required placeholder="Insert Name" onChange="StyleNameChange(${styleIndex})"/>`;
        cells[3].innerHTML  = `<input type="number" id="style-price-${styleIndex}" name="style_price[]" min="0" step="any"  class="form-control border-only-bottom input-sm"  autocomplete="off"  placeholder="Insert Price"/>`;
        cells[4].innerHTML  = `<input type="text" id="style-description-${styleIndex}" name="style_description[]" class="form-control border-only-bottom input-sm"  autocomplete="off" required placeholder="Insert Description"/>`;
    }
    if(id){
       getCustomSize(id,data.id,styleIndex); 
   }else{
       addCustomSize(styleIndex,null);
   }
}

function removeStyle()
{
    $('.style-worksheet-row-index:checked').each(function() {
        index = $(this).val();
        $(`#customsheet-row-id-${index}`).parents('tr.customsizesheet_row').remove();
    });
    $('.style-worksheet-row-index:checkbox:checked').parents('tr.stylesheet_row').remove();

    // removeCustomSize();
}

/*MAIN IMAGE AND STYLE IMAGE*/
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

/*SIZES*/
function getCustomSize(id,style_id,styleIndex){
    $.ajax({
        type: "post",
        url: "/products/custom-style-sizes",
        data: {
          id:id,
          style_id:style_id
        },
        dataType: 'JSON',
        success: function (res) {
            addCustomSize(styleIndex,res);
        },
        error: function(error) {
            showHttpErrorAlert(error);
        } 
    });
}

function addCustomSize(styleIndex,data){
    let cells = generateTableRow('table-custom-size', 'customsizesheet_row', 4);

    cells[0].innerHTML  = `<input type="checkbox" class="customsheet-row-index" id="customsheet-row-id-${styleIndex}" hidden/>`;

    // console.log(data);
    if(data){
    	cells[1].innerHTML  = `<input type="text" id="custom-size-style-name-${styleIndex}" name="custom_size_style_name[]" value="${data.product_style.name}" class="form-control border-only-bottom input-sm"  autocomplete="off" required readonly/>`;
        cells[1].innerHTML  += `<input type="hidden" id="custom-style-id-${styleIndex}" name="custom_style_id[]" value="${data.product_style.id}" class="form-control input-sm"  autocomplete="off" />`;
        cells[1].innerHTML  += `<input type="hidden" id="custom-size-id-${styleIndex}" name="custom_size_id[]" value="${data.id}" class="form-control input-sm"  autocomplete="off" />`;
        cells[2].innerHTML  = `<img id="preview-custom-size-${styleIndex}" data-action="zoom" src="${data.image}" onerror="this.src='/assets/images/default/no_image.png'" alt="your image" height="80"/>
                                 <br>
                                <input type="file"  name="multi_custom_size[]" id="multi-custom-size-${styleIndex}"  autocomplete="off"  onchange="readCustomSizeURL(this,${styleIndex});" class="mb-2"  >
                                <input type="hidden" id="multi-custom-size-id-${styleIndex}" name="multi_custome_size_id[]" value="old"  class="form-control input-sm style_input"  autocomplete="off"  />`;
        cells[3].innerHTML  = `<input type="number" min="1" step="any" id="custom-size-width-${styleIndex}" name="custom_size_width[]" value="${data.width}" class="form-control border-only-bottom input-sm"  autocomplete="off" required placeholder="Insert Width Count"/>`;
    }else{
    	cells[1].innerHTML  = `<input type="text" id="custom-size-style-name-${styleIndex}" name="custom_size_style_name[]" class="form-control border-only-bottom input-sm"  autocomplete="off" required readonly/>`;
        cells[1].innerHTML  += `<input type="hidden" id="custom-style-id-${styleIndex}" name="custom_style_id[]" class="form-control input-sm"  autocomplete="off" />`;
        cells[1].innerHTML  += `<input type="hidden" id="custom-size-id-${styleIndex}" name="custom_size_id[]" class="form-control input-sm"  autocomplete="off" />`;
        cells[2].innerHTML  = `
                                <img id="preview-custom-size-${styleIndex}" data-action="zoom" src="/assets/images/default/no_image.png" onerror="this.src='/assets/images/default/no_image.png'" alt="your image" height="80"/>
                                <br>
                                <input type="file"  name="multi_custom_size[]" id="multi-custom-size-${styleIndex}"  autocomplete="off"  onchange="readCustomSizeURL(this,${styleIndex});" class="mb-2" required >
                                <input type="hidden" id="multi-custom-size-id-${styleIndex}" name="multi_custome_size_id[]" value="old"  class="form-control input-sm style_input"  autocomplete="off"  />
                              `;
        cells[3].innerHTML  = `<input type="number" min="1" step="any" id="custom-size-width-${styleIndex}" name="custom_size_width[]"  class="form-control border-only-bottom input-sm"  autocomplete="off" required placeholder="Insert Width Count"/>`;
    }
}

function StyleNameChange(index){
    name = $(`#style-name-${index}`).val();
    $(`#custom-size-style-name-${index}`).val(name);
}

function readCustomSizeURL(input,i) {
    if (input.files && input.files[0]) {
        var reader = new FileReader();

        reader.onload = function (e) {
            $(`#preview-custom-size-${i}`)
                .attr('src', e.target.result);
            $(`#multi-custom-size-id-${i}`).val('change');
        };

        reader.readAsDataURL(input.files[0]);
    }
}

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

/*PRODUCT VIEW*/
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

    viewIndex ++;
    let cells = generateTableRow('table-view', 'viewsheet_row', 2);

    if(viewIndex == 1){
        cells[0].innerHTML  = `<input type="checkbox" class="viewworksheet-row-index" onclick="return false"/>`;
    }else{
        cells[0].innerHTML  = `<input type="checkbox" class="viewworksheet-row-index"/>`;
    }

    if(data){
        cells[1].innerHTML  = `<input type="text" id="view-name-${viewIndex}" name="view_name[]" value="${data.name}" class="form-control border-only-bottom input-sm"  autocomplete="off" required placeholder="Insert Product View"/>`;
        cells[1].innerHTML  += `<input type="hidden" id="view-id-${viewIndex}" name="view_id[]" value="${data.id}" class="form-control input-sm"  autocomplete="off" />`;
    }else{
        cells[1].innerHTML  = `<input type="text" id="view-name-${viewIndex}" name="view_name[]" class="form-control border-only-bottom input-sm"  autocomplete="off" required placeholder="Insert Product View"/>`;
        cells[1].innerHTML  += `<input type="hidden" id="view-id-${viewIndex}" name="view_id[]" value="" class="form-control input-sm"  autocomplete="off" />`;
    }
}

function removeView()
{
    $('.viewworksheet-row-index:checkbox:checked').parents('tr.viewsheet_row').remove();
}

/*PRODUCT FEATURE*/
function getFeatures(id){

    $.ajax({
        type: "post",
        url: "/products/features",
        data: {
          id:id
        },
        dataType: 'JSON',
        success: function (res) {
            for(i=0; i < res.length; i++){
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

    if(featureIndex == 1){
        cells[0].innerHTML  = `<input type="checkbox" class="featureworksheet-row-index" value="${featureIndex}" onclick="return false"/>`;
    }else{
        cells[0].innerHTML  = `<input type="checkbox" class="featureworksheet-row-index" value="${featureIndex}"/>`;
    }

    if(data){
        cells[1].innerHTML  = `<input type="text" id="feature-name-${featureIndex}" name="feature_name[]" value="${data.name}" onChange="changeFeatureName(${featureIndex});" class="form-control border-only-bottom input-sm"  autocomplete="off" required placeholder="Insert Product Other Feature"/>`;
        cells[1].innerHTML  += `<input type="hidden" id="feature-id-${featureIndex}" name="feature_id[]" value="${data.id}" class="form-control input-sm"  autocomplete="off" />`;
        subrowIndexArr.push(0);
        addCardFeature(featureIndex,data.id);
        changeFeatureName(featureIndex);
    }else{
        cells[1].innerHTML  = `<input type="text" id="feature-name-${featureIndex}" name="feature_name[]" onChange="changeFeatureName(${featureIndex});" class="form-control border-only-bottom input-sm"  autocomplete="off" required placeholder="Insert Product Other Feature"/>`;
        cells[1].innerHTML  += `<input type="hidden" id="feature-id-${featureIndex}" name="feature_id[]" value="" class="form-control input-sm"  autocomplete="off" />`;
        
        subrowIndexArr.push(0);
        addCardFeature(featureIndex,0);
    }
}

function removeFeature()
{   
    $('.featureworksheet-row-index:checked').each(function() {
            index = $(this).val();
            $(`#card-feature-${index}`).empty();
            $(`#card-feature-${index}`).remove();
        }); 
    $('.featureworksheet-row-index:checkbox:checked').parents('tr.featuresheet_row').remove();
}

function addCardFeature(index,id){

    $('#feature-card').append(`
                                <div class="card mb-4" id="card-feature-${index}">
                                    <div class="card-header">
                                        <h5><strong id="feature-card-title-${index}">FEATURES</strong></h5>
                                    </div>
                                    <div class="card-body">
                                        <div class="col-md-12 p-1">
                                            <button type="button" class="btn btn-sm btn-success" onclick="addCardFeatureDetails(${index},null)"><span class="glyphicon glyphicon-plus-sign"></span> Add</button>&nbsp;
                                            <button type="button" class="btn btn-sm btn-danger" onclick="removeCardFeatureDetails(${index})"><span class="glyphicon glyphicon-remove-sign"></span> Delete</button>&nbsp;
                                            <table id="table-feature-detail-${index}" class="table table-bordered" style="margin-top: 15px;">
                                                <tr>
                                                    <td width="3%"></td>
                                                    <th width="15%">Image</th>
                                                    <th>Code</th>
                                                    <th>Name</th>
                                                    <th width="15%">Price</th>
                                                    <th>Description</th>
                                                </tr>
                                            </table>
                                        </div>
                                    </div>
                                    <input type="hidden" name="feature_detail_num[]" id="feature-detail-num-${index}" value="${index}">
                                </div>
                              `);
    if(id){
        getFeatureDetails(index,id);
    }else{
        addCardFeatureDetails(index,null);
    }
}

function changeFeatureName(index){
    title = $(`#feature-name-${index}`).val();
    $(`#feature-card-title-${index}`).text(title);
}

function getFeatureDetails(index,id){

    product_id = $('#id').val();
    $.ajax({
        type: "post",
        url: "/products/feature-details",
        data: {
          id:id,
          product_id:product_id
        },
        dataType: 'JSON',
        success: function (res) {
            for(b=0; b < res.length; b++){
                addCardFeatureDetails(index,res[b]);
            }
        },
        error: function(error) {
            showHttpErrorAlert(error);
        } 
    });
}

function addCardFeatureDetails(index,data){
    si = subrowIndexArr[index-1];
    subrowIndex = si + 1;
    subrowIndexArr.splice(index-1, 1, subrowIndex);

    let cells = generateTableRow(`table-feature-detail-${index}`, `featuredetailsheet_row-${index}`, 6);
    if(subrowIndexArr == 1){
        cells[0].innerHTML  = `<input type="checkbox" class="featuredetailworksheet-row-index-${index}" onclick="return false"/>`;
    }else{
        cells[0].innerHTML  = `<input type="checkbox" class="featuredetailworksheet-row-index-${index}"/>`;
    }

    if(data){
        cells[1].innerHTML  = `<img id="feature-detail-preview-${index}-${subrowIndex}" data-action="zoom" src="${data.image}" onerror="this.src='/assets/images/default/no_image.png'" alt="your image" height="80"/>
                                 <br>
                                <input type="file"  name="multi_feature_detail${index}[]" id="multi-feature-detail-${index}-${subrowIndex}"  autocomplete="off"  onchange="readFeatureDetailURL(this,${index},${subrowIndex});" class="mb-2" >
                                <input type="hidden" id="multi-feature-detail-selected-id-${index}-${subrowIndex}" name="multi_feature_detail_selected_id${index}[]" value="old"  class="form-control input-sm style_input"  autocomplete="off"  />`;

        cells[2].innerHTML  = `<input type="text" id="feature-detail-code-${index}-${subrowIndex}" name="feature_detail_code${index}[]" value="${data.code}" class="form-control border-only-bottom input-sm"  autocomplete="off" placeholder="Insert Code"/>`;
        cells[3].innerHTML  = `<input type="text" id="feature-detail-name-${index}-${subrowIndex}" name="feature_detail_name${index}[]" value="${data.name}" class="form-control border-only-bottom input-sm"  autocomplete="off" required placeholder="Insert Name"/>`;
        cells[3].innerHTML  += `<input type="hidden" id="feature-detail-id-${index}-${subrowIndex}" name="feature_detail_id${index}[]" value="${data.id}" class="form-control input-sm"  autocomplete="off" />`;
        cells[4].innerHTML = `<input type="number" id="feature-detail-price-${index}-${subrowIndex}" name="feature_detail_price${index}[]" value="${data.price}" class="form-control" placeholder="Insert Price" min="0" step="any">`;
        cells[5].innerHTML  = `<input type="text" id="feature-detail-description-${index}-${subrowIndex}" name="feature_detail_description${index}[]" value="${data.description}" class="form-control border-only-bottom input-sm"  autocomplete="off" required placeholder="Insert Description"/>`;
    }else{
        cells[1].innerHTML  = `<img id="feature-detail-preview-${index}-${subrowIndex}" data-action="zoom" src="/assets/images/default/no_image.png" onerror="this.src='/assets/images/default/no_image.png'" alt="your image" height="80"/>
                                 <br>
                                <input type="file"  name="multi_feature_detail${index}[]" id="multi-feature-detail-${index}-${subrowIndex}"  autocomplete="off"  onchange="readFeatureDetailURL(this,${index},${subrowIndex});" class="mb-2" required >
                                <input type="hidden" id="multi-feature-detail-selected-id-${index}-${subrowIndex}" name="multi_feature_detail_selected_id${index}[]" value="old"  class="form-control input-sm style_input"  autocomplete="off"  />`;

        cells[2].innerHTML  = `<input type="text" id="feature-detail-code-${index}-${subrowIndex}" name="feature_detail_code${index}[]" class="form-control border-only-bottom input-sm"  autocomplete="off" placeholder="Insert Code"/>`;
        cells[3].innerHTML  = `<input type="text" id="feature-detail-name-${index}-${subrowIndex}" name="feature_detail_name${index}[]" class="form-control border-only-bottom input-sm"  autocomplete="off" required placeholder="Insert Name"/>`;
        cells[3].innerHTML  += `<input type="hidden" id="feature-detail-id-${index}-${subrowIndex}" name="feature_detail_id${index}[]" class="form-control input-sm"  autocomplete="off" />`;
        cells[4].innerHTML = `<input type="number" id="feature-detail-price-${index}-${subrowIndex}" name="feature_detail_price${index}[]" class="form-control" placeholder="Insert Price" min="0" step="any">`;
        cells[5].innerHTML  = `<input type="text" id="feature-detail-description-${index}-${subrowIndex}" name="feature_detail_description${index}[]" class="form-control border-only-bottom input-sm"  autocomplete="off" required placeholder="Insert Description"/>`;
    }
}

function readFeatureDetailURL(input,i,a) {
    if (input.files && input.files[0]) {
        var reader = new FileReader();

        reader.onload = function (e) {
            $(`#feature-detail-preview-${i}-${a}`)
                .attr('src', e.target.result);
            $(`#multi-feature-detail-selected-id-${i}-${a}`).val('change');
        };

        reader.readAsDataURL(input.files[0]);
    }
}

function removeCardFeatureDetails(index){
    $(`.featuredetailworksheet-row-index-${index}:checkbox:checked`).parents(`tr.featuredetailsheet_row-${index}`).remove();
}