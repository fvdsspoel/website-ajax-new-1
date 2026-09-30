$(document).ready(function() {
   //save button
	$("#add-team").submit(function(e) {
    	e.preventDefault();
    	var data = $(this).serializeArray();
        submitForm();
    });

	//reset button
	$('#reset_btn').click(function() {
	
        if ($('#add-team').length > 0) {
			$('#add-team')[0].reset();
		} 
    });
});


function submitForm()
{
    showLoader('Saving','Please wait....');
    data = new FormData($('#add-team')[0]);
    $.ajax({
        type:"post",
        url:"/teams/store",
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
                    'Team successfully created/update.',
                    'success',
                    'Okay',
                    'Go To list'
                ).then((result) => {
                    if (result.value == true) {
                        location.reload();
                    }
                    else{
                        window.location.replace(`/teams/index`);
                    }
                });
            }else{
                showErrorAlert('Error', 'Team unsuccessfully created/update, please check your internet connection.');
            } 
        },
        error: function(error) {
            showHttpErrorAlert(error);
        }
    });
}
