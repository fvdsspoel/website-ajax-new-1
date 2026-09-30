$(document).ready(function() {
   //save button
	$("#add-corporate-form").submit(function(e) {
    	e.preventDefault();
    	var data = $(this).serializeArray();
        submitForm();
    });
});

function submitForm()
{
    showLoader('Saving','Please wait....');
    data = new FormData($('#add-corporate-form')[0]);
    $.ajax({
        type:"post",
        url:"/contact-us/inquiry/store",
        data: data,
        method:'POST',
        dataType:"json",
        contentType: false,
        cache: false,
        processData: false,
        success:function(res) {
            if(res["status"] == "saved"){
            	showSuccessAlert('Success','Your Inquiry successfully saved. Please wait for our sales representative to contact you for more information');
            	$('#add-corporate-form')[0].reset();
            }else{
                showErrorAlert('Error', 'Your Inquiry unsuccessfully book, please check your internet connection.');
            } 
        },
        error: function(error) {
            showHttpErrorAlert(error);
        }
    });
}