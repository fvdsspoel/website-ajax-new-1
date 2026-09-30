$(document).ready(function() {
   //save button
	$("#add-summary-form").submit(function(e) {
    	e.preventDefault();
    	var data = $(this).serializeArray();
        submitForm();
    });
});

function submitForm()
{
    showLoader('Saving','Please wait....');
    data = new FormData($('#add-summary-form')[0]);
    $.ajax({
        type:"post",
        url:"/products/book-appointment/store",
        data: data,
        method:'POST',
        dataType:"json",
        contentType: false,
        cache: false,
        processData: false,
        success:function(res) {
            if (res[0] == "success") {
                $('#generated-pdf-a').attr('href', res[1]);
                $('#generated-pdf-a').attr('download', '').attr('target', '_blank'); 
                document.getElementById('generated-pdf-a').click();

                showSuccessAlert('Success','Appointment successfully booked. Please wait for our sales representative to contact you for more information');
            }else{
                showErrorAlert('Error', 'Appointment unsuccessfully book, please check your internet connection.');
            } 
        },
        error: function(error) {
            showHttpErrorAlert(error);
        }
    });
}