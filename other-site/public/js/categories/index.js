function deleteData(id){

    showConfirmAlert(
        'Deleting Category',
        'Are you sure you want to delete?',
        'info',
        'Yes',
        'No'
    ).then((result) => {
        if (result.value == true) {
            deleted(id);
        }
    });
}

function deleted(id){

    $.ajax({
        type: "post",
        url: "/categories/delete",
        data: {
          id:id
        },
        dataType: 'JSON',
        success: function (res) {
            if (res["status"] == "saved") {
              showSuccessAlert('Success', 'Category & Sub Category successfully delete')
              .then((result) => {
                  if (result.value == true) {
                      location.reload();
                  }
              });
            }
        },
        error: function(error) {
            showHttpErrorAlert(error);
        } 
    });
}