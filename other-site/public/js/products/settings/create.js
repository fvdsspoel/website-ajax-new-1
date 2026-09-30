$(document).ready(function() {
    //save button
	$("#add-product-setting").submit(function(e) {
    	e.preventDefault();
    	var data = $(this).serializeArray();
        submitForm();
    });

	//reset button
	$('#reset_btn').click(function() {
	
        if ($('#add-product-setting').length > 0) {
			$('#add-product-setting')[0].reset();
		} 
    });
});


function submitForm()
{
    showLoader('Saving','Please wait....');
    data = new FormData($('#add-product-setting')[0]);
    $.ajax({
        type:"post",
        url:"/products/setting/store",
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
                    'Product Settings successfully created/update.',
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
                showErrorAlert('Error', 'Product Settings unsuccessfully created/update, please check your internet connection.');
            }  
        },
        error: function(error) {
            showHttpErrorAlert(error);
        }
    });
}
