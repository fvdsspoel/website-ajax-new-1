let rowIndex = 0;
$(document).ready(function() {
    //save button
    $("#add-price-size").submit(function(e) {
        e.preventDefault();
        var data = $(this).serializeArray();
        submitForm();
    });

    //reset button
    $('#reset_btn').click(function() {
    
        if ($('#add-price-size').length > 0) {
            $('#add-price-size')[0].reset();
        } 
    });

    getData();
});

function getData(){

    $.ajax({
        type: "get",
        url: "/size-prices/get-data",
        data: null,
        dataType: 'JSON',
        success: function (res) {
            for (var i = 0; i < res.length; i++) {
                addRow(res[i]);
            }
        },
        error: function(error) {
            showHttpErrorAlert(error);
        } 
    });
}

function addRow(data){

    rowIndex ++;
    let cells = generateTableRow('table-size-price', 'worksheet_row', 4);
    cells[0].innerHTML  = `<input type="checkbox" class="worksheet-row-index"/>`;

    if(data){
        cells[1].innerHTML  = `<input type="number" id="min-size-${rowIndex}" name="min_size[]" value="${data.min_size}" class="form-control border-only-bottom input-sm"  placeholder="Enter Size(cm)" autocomplete="off" />`;
        cells[2].innerHTML  = `<input type="number" id="max-size-${rowIndex}" name="max_size[]" value="${data.max_size}" class="form-control border-only-bottom input-sm"  placeholder="Enter Size(cm)" autocomplete="off" />`;
        cells[2].innerHTML  += `<input type="hidden" id="size-price-id-${rowIndex}" name="size_price_id[]" value="${data.id}" class="form-control input-sm"  autocomplete="off" />`;
        cells[3].innerHTML  = `<input type="number" id="size-price-${rowIndex}" name="size_price[]" value="${data.price}" class="form-control border-only-bottom input-sm" placeholder="Enter Price" autocomplete="off" required />`;
    }else{
        cells[1].innerHTML  = `<input type="number" id="min-size-${rowIndex}" name="min_size[]" class="form-control border-only-bottom input-sm"  placeholder="Enter Size(cm)" autocomplete="off" />`;
        cells[2].innerHTML  = `<input type="number" id="max-size-${rowIndex}" name="max_size[]" class="form-control border-only-bottom input-sm"  placeholder="Enter Size(cm)" autocomplete="off" />`;
        cells[2].innerHTML  += `<input type="hidden" id="size-price-id-${rowIndex}" name="size_price_id[]" class="form-control input-sm"  autocomplete="off" />`;
        cells[3].innerHTML  = `<input type="number" id="size-price-${rowIndex}" name="size_price[]" class="form-control border-only-bottom input-sm" placeholder="Enter Price" autocomplete="off" required />`;
    }
}

function removeRow()
{
    $('.worksheet-row-index:checkbox:checked').parents('tr.worksheet_row').remove();
}

function submitForm()
{
    showLoader('Saving','Please wait....');
    data = new FormData($('#add-price-size')[0]);
    $.ajax({
        type:"post",
        url:"/size-prices/store",
        data: data,
        method:'POST',
        dataType:"json",
        contentType: false,
        cache: false,
        processData: false,
        success:function(data) {
            console.log(data);
            if (data["status"] == "saved") {
                showSuccessAlert('Success','Product Size Price successfully Saved.').then((result) => {
                    if (result.value == true) {
                        location.reload();
                    }
                });
            }else{
                showErrorAlert('Error', 'Product Size Price unsuccessfully created/update, please check your internet connection.');
            } 
        },
        error: function(error) {
            showHttpErrorAlert(error);
        }
    });
}