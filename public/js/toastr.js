document.addEventListener('DOMContentLoaded', function() {
    if (sessionStorage.getItem('toastMessage')) {
        toastr.options = {
            "closeButton": true,
            "progressBar": true,
            "timeOut": "5000",
            "extendedTimeOut": "2000",
            "positionClass": "toast-top-right",
            "toastClass": "toast-success"
        };
        toastr.success(sessionStorage.getItem('toastMessage'));
        sessionStorage.removeItem('toastMessage');
    }

    if (sessionStorage.getItem('toastError')) {
        toastr.options = {
            "closeButton": true,
            "progressBar": true,
            "timeOut": "5000",
            "extendedTimeOut": "2000",
            "positionClass": "toast-top-right",
            "toastClass": "toast-error"
        };
        toastr.error(sessionStorage.getItem('toastError'));
        sessionStorage.removeItem('toastError');
    }

    if (sessionStorage.getItem('toastErrors')) {
        toastr.options = {
            "closeButton": true,
            "progressBar": true,
            "timeOut": "5000",
            "extendedTimeOut": "2000",
            "positionClass": "toast-top-right",
            "toastClass": "toast-error"
        };
        const errors = JSON.parse(sessionStorage.getItem('toastErrors'));
        errors.forEach(error => {
            toastr.error(error);
        });
        sessionStorage.removeItem('toastErrors');
    }
});
