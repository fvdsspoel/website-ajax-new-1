// #sidebar-wrapper

$( document ).ready(function() {
    $("#sidenav-toggle").click(function () {
        /*$("#sidebar-wrapper").css({
            "width" : "80px"
        });*/
        $("#sidebar-wrapper").toggleClass('min-nav');
        $("#page-content-wrapper").toggleClass('expand-body');
    });
    let deactive_status = $("#is-deactivated").val();
    if (deactive_status == 1) {
        $("#deactivated-user-modal").modal({
            backdrop: 'static',
            keyboard: false
        });
        $("#deactivated-user-modal").modal("show");
    }
});
