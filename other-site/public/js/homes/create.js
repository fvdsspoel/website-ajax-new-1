$(document).ready(function() {
    //save button
	$("#add-cms").submit(function(e) {
    	e.preventDefault();
    	var data = $(this).serializeArray();
    	$('#about-detail').val($('#editor').html());
        submitForm();
    });

	//reset button
	$('#reset_btn').click(function() {
	
        if ($('#add-cms').length > 0) {
			$('#add-cms')[0].reset();
		} 
    });
});


function submitForm()
{
    showLoader('Saving','Please wait....');
    data = new FormData($('#add-cms')[0]);
    $.ajax({
        type:"post",
        url:"/cms",
        data: data,
        method:'POST',
        dataType:"json",
        contentType: false,
        cache: false,
        processData: false,
        success:function(data) {
            console.log(data);
            if (data["status"] == "saved") {
               showSuccessAlert('Success', 'CMS successfully created/update.')
               .then((result) => {
                    if (result.value) {
                        location.reload();
                    }
               });
            }else{
              showErrorAlert('Error', 'CMS unsuccessfully created/update, please check your internet connection.');
            } 
        },
        error: function(error) {
            showHttpErrorAlert(error);
        }
    });
}
