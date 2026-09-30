let rowIndex = 0;
$(document).ready(function() {
    id = $('#id').val();

    if(id){
        getSubCategory(id);
        $('#category-type').val($('#category-type-val').val());
    }
});

function getSubCategory(id){

    $.ajax({
        type: "post",
        url: "/categories/get-subcategory",
        data: {
            id:id
        },
        dataType: 'JSON',
        success: function (res) {
            for(i=0; i < res.length; i++){
                addRow(res[i]);
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

function addRow(data){

    rowIndex ++;
    let cells = generateTableRow('table-sub-category', 'worksheet_row', 3);
    cells[0].innerHTML  = `<input type="checkbox" class="worksheet-row-index"/>`;

    if(data){
        cells[1].innerHTML  = `<img id="preview-${rowIndex}" data-action="zoom" src="${data.image}" onerror="this.src='/assets/images/default/no_image.png'" alt="your image" height="80"/>
                                 <br>
                                <input type="file"  name="multi_selected[]" id="multi-selected-${rowIndex}"  autocomplete="off"  onchange="readURL(this,${rowIndex});" class="mb-2"  >
                                <input type="hidden" id="multi-selected-id-${rowIndex}" name="multi_selected_id[]" value="old"  class="form-control input-sm style_input"  autocomplete="off"  />`;

        cells[1].innerHTML  += `<input type="hidden" id="sub-category-id" name="sub_category_id[]" value="${data.id}" class="form-control input-sm"  autocomplete="off" />`;
        cells[2].innerHTML  = `<input type="text" id="sub-category" name="sub_category[]" value="${data.name}" class="form-control border-only-bottom input-sm"  autocomplete="off"  />`;
    }else{
        cells[1].innerHTML  = `<img id="preview-${rowIndex}" data-action="zoom" src="/assets/images/default/no_image.png" onerror="this.src='/assets/images/default/no_image.png'" alt="your image" height="80"/>
                                 <br>
                                <input type="file"  name="multi_selected[]" id="multi-selected-${rowIndex}"  autocomplete="off"  onchange="readURL(this,${rowIndex});" class="mb-2" required >
                                <input type="hidden" id="multi-selected-id-${rowIndex}" name="multi_selected_id[]" value="old"  class="form-control input-sm style_input"  autocomplete="off"  />`;

        cells[1].innerHTML  += `<input type="hidden" id="sub-category-id" name="sub_category_id[]" class="form-control input-sm"  autocomplete="off" />`;
        cells[2].innerHTML  = `<input type="text" id="sub-category" name="sub_category[]" class="form-control border-only-bottom input-sm"  autocomplete="off" required />`;

    }
}

function removeRow()
{
    $('.worksheet-row-index:checkbox:checked').parents('tr.worksheet_row').remove();
}