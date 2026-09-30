$(document).ready(function() {
    //save button
	$("#add-product").submit(function(e) {
    	e.preventDefault();
    	var data = $(this).serializeArray();
    	$('#product-detail').val($('#editor').html());
        submitForm();
    });

	//reset button
	$('#reset_btn').click(function() {
	
        if ($('#add-product').length > 0) {
			$('#add-product')[0].reset();
		} 
    });
});


function submitForm()
{
    showLoader('Saving','Please wait....');
    data = new FormData($('#add-product')[0]);
    $.ajax({
        type:"post",
        url:"/products/store",
        data: data,
        method:'POST',
        dataType:"json",
        contentType: false,
        cache: false,
        processData: false,
        success:function(data) {
            console.log(data);
            if (data["status"] == "saved") {
                showConfirmAlert(
                    'Success',
                    'Product successfully created/update.',
                    'success',
                    'Okay',
                    'Go To list'
                ).then((result) => {
                    if (result.value == true) {
                        location.reload();
                    }
                    else{
                        window.location.replace(`/products/index`);
                    }
                });
            }else{
                showErrorAlert('Error', 'Product unsuccessfully created/update, please check your internet connection.');
            }  
        },
        error: function(error) {
            showHttpErrorAlert(error);
        }
    });
}
