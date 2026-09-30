$(document).ready(function() {
   //save button
	$("#add-non-build-product").submit(function(e) {
    	e.preventDefault();
    	var data = $(this).serializeArray();
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
    data = new FormData($('#add-non-build-product')[0]);
    $.ajax({
        type:"post",
        url:"/non-build-products/store",
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
                        window.location.replace(`/non-build-products/index`);
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
