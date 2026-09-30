function showConfirmAlert(title, subtitle,icon,confirmText,canceledText) {
    return Swal.fire({
            confirmButtonText: confirmText,
            cancelButtonText: canceledText,
            showCancelButton: true,
            allowOutsideClick: false,
            allowEscapeKey: false,
            allowEnterKey: false,
            title: title,
            text: subtitle,
            icon: icon,
            width: '300px',
            customClass: {
                confirmButton: 'btn geo-primary',
                cancelButton: 'btn btn-secondary',
                title: 'swal-title',
                content: 'swal-subtitle'
            }
        });
}

function showSuccessAlert(title, subtitle) {
    return Swal.fire({
            confirmButtonText: 'OKAY',
            allowOutsideClick: false,
            allowEscapeKey: false,
            allowEnterKey: false,
            title: title,
            html: subtitle,
            icon: 'success',
            width: '300px',
            customClass: {
                confirmButton: 'btn geo-primary swal-okay-button',
                title: 'swal-title',
                content: 'swal-subtitle'
            }
        });
}

function showErrorAlert(title, subtitle) {
    Swal.fire({
        confirmButtonText: 'OKAY',
        allowOutsideClick: false,
        allowEscapeKey: false,
        allowEnterKey: false,
        title: title,
        html: subtitle,
        icon: 'error',
        width: '300px',
        customClass: {
            confirmButton: 'btn btn-danger swal-okay-button',
            title: 'swal-title',
            content: 'swal-subtitle'
        }
    });
}

function showInfoAlert(title, subtitle) {
    Swal.fire({
        confirmButtonText: 'OKAY',
        allowOutsideClick: false,
        allowEscapeKey: false,
        allowEnterKey: false,
        title: title,
        html: subtitle,
        icon: 'info',
        width: '300px',
        customClass: {
            confirmButton: 'btn swal-okay-button',
            title: 'swal-title',
            content: 'swal-subtitle'
        }
    });
}

function showWarningAlert(title, subtitle) {
    Swal.fire({
        confirmButtonText: 'OKAY',
        allowOutsideClick: false,
        allowEscapeKey: false,
        allowEnterKey: false,
        title: title,
        html: subtitle,
        icon: 'warning',
        width: '300px',
        customClass: {
            confirmButton: 'btn btn-warn swal-okay-button',
            title: 'swal-title',
            content: 'swal-subtitle'
        }
    });
}

function showLoader(title, subtitle) {
    Swal.fire({
        confirmButtonText: 'OKAY',
        allowOutsideClick: false,
        allowEscapeKey: false,
        allowEnterKey: false,
        title: title,
        html: subtitle,
        width: '300px',
        onBeforeOpen: () => {
            Swal.showLoading ()
        }
    });
}

function showHttpErrorAlert(err) {
    if (err.status == 0) {
        showErrorAlert('Error', 'Check your internet connection and try again');
    } else {
        showErrorAlert(err.statusText, err.responseJSON.message);
    }
}

function showModal(title, subtitle) {
    Swal.fire({
        showConfirmButton: false,
        allowOutsideClick: false,
        allowEscapeKey: false,
        allowEnterKey: false,
        title: title,
        html: subtitle,
        width: '350px',
        customClass: {
            title: 'swal-title',
            content: 'swal-subtitle'
        }
    });
}