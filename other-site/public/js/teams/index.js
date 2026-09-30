function deleteData(id){

    showConfirmAlert(
        'Deleting Team',
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
        url: "/teams/delete",
        data: {
          id:id
        },
        dataType: 'JSON',
        success: function (res) {
            if (res["status"] == "saved") {
              showSuccessAlert('Success', 'Team successfully delete')
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