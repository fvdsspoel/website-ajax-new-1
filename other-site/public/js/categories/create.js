$(document).ready(function() {
   //save button
	$("#add-category").submit(function(e) {
    	e.preventDefault();
    	var data = $(this).serializeArray();
        submitForm();
    });

	//reset button
	$('#reset_btn').click(function() {
	
        if ($('#add-category').length > 0) {
			$('#add-category')[0].reset();
		} 
    });
});


function submitForm()
{
    showLoader('Saving','Please wait....');
    data = new FormData($('#add-category')[0]);
    $.ajax({
        type:"post",
        url:"/categories/store",
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
                    'Category & Sub Category successfully created/update.',
                    'success',
                    'Okay',
                    'Go To list'
                ).then((result) => {
                    if (result.value == true) {
                        location.reload();
                    }
                    else{
                        window.location.replace(`/categories`);
                    }
                });
            }else{
                showErrorAlert('Error', 'Category & Sub Category unsuccessfully created/update, please check your internet connection.');
            } 
        },
        error: function(error) {
            showHttpErrorAlert(error);
        }
    });
}
