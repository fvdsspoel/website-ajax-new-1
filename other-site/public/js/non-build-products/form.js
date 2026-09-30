let rowIndex = 0;
$(document).ready(function() {
    id = $('#id').val();
    if(id){
        getSubProducts(id);
        $('#category-id').val($('#category-val').val());
    }
});

function getSubProducts(id){
    $.ajax({
        type: "post",
        url: "/non-build-products/get-sub-products",
        data: {
          id:id
        },
        dataType: 'JSON',
        success: function (res) {
            console.log(res);
            for(i=0; i < res.length;i++){
                addProduct(res[i]);
            }
        },
        error: function(error) {
            showHttpErrorAlert(error);
        } 
    });
}

function addProduct(data){
// alert(1);
    rowIndex ++;
    let cells = generateTableRow('table-product', 'worksheet_row', 5);

    cells[0].innerHTML  = `<input type="checkbox" class="worksheet-row-index"/>`;

    if(data){
        cells[1].innerHTML  = `<img id="preview-${rowIndex}" data-action="zoom" src="${data.image}" onerror="this.src='/assets/images/default/no_image.png'" alt="your image" height="80"/>
                                <br>
                                <input type="file"  name="multi_selected[]" id="multi-selected-${rowIndex}"  autocomplete="off"  onchange="readURL(this,${rowIndex});" class="mb-2" >
                                <input type="hidden" id="multi-selected-id-${rowIndex}" name="multi_selected_id[]" value="old"  class="form-control input-sm style_input"  autocomplete="off"  />`;

        cells[1].innerHTML  += `<input type="hidden" id="product-id" name="product_id[]" value="${data.id}" class="form-control input-sm"  autocomplete="off"/>`;
        cells[2].innerHTML  = `<input type="number" step="any" id="product-price" name="product_price[]" value="${data.price}" class="form-control border-only-bottom input-sm"  autocomplete="off" required placeholder="Insert Price"/>`;
        cells[3].innerHTML  = `<input type="text" id="product-name" name="product_name[]"value="${data.name}"  class="form-control border-only-bottom input-sm"  autocomplete="off" required placeholder="Insert Name"/>`;
        cells[4].innerHTML  = `<input type="text" id="product-description" name="product_description[]" value="${data.description}" class="form-control border-only-bottom input-sm"  autocomplete="off" required placeholder="Insert Description"/>`;
    }else{
        cells[1].innerHTML  = `<img id="preview-${rowIndex}" data-action="zoom" src="/assets/images/default/no_image.png" onerror="this.src='/assets/images/default/no_image.png'" alt="your image" height="80"/>
                                <br>
                                <input type="file"  name="multi_selected[]" id="multi-selected-${rowIndex}"  autocomplete="off"  onchange="readURL(this,${rowIndex});" class="mb-2" required >
                                <input type="hidden" id="multi-selected-id-${rowIndex}" name="multi_selected_id[]" value="old"  class="form-control input-sm style_input"  autocomplete="off"  />`;

        cells[1].innerHTML  += `<input type="hidden" id="product-id" name="product_id[]" class="form-control input-sm"  autocomplete="off"/>`;
        cells[2].innerHTML  = `<input type="number" step="any" id="product-price" name="product_price[]" class="form-control border-only-bottom input-sm"  autocomplete="off" required placeholder="Insert Price"/>`;
        cells[3].innerHTML  = `<input type="text" id="product-name" name="product_name[]" class="form-control border-only-bottom input-sm"  autocomplete="off" required placeholder="Insert Name"/>`;
        cells[4].innerHTML  = `<input type="text" id="product-description" name="product_description[]" class="form-control border-only-bottom input-sm"  autocomplete="off" required placeholder="Insert Description"/>`;
    }
}

function removeProduct()
{
    $('.worksheet-row-index:checkbox:checked').parents('tr.worksheet_row').remove();
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