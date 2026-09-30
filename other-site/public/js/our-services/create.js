$(document).ready(function() {
   //save button
	$("#add-our-services").submit(function(e) {
    	e.preventDefault();
    	var data = $(this).serializeArray();
        submitForm();
    });

	//reset button
	$('#reset_btn').click(function() {
	
        if ($('#add-our-services').length > 0) {
			$('#add-our-services')[0].reset();
		} 
    });
});


function submitForm()
{
    showLoader('Saving','Please wait....');
    data = new FormData($('#add-our-services')[0]);
    $.ajax({
        type:"post",
        url:"/our-services/store",
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
                    'Our Services successfully created/update.',
                    'success',
                    'Okay',
                    'Go To list'
                ).then((result) => {
                    if (result.value == true) {
                        location.reload();
                    }
                    else{
                        window.location.replace(`/our-services/index`);
                    }
                });
            }else{
                showErrorAlert('Error', 'Our Services unsuccessfully created/update, please check your internet connection.');
            } 
        },
        error: function(error) {
            showHttpErrorAlert(error);
        }
    });
}
